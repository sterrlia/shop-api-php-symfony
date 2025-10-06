<?php

declare(strict_types=1);

namespace App\Domain;

final readonly class ProductPriceCompositeKeyDto
{
    public function __construct(
        public int $productId,
        public int $regionId,
    ) {
    }

    public function toKeyString(): string
    {
        $productId = $this->productId;
        $regionId = $this->regionId;

        return "$productId-$regionId";
    }
}
