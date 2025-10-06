<?php

declare(strict_types=1);

namespace App\Controller\ProductPrice;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class UpdateProductPriceDto
{
    public function __construct(
        #[Assert\Positive]
        public int $productId,
        #[Assert\Positive]
        public int $regionId,

        public int $purchasePrice,
        public int $sellPrice,
        public int $discountPrice,
    ) {
    }
}
