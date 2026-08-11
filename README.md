# X (Twitter) Scraper PHP SDK: Tweet Search, Timelines, Followers & Posting

[![OpenSSF Best Practices](https://www.bestpractices.dev/projects/13737/badge)](https://www.bestpractices.dev/projects/13737)
[![CI](https://github.com/Xquik-dev/x-twitter-scraper-php/actions/workflows/ci.yml/badge.svg)](https://github.com/Xquik-dev/x-twitter-scraper-php/actions/workflows/ci.yml)

Use Xquik's typed Composer SDK as an X API alternative.

Search tweets, read timelines, export followers, and deliver webhooks.

Confirmed methods also support posting and other account actions.

## Is This A Twitter API Alternative?

This package calls Xquik's documented REST API.

It does not call or emulate the official X API.

Use it for supported X data and automation workflows from PHP.

## Choose the PHP SDK

Choose this client for Composer applications using typed value objects and retries.
Reuse its client inside framework-based or standalone PHP services.
Use REST when Composer installation is unavailable.

## Documentation

Read the [PHP SDK guide](https://docs.xquik.com/sdks/php) or [API guide](https://docs.xquik.com/api-reference/overview).

## Common X Data Tasks

Use the linked SDK guide for typed method names.

| Customer Question | REST Route | Workflow Note |
| --- | --- | --- |
| How do I search tweets? | `GET /x/tweets/search` | Use keyword or advanced operator queries. |
| How do I extract a profile timeline? | `GET /x/users/{id}/tweets` | Paginate bounded X timeline results. |
| How do I scrape X followers? | `GET /x/users/{id}/followers` | Use an extraction for complete datasets. |
| How do I scrape X following accounts? | `GET /x/users/{id}/following` | Use an extraction for complete datasets. |
| How do I read my home timeline? | `GET /x/timeline` | Approve this private read. |
| How do I read lists or communities? | `/x/lists/*`, `/x/communities/*` | Use the typed nested services. |
| How do I export large X datasets? | `POST /extractions` | Poll status, then download results. |
| How do I monitor an account? | `POST /monitors` | Deliver events through HMAC webhooks. |
| How do I post or reply? | `POST /x/tweets` | Confirm the account and payload. |

The [API reference](https://docs.xquik.com/api-reference/overview) lists every route.

The SDK exposes matching typed services and request models.

## Installation

Install the package from Packagist with Composer:

<!-- x-release-please-start-version -->

```sh
composer require xquik/x-twitter-scraper:^0.12.1
```

<!-- x-release-please-end -->

## Verify a Release

Composer users install through Packagist.

Verify Xquik's matching project archive before upgrading:

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

Require the Xquik-dev repository and expected release workflow.

GitHub verifies the archive digest, signer identity, and transparency proof.

## Usage

This library uses named parameters to specify optional arguments.
Parameters with a default value must be set by name.

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

It is recommended to use the static `with` constructor `Dog::with(name: "Joey")`
and named parameters to initialize value objects.

However, builders are also provided `(new Dog)->withName("Joey")`.

### Handling errors

When the library is unable to connect to the API, or if the API returns a non-success status code (i.e., 4xx or 5xx response), a subclass of `XTwitterScraper\Core\Exceptions\APIException` will be thrown:

```php
<?php

use XTwitterScraper\Core\Exceptions\APIConnectionException;
use XTwitterScraper\Core\Exceptions\RateLimitException;
use XTwitterScraper\Core\Exceptions\APIStatusException;

try {
  $account = $client->account->retrieve();
} catch (APIConnectionException $e) {
  echo "The server could not be reached", PHP_EOL;
  var_dump($e->getPrevious());
} catch (RateLimitException $e) {
  echo "A 429 status code was received; we should back off a bit.", PHP_EOL;
} catch (APIStatusException $e) {
  echo "Another non-200-range status code was received", PHP_EOL;
  echo $e->getMessage();
}
```

Error codes are as follows:

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

Certain errors will be automatically retried 2 times by default, with a short exponential backoff.

Connection errors (for example, due to a network connectivity problem), 408 Request Timeout, 409 Conflict, 429 Rate Limit, >=500 Internal errors, and timeouts will all be retried by default.

You can use the `maxRetries` option to configure or disable this:

```php
<?php

use XTwitterScraper\Client;

// Configure the default for all requests:
$client = new Client(requestOptions: ['maxRetries' => 0]);

// Or, configure per-request:
$result = $client->account->retrieve(requestOptions: ['maxRetries' => 5]);
```

## Advanced concepts

### Making custom or undocumented requests

#### Undocumented properties

You can send undocumented parameters to any endpoint, and read undocumented response properties, like so:

Note: the `extra*` parameters of the same name overrides the documented parameters.

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

#### Undocumented request params

If you want to explicitly send an extra param, you can do so with the `extra_query`, `extra_body`, and `extra_headers` under the `request_options:` parameter when making a request, as seen in the examples above.

#### Undocumented endpoints

To make requests to undocumented endpoints while retaining the benefit of auth, retries, and so on, you can make requests using `client.request`, like so:

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

This package follows [SemVer](https://semver.org/spec/v2.0.0.html) conventions. As the library is in initial development and has a major version of `0`, APIs may change at any time.

This package considers improvements to the (non-runtime) PHPDoc type definitions to be non-breaking changes.

## Requirements

PHP 8.1.0 or higher.

## Project Policies

Read [Contributing](CONTRIBUTING.md), [Governance](GOVERNANCE.md), and [Security](SECURITY.md).

See [OpenSSF evidence](OPENSSF.md) for verified controls and remaining blockers.

Xquik is an independent third-party service. Not affiliated with X Corp. "Twitter" and "X" are trademarks of X Corp.
