<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ActivityRecord;

use XTwitterScraper\ActivityRecord\Request\Method;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type RequestShape = array{
 *   method: Method|value-of<Method>,
 *   path: string,
 *   httpStatus: int,
 *   durationMs: int,
 *   ipAddress: string|null,
 *   userAgent: string|null,
 *   at: \DateTimeInterface,
 * }
 */
final class Request implements BaseModel
{
    /** @use SdkModel<RequestShape> */
    use SdkModel;

    /**
     * @var value-of<Method> $method
     */
    #[Required(enum: Method::class)]
    public string $method;

    #[Required]
    public string $path;

    #[Required]
    public int $httpStatus;

    #[Required]
    public int $durationMs;

    #[Required]
    public ?string $ipAddress;

    #[Required]
    public ?string $userAgent;

    #[Required]
    public \DateTimeInterface $at;

    /**
     * `new Request()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Request::with(method: ..., path: ..., httpStatus: ..., durationMs: ..., ipAddress: ..., userAgent: ..., at: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Request)->withMethod(...)->withPath(...)->withHttpStatus(...)->withDurationMs(...)->withIpAddress(...)->withUserAgent(...)->withAt(...)
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
     * @param Method|value-of<Method> $method
     */
    public static function with(Method|string $method, string $path, int $httpStatus, int $durationMs, ?string $ipAddress, ?string $userAgent, \DateTimeInterface $at): self
    {
        $self = new self;

        $self['method'] = $method;
        $self['path'] = $path;
        $self['httpStatus'] = $httpStatus;
        $self['durationMs'] = $durationMs;
        $self['ipAddress'] = $ipAddress;
        $self['userAgent'] = $userAgent;
        $self['at'] = $at;

        return $self;
    }

    /**
     * @param Method|value-of<Method> $method
     */
    public function withMethod(Method|string $method): self
    {
        $self = clone $this;
        $self['method'] = $method;

        return $self;
    }

    public function withPath(string $path): self
    {
        $self = clone $this;
        $self['path'] = $path;

        return $self;
    }

    public function withHttpStatus(int $httpStatus): self
    {
        $self = clone $this;
        $self['httpStatus'] = $httpStatus;

        return $self;
    }

    public function withDurationMs(int $durationMs): self
    {
        $self = clone $this;
        $self['durationMs'] = $durationMs;

        return $self;
    }

    public function withIpAddress(?string $ipAddress): self
    {
        $self = clone $this;
        $self['ipAddress'] = $ipAddress;

        return $self;
    }

    public function withUserAgent(?string $userAgent): self
    {
        $self = clone $this;
        $self['userAgent'] = $userAgent;

        return $self;
    }

    public function withAt(\DateTimeInterface $at): self
    {
        $self = clone $this;
        $self['at'] = $at;

        return $self;
    }
}
