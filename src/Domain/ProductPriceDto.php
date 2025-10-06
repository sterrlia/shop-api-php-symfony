<?php

declare(strict_types=1);

namespace App\Domain;

use Symfony\Component\Validator\Constraints as Assert;

class ProductPriceDto
{
    public function __construct(
        #[Assert\Positive]
        public int $productId,
        #[Assert\Positive]
        public int $regionId,

        #[Assert\Positive]
        public int $purchasePrice,
        #[Assert\Positive]
        public int $sellPrice,
        #[Assert\Positive]
        public int $discountedPrice,
    ) {
    }
}
