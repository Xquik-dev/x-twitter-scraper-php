<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace Tests\Support;

/**
 * @phpstan-type Parameter array{name: string, type: string, optional: bool, variadic: bool}
 * @phpstan-type Signatures array<string, list<Parameter>>
 * @phpstan-type Release array{version: string, signatures: Signatures}
 */
final class RequestSignatures
{
    public const FILE = 'tests/request-signatures.txt';

    private const HEADER = 'release ';

    private const NAMESPACE = 'XTwitterScraper\\';

    private const OPTIONS = 'requestOptions';

    private const LINE = '/^(?<method>[\w\\\]+::\w+)\((?<parameters>.*)\)$/';

    private const PARAMETER = '/^(?:(?<type>\S+) )?(?<variadic>\.\.\.)?\$(?<name>\w+)(?<optional> = \.\.\.)?$/';

    /**
     * @return Signatures
     */
    public static function read(string $source): array
    {
        $root = realpath($source);
        if (false === $root) {
            throw new \RuntimeException("{$source} does not exist.");
        }
        $signatures = [];
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS));
        foreach ($files as $file) {
            if (!$file instanceof \SplFileInfo || 'php' !== $file->getExtension()) {
                continue;
            }
            $path = $file->getPathname();

            require_once $path;
            $name = strtr(substr($path, strlen($root) + 1, -4), '/', '\\');
            $class = self::NAMESPACE.$name;
            if (!class_exists($class, false) && !interface_exists($class, false) && !trait_exists($class, false)) {
                continue;
            }
            $reflection = new \ReflectionClass($class);
            if (self::internal($reflection->getDocComment())) {
                continue;
            }
            foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                $parameters = array_map(self::parameter(...), $method->getParameters());
                if ($method->getFileName() === $path && !self::internal($method->getDocComment()) && in_array(self::OPTIONS, array_column($parameters, 'name'), true)) {
                    $signatures["{$name}::{$method->getName()}"] = $parameters;
                }
            }
        }
        ksort($signatures, SORT_STRING);

        return $signatures;
    }

    /**
     * @param Release $release
     */
    public static function render(array $release): string
    {
        $lines = [self::HEADER.$release['version']];
        foreach ($release['signatures'] as $method => $parameters) {
            $lines[] = $method.'('.implode(', ', array_map(self::describe(...), $parameters)).')';
        }

        return implode("\n", $lines)."\n";
    }

    /**
     * @return Release
     */
    public static function parse(string $text): array
    {
        $lines = explode("\n", rtrim($text, "\n"));
        if (!str_starts_with($lines[0], self::HEADER)) {
            throw new \RuntimeException(self::FILE.' must start with the line '.self::HEADER.'<version>.');
        }
        $signatures = [];
        foreach (array_slice($lines, 1) as $line) {
            if (1 !== preg_match(self::LINE, $line, $match)) {
                throw new \RuntimeException(self::FILE." has a line it cannot read: {$line}");
            }
            $parameters = [];
            if ('' !== $match['parameters']) {
                foreach (explode(', ', $match['parameters']) as $parameter) {
                    $parameters[] = self::readParameter($parameter, $line);
                }
            }
            $signatures[$match['method']] = $parameters;
        }

        return ['version' => substr($lines[0], strlen(self::HEADER)), 'signatures' => $signatures];
    }

    /**
     * @param Release $released
     * @param Signatures $current
     *
     * @return list<string>
     */
    public static function breaks(array $released, array $current): array
    {
        $version = $released['version'];
        $breaks = [];
        foreach ($released['signatures'] as $method => $parameters) {
            $now = $current[$method] ?? null;
            if (null === $now) {
                $breaks[] = "{$method} is gone, but {$version} callers still call it.";

                continue;
            }
            foreach ($parameters as $index => $parameter) {
                $position = $index + 1;
                $found = $now[$index] ?? null;
                if (null === $found || $found['name'] !== $parameter['name'] || $found['variadic'] !== $parameter['variadic']) {
                    $holder = null === $found ? 'nothing' : "\${$found['name']}";
                    $breaks[] = "{$method} argument {$position} is \${$parameter['name']} in {$version}, but {$holder} now.";

                    continue 2;
                }
                if (!self::accepts($found['type'], $parameter['type'])) {
                    $breaks[] = "{$method} argument {$position} \${$parameter['name']} took {$parameter['type']} in {$version}, but takes {$found['type']} now.";
                }
                if ($parameter['optional'] && !$found['optional']) {
                    $breaks[] = "{$method} argument {$position} \${$parameter['name']} was optional in {$version}, but is required now.";
                }
            }
            foreach (array_slice($now, count($parameters)) as $added) {
                if (!$added['optional']) {
                    $breaks[] = "{$method} adds the required \${$added['name']}, which {$version} calls leave out.";
                }
            }
        }

        return $breaks;
    }

    /**
     * @param Signatures $current
     */
    public static function next(string $recorded, string $version, array $current): string
    {
        $released = self::parse($recorded);
        if ($version === $released['version']) {
            throw new \RuntimeException(self::FILE." already records {$version}. Run this after the version bump.");
        }
        $breaks = self::breaks($released, $current);
        if ([] !== $breaks) {
            throw new \RuntimeException(implode("\n", $breaks));
        }

        return self::render(['version' => $version, 'signatures' => $current]);
    }

    /**
     * @return Parameter
     */
    private static function readParameter(string $parameter, string $line): array
    {
        if (1 !== preg_match(self::PARAMETER, $parameter, $part)) {
            throw new \RuntimeException(self::FILE." has a line it cannot read: {$line}");
        }
        $variadic = '' !== $part['variadic'];

        return [
            'name' => $part['name'],
            'type' => $part['type'],
            'optional' => $variadic || '' !== ($part['optional'] ?? ''),
            'variadic' => $variadic,
        ];
    }

    private static function internal(false|string $comment): bool
    {
        return false !== $comment && str_contains($comment, '@internal');
    }

    /**
     * @return Parameter
     */
    private static function parameter(\ReflectionParameter $parameter): array
    {
        return [
            'name' => $parameter->getName(),
            'type' => str_replace(self::NAMESPACE, '', (string) $parameter->getType()),
            'optional' => $parameter->isOptional(),
            'variadic' => $parameter->isVariadic(),
        ];
    }

    /**
     * @param Parameter $parameter
     */
    private static function describe(array $parameter): string
    {
        $type = '' === $parameter['type'] ? '' : "{$parameter['type']} ";
        $variadic = $parameter['variadic'] ? '...' : '';
        $optional = $parameter['optional'] && !$parameter['variadic'] ? ' = ...' : '';

        return "{$type}{$variadic}\${$parameter['name']}{$optional}";
    }

    private static function accepts(string $now, string $then): bool
    {
        $accepted = self::types($now);

        return in_array('mixed', $accepted, true) || [] === array_diff(self::types($then), $accepted);
    }

    /**
     * @return list<string>
     */
    private static function types(string $type): array
    {
        if ('' === $type) {
            return ['mixed'];
        }
        if (str_starts_with($type, '?')) {
            return [substr($type, 1), 'null'];
        }

        return explode('|', $type);
    }
}
