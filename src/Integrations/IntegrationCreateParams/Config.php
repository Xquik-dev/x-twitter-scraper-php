<?php

declare(strict_types=1);

namespace XTwitterScraper\Integrations\IntegrationCreateParams;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Integration config (e.g. Telegram chatId).
 *
 * @phpstan-type ConfigShape = array{chatID: string}
 */
final class Config implements BaseModel
{
    /** @use SdkModel<ConfigShape> */
    use SdkModel;

    #[Required('chatId')]
    public string $chatID;

    /**
     * `new Config()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Config::with(chatID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Config)->withChatID(...)
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
    public static function with(string $chatID): self
    {
        $self = new self;

        $self['chatID'] = $chatID;

        return $self;
    }

    public function withChatID(string $chatID): self
    {
        $self = clone $this;
        $self['chatID'] = $chatID;

        return $self;
    }
}
