<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\ActivityRecord\Caller;
use XTwitterScraper\ActivityRecord\Charge;
use XTwitterScraper\ActivityRecord\Kind;
use XTwitterScraper\ActivityRecord\ObjectModel;
use XTwitterScraper\ActivityRecord\Related;
use XTwitterScraper\ActivityRecord\Request;
use XTwitterScraper\ActivityRecord\Status;
use XTwitterScraper\ActivityRecord\Timestamps;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type ActivityRecordShape = array{
 *   object: ObjectModel|value-of<ObjectModel>,
 *   id: string,
 *   kind: Kind|value-of<Kind>,
 *   type: string,
 *   status: Status|value-of<Status>,
 *   url: string,
 *   requestID: string|null,
 *   timestamps: Timestamps|array<string,mixed>,
 *   request: Request|array<string,mixed>|null,
 *   caller: Caller|array<string,mixed>,
 *   charge: Charge|array<string,mixed>|null,
 *   details: array<string,mixed>,
 *   related: list<Related|array<string,mixed>>,
 * }
 */
final class ActivityRecord implements BaseModel
{
    /** @use SdkModel<ActivityRecordShape> */
    use SdkModel;

    /**
     * @var value-of<ObjectModel> $object
     */
    #[Required(enum: ObjectModel::class)]
    public string $object;

    /**
     * Activity ID.
     */
    #[Required]
    public string $id;

    /**
     * Kind of the activity. Only a signed-in dashboard session sees an `api_key` record.
     *
     * @var value-of<Kind> $kind
     */
    #[Required(enum: Kind::class)]
    public string $kind;

    /**
     * Type of the activity within its kind, the same as the type of its Activity log row. Examples are a write action type, an extraction tool type, a monitor change, a monitor event type or a ledger entry type.
     */
    #[Required]
    public string $type;

    /**
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * Dashboard page of this activity.
     */
    #[Required]
    public string $url;

    /**
     * ID of the API request behind this activity.
     */
    #[Required('requestId')]
    public ?string $requestID;

    #[Required]
    public Timestamps $timestamps;

    /**
     * The API request behind this activity. Null for activity from before Oct 30, 2026, and for activity no API request starts, such as a monitor event, a webhook delivery or a credit grant.
     */
    #[Required]
    public ?Request $request;

    #[Required]
    public Caller $caller;

    /**
     * Credits charged for this activity.
     */
    #[Required]
    public ?Charge $charge;

    /**
     * Fields of this kind of activity, such as its target. A field can hold JSON, such as the data of a monitor event or the payload of a webhook delivery.
     *
     * @var array<string,mixed> $details
     */
    #[Required(map: 'mixed')]
    public array $details;

    /**
     * Up to 5 other activities on the same subject within 7 days, newest first.
     *
     * @var list<Related> $related
     */
    #[Required(list: Related::class)]
    public array $related;

    /**
     * `new ActivityRecord()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ActivityRecord::with(object: ..., id: ..., kind: ..., type: ..., status: ..., url: ..., requestID: ..., timestamps: ..., request: ..., caller: ..., charge: ..., details: ..., related: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ActivityRecord)->withObject(...)->withId(...)->withKind(...)->withType(...)->withStatus(...)->withUrl(...)->withRequestID(...)->withTimestamps(...)->withRequest(...)->withCaller(...)->withCharge(...)->withDetails(...)->withRelated(...)
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
     * @param ObjectModel|value-of<ObjectModel> $object
     * @param Kind|value-of<Kind> $kind
     * @param Status|value-of<Status> $status
     * @param Timestamps|array<string,mixed> $timestamps
     * @param Request|array<string,mixed>|null $request
     * @param Caller|array<string,mixed> $caller
     * @param Charge|array<string,mixed>|null $charge
     * @param array<string,mixed> $details
     * @param list<Related|array<string,mixed>> $related
     */
    public static function with(ObjectModel|string $object, string $id, Kind|string $kind, string $type, Status|string $status, string $url, ?string $requestID, Timestamps|array $timestamps, Request|array|null $request, Caller|array $caller, Charge|array|null $charge, array $details, array $related): self
    {
        $self = new self;

        $self['object'] = $object;
        $self['id'] = $id;
        $self['kind'] = $kind;
        $self['type'] = $type;
        $self['status'] = $status;
        $self['url'] = $url;
        $self['requestID'] = $requestID;
        $self['timestamps'] = $timestamps;
        $self['request'] = $request;
        $self['caller'] = $caller;
        $self['charge'] = $charge;
        $self['details'] = $details;
        $self['related'] = $related;

        return $self;
    }

    /**
     * @param ObjectModel|value-of<ObjectModel> $object
     */
    public function withObject(ObjectModel|string $object): self
    {
        $self = clone $this;
        $self['object'] = $object;

        return $self;
    }

    /**
     * Activity ID.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Kind of the activity. Only a signed-in dashboard session sees an `api_key` record.
     *
     * @param Kind|value-of<Kind> $kind
     */
    public function withKind(Kind|string $kind): self
    {
        $self = clone $this;
        $self['kind'] = $kind;

        return $self;
    }

    /**
     * Type of the activity within its kind, the same as the type of its Activity log row. Examples are a write action type, an extraction tool type, a monitor change, a monitor event type or a ledger entry type.
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * Dashboard page of this activity.
     */
    public function withUrl(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * ID of the API request behind this activity.
     */
    public function withRequestID(?string $requestID): self
    {
        $self = clone $this;
        $self['requestID'] = $requestID;

        return $self;
    }

    /**
     * @param Timestamps|array<string,mixed> $timestamps
     */
    public function withTimestamps(Timestamps|array $timestamps): self
    {
        $self = clone $this;
        $self['timestamps'] = $timestamps;

        return $self;
    }

    /**
     * The API request behind this activity. Null for activity from before Oct 30, 2026, and for activity no API request starts, such as a monitor event, a webhook delivery or a credit grant.
     *
     * @param Request|array<string,mixed>|null $request
     */
    public function withRequest(Request|array|null $request): self
    {
        $self = clone $this;
        $self['request'] = $request;

        return $self;
    }

    /**
     * @param Caller|array<string,mixed> $caller
     */
    public function withCaller(Caller|array $caller): self
    {
        $self = clone $this;
        $self['caller'] = $caller;

        return $self;
    }

    /**
     * Credits charged for this activity.
     *
     * @param Charge|array<string,mixed>|null $charge
     */
    public function withCharge(Charge|array|null $charge): self
    {
        $self = clone $this;
        $self['charge'] = $charge;

        return $self;
    }

    /**
     * Fields of this kind of activity, such as its target. A field can hold JSON, such as the data of a monitor event or the payload of a webhook delivery.
     *
     * @param array<string,mixed> $details
     */
    public function withDetails(array $details): self
    {
        $self = clone $this;
        $self['details'] = $details;

        return $self;
    }

    /**
     * Up to 5 other activities on the same subject within 7 days, newest first.
     *
     * @param list<Related|array<string,mixed>> $related
     */
    public function withRelated(array $related): self
    {
        $self = clone $this;
        $self['related'] = $related;

        return $self;
    }
}
