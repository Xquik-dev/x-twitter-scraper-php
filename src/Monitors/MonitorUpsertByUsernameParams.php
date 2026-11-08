<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Monitors;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\EventType;

/**
 * Creates the monitor if it does not exist, or updates it if it does. Send the same call twice & you still have 1 monitor. A new monitor answers 201 & an update answers 200. Both carry `created`, so you know which one ran. Creating needs the credits of the first hour, then costs 30 credits an hour. A stopped monitor turns back on & counts as created. Updating is free & replaces the event types. It changes the name only when you send one.
 *
 * @see XTwitterScraper\Services\MonitorsService::upsertByUsername()
 *
 * @phpstan-type MonitorUpsertByUsernameParamsShape = array{
 *   eventTypes: list<EventType|value-of<EventType>>,
 *   name?: string|null,
 * }
 */
final class MonitorUpsertByUsernameParams implements BaseModel
{
    /** @use SdkModel<MonitorUpsertByUsernameParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Array of event types to subscribe to.
     *
     * @var list<value-of<EventType>> $eventTypes
     */
    #[Required(list: EventType::class)]
    public array $eventTypes;

    /**
     * Your label for the monitor. Its events carry it as monitorName. Leave it out to keep the current label, or send null to remove it.
     */
    #[Optional(nullable: true)]
    public ?string $name;

    /**
     * `new MonitorUpsertByUsernameParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MonitorUpsertByUsernameParams::with(eventTypes: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MonitorUpsertByUsernameParams)->withEventTypes(...)
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
     * @param list<EventType|value-of<EventType>> $eventTypes
     */
    public static function with(array $eventTypes, ?string $name = null): self
    {
        $self = new self;

        $self['eventTypes'] = $eventTypes;

        null !== $name && $self['name'] = $name;

        return $self;
    }

    /**
     * Array of event types to subscribe to.
     *
     * @param list<EventType|value-of<EventType>> $eventTypes
     */
    public function withEventTypes(array $eventTypes): self
    {
        $self = clone $this;
        $self['eventTypes'] = $eventTypes;

        return $self;
    }

    /**
     * Your label for the monitor. Its events carry it as monitorName. Leave it out to keep the current label, or send null to remove it.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
