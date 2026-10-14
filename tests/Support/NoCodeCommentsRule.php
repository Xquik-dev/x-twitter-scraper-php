<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace Tests\Support;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\FileNode;
use PHPStan\Rules\IdentifierRuleError;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<FileNode>
 */
final class NoCodeCommentsRule implements Rule
{
    private const PROOF = '~https://|SPDX-|REUSE-Ignore~';
    private const DIRECTIVE = '~@phpstan-|@psalm-|phpcs:|@codeCoverageIgnore|@noinspection~';
    private const TYPE_TAG = '~@(?:param|return|var|property(?:-read|-write)?|method|template(?:-covariant|-contravariant)?|extends|implements|use|mixin|throws|phpstan-|psalm-)\b~';
    private const DECLARATION_TOKENS = [
        T_ABSTRACT, T_CASE, T_CLASS, T_CONST, T_ENUM, T_FINAL, T_FUNCTION,
        T_INTERFACE, T_PROTECTED, T_PUBLIC, T_READONLY, T_STATIC, T_TRAIT,
    ];

    /**
     * @param list<string> $publicApiFolders
     * @param list<string> $privateApiFolders
     */
    public function __construct(
        private readonly string $root,
        private readonly array $publicApiFolders,
        private readonly array $privateApiFolders,
    ) {}

    public function getNodeType(): string
    {
        return FileNode::class;
    }

    /**
     * @return list<IdentifierRuleError>
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $source = file_get_contents($scope->getFile());
        if (false === $source) {
            return [];
        }
        $tokens = \PhpToken::tokenize($source);
        $comments = array_values(array_filter($tokens, static fn (\PhpToken $token): bool => $token->is([T_COMMENT, T_DOC_COMMENT])));
        $publicApi = $this->isPublicApiFile($scope->getFile());
        $proven = false;
        $errors = [];
        foreach (array_reverse(array_keys($comments)) as $index) {
            $comment = $comments[$index];
            $later = $comments[$index + 1] ?? null;
            $proven = 1 === preg_match(self::PROOF, $comment->text)
                || ($proven && null !== $later && $this->adjacent($source, $comment, $later));
            if ($proven || $this->isFunctional($comment) || ($publicApi && $this->documentsDeclaration($tokens, $comment))) {
                continue;
            }
            $errors[] = RuleErrorBuilder::message('Code has no comments. Put the meaning in names, types and tests.')
                ->identifier('xquik.noCodeComments')
                ->line($comment->line)
                ->build()
            ;
        }

        return array_reverse($errors);
    }

    private function isFunctional(\PhpToken $comment): bool
    {
        return 1 === preg_match(self::DIRECTIVE, $comment->text)
            || ($comment->is(T_DOC_COMMENT) && 1 === preg_match(self::TYPE_TAG, $comment->text));
    }

    private function adjacent(string $source, \PhpToken $earlier, \PhpToken $later): bool
    {
        $between = substr($source, $earlier->pos + strlen($earlier->text), $later->pos - $earlier->pos - strlen($earlier->text));

        return '' === trim($between) && substr_count($between, "\n") <= 1;
    }

    /**
     * @param array<\PhpToken> $tokens
     */
    private function documentsDeclaration(array $tokens, \PhpToken $comment): bool
    {
        if (!$comment->is(T_DOC_COMMENT)) {
            return false;
        }
        foreach ($tokens as $token) {
            if ($token->pos <= $comment->pos || $token->isIgnorable()) {
                continue;
            }

            return $token->is(self::DECLARATION_TOKENS) || $token->is(T_ATTRIBUTE);
        }

        return false;
    }

    private function isPublicApiFile(string $file): bool
    {
        $relative = str_starts_with($file, $this->root.'/') ? substr($file, strlen($this->root) + 1) : $file;
        $inside = static fn (string $folder): bool => str_starts_with($relative, $folder);

        return [] !== array_filter($this->publicApiFolders, $inside) && [] === array_filter($this->privateApiFolders, $inside);
    }
}
