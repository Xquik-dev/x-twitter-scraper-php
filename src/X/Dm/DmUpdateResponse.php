<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Dm;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type DmUpdateResponseShape = array{messageID: string, success: bool}
 */
final class DmUpdateResponse implements BaseModel
{
    /** @use SdkModel<DmUpdateResponseShape> */
    use SdkModel;

    #[Required]
    public bool $success = true;

    #[Required('messageId')]
    public string $messageID;

    /**
     * `new DmUpdateResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DmUpdateResponse::with(messageID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DmUpdateResponse)->withMessageID(...)
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
    public static function with(string $messageID): self
    {
        $self = new self;

        $self['messageID'] = $messageID;

        return $self;
    }

    public function withMessageID(string $messageID): self
    {
        $self = clone $this;
        $self['messageID'] = $messageID;

        return $self;
    }

    public function withSuccess(bool $success): self
    {
        $self = clone $this;
        $self['success'] = $success;

        return $self;
    }
}
