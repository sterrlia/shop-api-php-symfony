<?php

namespace App\Controller\ProductPrice;

use App\Application\ProductService;
use App\Controller\ValidatedJsonRequestResolver;
use App\Domain\ProductPriceDto;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;
use Symfony\Component\Routing\Attribute\Route;

final class ProductPriceController extends AbstractController
{
    public function __construct(
        private readonly ProductService $productService,
        private readonly LoggerInterface $logger,
    ) {
    }

    #[Route('/product/price/update-prices', methods: ['POST'], name: 'update-product-prices')]
    public function update(
        #[ValueResolver(ValidatedJsonRequestResolver::class)]
        UpdateProductPricesRequest $request,
    ): JsonResponse {
        $pricesInput = array_map(
            fn (UpdateProductPriceDto $price) => new ProductPriceDto(
                productId: $price->productId,
                regionId: $price->regionId,
                purchasePrice: $price->purchasePrice,
                sellPrice: $price->sellPrice,
                discountedPrice: $price->discountPrice
            ),
            $request->data
        );
        $errors = $this->productService->updatePrices($pricesInput);
        $response = new UpdateProductPricesResponse($errors);

        if (!empty($response->errors)) {
            $this->logger->warning('Price update error', [
                'errors' => json_encode($errors),
            ]);

            return $this->json($response, 207);
        } else {
            return $this->json($response, 200);
        }
    }
}
