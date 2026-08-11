<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Draws;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Draws\DrawExportParams\Format;
use XTwitterScraper\Draws\DrawExportParams\Type;

/**
 * Export draw data.
 *
 * @see XTwitterScraper\Services\DrawsService::export()
 *
 * @phpstan-type DrawExportParamsShape = array{
 *   format: Format|value-of<Format>, type?: null|Type|value-of<Type>
 * }
 */
final class DrawExportParams implements BaseModel
{
    /** @use SdkModel<DrawExportParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Export output format. PDF entry exports include up to 10,000 rows. Other entry formats include up to 100,000 rows.
     *
     * @var value-of<Format> $format
     */
    #[Required(enum: Format::class)]
    public string $format;

    /**
     * Export winners or all entries.
     *
     * @var value-of<Type>|null $type
     */
    #[Optional(enum: Type::class)]
    public ?string $type;

    /**
     * `new DrawExportParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DrawExportParams::with(format: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DrawExportParams)->withFormat(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Format|value-of<Format> $format
     * @param Type|value-of<Type>|null $type
     */
    public static function with(
        Format|string $format,
        Type|string|null $type = null
    ): self {
        $self = new self;

        $self['format'] = $format;

        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * Export output format. PDF entry exports include up to 10,000 rows. Other entry formats include up to 100,000 rows.
     *
     * @param Format|value-of<Format> $format
     */
    public function withFormat(Format|string $format): self
    {
        $self = clone $this;
        $self['format'] = $format;

        return $self;
    }

    /**
     * Export winners or all entries.
     *
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
