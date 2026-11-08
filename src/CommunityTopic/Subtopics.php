<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\CommunityTopic;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type SubtopicsShape = array{
 *   id: string,
 *   name: string,
 * }
 */
final class Subtopics implements BaseModel
{
    /** @use SdkModel<SubtopicsShape> */
    use SdkModel;

    /**
     * Subtopic ID, which topicId also takes.
     */
    #[Required]
    public string $id;

    /**
     * Subtopic name, which topic also takes.
     */
    #[Required]
    public string $name;

    /**
     * `new Subtopics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Subtopics::with(id: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Subtopics)->withId(...)->withName(...)
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
     */
    public static function with(string $id, string $name): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Subtopic ID, which topicId also takes.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Subtopic name, which topic also takes.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
