<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ActivityRecord;

use XTwitterScraper\ActivityRecord\Caller\ApiKey;
use XTwitterScraper\ActivityRecord\Caller\AuthMethod;
use XTwitterScraper\ActivityRecord\Caller\OauthClient;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type CallerShape = array{
 *   authMethod: AuthMethod|value-of<AuthMethod>|null,
 *   apiKey: ApiKey|array<string,mixed>|null,
 *   oauthClient: OauthClient|array<string,mixed>|null,
 * }
 */
final class Caller implements BaseModel
{
    /** @use SdkModel<CallerShape> */
    use SdkModel;

    /**
     * @var value-of<AuthMethod>|null $authMethod
     */
    #[Required(enum: AuthMethod::class)]
    public ?string $authMethod;

    /**
     * Name and prefix of the API key used. Never its value.
     */
    #[Required]
    public ?ApiKey $apiKey;

    #[Required]
    public ?OauthClient $oauthClient;

    /**
     * `new Caller()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Caller::with(authMethod: ..., apiKey: ..., oauthClient: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Caller)->withAuthMethod(...)->withApiKey(...)->withOauthClient(...)
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
     * @param AuthMethod|value-of<AuthMethod>|null $authMethod
     * @param ApiKey|array<string,mixed>|null $apiKey
     * @param OauthClient|array<string,mixed>|null $oauthClient
     */
    public static function with(AuthMethod|string|null $authMethod, ApiKey|array|null $apiKey, OauthClient|array|null $oauthClient): self
    {
        $self = new self;

        $self['authMethod'] = $authMethod;
        $self['apiKey'] = $apiKey;
        $self['oauthClient'] = $oauthClient;

        return $self;
    }

    /**
     * @param AuthMethod|value-of<AuthMethod>|null $authMethod
     */
    public function withAuthMethod(AuthMethod|string|null $authMethod): self
    {
        $self = clone $this;
        $self['authMethod'] = $authMethod;

        return $self;
    }

    /**
     * Name and prefix of the API key used. Never its value.
     *
     * @param ApiKey|array<string,mixed>|null $apiKey
     */
    public function withApiKey(ApiKey|array|null $apiKey): self
    {
        $self = clone $this;
        $self['apiKey'] = $apiKey;

        return $self;
    }

    /**
     * @param OauthClient|array<string,mixed>|null $oauthClient
     */
    public function withOauthClient(OauthClient|array|null $oauthClient): self
    {
        $self = clone $this;
        $self['oauthClient'] = $oauthClient;

        return $self;
    }
}
