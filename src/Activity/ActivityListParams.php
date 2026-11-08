<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Activity;

use XTwitterScraper\Activity\ActivityListParams\Format;
use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Returns the account's activity log, newest first, with the Activity page's filters. It covers write actions, extractions, monitor changes and events, webhooks, giveaways, media, support, API keys, X account connections and billing. Pick a file format to get the same rows as a CSV, Excel, Markdown, PDF or text file.
 *
 * @see XTwitterScraper\Services\ActivityService::list()
 *
 * @phpstan-type ActivityListParamsShape = array{
 *   format?: Format|value-of<Format>|null,
 *   limit?: int|null,
 *   category?: string|null,
 *   status?: string|null,
 *   q?: string|null,
 *   since?: \DateTimeInterface|null,
 *   until?: \DateTimeInterface|null,
 * }
 */
final class ActivityListParams implements BaseModel
{
    /** @use SdkModel<ActivityListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Answer format. JSON by default.
     *
     * @var value-of<Format>|null $format
     */
    #[Optional(enum: Format::class)]
    public ?string $format;

    /**
     * Most rows to return, with no upper limit. A PDF above 10,000 rows comes as a ZIP of PDF parts.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Activity group, like the Activity page's tabs. `all` by default, or `actions`, `extractions`, `monitors`, `webhooks` or `billing`.
     */
    #[Optional]
    public ?string $category;

    /**
     * Comma-separated statuses.
     */
    #[Optional]
    public ?string $status;

    /**
     * Search text.
     */
    #[Optional]
    public ?string $q;

    /**
     * Oldest time, ISO 8601.
     */
    #[Optional]
    public ?\DateTimeInterface $since;

    /**
     * Newest time, ISO 8601.
     */
    #[Optional]
    public ?\DateTimeInterface $until;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Format|value-of<Format>|null $format
     */
    public static function with(Format|string|null $format = null, ?int $limit = null, ?string $category = null, ?string $status = null, ?string $q = null, ?\DateTimeInterface $since = null, ?\DateTimeInterface $until = null): self
    {
        $self = new self;

        null !== $format && $self['format'] = $format;
        null !== $limit && $self['limit'] = $limit;
        null !== $category && $self['category'] = $category;
        null !== $status && $self['status'] = $status;
        null !== $q && $self['q'] = $q;
        null !== $since && $self['since'] = $since;
        null !== $until && $self['until'] = $until;

        return $self;
    }

    /**
     * Answer format. JSON by default.
     *
     * @param Format|value-of<Format>|null $format
     */
    public function withFormat(Format|string|null $format): self
    {
        $self = clone $this;
        $self['format'] = $format;

        return $self;
    }

    /**
     * Most rows to return, with no upper limit. A PDF above 10,000 rows comes as a ZIP of PDF parts.
     */
    public function withLimit(?int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Activity group, like the Activity page's tabs. `all` by default, or `actions`, `extractions`, `monitors`, `webhooks` or `billing`.
     */
    public function withCategory(?string $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }

    /**
     * Comma-separated statuses.
     */
    public function withStatus(?string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * Search text.
     */
    public function withQ(?string $q): self
    {
        $self = clone $this;
        $self['q'] = $q;

        return $self;
    }

    /**
     * Oldest time, ISO 8601.
     */
    public function withSince(?\DateTimeInterface $since): self
    {
        $self = clone $this;
        $self['since'] = $since;

        return $self;
    }

    /**
     * Newest time, ISO 8601.
     */
    public function withUntil(?\DateTimeInterface $until): self
    {
        $self = clone $this;
        $self['until'] = $until;

        return $self;
    }
}
