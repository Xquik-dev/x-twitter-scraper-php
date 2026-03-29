<?php

declare(strict_types=1);

namespace XTwitterScraper\Bot;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Track bot token usage.
 *
 * @see XTwitterScraper\Services\BotService::trackUsage()
 *
 * @phpstan-type BotTrackUsageParamsShape = array{
 *   inputTokens: int, outputTokens: int, platformUserID: string
 * }
 */
final class BotTrackUsageParams implements BaseModel
{
    /** @use SdkModel<BotTrackUsageParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public int $inputTokens;

    #[Required]
    public int $outputTokens;

    #[Required('platformUserId')]
    public string $platformUserID;

    /**
     * `new BotTrackUsageParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BotTrackUsageParams::with(
     *   inputTokens: ..., outputTokens: ..., platformUserID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BotTrackUsageParams)
     *   ->withInputTokens(...)
     *   ->withOutputTokens(...)
     *   ->withPlatformUserID(...)
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
     */
    public static function with(
        int $inputTokens,
        int $outputTokens,
        string $platformUserID
    ): self {
        $self = new self;

        $self['inputTokens'] = $inputTokens;
        $self['outputTokens'] = $outputTokens;
        $self['platformUserID'] = $platformUserID;

        return $self;
    }

    public function withInputTokens(int $inputTokens): self
    {
        $self = clone $this;
        $self['inputTokens'] = $inputTokens;

        return $self;
    }

    public function withOutputTokens(int $outputTokens): self
    {
        $self = clone $this;
        $self['outputTokens'] = $outputTokens;

        return $self;
    }

    public function withPlatformUserID(string $platformUserID): self
    {
        $self = clone $this;
        $self['platformUserID'] = $platformUserID;

        return $self;
    }
}
