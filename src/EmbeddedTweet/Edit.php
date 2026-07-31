<?php

declare(strict_types=1);

namespace XTwitterScraper\EmbeddedTweet;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Edit history metadata returned by X.
 *
 * @phpstan-type EditShape = array{
 *   editableUntilMsecs?: string|null, editTweetIDs?: list<string>|null
 * }
 */
final class Edit implements BaseModel
{
    /** @use SdkModel<EditShape> */
    use SdkModel;

    #[Optional]
    public ?string $editableUntilMsecs;

    /** @var list<string>|null $editTweetIDs */
    #[Optional('editTweetIds', list: 'string')]
    public ?array $editTweetIDs;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $editTweetIDs
     */
    public static function with(
        ?string $editableUntilMsecs = null,
        ?array $editTweetIDs = null
    ): self {
        $self = new self;

        null !== $editableUntilMsecs && $self['editableUntilMsecs'] = $editableUntilMsecs;
        null !== $editTweetIDs && $self['editTweetIDs'] = $editTweetIDs;

        return $self;
    }

    public function withEditableUntilMsecs(string $editableUntilMsecs): self
    {
        $self = clone $this;
        $self['editableUntilMsecs'] = $editableUntilMsecs;

        return $self;
    }

    /**
     * @param list<string> $editTweetIDs
     */
    public function withEditTweetIDs(array $editTweetIDs): self
    {
        $self = clone $this;
        $self['editTweetIDs'] = $editTweetIDs;

        return $self;
    }
}
