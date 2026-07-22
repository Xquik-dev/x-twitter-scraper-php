<?php

declare(strict_types=1);

namespace XTwitterScraper\Compose\ComposeNewResponse\ComposePrepareResult;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type ContentRuleShape = array{rule: string}
 */
final class ContentRule implements BaseModel
{
    /** @use SdkModel<ContentRuleShape> */
    use SdkModel;

    #[Required]
    public string $rule;

    /**
     * `new ContentRule()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ContentRule::with(rule: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ContentRule)->withRule(...)
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
    public static function with(string $rule): self
    {
        $self = new self;

        $self['rule'] = $rule;

        return $self;
    }

    public function withRule(string $rule): self
    {
        $self = clone $this;
        $self['rule'] = $rule;

        return $self;
    }
}
