<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\SearchTweet2;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\SearchTweet2\SoftIntervention\Text;
use XTwitterScraper\SearchTweet2\SoftIntervention\Url;

/**
 * @phpstan-type SoftInterventionShape = array{
 *   displayType?: string|null,
 *   engagementNudge?: bool|null,
 *   text?: Text|array<string,mixed>|null,
 *   url?: Url|array<string,mixed>|null,
 * }
 */
final class SoftIntervention implements BaseModel
{
    /** @use SdkModel<SoftInterventionShape> */
    use SdkModel;

    /**
     * The label's kind. `Fosnr` marks a post X keeps up but shows to fewer people.
     */
    #[Optional]
    public ?string $displayType;

    /**
     * Whether X prompts people before they engage with the post.
     */
    #[Optional]
    public ?bool $engagementNudge;

    #[Optional]
    public ?Text $text;

    /**
     * The page that explains the label.
     */
    #[Optional]
    public ?Url $url;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Text|array<string,mixed>|null $text
     * @param Url|array<string,mixed>|null $url
     */
    public static function with(?string $displayType = null, ?bool $engagementNudge = null, Text|array|null $text = null, Url|array|null $url = null): self
    {
        $self = new self;

        null !== $displayType && $self['displayType'] = $displayType;
        null !== $engagementNudge && $self['engagementNudge'] = $engagementNudge;
        null !== $text && $self['text'] = $text;
        null !== $url && $self['url'] = $url;

        return $self;
    }

    /**
     * The label's kind. `Fosnr` marks a post X keeps up but shows to fewer people.
     */
    public function withDisplayType(?string $displayType): self
    {
        $self = clone $this;
        $self['displayType'] = $displayType;

        return $self;
    }

    /**
     * Whether X prompts people before they engage with the post.
     */
    public function withEngagementNudge(?bool $engagementNudge): self
    {
        $self = clone $this;
        $self['engagementNudge'] = $engagementNudge;

        return $self;
    }

    /**
     * @param Text|array<string,mixed>|null $text
     */
    public function withText(Text|array|null $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * The page that explains the label.
     *
     * @param Url|array<string,mixed>|null $url
     */
    public function withUrl(Url|array|null $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
