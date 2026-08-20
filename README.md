# Xquik PHP SDK: Twitter Search, Followers & X Automation

[![OpenSSF Best Practices](https://www.bestpractices.dev/projects/13737/badge)](https://www.bestpractices.dev/projects/13737)
[![CI](https://github.com/Xquik-dev/x-twitter-scraper-php/actions/workflows/ci.yml/badge.svg)](https://github.com/Xquik-dev/x-twitter-scraper-php/actions/workflows/ci.yml)

Search Twitter, read timelines, fetch profiles & export followers with Xquik.
Use typed Composer methods for media, webhooks & X automation.

## PHP or REST

Use this SDK for typed value objects, retries & Composer applications.
Use the REST API when Composer is unavailable.

## Documentation

Read the [PHP SDK guide](https://docs.xquik.com/sdks/php) or [API guide](https://docs.xquik.com/api-reference/overview).

## Common Twitter & X Tasks

| Task | REST Route | Usage |
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

Install the package from Packagist with Composer:

<!-- x-release-please-start-version -->

```sh
composer require xquik/x-twitter-scraper:^0.13.3
```

<!-- x-release-please-end -->

## Verify a Release

Replace `VERSION` with the release number. Then verify its project archive:

```sh
release_tag=vVERSION
archive="x-twitter-scraper-php-$release_tag.zip"

gh release download "$release_tag" \
  --repo Xquik-dev/x-twitter-scraper-php \
  --pattern "$archive"

gh attestation verify "$archive" \
  --repo Xquik-dev/x-twitter-scraper-php \
  --signer-workflow Xquik-dev/x-twitter-scraper-php/.github/workflows/release-provenance.yml \
  --source-ref "refs/tags/$release_tag" \
  --deny-self-hosted-runners
```

GitHub verifies the archive, repository, workflow, signer & transparency proof.

## Usage

Set optional arguments and parameters with defaults by name.

```php
<?php

use XTwitterScraper\Client;

$client = new Client(
  apiKey: getenv('X_TWITTER_SCRAPER_API_KEY') ?: 'My API Key'
);

$response = $client->x->tweets->search(q: 'from:elonmusk', limit: 10);

var_dump($response);
```

### Value Objects

Create value objects with `Dog::with(name: "Joey")` and named parameters.
Builders also work: `(new Dog)->withName("Joey")`.

### Handling Errors

Connection failures and non-2xx responses throw an `APIException` subclass:

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

Error types by cause:

| Cause            | Error Type                     |
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
Defaults include connection failures, timeouts, HTTP 408, 409, 429 & 5xx responses.
Set `maxRetries` globally or per request:

```php
<?php

use XTwitterScraper\Client;

// Configure the default for all requests:
$client = new Client(requestOptions: ['maxRetries' => 0]);

// Or, configure per-request:
$result = $client->account->retrieve(requestOptions: ['maxRetries' => 5]);
```

## Advanced Concepts

### Custom or Undocumented Requests

#### Undocumented Properties

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

#### Undocumented Request Parameters

Pass `extraQueryParams`, `extraBodyParams` & `extraHeaders` through `requestOptions`.

#### Undocumented Endpoints

Use `$client->request()` to keep authentication and retries on undocumented routes:

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

PHP 8.1.0 or higher.

## Project Policies

Read [Contributing](CONTRIBUTING.md), [Governance](GOVERNANCE.md), and [Security](SECURITY.md).
See [OpenSSF evidence](OPENSSF.md) for verified controls and blockers.

Xquik is an independent third-party service. Not affiliated with X Corp. "Twitter" and "X" are trademarks of X Corp.
