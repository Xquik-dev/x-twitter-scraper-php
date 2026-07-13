<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Dm;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Send direct message.
 *
 * @see XTwitterScraper\Services\X\DmService::send()
 *
 * @phpstan-type DmSendParamsShape = array{
 *   account: string, text: string, mediaIDs?: list<string>|null
 * }
 */
final class DmSendParams implements BaseModel
{
    /** @use SdkModel<DmSendParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * X account (@username or ID) sending the DM.
     */
    #[Required]
    public string $account;

    #[Required]
    public string $text;

    /**
     * Optional array containing exactly 1 uploaded media ID.
     *
     * @var list<string>|null $mediaIDs
     */
    #[Optional('media_ids', list: 'string')]
    public ?array $mediaIDs;

    /**
     * `new DmSendParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DmSendParams::with(account: ..., text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DmSendParams)->withAccount(...)->withText(...)
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
     * @param list<string>|null $mediaIDs
     */
    public static function with(
        string $account,
        string $text,
        ?array $mediaIDs = null
    ): self {
        $self = new self;

        $self['account'] = $account;
        $self['text'] = $text;

        null !== $mediaIDs && $self['mediaIDs'] = $mediaIDs;

        return $self;
    }

    /**
     * X account (@username or ID) sending the DM.
     */
    public function withAccount(string $account): self
    {
        $self = clone $this;
        $self['account'] = $account;

        return $self;
    }

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * Optional array containing exactly 1 uploaded media ID.
     *
     * @param list<string> $mediaIDs
     */
    public function withMediaIDs(array $mediaIDs): self
    {
        $self = clone $this;
        $self['mediaIDs'] = $mediaIDs;

        return $self;
    }
}
