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
 * @phpstan-type CursorPageLegacyShape = array{
 *   items?: list<mixed>|null, nextCursor?: string|null, hasMore?: bool|null
 * }
 *
 * @template TItem
 *
 * @implements BasePage<TItem>
 */
final class CursorPageLegacy implements BaseModel, BasePage
{
    /** @use SdkModel<CursorPageLegacyShape> */
    use SdkModel;

    /** @use SdkPage<TItem> */
    use SdkPage;

    /** @var list<TItem>|null $items */
    #[Optional(list: 'mixed')]
    public ?array $items;

    #[Optional]
    public ?string $nextCursor;

    #[Optional]
    public ?bool $hasMore;

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

        if (is_array($items = $this->offsetGet('items'))) {
            $parsed = Conversion::coerce(new ListOf($convert), value: $items);
            // @phpstan-ignore-next-line
            $this->offsetSet('items', value: $parsed);
        }
    }

    /** @return list<TItem> */
    public function getItems(): array
    {
        // @phpstan-ignore-next-line return.type
        return $this->offsetGet('items') ?? [];
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
        if (!($this->hasMore ?? null) || !count($this->getItems())) {
            return null;
        }

        if (!($next = $this->nextCursor ?? null)) {
            return null;
        }

        $nextRequest = array_merge_recursive(
            $this->requestInfo,
            ['query' => ['afterCursor' => $next]]
        );

        // @phpstan-ignore-next-line return.type
        return [$nextRequest, $this->options];
    }
}
