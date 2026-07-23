<?php

declare(strict_types=1);

namespace Tests\Core;

use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkEnum;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkUnion;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Core\Conversion;
use XTwitterScraper\Core\Conversion\CoerceState;
use XTwitterScraper\Core\Conversion\Contracts\Converter;
use XTwitterScraper\Core\Conversion\Contracts\ConverterSource;
use XTwitterScraper\Core\Conversion\DumpState;
use XTwitterScraper\Core\Conversion\EnumOf;
use XTwitterScraper\Core\Conversion\ListOf;
use XTwitterScraper\Core\Conversion\MapOf;
use XTwitterScraper\Core\Conversion\ModelOf;
use XTwitterScraper\Core\Conversion\PropertyInfo;
use XTwitterScraper\Core\Conversion\UnionOf;
use XTwitterScraper\Core\FileParam;

enum ConversionKind: string
{
    case First = 'first';
    case Second = 'second';
}

final class ConversionJson implements \JsonSerializable
{
    /**
     * @return array<string,bool>
     */
    public function jsonSerialize(): array
    {
        return ['serialized' => true];
    }
}

/**
 * @phpstan-type ConversionRecordShape = array{
 *   display_name: string,
 *   nullable: int|null,
 *   optional?: int|null,
 *   unknown?: mixed,
 * }
 */
final class ConversionRecord implements BaseModel
{
    /** @use SdkModel<ConversionRecordShape> */
    use SdkModel;

    #[Required(apiName: 'display_name')]
    public string $name;

    #[Required(nullable: true)]
    public ?int $nullable;

    #[Optional]
    public ?int $optional;

    public function __construct(string $name, ?int $nullable)
    {
        $this->initialize();
        $this->name = $name;
        $this->nullable = $nullable;
    }
}

final class ConversionLabels implements ConverterSource
{
    use SdkEnum;

    public const FIRST = 'first';

    public const SECOND = 'second';

    private const PRIVATE_VALUE = 'private';

    public static function privateValue(): string
    {
        return self::PRIVATE_VALUE;
    }
}

final class ConversionUnion implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'kind';
    }

    /**
     * @return array<string,Converter|ConverterSource|string>
     */
    public static function variants(): array
    {
        return [
            'record' => ConversionRecord::class,
            'string' => 'string',
        ];
    }
}

final class IntersectionProperty
{
    #[Required]
    public \Countable&\Iterator $value;
}

/**
 * @internal
 */
#[RunTestsInSeparateProcesses]
final class ConversionTest extends TestCase
{
    #[Test]
    public function testPrimitiveCoercionTracksConfidence(): void
    {
        $cases = [
            ['mixed', 'value', 'value', [1, 0, 0]],
            ['null', null, null, [1, 0, 0]],
            ['null', 'value', null, [0, 0, 1]],
            ['bool', true, true, [1, 0, 0]],
            ['bool', 1, 1, [0, 1, 0]],
            ['int', 1, 1, [1, 0, 0]],
            ['int', 1.5, 1, [0, 0, 1]],
            ['int', '12', 12, [0, 0, 1]],
            ['int', 'no', 'no', [0, 1, 0]],
            ['float', 1, 1.0, [1, 0, 0]],
            ['float', '1.5', 1.5, [0, 0, 1]],
            ['float', 'no', 'no', [0, 1, 0]],
            ['string', 'value', 'value', [1, 0, 0]],
            ['string', 12, '12', [0, 0, 1]],
            ['string', false, false, [0, 1, 0]],
            ['DateTimeImmutable', '2026-01-02', new \DateTimeImmutable('2026-01-02'), [0, 0, 1]],
            ['DateTimeImmutable', 'invalid date value', 'invalid date value', [0, 1, 0]],
            ['DateTime', '2026-01-02', new \DateTime('2026-01-02'), [0, 0, 1]],
            ['DateTime', 'invalid date value', 'invalid date value', [0, 1, 0]],
            ['UnknownClass', 'value', 'value', [0, 1, 0]],
        ];

        foreach ($cases as [$target, $value, $expected, [$yes, $no, $maybe]]) {
            $state = new CoerceState;
            $actual = Conversion::coerce($target, $value, $state);
            $this->assertEquals($expected, $actual, $target);
            $this->assertSame($yes, $state->yes, "{$target} yes");
            $this->assertSame($no, $state->no, "{$target} no");
            $this->assertSame($maybe, $state->maybe, "{$target} maybe");
        }

        $generator = (static function (): \Generator {
            yield 'tweet';

            yield 2;
        })();
        $this->assertSame('tweet2', Conversion::coerce('string', $generator));

        $date = new \DateTimeImmutable('2026-01-02');
        $state = new CoerceState;
        $this->assertSame($date, Conversion::coerce(\DateTimeImmutable::class, $date, $state));
        $this->assertSame(1, $state->yes);
    }

    #[Test]
    public function testDumpUnknownSupportsSdkAndPhpValueTypes(): void
    {
        $state = new DumpState;
        $file = FileParam::fromString('content', 'file.txt');
        $record = new ConversionRecord('Xquik', null);
        $date = new \DateTimeImmutable('2026-01-02T03:04:05+00:00');

        $this->assertSame(['nested' => [1, 'two']], Conversion::dump_unknown(['nested' => [1, 'two']], $state));
        $this->assertSame($file, Conversion::dump_unknown($file, $state));
        $this->assertSame(
            ['display_name' => 'Xquik', 'nullable' => null],
            Conversion::dump_unknown($record, $state),
        );
        $this->assertSame('first', Conversion::dump_unknown(ConversionKind::First, $state));
        $this->assertSame('2026-01-02T03:04:05+00:00', Conversion::dump_unknown($date, $state));
        $this->assertSame(['serialized' => true], Conversion::dump_unknown(new ConversionJson, $state));
        $this->assertSame(['property' => 'value'], Conversion::dump_unknown((object) ['property' => 'value'], $state));
        $this->assertEquals((object) [], Conversion::dump_unknown(new \stdClass, $state));
        $this->assertSame('scalar', Conversion::dump_unknown('scalar', $state));

        $resource = fopen('php://temp', 'w+');
        $this->assertIsResource($resource);
        $resourceState = new DumpState;
        $this->assertSame($resource, Conversion::dump_unknown($resource, $resourceState));
        $this->assertFalse($resourceState->canRetry);
        fclose($resource);

        $generator = (static function (): \Generator {
            yield 'one-shot';
        })();
        $generatorState = new DumpState;
        $this->assertSame($generator, Conversion::dump_unknown($generator, $generatorState));
        $this->assertFalse($generatorState->canRetry);
    }

    #[Test]
    public function testConverterSourcesAndBackedEnumsAreReusable(): void
    {
        $record = new ConversionRecord('Xquik', 1);
        $coerced = Conversion::coerce(
            ConversionRecord::class,
            ['display_name' => 'SDK', 'nullable' => 2],
        );
        $this->assertInstanceOf(ConversionRecord::class, $coerced);
        $this->assertSame('SDK', $coerced->name);
        $this->assertSame($record, Conversion::coerce(ConversionRecord::class, $record));
        $this->assertSame(
            ['display_name' => 'Xquik', 'nullable' => 1],
            Conversion::dump(ConversionRecord::class, $record),
        );

        $this->assertSame('first', Conversion::coerce(ConversionKind::class, 'first'));
        $this->assertSame('first', Conversion::dump(ConversionKind::class, ConversionKind::First));

        $first = EnumOf::fromBackedEnum(ConversionKind::class);
        $this->assertSame($first, EnumOf::fromBackedEnum(ConversionKind::class));
        $this->assertSame('first', $first->coerce('first', new CoerceState));
        $this->assertSame('second', $first->dump(ConversionKind::Second, new DumpState));

        $this->assertSame(ConversionLabels::converter(), ConversionLabels::converter());
        $this->assertSame('second', Conversion::coerce(ConversionLabels::class, 'second'));
        $this->assertSame('private', ConversionLabels::privateValue());
    }

    #[Test]
    public function testCollectionConvertersHandleNullsMapsAndLists(): void
    {
        $list = new ListOf('int', nullable: true);
        $map = new MapOf('string', nullable: true);

        $coerceState = new CoerceState;
        $this->assertSame([1, null, 2], $list->coerce(['1', null, 2], $coerceState));
        $this->assertGreaterThan(0, $coerceState->yes);
        $this->assertSame('not-an-array', $list->coerce('not-an-array', new CoerceState));

        $dumpState = new DumpState;
        $this->assertSame(
            ['first' => 'one', 'empty' => null],
            $map->dump(['first' => 'one', 'empty' => null], $dumpState),
        );
        $this->assertSame([], $list->dump([], new DumpState));
        $this->assertEquals((object) [], $map->dump([], new DumpState));
        $this->assertSame('not-an-array', $map->dump('not-an-array', new DumpState));
    }

    #[Test]
    public function testEnumConverterScoresExactCompatibleAndInvalidValues(): void
    {
        $enum = new EnumOf(['first', 'second']);

        $exact = new CoerceState;
        $this->assertSame('first', $enum->coerce('first', $exact));
        $this->assertSame(1, $exact->yes);

        $compatible = new CoerceState;
        $this->assertSame('third', $enum->coerce('third', $compatible));
        $this->assertSame(1, $compatible->maybe);

        $invalid = new DumpState;
        $this->assertSame(3, $enum->dump(3, $invalid));
        $this->assertSame(1, $invalid->no);
    }

    #[Test]
    public function testUnionConverterResolvesDiscriminatorsAndBestAlternatives(): void
    {
        $discriminated = new UnionOf(
            ['record' => ConversionRecord::class, 'string' => 'string'],
            'kind',
        );
        $record = $discriminated->coerce(
            ['kind' => 'record', 'display_name' => 'Xquik', 'nullable' => null],
            new CoerceState,
        );
        $this->assertInstanceOf(ConversionRecord::class, $record);
        $this->assertSame('Xquik', $record->name);

        $nonStringDiscriminator = new CoerceState;
        $nonStringRecord = $discriminated->coerce(['kind' => 1], $nonStringDiscriminator);
        $this->assertInstanceOf(ConversionRecord::class, $nonStringRecord);
        $this->assertSame(1, $nonStringRecord['kind']);
        $this->assertGreaterThan(0, $nonStringDiscriminator->branched);

        $alternatives = new UnionOf(['int', 'float']);
        $alternativeState = new CoerceState;
        $this->assertSame(12, $alternatives->coerce('12', $alternativeState));
        $this->assertSame(1, $alternativeState->maybe);
        $this->assertSame(2, $alternativeState->branched);

        $exact = new CoerceState;
        $this->assertSame(12, (new UnionOf(['int', 'string']))->coerce(12, $exact));
        $this->assertSame(1, $exact->yes);

        $invalid = new CoerceState;
        $value = new \stdClass;
        $this->assertSame($value, (new UnionOf(['int', 'bool']))->coerce($value, $invalid));
        $this->assertSame(1, $invalid->no);

        $this->assertInstanceOf(
            ConversionRecord::class,
            Conversion::coerce(ConversionUnion::class, [
                'kind' => 'record',
                'display_name' => 'SDK',
                'nullable' => 1,
            ]),
        );
        $this->assertSame(ConversionUnion::converter(), ConversionUnion::converter());
    }

    #[Test]
    public function testUnionDumpHandlesModelsInstancesAlternativesAndFallback(): void
    {
        $record = new ConversionRecord('Xquik', null);
        $this->assertSame(
            ['display_name' => 'Xquik', 'nullable' => null],
            (new UnionOf([ConversionRecord::class, 'string']))->dump($record, new DumpState),
        );

        $json = new ConversionJson;
        $this->assertSame(
            ['serialized' => true],
            (new UnionOf([ConversionJson::class, 'string']))->dump($json, new DumpState),
        );

        $alternatives = new DumpState;
        $this->assertSame('12', (new UnionOf(['int', 'float']))->dump('12', $alternatives));
        $this->assertSame(1, $alternatives->maybe);

        $invalid = new DumpState;
        $value = new \stdClass;
        $this->assertEquals((object) [], (new UnionOf(['int', 'bool']))->dump($value, $invalid));
        $this->assertSame(1, $invalid->no);
    }

    #[Test]
    public function testModelConverterTracksMissingNullableOptionalAndUnknownFields(): void
    {
        $converter = new ModelOf(new \ReflectionClass(ConversionRecord::class));
        $state = new CoerceState;
        $record = $converter->coerce(
            ['display_name' => 'Xquik', 'unknown' => 'preserved'],
            $state,
        );

        $this->assertInstanceOf(ConversionRecord::class, $record);
        $this->assertSame('Xquik', $record->name);
        $this->assertFalse($record->offsetExists('nullable'));
        $this->assertSame('preserved', $record['unknown']);
        $this->assertGreaterThan(0, $state->yes);
        $this->assertGreaterThan(0, $state->maybe);

        $this->assertSame('invalid', $converter->coerce('invalid', new CoerceState));
        $this->assertSame([1], $converter->coerce([1], new CoerceState));
        $this->assertEquals((object) [], $converter->dump([], new DumpState));
        $this->assertSame('invalid', $converter->dump('invalid', new DumpState));

        $property = new \ReflectionProperty(IntersectionProperty::class, 'value');
        $this->expectException(\ValueError::class);
        new PropertyInfo($property);
    }
}
