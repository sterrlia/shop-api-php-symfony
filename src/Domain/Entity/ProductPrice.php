<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Infrastructure\Repository\ProductPriceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductPriceRepository::class)]
#[ORM\Table('product_price')]
class ProductPrice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null; // @phpstan-ignore-line

    public function __construct(
        #[ORM\ManyToOne(inversedBy: 'productPrices')]
        #[ORM\JoinColumn(nullable: false)]
        private Product $product,

        #[ORM\ManyToOne(inversedBy: 'productPrices')]
        #[ORM\JoinColumn(nullable: false)]
        private Region $region,

        #[Assert\Positive]
        #[ORM\Column]
        private int $purchasePrice,

        #[Assert\Positive]
        #[ORM\Column]
        private int $sellPrice,

        #[Assert\Positive]
        #[ORM\Column]
        private int $discountedPrice,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(Region $region): static
    {
        $this->region = $region;

        return $this;
    }

    public function getPurchasePrice(): int
    {
        return $this->purchasePrice;
    }

    public function setPurchasePrice(int $purchasePrice): static
    {
        $this->purchasePrice = $purchasePrice;

        return $this;
    }

    public function getSellPrice(): int
    {
        return $this->sellPrice;
    }

    public function setSellPrice(int $sellPrice): static
    {
        $this->sellPrice = $sellPrice;

        return $this;
    }

    public function getDiscountedPrice(): int
    {
        return $this->discountedPrice;
    }

    public function setDiscountedPrice(int $discountedPrice): static
    {
        $this->discountedPrice = $discountedPrice;

        return $this;
    }
}
