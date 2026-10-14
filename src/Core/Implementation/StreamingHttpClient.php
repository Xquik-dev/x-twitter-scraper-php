<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Core\Implementation;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
final class StreamingHttpClient implements ClientInterface
{
    public function __construct(private ClientInterface $inner) {}

    public function sendRequest(RequestInterface $request, ?float $timeout = null): ResponseInterface
    {
        if (is_a($this->inner, '\GuzzleHttp\Client')) {
            $options = ['stream' => true];
            if (null !== $timeout) {
                $options['timeout'] = $timeout;
            }

            return $this->inner->send($request, $options);
        }

        return $this->inner->sendRequest($request);
    }
}
