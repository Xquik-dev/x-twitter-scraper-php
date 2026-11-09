# X (Twitter) API PHP SDK & Scraper by Xquik

[![Framer builds a tweet ticker with Xquik](https://img.youtube.com/vi/4UOSpoOoC3Y/maxresdefault.jpg)](https://youtu.be/4UOSpoOoC3Y?t=367)\
[Watch Framer build a tweet ticker with Xquik, from 6:07](https://youtu.be/4UOSpoOoC3Y?t=367).
This PHP SDK calls the Xquik API.

Add this X (Twitter) scraper PHP SDK by Xquik to search tweets & posts.
Calls take named arguments and return typed value objects.
Public reads need no X (Twitter) developer account.

Xquik is the world's fastest and cheapest X (Twitter) scraper service with the most complete X (Twitter) data.
Most other Apify Actors charge before filtering or deduplication.
Xquik charges only for delivered, unique, filter-matching results and never pads rows.
Xquik is independent and not affiliated with X Corp.

<!-- trust:win:start -->
The Xquik REST API read 45 tweets per second at $0.15 per 1,000 on 2026-10-15. The fastest of 4 rival Actors read 12.5 per second. The cheapest cost $0.173 per 1,000. [Compare each run](https://xquik.com/benchmarks#benchmark-x-tweet-scraper).
<!-- trust:win:end -->

## Install the X (Twitter) API PHP SDK

The SDK requires PHP 8.1.0 or later.

Install the [Packagist package `xquik/x-twitter-scraper`](https://packagist.org/packages/xquik/x-twitter-scraper) with Composer.

```sh
composer require xquik/x-twitter-scraper:^0.13.5
```

## Scrape tweets with the Twitter PHP client

Create an API key in the [Xquik dashboard](https://dashboard.xquik.com) and export it.

```sh
export X_TWITTER_SCRAPER_API_KEY="your-api-key"
```

This script prints 10 recent X (Twitter) posts from 1 account.

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use XTwitterScraper\Client;

$client = new Client();

$response = $client->x->tweets->search(q: 'from:elonmusk', limit: 10);

var_dump($response);
```

Next, read the [PHP SDK guide](https://docs.xquik.com/sdks/php) or the [REST API reference](https://docs.xquik.com/api-reference/overview).

<!-- trust:start -->

## Benchmarks & usage

[![X (Twitter) API package downloads](https://img.shields.io/endpoint?url=https%3A%2F%2Fxquik.com%2Fbadges%2Fdownloads.json)](https://xquik.com/benchmarks#downloads)
[![X (Twitter) API p99 server read time](https://img.shields.io/endpoint?url=https%3A%2F%2Fxquik.com%2Fbadges%2Frest-p99.json)](https://xquik.com/benchmarks#speed)
[![OpenSSF Best Practices](https://www.bestpractices.dev/projects/13737/badge)](https://www.bestpractices.dev/projects/13737)

- 63,000+ downloads of Xquik's X (Twitter) API packages across 6 registries ([source](https://xquik.com/benchmarks#downloads)) <!-- trust:downloads 63185 -->
- 6.4 s p99 REST API server read time over 7 days, failed reads included ([source](https://xquik.com/benchmarks#speed)) <!-- trust:rest-p99 6317 -->
- This repo meets the OpenSSF Best Practices passing criteria ([source](https://www.bestpractices.dev/projects/13737)) <!-- trust:openssf-x-twitter-scraper-php 1 -->

Checked on 2026-11-07. See each number with its date & source on [xquik.com/benchmarks](https://xquik.com/benchmarks) or as [JSON](https://xquik.com/trust.json).

<!-- trust:end -->

## Common X (Twitter) tasks

| Task | REST route | Usage |
| --- | --- | --- |
| Run an advanced Twitter search | `GET /x/tweets/search` | Use keywords or supported operators. |
| Extract an X (Twitter) profile timeline | `GET /x/users/{id}/tweets` | Paginate bounded timeline results. |
| Scrape Twitter followers | `GET /x/users/{id}/followers` | Use an extraction for complete datasets. |
| Scrape X (Twitter) following accounts | `GET /x/users/{id}/following` | Use an extraction for complete datasets. |
| Read a home timeline | `GET /x/timeline` | Approve this private read. |
| Read lists or communities | `/x/lists/*`, `/x/communities/*` | Use the typed nested services. |
| Export large X (Twitter) datasets | `POST /extractions` | Poll status, then download results. |
| Monitor an account | `POST /monitors` | Deliver events through HMAC webhooks. |
| Post a tweet or reply | `POST /x/tweets` | Confirm the account and payload. |

## Verify a release

Each release attaches a reproducible Composer archive.
Replace `VERSION` with the release number, then rebuild the archive and compare.

```sh
release_tag=vVERSION
archive="x-twitter-scraper-php-$release_tag.zip"

git clone --depth 1 --branch "$release_tag" \
  https://github.com/Xquik-dev/x-twitter-scraper-php.git source

gh release download "$release_tag" \
  --repo Xquik-dev/x-twitter-scraper-php \
  --pattern "$archive"

TZ=UTC ./source/scripts/build-archive rebuilt.zip
cmp "$archive" rebuilt.zip
```

`cmp` prints nothing when both archives have identical bytes.

## Usage

### Value objects

Create value objects with named parameters, as in `TweetMedia::with(mediaURL: $preview, type: 'photo', url: $url)`.
Builders also work, as in `(new TweetMedia)->withURL($url)`.

### Handling errors

Connection failures and non-2xx responses throw an `APIException` subclass.

```php
<?php

use XTwitterScraper\Core\Exceptions\APIConnectionException;
use XTwitterScraper\Core\Exceptions\RateLimitException;
use XTwitterScraper\Core\Exceptions\APIStatusException;

try {
  $account = $client->account->retrieve();
} catch (APIConnectionException $e) {
  echo "Could not reach the API. Check your connection.", PHP_EOL;
  var_dump($e->getPrevious());
} catch (RateLimitException $e) {
  echo "Rate limit reached. Retry later.", PHP_EOL;
} catch (APIStatusException $e) {
  echo "Request failed. Check the response details.", PHP_EOL;
  echo $e->getMessage();
}
```

The SDK throws 1 error type for each cause.

| Cause            | Error type                     |
| ---------------- | ------------------------------ |
| HTTP 400         | `BadRequestException`          |
| HTTP 401         | `AuthenticationException`      |
| HTTP 403         | `PermissionDeniedException`    |
| HTTP 404         | `NotFoundException`            |
| HTTP 409         | `ConflictException`            |
| HTTP 422         | `UnprocessableEntityException` |
| HTTP 429         | `RateLimitException`           |
| HTTP >= 500      | `InternalServerException`      |
| Other HTTP error | `APIStatusException`           |
| Timeout          | `APITimeoutException`          |
| Network error    | `APIConnectionException`       |

### Retries

The client retries some failures twice with exponential backoff.
It retries connection failures, timeouts and HTTP 408, 409, 429 & 5xx responses.
Set `maxRetries` globally or per request.

```php
<?php

use XTwitterScraper\Client;

// Set the default for all requests.
$client = new Client(requestOptions: ['maxRetries' => 0]);

// Or set it for 1 request.
$result = $client->account->retrieve(requestOptions: ['maxRetries' => 5]);
```

## Custom requests

Pass `extraQueryParams`, `extraBodyParams` & `extraHeaders` through `requestOptions`.
An `extra*` value overrides its documented counterpart.

```php
<?php

$account = $client->account->retrieve(
  requestOptions: [
    'extraQueryParams' => ['my_query_parameter' => 'value'],
    'extraBodyParams' => ['my_body_parameter' => 'value'],
    'extraHeaders' => ['my-header' => 'value'],
  ],
);
```

Use `$client->request()` to keep authentication and retries on undocumented routes.

```php
<?php

$response = $client->request(
  method: 'post',
  path: '/undocumented/endpoint',
  query: ['my_query_parameter' => 'value'],
  headers: ['my-header' => 'value'],
  body: ['my_body_parameter' => 'value'],
);
```

## Versioning

This package follows [SemVer](https://semver.org/spec/v2.0.0.html).
Before version 1.0, APIs may change without a major release.
PHPDoc-only type improvements are non-breaking changes.

## Questions

### Do I need an X (Twitter) developer account?

No. Public reads need only an Xquik API key.
Private reads & account actions need a connected X (Twitter) account.

### Is this the official X API?

No. Xquik runs its own REST API. This SDK calls that API, not the official X API.

## More Xquik tools

- [X (Twitter) scraper API & X (Twitter) MCP server](https://github.com/Xquik-dev/x-twitter-scraper) with REST, MCP & Skill setup.
- X (Twitter) API SDKs for [TypeScript](https://github.com/Xquik-dev/x-twitter-scraper-typescript), [Python](https://github.com/Xquik-dev/x-twitter-scraper-python), [Go](https://github.com/Xquik-dev/x-twitter-scraper-go) & [Java](https://github.com/Xquik-dev/x-twitter-scraper-java).
- X (Twitter) API SDKs for [Ruby](https://github.com/Xquik-dev/x-twitter-scraper-ruby), [Kotlin](https://github.com/Xquik-dev/x-twitter-scraper-kotlin) & [C#](https://github.com/Xquik-dev/x-twitter-scraper-csharp).
- [Twitter CLI & X CLI](https://github.com/Xquik-dev/x-twitter-scraper-cli) for terminal workflows.
- [Twitter advanced search operators](https://github.com/Xquik-dev/x-twitter-advanced-search) with tested examples.
- X (Twitter) agent plugins for [OpenClaw](https://github.com/Xquik-dev/tweetclaw) & [Hermes Agent](https://github.com/Xquik-dev/hermes-tweet).
- X (Twitter) integrations for [n8n](https://github.com/Xquik-dev/n8n-nodes-xquik), [Prefect](https://github.com/Xquik-dev/prefect-xquik), [Haystack](https://github.com/Xquik-dev/xquik-haystack) & [Paperclip](https://github.com/Xquik-dev/paperclip-plugin-xquik).
- X (Twitter) integrations for [Terraform](https://github.com/Xquik-dev/terraform-provider-x-twitter-scraper), [Convex](https://github.com/Xquik-dev/xquik-convex), [Supabase](https://github.com/Xquik-dev/xquik-supabase) & [Strapi](https://github.com/Xquik-dev/strapi-plugin-xquik).
- X (Twitter) MCP for [AI agents](https://github.com/Xquik-dev/xquik-mcp), [VS Code](https://github.com/Xquik-dev/xquik-vscode) & [Raycast](https://github.com/Xquik-dev/xquik-raycast).
- [Xquik X API & Twitter scraper](https://xquik.com).
- [X (Twitter) API documentation](https://docs.xquik.com/api-reference/overview) and its [source](https://github.com/Xquik-dev/xquik-docs).

## Project policies

Read [Contributing](CONTRIBUTING.md), [Governance](GOVERNANCE.md), and [Security](SECURITY.md).
See [OpenSSF evidence](OPENSSF.md) for verified controls and blockers.

Xquik is an independent third-party service. Not affiliated with X Corp. "Twitter" and "X" are trademarks of X Corp.
