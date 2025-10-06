<?php

declare(strict_types=1);

namespace App\Application;

use App\Controller\ProductPrice\ProductPriceUpdateErrorDto;
use App\Domain\ProductPriceDto;
use App\Infrastructure\Repository\ProductPriceRepository;
use App\Infrastructure\Repository\ProductRepository;
use App\Infrastructure\Repository\RegionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class ProductService
{
    public function __construct(
        private ProductPriceRepository $productPriceRepository,
        private ProductRepository $productRepository,
        private RegionRepository $regionRepository,
        private EntityManagerInterface $em,
        private ValidatorInterface $validator,
    ) {
    }

    /**
     * @param ProductPriceDto[] $prices
     *
     * @return ProductPriceUpdateErrorDto[]
     */
    public function updatePrices(array $prices): array
    {
        return $this->em->wrapInTransaction(fn () => $this->updatePricesTransaction($prices));
    }

    /**
     * @param ProductPriceDto[] $prices
     *
     * @return ProductPriceUpdateErrorDto[]
     */
    public function updatePricesTransaction(array $prices): array
    {
        $errors = [];

        $productIds = [];
        $regionIds = [];
        foreach ($prices as $price) {
            $productIds[] = $price->productId;
            $regionIds[] = $price->regionId;
        }

        $missingProductIds = $this->productRepository->findMissingIds($productIds);
        $missingRegionIds = $this->regionRepository->findMissingIds($regionIds);

        $filteredPrices = [];
        foreach ($prices as $price) {
            $errorMessages = [];
            if (in_array($price->productId, $missingProductIds, true)) {
                $errorMessages[] = 'Product does not exist: '.$price->productId;
            }

            if (in_array($price->regionId, $missingRegionIds, true)) {
                $errorMessages[] = 'Region does not exist: '.$price->regionId;
            }

            if (empty($errorMessages)) {
                $filteredPrices[] = $price;
            } else {
                $errors[] = new ProductPriceUpdateErrorDto(
                    $price->productId,
                    $price->regionId,
                    $errorMessages
                );
            }
        }

        foreach ($filteredPrices as $price) {
            $validationErrors = $this->validator->validate($price);

            if (count($errors) > 0) {
                $errorMessages = [];
                foreach ($validationErrors as $violation) {
                    $errorMessages[] = $violation->getPropertyPath().': '.$violation->getMessage();
                }

                $errors[] = new ProductPriceUpdateErrorDto(
                    $price->productId,
                    $price->regionId,
                    $errorMessages
                );

                continue;
            }

            $this->productPriceRepository->updatePrice($price);
        }

        return $errors;
    }
}
