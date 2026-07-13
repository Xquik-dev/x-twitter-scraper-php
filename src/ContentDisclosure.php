<?php

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\ContentDisclosure\Advertising;
use XTwitterScraper\ContentDisclosure\AIGenerated;
use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Content disclosure metadata shown by X when a tweet is labeled as paid partnership content or AI-generated media.
 *
 * @phpstan-import-type AdvertisingShape from \XTwitterScraper\ContentDisclosure\Advertising
 * @phpstan-import-type AIGeneratedShape from \XTwitterScraper\ContentDisclosure\AIGenerated
 *
 * @phpstan-type ContentDisclosureShape = array{
 *   advertising?: null|Advertising|AdvertisingShape,
 *   aiGenerated?: null|AIGenerated|AIGeneratedShape,
 * }
 */
final class ContentDisclosure implements BaseModel
{
    /** @use SdkModel<ContentDisclosureShape> */
    use SdkModel;

    #[Optional]
    public ?Advertising $advertising;

    #[Optional]
    public ?AIGenerated $aiGenerated;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Advertising|AdvertisingShape|null $advertising
     * @param AIGenerated|AIGeneratedShape|null $aiGenerated
     */
    public static function with(
        Advertising|array|null $advertising = null,
        AIGenerated|array|null $aiGenerated = null
    ): self {
        $self = new self;

        null !== $advertising && $self['advertising'] = $advertising;
        null !== $aiGenerated && $self['aiGenerated'] = $aiGenerated;

        return $self;
    }

    /**
     * @param Advertising|AdvertisingShape $advertising
     */
    public function withAdvertising(Advertising|array $advertising): self
    {
        $self = clone $this;
        $self['advertising'] = $advertising;

        return $self;
    }

    /**
     * @param AIGenerated|AIGeneratedShape $aiGenerated
     */
    public function withAIGenerated(AIGenerated|array $aiGenerated): self
    {
        $self = clone $this;
        $self['aiGenerated'] = $aiGenerated;

        return $self;
    }
}
