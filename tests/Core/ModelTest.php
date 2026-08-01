<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests\Core;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Compose\ComposeNewResponse\ComposePrepareResult\ScorerWeight;
use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Core\FileParam;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\UserProfile\HighlightsInfo;
use XTwitterScraper\X\Tweets\TweetGetRepliesResponse\Diagnostic\StrategiesAttempted;
use XTwitterScraper\X\Tweets\TweetGetRepliesResponse\Diagnostic\StrategiesAttempted\StopReason;

class Dog implements BaseModel
{
    /** @use SdkModel<array<string, mixed>> */
    use SdkModel;

    #[Required]
    public string $name;

    #[Required('age_years')]
    public int $ageYears;

    /** @var list<string>|null */
    #[Optional]
    public ?array $friends;

    #[Required]
    public ?string $owner;

    /**
     * @param list<string>|null $friends
     */
    public function __construct(
        string $name,
        int $ageYears,
        ?string $owner,
        ?array $friends = null,
    ) {
        $this->initialize();

        $this->name = $name;
        $this->ageYears = $ageYears;
        $this->owner = $owner;

        null !== $friends && $this['friends'] = $friends;
    }
}

/**
 * @phpstan-type KennelShape = array{dog: Dog, dogs: list<Dog>}
 */
class Kennel implements BaseModel
{
    /** @use SdkModel<KennelShape> */
    use SdkModel;

    #[Required]
    public Dog $dog;

    /** @var list<Dog> */
    #[Required(list: Dog::class)]
    public array $dogs;

    /**
     * @param list<Dog> $dogs
     */
    public function __construct(Dog $dog, array $dogs)
    {
        $this->initialize();
        $this->dog = $dog;
        $this->dogs = $dogs;
    }
}

/**
 * @phpstan-type UploadParamsShape = array{file: FileParam}
 */
class UploadParams implements BaseModel
{
    /** @use SdkModel<UploadParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public FileParam $file;

    public function __construct(FileParam $file)
    {
        $this->initialize();
        $this->file = $file;
    }
}

/**
 * @internal
 */
class ModelTest extends TestCase
{
    #[Test]
    public function testNullOnlyGeneratedPropertiesRemainPhp81Compatible(): void
    {
        $weight = ScorerWeight::with(context: 'ranking', signal: 'reply', weight: null);
        $expected = ['context' => 'ranking', 'signal' => 'reply', 'weight' => null];
        $this->assertSame($expected, $weight->toProperties());
        $this->assertSame($expected, $weight->withWeight(null)->toProperties());
        $this->assertSame($expected, ScorerWeight::fromArray([
            'context' => 'ranking',
            'signal' => 'reply',
            'weight' => 'not-published',
        ])->toProperties());

        $factory = new \ReflectionMethod(ScorerWeight::class, 'with');
        $setter = new \ReflectionMethod(ScorerWeight::class, 'withWeight');
        foreach ([
            static fn (): mixed => $factory->invoke(null, 'ranking', 'reply', 1),
            static fn (): mixed => $setter->invoke($weight, 1),
        ] as $operation) {
            try {
                $operation();
                $this->fail('Expected a non-null scorer weight to fail.');
            } catch (\TypeError $exception) {
                $this->assertSame('Scorer weight must be null.', $exception->getMessage());
            }
        }
    }

    #[Test]
    public function testBasicGetAndSet(): void
    {
        $model = new Dog(name: 'Bob', ageYears: 12, owner: null);
        $this->assertEquals(12, $model->ageYears);

        ++$model->ageYears;
        $this->assertEquals(13, $model->ageYears);
    }

    #[Test]
    public function testNullAccess(): void
    {
        $model = new Dog(name: 'Bob', ageYears: 12, owner: null);
        $this->assertNull($model->owner);
        $this->assertNull($model->friends);
    }

    #[Test]
    public function testArrayGetAndSet(): void
    {
        $model = new Dog(name: 'Bob', ageYears: 12, owner: null);
        $model->friends ??= [];
        $this->assertEquals([], $model->friends);
        $model->friends[] = 'Alice';
        $this->assertEquals(['Alice'], $model->friends);
    }

    #[Test]
    public function testDiscernsBetweenNullAndUnset(): void
    {
        $modelUnsetFriends = new Dog(name: 'Bob', ageYears: 12, owner: null);
        $modelNullFriends = new Dog(name: 'bob', ageYears: 12, owner: null);
        $modelNullFriends->friends = null;

        $this->assertEquals(12, $modelUnsetFriends->ageYears);
        $this->assertEquals(12, $modelNullFriends->ageYears);

        $this->assertTrue($modelUnsetFriends->offsetExists('ageYears'));
        $this->assertTrue($modelNullFriends->offsetExists('ageYears'));

        $this->assertNull($modelUnsetFriends->friends);
        $this->assertNull($modelNullFriends->friends);

        $this->assertFalse($modelUnsetFriends->offsetExists('friends'));
        $this->assertTrue($modelNullFriends->offsetExists('friends'));
    }

    #[Test]
    public function testIssetOnOmittedProperties(): void
    {
        $model = new Dog(name: 'Bob', ageYears: 12, owner: null);
        $this->assertFalse(isset($model->owner));
        $this->assertFalse(isset($model->friends));
    }

    #[Test]
    public function testSerializeBasicModel(): void
    {
        $model = new Dog(name: 'Bob', ageYears: 12, owner: 'Eve', friends: ['Alice', 'Charlie']);
        $this->assertEquals(
            '{"name":"Bob","age_years":12,"friends":["Alice","Charlie"],"owner":"Eve"}',
            json_encode($model)
        );
    }

    #[Test]
    public function testSerializeModelWithOmittedProperties(): void
    {
        $model = new Dog(name: 'Bob', ageYears: 12, owner: null);
        $this->assertEquals(
            '{"name":"Bob","age_years":12,"owner":null}',
            json_encode($model)
        );
    }

    #[Test]
    public function testEmptyModelsAndBackedEnumInputsSerializeSafely(): void
    {
        $this->assertSame('{}', json_encode(new HighlightsInfo, JSON_THROW_ON_ERROR));

        $strategy = StrategiesAttempted::with(
            name: 'search',
            newDirectReplies: 12,
            newNestedReplies: 3,
            pagesAttempted: 2,
            stopReason: StopReason::EMPTY_PAGES,
        );

        $this->assertSame(StopReason::EMPTY_PAGES->value, $strategy->stopReason);
        $this->assertSame(StopReason::EMPTY_PAGES->value, $strategy->toProperties()['stopReason']);
    }

    #[Test]
    public function testSerializeModelWithExplicitNull(): void
    {
        $model = new Dog(name: 'Bob', ageYears: 12, owner: null);
        $model->friends = null;
        $this->assertEquals(
            '{"name":"Bob","age_years":12,"friends":null,"owner":null}',
            json_encode($model)
        );
    }

    #[Test]
    public function testNativeSerializationDebugAndStringRepresentations(): void
    {
        $model = new Dog(name: 'Bob', ageYears: 12, owner: 'Eve', friends: ['Alice']);
        $serialized = serialize($model);
        $restored = unserialize($serialized);

        $this->assertInstanceOf(Dog::class, $restored);
        $this->assertSame($model->toProperties(), $restored->toProperties());
        $this->assertSame($model->__serialize(), $model->__debugInfo());
        $this->assertStringContainsString('"name": "Bob"', (string) $model);
        $this->assertSame(Dog::converter(), Dog::converter());
    }

    #[Test]
    public function testNestedModelsSerializeRecursively(): void
    {
        $dog = new Dog(name: 'Bob', ageYears: 12, owner: null);
        $kennel = new Kennel($dog, [$dog]);

        $this->assertSame([
            'dog' => ['name' => 'Bob', 'ageYears' => 12, 'owner' => null],
            'dogs' => [['name' => 'Bob', 'ageYears' => 12, 'owner' => null]],
        ], $kennel->__serialize());
        $this->assertSame([
            'dog' => ['name' => 'Bob', 'age_years' => 12, 'owner' => null],
            'dogs' => [['name' => 'Bob', 'age_years' => 12, 'owner' => null]],
        ], $kennel->jsonSerialize());
    }

    #[Test]
    public function testUnknownAndIncongruentPayloadValuesRemainAccessible(): void
    {
        $model = Dog::fromArray([
            'name' => 'Bob',
            'ageYears' => 'not-an-integer',
            'owner' => null,
            'unknown' => 'preserved',
        ]);

        $this->assertSame('not-an-integer', $model['ageYears']);
        $this->assertSame('preserved', $model['unknown']);
        $this->assertTrue($model->offsetExists('unknown'));
        $this->assertFalse($model->offsetExists('missing'));
        $this->assertNull($model['missing']);

        try {
            $unused = $model->ageYears;
            $this->fail('Expected incongruent native property access to fail.');
        } catch (\Exception $exception) {
            $this->assertStringContainsString('array access', $exception->getMessage());
        }

        $model['ageYears'] = 13;
        $this->assertSame(13, $model->ageYears);
        $model->offsetUnset('unknown');
        $this->assertFalse($model->offsetExists('unknown'));
    }

    #[Test]
    public function testMissingMagicPropertyReportsTheModelType(): void
    {
        $model = new Dog(name: 'Bob', ageYears: 12, owner: null);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage("Property 'missing' does not exist");
        $model->__get('missing');
    }

    #[Test]
    public function testArrayAccessRejectsNonStringOffsets(): void
    {
        $model = new Dog(name: 'Bob', ageYears: 12, owner: null);
        $operations = [
            ['offsetExists', [1]],
            ['offsetGet', [1]],
            ['offsetSet', [1, 'value']],
            ['offsetUnset', [1]],
        ];

        foreach ($operations as [$methodName, $arguments]) {
            try {
                $method = new \ReflectionMethod($model, $methodName);
                $method->invokeArgs($model, $arguments);
                $this->fail('Expected the non-string offset to fail.');
            } catch (\InvalidArgumentException) {
                $this->addToAssertionCount(1);
            }
        }
    }

    #[Test]
    public function testRequestParamsDisableRetriesForOneShotInputs(): void
    {
        $safe = new UploadParams(FileParam::fromString('content', 'file.txt'));
        [$safeBody, $safeOptions] = UploadParams::parseRequest(
            $safe,
            RequestOptions::with(maxRetries: 5),
        );
        $this->assertInstanceOf(FileParam::class, $safeBody['file']);
        $this->assertSame(5, $safeOptions->maxRetries);

        $resource = fopen('php://temp', 'w+');
        $this->assertIsResource($resource);
        fwrite($resource, 'content');
        rewind($resource);
        $oneShot = new UploadParams(FileParam::fromResource($resource, 'file.txt'));
        [$oneShotBody, $oneShotOptions] = UploadParams::parseRequest(
            $oneShot,
            RequestOptions::with(maxRetries: 5),
        );
        $this->assertInstanceOf(FileParam::class, $oneShotBody['file']);
        $this->assertSame(0, $oneShotOptions->maxRetries);
        fclose($resource);
    }
}
