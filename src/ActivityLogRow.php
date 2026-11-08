<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type ActivityLogRowShape = array{
 *   time: string,
 *   category: string,
 *   type: string,
 *   activity: string,
 *   status: string,
 *   source: string,
 *   target: string,
 *   results: mixed,
 *   credits: mixed,
 *   details: string,
 *   id: string,
 *   link: string,
 * }
 */
final class ActivityLogRow implements BaseModel
{
    /** @use SdkModel<ActivityLogRowShape> */
    use SdkModel;

    /**
     * ISO 8601 time in UTC to the millisecond. Empty on the notice row.
     */
    #[Required]
    public string $time;

    #[Required]
    public string $category;

    #[Required]
    public string $type;

    #[Required]
    public string $activity;

    #[Required]
    public string $status;

    #[Required]
    public string $source;

    #[Required]
    public string $target;

    #[Required]
    public mixed $results;

    #[Required]
    public mixed $credits;

    #[Required]
    public string $details;

    /**
     * Activity ID. GET /activity/{id} returns its full record.
     */
    #[Required]
    public string $id;

    #[Required]
    public string $link;

    /**
     * `new ActivityLogRow()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ActivityLogRow::with(time: ..., category: ..., type: ..., activity: ..., status: ..., source: ..., target: ..., results: ..., credits: ..., details: ..., id: ..., link: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ActivityLogRow)->withTime(...)->withCategory(...)->withType(...)->withActivity(...)->withStatus(...)->withSource(...)->withTarget(...)->withResults(...)->withCredits(...)->withDetails(...)->withId(...)->withLink(...)
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
    public static function with(string $time, string $category, string $type, string $activity, string $status, string $source, string $target, mixed $results, mixed $credits, string $details, string $id, string $link): self
    {
        $self = new self;

        $self['time'] = $time;
        $self['category'] = $category;
        $self['type'] = $type;
        $self['activity'] = $activity;
        $self['status'] = $status;
        $self['source'] = $source;
        $self['target'] = $target;
        $self['results'] = $results;
        $self['credits'] = $credits;
        $self['details'] = $details;
        $self['id'] = $id;
        $self['link'] = $link;

        return $self;
    }

    /**
     * ISO 8601 time in UTC to the millisecond. Empty on the notice row.
     */
    public function withTime(string $time): self
    {
        $self = clone $this;
        $self['time'] = $time;

        return $self;
    }

    public function withCategory(string $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }

    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    public function withActivity(string $activity): self
    {
        $self = clone $this;
        $self['activity'] = $activity;

        return $self;
    }

    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withSource(string $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    public function withTarget(string $target): self
    {
        $self = clone $this;
        $self['target'] = $target;

        return $self;
    }

    public function withResults(mixed $results): self
    {
        $self = clone $this;
        $self['results'] = $results;

        return $self;
    }

    public function withCredits(mixed $credits): self
    {
        $self = clone $this;
        $self['credits'] = $credits;

        return $self;
    }

    public function withDetails(string $details): self
    {
        $self = clone $this;
        $self['details'] = $details;

        return $self;
    }

    /**
     * Activity ID. GET /activity/{id} returns its full record.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withLink(string $link): self
    {
        $self = clone $this;
        $self['link'] = $link;

        return $self;
    }
}
