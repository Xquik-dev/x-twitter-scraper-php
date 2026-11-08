<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Communities\CommunityGetInfoResponse\Community\MembersFacepile;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Communities\CommunityGetInfoResponse\Community\MembersFacepile\VerificationReason\Entities;

/**
 * @phpstan-type VerificationReasonShape = array{
 *   text?: string|null,
 *   entities?: list<Entities|array<string,mixed>>|null,
 * }
 */
final class VerificationReason implements BaseModel
{
    /** @use SdkModel<VerificationReasonShape> */
    use SdkModel;

    #[Optional]
    public ?string $text;

    /**
     * Links inside the text, by character range.
     *
     * @var list<Entities>|null $entities
     */
    #[Optional(list: Entities::class)]
    public ?array $entities;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<Entities|array<string,mixed>>|null $entities
     */
    public static function with(?string $text = null, ?array $entities = null): self
    {
        $self = new self;

        null !== $text && $self['text'] = $text;
        null !== $entities && $self['entities'] = $entities;

        return $self;
    }

    public function withText(?string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * Links inside the text, by character range.
     *
     * @param list<Entities|array<string,mixed>>|null $entities
     */
    public function withEntities(?array $entities): self
    {
        $self = clone $this;
        $self['entities'] = $entities;

        return $self;
    }
}
