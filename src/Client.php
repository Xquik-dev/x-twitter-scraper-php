<?php

declare(strict_types=1);

namespace XTwitterScraper;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use XTwitterScraper\Core\BaseClient;
use XTwitterScraper\Core\Util;
use XTwitterScraper\Services\AccountService;
use XTwitterScraper\Services\APIKeysService;
use XTwitterScraper\Services\BotService;
use XTwitterScraper\Services\ComposeService;
use XTwitterScraper\Services\CreditsService;
use XTwitterScraper\Services\DraftsService;
use XTwitterScraper\Services\DrawsService;
use XTwitterScraper\Services\EventsService;
use XTwitterScraper\Services\ExtractionsService;
use XTwitterScraper\Services\IntegrationsService;
use XTwitterScraper\Services\MonitorsService;
use XTwitterScraper\Services\RadarService;
use XTwitterScraper\Services\StylesService;
use XTwitterScraper\Services\SubscribeService;
use XTwitterScraper\Services\SupportService;
use XTwitterScraper\Services\TrendsService;
use XTwitterScraper\Services\WebhooksService;
use XTwitterScraper\Services\XService;

/**
 * @phpstan-import-type NormalizedRequest from \XTwitterScraper\Core\BaseClient
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
class Client extends BaseClient
{
    public string $apiKey;

    public string $bearerToken;

    /**
     * @api
     */
    public AccountService $account;

    /**
     * @api
     */
    public APIKeysService $apiKeys;

    /**
     * @api
     */
    public SubscribeService $subscribe;

    /**
     * @api
     */
    public ComposeService $compose;

    /**
     * @api
     */
    public DraftsService $drafts;

    /**
     * @api
     */
    public StylesService $styles;

    /**
     * @api
     */
    public RadarService $radar;

    /**
     * @api
     */
    public MonitorsService $monitors;

    /**
     * @api
     */
    public EventsService $events;

    /**
     * @api
     */
    public ExtractionsService $extractions;

    /**
     * @api
     */
    public DrawsService $draws;

    /**
     * @api
     */
    public WebhooksService $webhooks;

    /**
     * @api
     */
    public IntegrationsService $integrations;

    /**
     * @api
     */
    public XService $x;

    /**
     * @api
     */
    public TrendsService $trends;

    /**
     * @api
     */
    public BotService $bot;

    /**
     * @api
     */
    public SupportService $support;

    /**
     * @api
     */
    public CreditsService $credits;

    /**
     * @param RequestOpts|null $requestOptions
     */
    public function __construct(
        ?string $apiKey = null,
        ?string $bearerToken = null,
        ?string $baseUrl = null,
        RequestOptions|array|null $requestOptions = null,
    ) {
        $this->apiKey = (string) ($apiKey ?? Util::getenv(
            'X_TWITTER_SCRAPER_API_KEY'
        ));
        $this->bearerToken = (string) ($bearerToken ?? Util::getenv(
            'X_TWITTER_SCRAPER_BEARER_TOKEN'
        ));

        $baseUrl ??= Util::getenv(
            'X_TWITTER_SCRAPER_BASE_URL'
        ) ?: 'https://xquik.com/api/v1';

        $options = RequestOptions::parse(
            RequestOptions::with(
                uriFactory: Psr17FactoryDiscovery::findUriFactory(),
                streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
                requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
                transporter: Psr18ClientDiscovery::find(),
            ),
            $requestOptions,
        );

        parent::__construct(
            headers: [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'User-Agent' => sprintf('x-twitter-scraper/PHP %s', VERSION),
                'X-Stainless-Lang' => 'php',
                'X-Stainless-Package-Version' => '0.1.0',
                'X-Stainless-Arch' => Util::machtype(),
                'X-Stainless-OS' => Util::ostype(),
                'X-Stainless-Runtime' => php_sapi_name(),
                'X-Stainless-Runtime-Version' => phpversion(),
            ],
            baseUrl: $baseUrl,
            options: $options
        );

        $this->account = new AccountService($this);
        $this->apiKeys = new APIKeysService($this);
        $this->subscribe = new SubscribeService($this);
        $this->compose = new ComposeService($this);
        $this->drafts = new DraftsService($this);
        $this->styles = new StylesService($this);
        $this->radar = new RadarService($this);
        $this->monitors = new MonitorsService($this);
        $this->events = new EventsService($this);
        $this->extractions = new ExtractionsService($this);
        $this->draws = new DrawsService($this);
        $this->webhooks = new WebhooksService($this);
        $this->integrations = new IntegrationsService($this);
        $this->x = new XService($this);
        $this->trends = new TrendsService($this);
        $this->bot = new BotService($this);
        $this->support = new SupportService($this);
        $this->credits = new CreditsService($this);
    }

    /**
     * @param array{apiKey?: bool, oauthBearer?: bool} $security
     *
     * @return array<string,string>
     */
    protected function authHeaders(array $security): array
    {
        return [
            ...($security['apiKey'] ?? false) ? $this->apiKeyScheme() : [],
            ...($security['oauthBearer'] ?? false) ? $this->oauthBearer() : [],
        ];
    }

    /** @return array<string,string> */
    protected function apiKeyScheme(): array
    {
        return $this->apiKey ? ['X-Api-Key' => $this->apiKey] : [];
    }

    /** @return array<string,string> */
    protected function oauthBearer(): array
    {
        return $this->bearerToken ? [
            'Authorization' => "Bearer {$this->bearerToken}",
        ] : [];
    }

    /**
     * @internal
     *
     * @param string|list<string> $path
     * @param array<string,mixed> $query
     * @param array<string,string|int|list<string|int>|null> $headers
     * @param RequestOpts|null $opts
     * @param array{apiKey?: bool, oauthBearer?: bool}|null $security
     *
     * @return array{NormalizedRequest, RequestOptions}
     */
    protected function buildRequest(
        string $method,
        string|array $path,
        array $query,
        array $headers,
        mixed $body,
        RequestOptions|array|null $opts,
        ?array $security = null,
    ): array {
        return parent::buildRequest(
            method: $method,
            path: $path,
            query: $query,
            headers: [
                ...$this->authHeaders(
                    security: ($security ?? ['apiKey' => true, 'oauthBearer' => true])
                ),
                ...$headers,
            ],
            body: $body,
            opts: $opts,
            security: $security,
        );
    }
}
