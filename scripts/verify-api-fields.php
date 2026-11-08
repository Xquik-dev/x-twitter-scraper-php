<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Core\Conversion\Contracts\ConverterSource;

const DEFAULT_SPEC = 'https://xquik.com/openapi.json';
const ACCEPTED_FILE = 'accepted-field-differences.json';
const EXCLUDED_FILE = 'excluded-operations.json';
const HTTP_METHODS = ['get', 'put', 'post', 'delete', 'options', 'head', 'patch', 'trace'];
const BODY_TYPES = ['application/json', 'multipart/form-data', 'application/x-www-form-urlencoded'];
const BASE_PATH = '/api/v1';
const LEAF_TYPES = ['string', 'int', 'float', 'bool', 'DateTimeInterface', 'DateTimeImmutable', 'DateTime'];

final class CheckFailure extends Exception {}

function unknown(): array
{
    return ['kind' => 'unknown'];
}

function freeForm(): array
{
    return ['kind' => 'free-form'];
}

function leaf(?array $values = null): array
{
    return ['kind' => 'leaf', 'values' => $values];
}

function listOf(array $items): array
{
    return ['kind' => 'array', 'items' => $items];
}

function objectNode(array $props = [], bool $open = false): array
{
    return ['kind' => 'object', 'props' => $props, 'open' => $open];
}

function prop(array $node, bool $required, ?bool $nullable, bool $obsolete = false): array
{
    return ['node' => $node, 'required' => $required, 'nullable' => $nullable, 'obsolete' => $obsolete];
}

function ofKind(array $nodes, string $kind): array
{
    return array_values(array_filter($nodes, static fn (array $node): bool => $node['kind'] === $kind));
}

function mergeObjects(array $objects): array
{
    $names = [];
    foreach ($objects as $node) {
        $names += array_flip(array_map('strval', array_keys($node['props'])));
    }
    $props = [];
    foreach (array_keys($names) as $name) {
        $name = (string) $name;
        $have = [];
        foreach ($objects as $node) {
            if (array_key_exists($name, $node['props'])) {
                $have[] = $node['props'][$name];
            }
        }
        $nullables = array_column($have, 'nullable');
        $hasUnknown = count($have) !== count(array_filter($have, static fn (array $item): bool => null !== $item['nullable']));
        $props[$name] = prop(
            merge(array_column($have, 'node')),
            count($have) === count($objects) && [] === array_filter($have, static fn (array $item): bool => !$item['required']),
            $hasUnknown ? null : in_array(true, $nullables, true),
            [] === array_filter($have, static fn (array $item): bool => !$item['obsolete']),
        );
    }
    $open = [] !== array_filter($objects, static fn (array $node): bool => $node['open']);

    return objectNode($props, $open);
}

function merge(array $nodes): array
{
    if ([] !== ofKind($nodes, 'free-form')) {
        return freeForm();
    }
    $objects = ofKind($nodes, 'object');
    if ([] !== $objects) {
        return mergeObjects($objects);
    }
    $arrays = ofKind($nodes, 'array');
    if ([] !== $arrays) {
        return listOf(merge(array_column($arrays, 'items')));
    }
    $leaves = ofKind($nodes, 'leaf');
    if ([] !== $leaves) {
        $values = [];
        foreach ($leaves as $node) {
            if (null === $node['values']) {
                return leaf();
            }
            $values = array_merge($values, $node['values']);
        }

        return leaf(array_values(array_unique($values)));
    }

    return unknown();
}

function intersect(array $nodes): array
{
    $objects = ofKind($nodes, 'object');
    $arrays = ofKind($nodes, 'array');
    if ([] === $objects && [] !== $arrays) {
        return listOf(intersect(array_column($arrays, 'items')));
    }
    if ([] === $objects) {
        foreach ($nodes as $node) {
            if (!in_array($node['kind'], ['unknown', 'free-form'], true)) {
                return $node;
            }
        }

        return unknown();
    }
    $props = [];
    foreach ($objects as $node) {
        foreach ($node['props'] as $name => $item) {
            $name = (string) $name;
            $earlier = $props[$name] ?? null;
            $props[$name] = null === $earlier ? $item : prop(
                intersect([$earlier['node'], $item['node']]),
                $earlier['required'] || $item['required'],
                (bool) $earlier['nullable'] && (bool) $item['nullable'],
                $earlier['obsolete'] && $item['obsolete'],
            );
        }
    }
    $open = [] !== array_filter($objects, static fn (array $node): bool => $node['open']);

    return objectNode($props, $open);
}

function joined(string $path, string $name): string
{
    return '' === $path ? $name : "{$path}.{$name}";
}

function compareNodes(array $spec, array $sdk, string $path, array &$found): void
{
    $opaque = static fn (array $node): bool => in_array($node['kind'], ['unknown', 'free-form'], true);
    if ('object' === $spec['kind'] && 'object' === $sdk['kind']) {
        foreach ($spec['props'] as $name => $wanted) {
            $name = (string) $name;
            $here = joined($path, $name);
            $got = $sdk['props'][$name] ?? null;
            if (null === $got) {
                $found[] = ['missing', $here];

                continue;
            }
            if ($wanted['required'] !== $got['required']) {
                $found[] = ['required', $here];
            }
            if (null !== $wanted['nullable'] && null !== $got['nullable'] && $wanted['nullable'] !== $got['nullable']) {
                $found[] = ['nullable', $here];
            }
            compareNodes($wanted['node'], $got['node'], $here, $found);
        }
        if (!$spec['open']) {
            foreach ($sdk['props'] as $name => $item) {
                if (!array_key_exists($name, $spec['props']) && !$item['obsolete']) {
                    $found[] = ['extra', joined($path, (string) $name)];
                }
            }
        }
    } elseif ('array' === $spec['kind'] && 'array' === $sdk['kind']) {
        compareNodes($spec['items'], $sdk['items'], "{$path}[]", $found);
    } elseif ('leaf' === $spec['kind'] && 'leaf' === $sdk['kind']) {
        if (null !== $spec['values'] && null !== $sdk['values']) {
            $first = $spec['values'];
            $second = $sdk['values'];
            sort($first);
            sort($second);
            if ($first !== $second) {
                $found[] = ['enum', '' === $path ? '(body)' : $path];
            }
        }
    } elseif (!$opaque($spec) && !$opaque($sdk)) {
        $found[] = ['missing', '' === $path ? '(body)' : $path];
    }
}

function differences(array $spec, array $sdk): array
{
    $request = [];
    compareNodes($spec['query'], $sdk['query'], '', $request);
    if (null !== $spec['body'] && null !== $sdk['body']) {
        compareNodes($spec['body'], $sdk['body'], '', $request);
    } elseif ('object' === ($spec['body']['kind'] ?? null)) {
        foreach (array_keys($spec['body']['props']) as $name) {
            $request[] = ['missing', (string) $name];
        }
    } elseif ('object' === ($sdk['body']['kind'] ?? null)) {
        foreach ($sdk['body']['props'] as $name => $item) {
            if (!$item['obsolete']) {
                $request[] = ['extra', (string) $name];
            }
        }
    }
    $response = [];
    if (null !== $spec['response']) {
        compareNodes($spec['response'], $sdk['response'] ?? leaf(), '', $response);
    }
    $lines = [];
    foreach ($request as [$kind, $path]) {
        $lines[] = "request {$kind} {$path}";
    }
    foreach ($response as [$kind, $path]) {
        $lines[] = "response {$kind} {$path}";
    }

    return $lines;
}

function operationKey(string $method, string $path): string
{
    return $method.' '.preg_replace('/\{[^{}\/]*\}/', '{}', $path);
}

final class SpecReader
{
    public function __construct(private array $document) {}

    public function shapes(): array
    {
        $shapes = [];
        foreach ($this->document['paths'] as $path => $item) {
            foreach (HTTP_METHODS as $method) {
                if (isset($item[$method])) {
                    $operation = $item[$method];
                    $absolute = $this->serverPath($operation['servers'] ?? null, $item['servers'] ?? null, $this->document['servers'] ?? null).$path;
                    $upper = strtoupper($method);
                    $shapes[operationKey($upper, $absolute)] = [
                        'label' => "{$upper} {$absolute}",
                        'shape' => $this->shape($item, $operation),
                    ];
                }
            }
        }

        return $shapes;
    }

    private function serverPath(?array ...$levels): string
    {
        foreach ($levels as $servers) {
            if (null !== $servers && [] !== $servers) {
                $path = parse_url($servers[0]['url'], PHP_URL_PATH);

                return rtrim(is_string($path) ? $path : '', '/');
            }
        }

        return '';
    }

    private function resolve(string $reference): mixed
    {
        $value = $this->document;
        foreach (explode('/', (string) preg_replace('/^#\//', '', $reference)) as $token) {
            $value = $value[str_replace(['~1', '~0'], ['/', '~'], $token)];
        }

        return $value;
    }

    private function node(array $schema, array $stack = []): array
    {
        $declared = $schema['type'] ?? null;
        $listsNull = is_array($declared) && in_array('null', $declared, true);
        if (is_string($schema['$ref'] ?? null)) {
            if (in_array($schema['$ref'], $stack, true)) {
                return ['node' => unknown(), 'nullable' => false];
            }
            $target = $this->node($this->resolve($schema['$ref']), [...$stack, $schema['$ref']]);

            return ['node' => $target['node'], 'nullable' => $target['nullable'] || $listsNull || true === ($schema['nullable'] ?? null)];
        }
        if ('null' === $declared) {
            return ['node' => unknown(), 'nullable' => true];
        }
        $nullable = true === ($schema['nullable'] ?? null) || $listsNull;
        $types = array_values(array_filter(is_array($declared) ? $declared : [$declared], static fn (mixed $name): bool => null !== $name && 'null' !== $name));
        if (array_key_exists('allOf', $schema)) {
            return $this->allOf($schema, $nullable, $stack);
        }
        foreach (['oneOf', 'anyOf'] as $key) {
            if (array_key_exists($key, $schema)) {
                return $this->choices($schema, $key, $nullable, $stack);
            }
        }
        if (array_key_exists('const', $schema)) {
            return ['node' => leaf([self::text($schema['const'])]), 'nullable' => $nullable];
        }
        if (array_key_exists('enum', $schema)) {
            $values = array_values(array_filter($schema['enum'], static fn (mixed $item): bool => null !== $item));

            return ['node' => leaf(array_map(self::text(...), $values)), 'nullable' => $nullable || in_array(null, $schema['enum'], true)];
        }
        if (is_array($schema['properties'] ?? null)) {
            return $this->properties($schema, $nullable, $stack);
        }
        if (in_array('object', $types, true)) {
            return ['node' => freeForm(), 'nullable' => $nullable];
        }
        if (in_array('array', $types, true) && array_key_exists('items', $schema)) {
            return ['node' => listOf($this->node($schema['items'], $stack)['node']), 'nullable' => $nullable];
        }

        return ['node' => leaf(), 'nullable' => $nullable];
    }

    private static function text(mixed $value): string
    {
        return is_bool($value) ? ($value ? 'true' : 'false') : (string) $value;
    }

    private function properties(array $schema, bool $nullable, array $stack): array
    {
        $required = $schema['required'] ?? [];
        $props = [];
        foreach ($schema['properties'] as $name => $value) {
            $read = $this->node($value, $stack);
            $props[(string) $name] = prop($read['node'], in_array($name, $required, true), $read['nullable']);
        }
        $extra = $schema['additionalProperties'] ?? null;

        return ['node' => objectNode($props, null !== $extra && false !== $extra), 'nullable' => $nullable];
    }

    private function allOf(array $schema, bool $nullable, array $stack): array
    {
        $parts = $schema['allOf'];
        $rest = $schema;
        unset($rest['allOf']);
        $nodes = array_map(fn (array $part): array => $this->node($part, $stack)['node'], $parts);
        if (array_key_exists('properties', $rest)) {
            $nodes[] = $this->node($rest, $stack)['node'];
        }
        $merged = intersect($nodes);
        $required = [];
        foreach ([...$parts, $rest] as $part) {
            if (!array_key_exists('properties', $part)) {
                $required = array_merge($required, $part['required'] ?? []);
            }
        }
        if ('object' !== $merged['kind'] || [] === $required) {
            return ['node' => $merged, 'nullable' => $nullable];
        }
        foreach ($merged['props'] as $name => $item) {
            if (in_array($name, $required, true)) {
                $merged['props'][$name]['required'] = true;
            }
        }

        return ['node' => $merged, 'nullable' => $nullable];
    }

    private function choices(array $schema, string $key, bool $starting, array $stack): array
    {
        $nullable = $starting;
        $variants = [];
        foreach ($schema[$key] as $branch) {
            if ('null' === ($branch['type'] ?? null)) {
                $nullable = true;
            } else {
                $read = $this->node($branch, $stack);
                $nullable = $nullable || $read['nullable'];
                $variants[] = $read['node'];
            }
        }
        if (array_key_exists('properties', $schema)) {
            $rest = $schema;
            unset($rest[$key]);
            $base = $this->node($rest, $stack)['node'];
            $variants = array_map(static fn (array $variant): array => intersect([$base, $variant]), $variants);
        }

        return ['node' => merge($variants), 'nullable' => $nullable];
    }

    private function content(array $value, array $accepted): ?array
    {
        $container = is_string($value['$ref'] ?? null) ? $this->resolve($value['$ref']) : $value;
        $nodes = [];
        foreach ($container['content'] ?? [] as $type => $media) {
            if (in_array(trim(explode(';', (string) $type)[0]), $accepted, true) && array_key_exists('schema', $media)) {
                $nodes[] = $this->node($media['schema'])['node'];
            }
        }

        return [] === $nodes ? null : merge($nodes);
    }

    private function shape(array $item, array $operation): array
    {
        $query = [];
        foreach ([...($item['parameters'] ?? []), ...($operation['parameters'] ?? [])] as $value) {
            $parameter = is_string($value['$ref'] ?? null) ? $this->resolve($value['$ref']) : $value;
            if ('query' === $parameter['in']) {
                $query[(string) $parameter['name']] = prop($this->node($parameter['schema'] ?? [])['node'], true === ($parameter['required'] ?? null), null);
            }
        }
        $responses = [];
        foreach ($operation['responses'] ?? [] as $code => $response) {
            if (str_starts_with((string) $code, '2')) {
                $node = $this->content($response, ['application/json']);
                if (null !== $node) {
                    $responses[] = $node;
                }
            }
        }

        return [
            'query' => objectNode($query),
            'body' => array_key_exists('requestBody', $operation) ? $this->content($operation['requestBody'], BODY_TYPES) : null,
            'response' => [] === $responses ? null : merge($responses),
        ];
    }
}

final class SdkReader
{
    private array $shapes = [];

    public array $problems = [];

    public function __construct(private string $root) {}

    public function operations(): array
    {
        $found = [];
        $source = new RecursiveIteratorIterator(new RecursiveDirectoryIterator("{$this->root}/src/Services", FilesystemIterator::SKIP_DOTS));
        foreach ($source as $file) {
            $path = (string) $file;
            if (str_ends_with($path, 'RawService.php')) {
                $this->readService($path, $found);
            }
        }

        return $found;
    }

    private function readService(string $path, array &$found): void
    {
        $text = (string) file_get_contents($path);
        $names = [];
        preg_match_all('/^use ([\w\\\\]+?)(?: as (\w+))?;$/m', $text, $uses, PREG_SET_ORDER);
        foreach ($uses as $use) {
            $parts = explode('\\', $use[1]);
            $names[$use[2] ?? end($parts)] = $use[1];
        }
        preg_match('/^namespace ([\w\\\\]+);$/m', $text, $namespace);
        $methods = preg_split('/\n    public function /', $text);
        foreach (array_slice($methods ?: [], 1) as $method) {
            if (!str_contains($method, '$this->client->request(')) {
                continue;
            }
            $read = $this->readMethod($method, $names, $namespace[1] ?? '', $path);
            if (null !== $read) {
                $found[$read['key']] = isset($found[$read['key']]) ? $this->combine($found[$read['key']], $read['shape']) : $read['shape'];
            }
        }
    }

    private function combine(array $first, array $second): array
    {
        return [
            'query' => mergeObjects([$first['query'], $second['query']]),
            'body' => null === $first['body'] || null === $second['body'] ? ($first['body'] ?? $second['body']) : merge([$first['body'], $second['body']]),
            'response' => null === $first['response'] || null === $second['response'] ? ($first['response'] ?? $second['response']) : merge([$first['response'], $second['response']]),
        ];
    }

    private function readMethod(string $method, array $names, string $namespace, string $path): ?array
    {
        $verb = preg_match("/method: '(\\w+)'/", $method, $match) ? strtoupper($match[1]) : null;
        $route = preg_match("/path: (?:\\[\\s*)?'([^']*)'/", $method, $match) ? $match[1] : null;
        if (null === $verb || null === $route) {
            $this->problems[$path.' builds a request the check cannot read.'] = true;

            return null;
        }
        $key = operationKey($verb, BASE_PATH.'/'.preg_replace('/%\d+\$s/', '{}', $route));
        $response = null;
        if (preg_match('/convert: new ListOf\((\w+)::class\)/', $method, $match)) {
            $response = listOf($this->classNode($this->className($match[1], $names, $namespace), []));
        } elseif (preg_match('/convert: (\w+)::class/', $method, $match)) {
            $response = $this->classNode($this->className($match[1], $names, $namespace), []);
        }
        $query = objectNode();
        $body = null;
        if (preg_match('/(\w+)::parseRequest\(/', $method, $match)) {
            [$query, $body] = $this->requestShape($this->className($match[1], $names, $namespace), $method);
        }

        return ['key' => $key, 'shape' => ['query' => $query, 'body' => $body, 'response' => $response]];
    }

    private function className(string $name, array $names, string $namespace): string
    {
        return $names[$name] ?? "{$namespace}\\{$name}";
    }

    private function requestShape(string $class, string $method): array
    {
        $fields = $this->fields(new ReflectionClass($class), [$class]);
        $renames = [];
        preg_match_all("/'(\\w+)' => '(\\w+)'/", $method, $pairs, PREG_SET_ORDER);
        foreach ($pairs as $pair) {
            $renames[$pair[1]] = $pair[2];
        }
        $listed = [];
        preg_match_all('/array_flip\(\s*\[([^\]]*)\]\s*\)/', $method, $flips);
        foreach ($flips[1] as $list) {
            preg_match_all("/'(\\w+)'/", $list, $items);
            $listed = array_merge($listed, $items[1]);
        }
        $headerOnly = [];
        if (preg_match('/headers: Util::array_transform_keys\(\s*array_intersect_key\(\s*\$parsed,\s*array_flip\(\s*\[([^\]]*)\]/', $method, $match)) {
            preg_match_all("/'(\\w+)'/", $match[1], $items);
            $headerOnly = $items[1];
        }
        $splitQuery = str_contains($method, '$query_params');
        $wholeQuery = (bool) preg_match('/query: (Util::array_transform_keys\(\s*)?\$parsed/', $method);
        $hasBody = (bool) preg_match('/body: /', $method);
        $query = [];
        $body = [];
        foreach ($fields as $property => $field) {
            if (in_array($property, $headerOnly, true)) {
                continue;
            }
            $name = $field['name'];
            if ($wholeQuery || ($splitQuery && (in_array($property, $listed, true) || in_array($name, $listed, true)))) {
                $query[$renames[$property] ?? $name] = $field['prop'];
            } else {
                $body[$name] = $field['prop'];
            }
        }

        return [objectNode($query), $hasBody ? objectNode($body) : null];
    }

    private function fields(ReflectionClass $class, array $stack): array
    {
        $fields = [];
        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $attributes = $property->getAttributes(Required::class, ReflectionAttribute::IS_INSTANCEOF);
            if ([] === $attributes) {
                continue;
            }
            $attribute = $attributes[0];
            $arguments = $attribute->getArguments();
            $required = Optional::class !== $attribute->getName();
            $nullable = $required ? (bool) $property->getType()?->allowsNull() : (($arguments['nullable'] ?? false) ? true : null);
            $fields[$property->getName()] = [
                'name' => $arguments[0] ?? $arguments['apiName'] ?? $property->getName(),
                'prop' => prop(
                    $this->propertyNode($property, $arguments, $stack),
                    $required,
                    $nullable,
                    str_contains((string) $property->getDocComment(), '@deprecated'),
                ),
            ];
        }

        return $fields;
    }

    private function propertyNode(ReflectionProperty $property, array $arguments, array $stack): array
    {
        if (array_key_exists('map', $arguments)) {
            return freeForm();
        }
        if (array_key_exists('list', $arguments)) {
            return listOf($this->typeNode($arguments['list'], $stack));
        }
        if (array_key_exists('enum', $arguments)) {
            return $this->typeNode($arguments['enum'], $stack);
        }
        if (array_key_exists('union', $arguments)) {
            return $this->typeNode($arguments['union'], $stack);
        }
        if (array_key_exists('type', $arguments)) {
            return $this->typeNode($arguments['type'], $stack);
        }
        $type = $property->getType();
        if (!$type instanceof ReflectionNamedType) {
            return unknown();
        }
        if ('array' === $type->getName()) {
            return freeForm();
        }

        return $this->typeNode($type->getName(), $stack);
    }

    private function typeNode(mixed $type, array $stack): array
    {
        if (!is_string($type) || 'mixed' === $type) {
            return unknown();
        }
        if (in_array(ltrim($type, '\\'), LEAF_TYPES, true) || 'null' === $type) {
            return leaf();
        }

        return $this->classNode($type, $stack);
    }

    private function classNode(string $class, array $stack): array
    {
        if (in_array($class, $stack, true)) {
            return unknown();
        }
        if (!class_exists($class) && !enum_exists($class)) {
            $this->problems["The SDK names the type {$class}, which the check cannot read."] = true;

            return unknown();
        }
        if (isset($this->shapes[$class])) {
            return $this->shapes[$class];
        }
        $reflection = new ReflectionClass($class);
        if ($reflection->isEnum()) {
            $values = array_map(static fn (BackedEnum $case): string => (string) $case->value, $class::cases());

            return $this->shapes[$class] = leaf($values);
        }
        if ($reflection->implementsInterface(ConverterSource::class) && method_exists($class, 'variants')) {
            $variants = array_map(fn (mixed $variant): array => $this->typeNode($variant, [...$stack, $class]), array_values($class::variants()));

            return $this->shapes[$class] = merge($variants);
        }
        if (!$reflection->implementsInterface(BaseModel::class)) {
            return leaf();
        }
        $props = [];
        foreach ($this->fields($reflection, [...$stack, $class]) as $field) {
            $props[(string) $field['name']] = $field['prop'];
        }

        return $this->shapes[$class] = objectNode($props);
    }
}

function readList(string $file, string $key, string $pattern): array
{
    $text = @file_get_contents($file);
    if (false === $text) {
        throw new CheckFailure("{$file} cannot be read. Fix it in the format CONTRIBUTING.md shows under API fields.");
    }
    $groups = json_decode($text, true);
    if (!is_array($groups)) {
        throw new CheckFailure("{$file} is not valid JSON. Fix it in the format CONTRIBUTING.md shows under API fields.");
    }
    $entries = [];
    foreach ($groups as $index => $group) {
        $number = (int) $index + 1;
        if (!is_array($group) || 2 !== count($group) || !is_string($group['reason'] ?? null) || '' === trim($group['reason']) || !is_array($group[$key] ?? null) || [] === $group[$key]) {
            throw new CheckFailure("{$file} is not valid. Group {$number} must hold a non-empty reason and at least 1 entry in {$key}.");
        }
        foreach ($group[$key] as $item) {
            if (!is_string($item) || !preg_match($pattern, $item)) {
                throw new CheckFailure("{$file} is not valid. Group {$number} lists ".json_encode($item).'.');
            }
            if (isset($entries[$item])) {
                throw new CheckFailure("{$file} is not valid. {$item} appears more than once.");
            }
            $entries[$item] = true;
        }
    }

    return $entries;
}

function loadSpec(string $source): array
{
    $text = @file_get_contents($source, false, stream_context_create(['http' => ['timeout' => 60]]));
    $document = false === $text ? null : json_decode($text, true);
    if (!is_array($document)) {
        throw new CheckFailure("Could not read the API spec from {$source}. Check network access, or set XQUIK_OPENAPI_SPEC to a local copy of ".DEFAULT_SPEC.'.');
    }

    return $document;
}

function run(string $root, string $source): string
{
    $methods = 'GET|PUT|POST|DELETE|OPTIONS|HEAD|PATCH|TRACE';
    $accepted = readList("{$root}/".ACCEPTED_FILE, 'differences', "#^({$methods}) /\\S* (request|response) (missing|extra|enum|required|nullable) \\S+$#");
    $excluded = readList("{$root}/".EXCLUDED_FILE, 'operations', "#^({$methods}) /\\S*$#");
    $spec = (new SpecReader(loadSpec($source)))->shapes();
    $reader = new SdkReader($root);
    $sdk = $reader->operations();
    if ([] !== $reader->problems) {
        throw new CheckFailure(implode("\n", array_keys($reader->problems))."\nWrite each line above in the style of the existing code, or teach scripts/verify-api-fields.php the new form.");
    }
    $skipped = [];
    foreach (array_keys($excluded) as $entry) {
        [$method, $path] = explode(' ', (string) $entry, 2);
        $skipped[operationKey($method, $path)] = true;
        if (!isset($spec[operationKey($method, $path)])) {
            throw new CheckFailure(EXCLUDED_FILE." lists {$entry}, which the API no longer has. Remove it.");
        }
    }
    $found = [];
    $compared = 0;
    $uncovered = [];
    foreach ($spec as $key => $operation) {
        if (isset($skipped[$key])) {
            continue;
        }
        if (!isset($sdk[$key])) {
            $uncovered[] = "{$operation['label']} is in the API but not in the SDK.";

            continue;
        }
        ++$compared;
        foreach (differences($operation['shape'], $sdk[$key]) as $line) {
            $found["{$operation['label']} {$line}"] = true;
        }
    }
    $unaccepted = array_keys(array_diff_key($found, $accepted));
    sort($unaccepted);
    $stale = array_map(static fn (int|string $line): string => ACCEPTED_FILE." lists {$line}, which the check no longer finds. Remove it.", array_keys(array_diff_key($accepted, $found)));
    if ([] !== $uncovered || [] !== $unaccepted) {
        $help = 'Fix each line above in the SDK, list a field in '.ACCEPTED_FILE.' or an operation in '.EXCLUDED_FILE.' with a reason.';

        throw new CheckFailure(implode("\n", [...$uncovered, ...$unaccepted, ...$stale, $help]));
    }
    if ([] !== $stale) {
        throw new CheckFailure(implode("\n", [...$stale, 'Remove each entry above from its file.']));
    }

    return "The SDK's fields match the API for {$compared} operations, and ".ACCEPTED_FILE.' lists '.count($accepted).' accepted differences.';
}

$root = dirname(__DIR__);

require "{$root}/vendor/autoload.php";

if (in_array('--list', $argv, true)) {
    $spec = (new SpecReader(loadSpec(getenv('XQUIK_OPENAPI_SPEC') ?: DEFAULT_SPEC)))->shapes();
    $reader = new SdkReader($root);
    $sdk = $reader->operations();
    foreach ($spec as $key => $operation) {
        if (isset($sdk[$key])) {
            foreach (differences($operation['shape'], $sdk[$key]) as $line) {
                echo "{$operation['label']} {$line}\n";
            }
        } else {
            echo "{$operation['label']} uncovered\n";
        }
    }
    foreach (array_keys($reader->problems) as $problem) {
        echo "problem {$problem}\n";
    }

    exit(0);
}

try {
    echo run($root, getenv('XQUIK_OPENAPI_SPEC') ?: DEFAULT_SPEC), "\n";
} catch (CheckFailure $failure) {
    fwrite(STDERR, $failure->getMessage()."\n");

    exit(1);
}
