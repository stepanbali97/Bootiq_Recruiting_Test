<?php declare(strict_types=1);

/**
 * This file is part of the project bootiq_recruiting_test.
 *
 * @author: Štěpán Balatka <stepan.balatka@seznam.cz>
 *
 * @date: 5.3.2026
 */

namespace App\Controller;

use App\Service\ProductService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Product controller
 */
class ProductController
{
    /**
     * @param ProductService $productService
     */
    public function __construct(
        private readonly ProductService $productService
    ) {
    }

    /**
     * Handles the request to fetch product details and returns a JSON response.
     *
     * @param string $id
     * 
     * @return JsonResponse 
     */
    #[Route('/product-info/{id}', methods: ['GET'])]
    public function product(string $id): JsonResponse
    {
        $sanitizedId = rtrim($id, '/');
        $productData = $this->productService->getProduct($sanitizedId);

        return new JsonResponse([
            'id' => $sanitizedId,
            'data' => $productData,
        ]);
    }
}
