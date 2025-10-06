<?php

declare(strict_types=1);

namespace App\Controller\ProductPrice;

class UpdateProductPricesRequest
{
    /** @param UpdateProductPriceDto[] $data */
    public function __construct(
        public readonly array $data,
    ) {
    }
}
