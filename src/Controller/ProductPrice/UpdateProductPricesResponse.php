<?php

declare(strict_types=1);

namespace App\Controller\ProductPrice;

final readonly class UpdateProductPricesResponse
{
    /** @param ProductPriceUpdateErrorDto[] $errors */
    public function __construct(
        public array $errors,
    ) {
    }
}
