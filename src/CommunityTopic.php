<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\CommunityTopic\Subtopics;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type CommunityTopicShape = array{
 *   id: string,
 *   name: string,
 *   subtopics: list<Subtopics|array<string,mixed>>,
 * }
 */
final class CommunityTopic implements BaseModel
{
    /** @use SdkModel<CommunityTopicShape> */
    use SdkModel;

    /**
     * Topic ID. Pass it as topicId to /x/communities/popular.
     */
    #[Required]
    public string $id;

    /**
     * Topic name, which topic on /x/communities/popular takes.
     */
    #[Required]
    public string $name;

    /**
     * Narrower topics inside this topic.
     *
     * @var list<Subtopics> $subtopics
     */
    #[Required(list: Subtopics::class)]
    public array $subtopics;

    /**
     * `new CommunityTopic()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CommunityTopic::with(id: ..., name: ..., subtopics: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CommunityTopic)->withId(...)->withName(...)->withSubtopics(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<Subtopics|array<string,mixed>> $subtopics
     */
    public static function with(string $id, string $name, array $subtopics): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['name'] = $name;
        $self['subtopics'] = $subtopics;

        return $self;
    }

    /**
     * Topic ID. Pass it as topicId to /x/communities/popular.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Topic name, which topic on /x/communities/popular takes.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Narrower topics inside this topic.
     *
     * @param list<Subtopics|array<string,mixed>> $subtopics
     */
    public function withSubtopics(array $subtopics): self
    {
        $self = clone $this;
        $self['subtopics'] = $subtopics;

        return $self;
    }
}
