# X API & Twitter API PHP SDK by Xquik

[![OpenSSF Best Practices](https://www.bestpractices.dev/projects/13737/badge)](https://www.bestpractices.dev/projects/13737)

Use this X API & Twitter API SDK to work with X from PHP.
It works as a Twitter scraper & tweet scraper for search, profiles & followers.
Scrape Twitter timelines, lists, communities & trends into typed PHP value objects.
Manage media, webhooks, monitors & X automation through typed Composer methods.
It provides a Twitter API alternative through documented Xquik REST routes.

Xquik is the world's fastest and cheapest X Twitter scraper service with the most complete X data.
Xquik charges only for delivered, unique, filter-matching results and never pads rows.

> Xquik is an independent third-party service. Not affiliated with X Corp.
> "Twitter" and "X" are trademarks of X Corp.

<!-- trust:start -->

## Trust & usage

[![Twitter API package downloads](https://img.shields.io/endpoint?url=https%3A%2F%2Fxquik.com%2Fbadges%2Fdownloads.json)](https://xquik.com/trust#downloads)
[![Twitter scraper users on Apify](https://img.shields.io/endpoint?url=https%3A%2F%2Fxquik.com%2Fbadges%2Fapify-users.json)](https://apify.com/xquik)
[![Twitter scraper runs on Apify](https://img.shields.io/endpoint?url=https%3A%2F%2Fxquik.com%2Fbadges%2Fapify-runs.json)](https://apify.com/xquik)
[![Tweet scraper rating on Apify](https://img.shields.io/endpoint?url=https%3A%2F%2Fxquik.com%2Fbadges%2Fapify-rating.json)](https://apify.com/xquik/x-tweet-scraper/reviews)
[![Xquik Twitter API accounts](https://img.shields.io/endpoint?url=https%3A%2F%2Fxquik.com%2Fbadges%2Faccounts.json)](https://xquik.com/trust#accounts)
[![Twitter Skill installs](https://img.shields.io/endpoint?url=https%3A%2F%2Fxquik.com%2Fbadges%2Fskill-installs.json)](https://xquik.com/trust#skill-installs)
[![Xquik verified revenue on TrustMRR](https://img.shields.io/endpoint?url=https%3A%2F%2Fxquik.com%2Fbadges%2Frevenue.json)](https://trustmrr.com/startup/xquik)
[![Twitter API median response time](https://img.shields.io/endpoint?url=https%3A%2F%2Fxquik.com%2Fbadges%2Frest-p50.json)](https://xquik.com/trust#speed)
[![Xquik GitHub stars](https://img.shields.io/endpoint?url=https%3A%2F%2Fxquik.com%2Fbadges%2Fgithub-stars.json)](https://github.com/Xquik-dev)
[![xquik/x-twitter-scraper downloads on Packagist](https://img.shields.io/endpoint?url=https%3A%2F%2Fxquik.com%2Fbadges%2Fpackagist-xquik-x-twitter-scraper.json)](https://packagist.org/packages/xquik/x-twitter-scraper/stats)
[![OpenSSF Best Practices](https://www.bestpractices.dev/projects/13737/badge)](https://www.bestpractices.dev/projects/13737)

- 51,000+ downloads of Xquik's Twitter API packages on npm, PyPI, RubyGems, NuGet, Packagist & Terraform ([source](https://xquik.com/trust#downloads)) <!-- trust:downloads 51020 -->
- 7,800+ users of Xquik's Twitter scraper Actors on Apify ([source](https://apify.com/xquik)) <!-- trust:apify-users 7800 -->
- 5,700,000+ runs of Xquik's Twitter scraper Actors on Apify ([source](https://apify.com/xquik)) <!-- trust:apify-runs 5704701 -->
- 4.66 of 5 for the X Tweet Scraper from 16 Apify reviews ([source](https://apify.com/xquik/x-tweet-scraper/reviews)) <!-- trust:apify-rating 4.66 16 -->
- 3,900+ accounts on xquik.com ([source](https://xquik.com/trust#accounts)) <!-- trust:accounts 3924 -->
- 1,600+ installs of Xquik's Twitter Skills on skills.sh ([source](https://xquik.com/trust#skill-installs)) <!-- trust:skill-installs 1612 -->
- $38,000+ in revenue verified by TrustMRR ([source](https://trustmrr.com/startup/xquik)) <!-- trust:revenue 38115 -->
- 501 ms median REST API read time over the last 7 days ([source](https://xquik.com/trust#speed)) <!-- trust:rest-p50 501 -->
- 370+ GitHub stars across Xquik's repos ([source](https://github.com/Xquik-dev)) <!-- trust:github-stars 374 -->
- 34 downloads of xquik/x-twitter-scraper on Packagist ([source](https://packagist.org/packages/xquik/x-twitter-scraper/stats)) <!-- trust:packagist-xquik-x-twitter-scraper 34 -->
- This repo meets the OpenSSF Best Practices passing criteria ([source](https://www.bestpractices.dev/projects/13737)) <!-- trust:openssf-x-twitter-scraper-php 1 -->

Checked on 2026-10-15. See each number with its date & source on [xquik.com/trust](https://xquik.com/trust) or as [JSON](https://xquik.com/trust.json).

<!-- trust:end -->

## PHP client or REST

The typed Composer package calls the documented Xquik REST API.
It does not call or emulate the official X API.
Use this SDK for typed value objects, retries & Composer applications.
Call REST directly when a Composer dependency does not fit.

Read the [PHP SDK guide](https://docs.xquik.com/sdks/php) or the [API guide](https://docs.xquik.com/api-reference/overview).

## Common Twitter & X tasks

| Task | REST route | Usage |
| --- | --- | --- |
| Run an advanced Twitter search | `GET /x/tweets/search` | Use keywords or supported operators. |
| Extract an X profile timeline | `GET /x/users/{id}/tweets` | Paginate bounded timeline results. |
| Scrape Twitter followers | `GET /x/users/{id}/followers` | Use an extraction for complete datasets. |
| Scrape X following accounts | `GET /x/users/{id}/following` | Use an extraction for complete datasets. |
| Read a home timeline | `GET /x/timeline` | Approve this private read. |
| Read lists or communities | `/x/lists/*`, `/x/communities/*` | Use the typed nested services. |
| Export large X datasets | `POST /extractions` | Poll status, then download results. |
| Monitor an account | `POST /monitors` | Deliver events through HMAC webhooks. |
| Post or reply | `POST /x/tweets` | Confirm the account and payload. |

The [API reference](https://docs.xquik.com/api-reference/overview) lists every route and contract.

## Installation

Install the [Packagist package `xquik/x-twitter-scraper`](https://packagist.org/packages/xquik/x-twitter-scraper) with Composer.

```sh
composer require xquik/x-twitter-scraper:^0.13.4
```

## Verify a release

Maintainers release from their own machine with `bin/release-local`.
The script runs every repository check before it pushes the tag.
`bin/release-local --dry-run` runs the same checks and prints the listing without releasing.
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
Releases up to v0.13.3 also carry GitHub build attestations.

## Usage

Set optional arguments, and parameters that have defaults, by name.

```php
<?php

use XTwitterScraper\Client;

$client = new Client(
  apiKey: getenv('X_TWITTER_SCRAPER_API_KEY') ?: 'My API Key'
);

$response = $client->x->tweets->search(q: 'from:elonmusk', limit: 10);

var_dump($response);
```

### Value objects

Create value objects with `Dog::with(name: "Joey")` and named parameters.
Builders also work, as in `(new Dog)->withName("Joey")`.

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
By default, it retries connection failures, timeouts, and HTTP 408, 409, 429 & 5xx responses.
Set `maxRetries` globally or per request.

```php
<?php

use XTwitterScraper\Client;

// Set the default for all requests.
$client = new Client(requestOptions: ['maxRetries' => 0]);

// Or set it for 1 request.
$result = $client->account->retrieve(requestOptions: ['maxRetries' => 5]);
```

## Advanced concepts

### Custom or undocumented requests

#### Undocumented properties

Send undocumented parameters and read undocumented response properties.
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

#### Undocumented request parameters

Pass `extraQueryParams`, `extraBodyParams` & `extraHeaders` through `requestOptions`.

#### Undocumented endpoints

Use `$client->request()` to keep authentication and retries on undocumented routes.

```php
<?php

$response = $client->request(
  method: "post",
  path: '/undocumented/endpoint',
  query: ['dog' => 'woof'],
  headers: ['useful-header' => 'interesting-value'],
  body: ['hello' => 'world']
);
```

## Versioning

This package follows [SemVer](https://semver.org/spec/v2.0.0.html).
Before version 1.0, APIs may change without a major release.
PHPDoc-only type improvements are non-breaking changes.

## Requirements

The SDK requires PHP 8.1.0 or later.

## More Xquik tools

- [X (Twitter) scraper API & Twitter MCP server](https://github.com/Xquik-dev/x-twitter-scraper) with REST, MCP & Skill setup.
- Twitter API SDKs for [TypeScript](https://github.com/Xquik-dev/x-twitter-scraper-typescript), [Python](https://github.com/Xquik-dev/x-twitter-scraper-python), [Go](https://github.com/Xquik-dev/x-twitter-scraper-go), [Ruby](https://github.com/Xquik-dev/x-twitter-scraper-ruby), [Java](https://github.com/Xquik-dev/x-twitter-scraper-java), [Kotlin](https://github.com/Xquik-dev/x-twitter-scraper-kotlin) & [C#](https://github.com/Xquik-dev/x-twitter-scraper-csharp).
- [Twitter CLI & X CLI](https://github.com/Xquik-dev/x-twitter-scraper-cli) for terminal workflows.
- [Twitter advanced search operators](https://github.com/Xquik-dev/x-twitter-advanced-search) with tested examples.
- [Xquik X API & Twitter scraper](https://xquik.com) and the [Twitter API documentation](https://docs.xquik.com/api-reference/overview).

## Project policies

Read [Contributing](CONTRIBUTING.md), [Governance](GOVERNANCE.md), and [Security](SECURITY.md).
See [OpenSSF evidence](OPENSSF.md) for verified controls and blockers.

Xquik is an independent third-party service. Not affiliated with X Corp. "Twitter" and "X" are trademarks of X Corp.
