<?php

declare(strict_types=1);

namespace App\Controller\ProductPrice;

final readonly class ProductPriceUpdateErrorDto
{
    /** @param array<int, string> $messages */
    public function __construct(
        public int $productId,
        public int $regionId,
        public array $messages,
    ) {
    }
}
