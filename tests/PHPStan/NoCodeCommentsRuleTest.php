<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace Tests\PHPStan;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Tests\Support\NoCodeCommentsRule;

/**
 * @extends RuleTestCase<NoCodeCommentsRule>
 *
 * @internal
 */
final class NoCodeCommentsRuleTest extends RuleTestCase
{
    private const MESSAGE = 'Code has no comments. Put the meaning in names, types and tests.';

    private string $root = '';

    protected function setUp(): void
    {
        parent::setUp();
        $this->root = sys_get_temp_dir().'/no-code-comments-'.bin2hex(random_bytes(6));
        mkdir($this->root.'/src/Core', 0o700, true);
    }

    protected function tearDown(): void
    {
        foreach (['src/Core/Helper.php', 'src/Search.php', 'scripts.php'] as $file) {
            if (is_file($this->root.'/'.$file)) {
                unlink($this->root.'/'.$file);
            }
        }
        rmdir($this->root.'/src/Core');
        rmdir($this->root.'/src');
        rmdir($this->root);
        parent::tearDown();
    }

    public function testKeepsLegalProofDirectiveAndPublicApiDocs(): void
    {
        $file = $this->write('src/Search.php', <<<'PHP'
            <?php

            // SPDX-FileCopyrightText: 2026 Xquik contributors
            //
            // SPDX-License-Identifier: Apache-2.0

            namespace Fixture;

            // cURL keeps the connection open.
            // https://www.php.net/manual/en/function.curl-setopt.php
            /**
             * Searches tweets.
             */
            final class Search
            {
                /**
                 * Returns the query.
                 */
                public function query(): string
                {
                    /** @var string $value */
                    $value = 'q';

                    return $value;
                }
            }
            PHP);
        $this->analyse([$file], []);
    }

    public function testRejectsNarration(): void
    {
        $file = $this->write('src/Search.php', <<<'PHP'
            <?php

            namespace Fixture;

            final class Search
            {
                /**
                 * Hidden helper.
                 */
                private function helper(): int
                {
                    // Explains the next line.
                    $value = 1;

                    return $value; # says what value is
                }

                // First line.
                // Second line, still no proof.

                // Unrelated note.

                // https://example.com/doc
                public function run(): int
                {
                    return $this->helper();
                }
            }
            PHP);
        $this->analyse([$file], [
            [self::MESSAGE, 7],
            [self::MESSAGE, 12],
            [self::MESSAGE, 15],
            [self::MESSAGE, 18],
            [self::MESSAGE, 19],
            [self::MESSAGE, 21],
        ]);
    }

    public function testRejectsDocsOutsideThePublicApi(): void
    {
        $file = $this->write('src/Core/Helper.php', <<<'PHP'
            <?php

            namespace Fixture;

            /**
             * Describes an internal helper.
             */
            final class Helper {}
            PHP);
        $this->analyse([$file], [[self::MESSAGE, 5]]);
    }

    protected function getRule(): Rule
    {
        return new NoCodeCommentsRule($this->root, ['src/'], ['src/Core/']);
    }

    private function write(string $path, string $source): string
    {
        $file = $this->root.'/'.$path;
        file_put_contents($file, $source);

        return $file;
    }
}
