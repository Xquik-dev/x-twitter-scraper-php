<?php

namespace XTwitterScraper;

use Psr\Http\Message\ResponseInterface;
use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkPage;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Core\Contracts\BasePage;
use XTwitterScraper\Core\Conversion;
use XTwitterScraper\Core\Conversion\Contracts\Converter;
use XTwitterScraper\Core\Conversion\Contracts\ConverterSource;
use XTwitterScraper\Core\Conversion\ListOf;

/**
 * @phpstan-type CursorPageShape = array{
 *   tweets?: list<mixed>|null,
 *   users?: list<mixed>|null,
 *   nextCursor?: string|null,
 *   hasNextPage?: bool|null,
 * }
 *
 * @template TItem
 *
 * @implements BasePage<TItem>
 */
final class CursorPage implements BaseModel, BasePage
{
    /** @use SdkModel<CursorPageShape> */
    use SdkModel;

    /** @use SdkPage<TItem> */
    use SdkPage;

    /** @var list<mixed>|null $tweets */
    #[Optional(list: 'mixed')]
    public ?array $tweets;

    /** @var list<mixed>|null $users */
    #[Optional(list: 'mixed')]
    public ?array $users;

    #[Optional('next_cursor')]
    public ?string $nextCursor;

    #[Optional('has_next_page')]
    public ?bool $hasNextPage;

    /**
     * @internal
     *
     * @param array{
     *   method: string,
     *   path: string,
     *   query: array<string,mixed>,
     *   headers: array<string,string|list<string>|null>,
     *   body: mixed,
     * } $requestInfo
     */
    public function __construct(
        private string|Converter|ConverterSource $convert,
        private Client $client,
        private array $requestInfo,
        private RequestOptions $options,
        private ResponseInterface $response,
        private mixed $parsedBody,
    ) {
        $this->initialize();

        if (!is_array($this->parsedBody)) {
            return;
        }

        // @phpstan-ignore-next-line argument.type
        self::__unserialize($this->parsedBody);

        if (is_array($items = $this->offsetGet('STAINLESS_FIXME_data'))) {
            $parsed = Conversion::coerce(new ListOf($convert), value: $items);
            // @phpstan-ignore-next-line
            $this->offsetSet('STAINLESS_FIXME_data', value: $parsed);
        }
    }

    /** @return list<TItem> */
    public function getItems(): array
    {
        // @phpstan-ignore-next-line return.type
        return $this->offsetGet('STAINLESS_FIXME_data') ?? [];
    }

    /**
     * @internal
     *
     * @return array{
     *   array{
     *     method: string,
     *     path: string,
     *     query: array<string,mixed>,
     *     headers: array<string,string|list<string>|null>,
     *     body: mixed,
     *   },
     *   RequestOptions,
     * }|null
     */
    public function nextRequest(): ?array
    {
        if (!count($this->getItems())) {
            return null;
        }

        if (!($next = $this->nextCursor ?? null)) {
            return null;
        }

        $nextRequest = array_merge_recursive(
            $this->requestInfo,
            ['query' => ['cursor' => $next]]
        );

        // @phpstan-ignore-next-line return.type
        return [$nextRequest, $this->options];
    }
}
