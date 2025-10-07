<?php

declare(strict_types=1);

namespace App\Controller\ProductPrice;

final readonly class UpdateProductPricesRequest
{
    /** @param UpdateProductPriceDto[] $data */
    public function __construct(
        public array $data,
    ) {
    }
}
