<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Events;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Events\EventStreamParams\IncludeModel;

/**
 * Streams the account's monitor events as server-sent events, each named by its event type and numbered by its event ID. A reconnect that sends Last-Event-ID first gets every event after that one from the last 30 days, then each new event. Set lookBack to also get events saved late. A connection lasts up to 30 minutes and sends a comment every 15 seconds while idle. Keep up to 200 streams open per account. Events and streams cost no credits. Add include=post_metrics to also get post.metrics frames. The first poll sends 1 for each post monitor with a check or a pause. After that, a frame comes when a monitor's saved numbers or status change. These frames carry no ID, so Last-Event-ID never moves.
 *
 * @see XTwitterScraper\Services\EventsService::stream()
 *
 * @phpstan-type EventStreamParamsShape = array{
 *   include?: IncludeModel|value-of<IncludeModel>|null,
 *   lookBack?: bool|null,
 * }
 */
final class EventStreamParams implements BaseModel
{
    /** @use SdkModel<EventStreamParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Set to post_metrics to also get each post monitor's saved numbers. Any other value is refused.
     *
     * @var value-of<IncludeModel>|null $include
     */
    #[Optional(enum: IncludeModel::class)]
    public ?string $include;

    /**
     * Set to true to resume 30 seconds before Last-Event-ID. Events saved late then still arrive. Events you have can arrive again, so skip IDs you've seen. An ID the stream can't find starts 5 minutes back, not 30 days.
     */
    #[Optional]
    public ?bool $lookBack;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param IncludeModel|value-of<IncludeModel>|null $include
     */
    public static function with(IncludeModel|string|null $include = null, ?bool $lookBack = null): self
    {
        $self = new self;

        null !== $include && $self['include'] = $include;
        null !== $lookBack && $self['lookBack'] = $lookBack;

        return $self;
    }

    /**
     * Set to post_metrics to also get each post monitor's saved numbers. Any other value is refused.
     *
     * @param IncludeModel|value-of<IncludeModel>|null $include
     */
    public function withInclude(IncludeModel|string|null $include): self
    {
        $self = clone $this;
        $self['include'] = $include;

        return $self;
    }

    /**
     * Set to true to resume 30 seconds before Last-Event-ID. Events saved late then still arrive. Events you have can arrive again, so skip IDs you've seen. An ID the stream can't find starts 5 minutes back, not 30 days.
     */
    public function withLookBack(?bool $lookBack): self
    {
        $self = clone $this;
        $self['lookBack'] = $lookBack;

        return $self;
    }
}
