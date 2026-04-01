<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Communities\CommunityGetInfoResponse\Community;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type RuleShape = array{
 *   id?: string|null, description?: string|null, name?: string|null
 * }
 */
final class Rule implements BaseModel
{
    /** @use SdkModel<RuleShape> */
    use SdkModel;

    #[Optional]
    public ?string $id;

    #[Optional]
    public ?string $description;

    #[Optional]
    public ?string $name;

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
        ?string $id = null,
        ?string $description = null,
        ?string $name = null
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $description && $self['description'] = $description;
        null !== $name && $self['name'] = $name;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
