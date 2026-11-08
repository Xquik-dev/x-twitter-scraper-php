<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Users;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\ProfileTranslation;

/**
 * @phpstan-type UserTranslateBioResponseShape = array{
 *   translation: ProfileTranslation|array<string,mixed>|null,
 *   message?: string|null,
 * }
 */
final class UserTranslateBioResponse implements BaseModel
{
    /** @use SdkModel<UserTranslateBioResponseShape> */
    use SdkModel;

    /**
     * Null when the profile has no bio.
     */
    #[Required]
    public ?ProfileTranslation $translation;

    /**
     * Says why translation is null.
     */
    #[Optional]
    public ?string $message;

    /**
     * `new UserTranslateBioResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserTranslateBioResponse::with(translation: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserTranslateBioResponse)->withTranslation(...)
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
     * @param ProfileTranslation|array<string,mixed>|null $translation
     */
    public static function with(ProfileTranslation|array|null $translation, ?string $message = null): self
    {
        $self = new self;

        $self['translation'] = $translation;

        null !== $message && $self['message'] = $message;

        return $self;
    }

    /**
     * Null when the profile has no bio.
     *
     * @param ProfileTranslation|array<string,mixed>|null $translation
     */
    public function withTranslation(ProfileTranslation|array|null $translation): self
    {
        $self = clone $this;
        $self['translation'] = $translation;

        return $self;
    }

    /**
     * Says why translation is null.
     */
    public function withMessage(?string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
