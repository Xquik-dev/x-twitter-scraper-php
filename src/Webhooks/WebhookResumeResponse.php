<?php

declare(strict_types=1);

namespace XTwitterScraper\Webhooks;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type WebhookShape from \XTwitterScraper\Webhooks\Webhook
 *
 * @phpstan-type WebhookResumeResponseShape = array{
 *   statusCode: int, success: bool, webhook: Webhook|WebhookShape
 * }
 */
final class WebhookResumeResponse implements BaseModel
{
    /** @use SdkModel<WebhookResumeResponseShape> */
    use SdkModel;

    #[Required]
    public int $statusCode;

    #[Required]
    public bool $success;

    /**
     * Webhook endpoint registered to receive event deliveries.
     */
    #[Required]
    public Webhook $webhook;

    /**
     * `new WebhookResumeResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebhookResumeResponse::with(statusCode: ..., success: ..., webhook: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebhookResumeResponse)
     *   ->withStatusCode(...)
     *   ->withSuccess(...)
     *   ->withWebhook(...)
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
     * @param Webhook|WebhookShape $webhook
     */
    public static function with(
        int $statusCode,
        bool $success,
        Webhook|array $webhook
    ): self {
        $self = new self;

        $self['statusCode'] = $statusCode;
        $self['success'] = $success;
        $self['webhook'] = $webhook;

        return $self;
    }

    public function withStatusCode(int $statusCode): self
    {
        $self = clone $this;
        $self['statusCode'] = $statusCode;

        return $self;
    }

    public function withSuccess(bool $success): self
    {
        $self = clone $this;
        $self['success'] = $success;

        return $self;
    }

    /**
     * Webhook endpoint registered to receive event deliveries.
     *
     * @param Webhook|WebhookShape $webhook
     */
    public function withWebhook(Webhook|array $webhook): self
    {
        $self = clone $this;
        $self['webhook'] = $webhook;

        return $self;
    }
}
