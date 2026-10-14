<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

use Composer\Semver\Comparator;
use Composer\Semver\Semver;
use Composer\Semver\VersionParser;

const EXCEPTIONS_FILE = 'audit-exceptions.json';
const EXCEPTION_KEYS = ['advisory', 'path', 'reason', 'recheck'];
const EXCEPTION_REASONS = ['build-time only', 'peer dependency provided by the host'];
const MAX_RECHECK_DAYS = 30;

function stop(string $message): never
{
    fwrite(STDERR, $message."\n");

    exit(1);
}

/**
 * @return array<mixed>
 */
function read_json(string $contents, string $source, string $hint): array
{
    try {
        $decoded = json_decode($contents, true, flags: JSON_THROW_ON_ERROR);
    } catch (JsonException $exception) {
        stop("{$source} is not valid JSON. {$hint}");
    }
    if (!is_array($decoded)) {
        stop("{$source} must hold a JSON object. {$hint}");
    }

    return $decoded;
}

/**
 * @return array<string, string>
 */
function locked_packages(mixed $packages): array
{
    $versions = [];
    foreach (is_array($packages) ? $packages : [] as $package) {
        if (is_array($package) && is_string($package['name'] ?? null) && is_string($package['version'] ?? null)) {
            $versions[$package['name']] = $package['version'];
        }
    }

    return $versions;
}

/**
 * @param array<mixed> $advisory
 *
 * @return list<string>
 */
function advisory_ids(array $advisory): array
{
    $ids = [];
    foreach (['advisoryId', 'cve'] as $key) {
        if (is_string($advisory[$key] ?? null) && '' !== $advisory[$key]) {
            $ids[] = $advisory[$key];
        }
    }
    foreach (is_array($advisory['sources'] ?? null) ? $advisory['sources'] : [] as $source) {
        if (is_array($source) && is_string($source['remoteId'] ?? null) && '' !== $source['remoteId']) {
            $ids[] = $source['remoteId'];
        }
    }

    return $ids;
}

function fixed_release(string $package, string $lockedVersion, string $affectedVersions): ?string
{
    if (!is_file(__DIR__.'/../vendor/autoload.php')) {
        stop('Install dependencies with ./scripts/bootstrap, then run the audit again.');
    }

    require_once __DIR__.'/../vendor/autoload.php';

    $context = stream_context_create(['http' => ['timeout' => 30]]);
    set_error_handler(static function (): bool {
        return true;
    });
    $metadata = file_get_contents("https://repo.packagist.org/p2/{$package}.json", false, $context);
    restore_error_handler();
    if (false === $metadata) {
        stop("Could not read Packagist metadata for {$package}. Check your network, then try again.");
    }
    $releases = read_json($metadata, "Packagist metadata for {$package}", 'Try again later.')['packages'][$package] ?? [];

    $parser = new VersionParser;
    foreach (is_array($releases) ? $releases : [] as $release) {
        $version = is_array($release) ? ($release['version'] ?? null) : null;
        if (!is_string($version) || 'stable' !== VersionParser::parseStability($version)) {
            continue;
        }
        $normalized = $parser->normalize($version);
        if (Comparator::greaterThan($normalized, $parser->normalize($lockedVersion))
            && !Semver::satisfies($normalized, $affectedVersions)) {
            return $version;
        }
    }

    return null;
}

$audit = read_json((string) stream_get_contents(STDIN), 'Composer audit output', 'Rerun composer audit and check its errors.');
if (!array_key_exists('advisories', $audit) || !array_key_exists('abandoned', $audit)) {
    stop('Composer audit output is incomplete. Rerun composer audit.');
}

$lock = read_json((string) file_get_contents(__DIR__.'/../composer.lock'), 'composer.lock', 'Restore it from Git.');
$runtimePackages = locked_packages($lock['packages'] ?? []);
$developmentPackages = locked_packages($lock['packages-dev'] ?? []);

$exceptions = read_json((string) file_get_contents(__DIR__.'/../'.EXCEPTIONS_FILE), EXCEPTIONS_FILE, 'Fix it, then run the audit again.')['exceptions'] ?? null;
if (!is_array($exceptions) || !array_is_list($exceptions)) {
    stop(EXCEPTIONS_FILE.' needs an "exceptions" list. Fix it, then run the audit again.');
}

$today = new DateTimeImmutable('today', new DateTimeZone('UTC'));
$latestRecheck = $today->modify('+'.MAX_RECHECK_DAYS.' days');
$problems = [];
$listed = [];
foreach ($exceptions as $index => $exception) {
    $label = EXCEPTIONS_FILE." entry {$index}";
    $keys = is_array($exception) ? array_keys($exception) : [];
    sort($keys);
    if (!is_array($exception) || EXCEPTION_KEYS !== $keys
        || [] !== array_filter($exception, static function (mixed $value): bool {
            return !is_string($value) || '' === $value;
        })) {
        $problems[] = "{$label} needs exactly the text fields ".implode(', ', EXCEPTION_KEYS).'.';

        continue;
    }
    $problemCount = count($problems);
    if (!in_array($exception['reason'], EXCEPTION_REASONS, true)) {
        $problems[] = "{$label} has reason \"{$exception['reason']}\". Use \"".implode('" or "', EXCEPTION_REASONS).'".';
    }
    $recheck = DateTimeImmutable::createFromFormat('!Y-m-d', $exception['recheck'], new DateTimeZone('UTC'));
    if (false === $recheck || $recheck->format('Y-m-d') !== $exception['recheck']) {
        $problems[] = "{$label} has recheck \"{$exception['recheck']}\". Use a YYYY-MM-DD date.";
    } elseif ($recheck <= $today) {
        $problems[] = "{$exception['advisory']} reached its recheck date. Review it, then update or remove the entry.";
    } elseif ($recheck > $latestRecheck) {
        $problems[] = "{$exception['advisory']} rechecks more than ".MAX_RECHECK_DAYS.' days out. Pick an earlier date.';
    }
    $path = array_map('trim', explode('>', $exception['path']));
    $listed[$exception['advisory']] = [
        'package' => end($path),
        'path' => $exception['path'],
        'used' => false,
        'valid' => count($problems) === $problemCount,
    ];
}

foreach (is_array($audit['abandoned']) ? $audit['abandoned'] : [] as $package => $replacement) {
    $problems[] = "{$package} is abandoned. Replace it".(is_string($replacement) ? " with {$replacement}" : '').'.';
}

foreach (is_array($audit['ignored-advisories'] ?? null) ? $audit['ignored-advisories'] : [] as $package => $advisories) {
    foreach (is_array($advisories) ? $advisories : [] as $advisory) {
        $name = is_array($advisory) ? (advisory_ids($advisory)[0] ?? 'an advisory') : 'an advisory';
        $problems[] = "{$package} has {$name}, which the Composer config ignores. Remove that ignore rule, then update the package.";
    }
}

foreach (is_array($audit['filter'] ?? null) ? $audit['filter'] : [] as $package => $entries) {
    foreach (is_array($entries) ? $entries : [] as $entry) {
        $list = is_array($entry) && is_string($entry['listName'] ?? null) ? $entry['listName'] : 'unnamed';
        $problems[] = "{$package} is on the Composer {$list} filter list. Replace it.";
    }
}

if ([] !== ($audit['unreachable-repositories'] ?? [])) {
    $problems[] = 'Composer could not reach a package repository, so the audit is incomplete. Check your network, then run it again.';
}

$findings = 0;
foreach (is_array($audit['advisories']) ? $audit['advisories'] : [] as $package => $advisories) {
    foreach (is_array($advisories) ? $advisories : [] as $advisory) {
        if (!is_array($advisory)) {
            continue;
        }
        ++$findings;
        $ids = advisory_ids($advisory);
        $name = $ids[0] ?? 'unknown advisory';
        if (isset($runtimePackages[$package])) {
            $problems[] = "{$package} ships with the SDK and has {$name}. Update it.";

            continue;
        }
        $match = null;
        foreach ($ids as $id) {
            if (isset($listed[$id]) && $listed[$id]['package'] === $package) {
                $match = $id;
            }
        }
        if (null === $match) {
            $problems[] = "{$package} has {$name}. Update it, or list it in ".EXCEPTIONS_FILE.' if no fix exists.';

            continue;
        }
        $listed[$match]['used'] = true;
        if (!$listed[$match]['valid']) {
            continue;
        }
        $fixed = fixed_release(
            (string) $package,
            $developmentPackages[$package] ?? '0.0.0',
            is_string($advisory['affectedVersions'] ?? null) ? $advisory['affectedVersions'] : '*',
        );
        if (null !== $fixed) {
            $problems[] = "{$package} {$fixed} fixes {$match}. Update it and remove the exception.";
        } else {
            printf("Allowed %s in %s until its recheck date.\n", $match, $listed[$match]['path']);
        }
    }
}

foreach ($listed as $id => $entry) {
    if (!$entry['used']) {
        $problems[] = "{$id} matches no audit finding. Remove it from ".EXCEPTIONS_FILE.'.';
    }
}

if ([] !== $problems) {
    foreach ($problems as $problem) {
        fwrite(STDERR, $problem."\n");
    }

    exit(1);
}

echo 0 === $findings
    ? "No advisories or abandoned packages found.\n"
    : "Every advisory is a reviewed development-only exception.\n";
