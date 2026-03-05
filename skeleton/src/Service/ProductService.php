<?php

declare(strict_types=1);

namespace App\Service;

use App\Provider\ProductDataProviderInterface;
use App\Cache\ProductCacheInterface;
use App\Counter\ProductQueryCounterInterface;

class ProductService
{
    public function __construct(
        private readonly ProductDataProviderInterface $provider,
        private readonly ProductCacheInterface $cache,
        private readonly ProductQueryCounterInterface $counter,
    ) {
    }

    public function getProduct (string $id): array
    {
        $cacheProduct = $this->cache->get($id);

        if ($cacheProduct !== null) {
            $this->counter->increment($id);
            return $cacheProduct;
        }

        $notCacheProduct = $this->provider->getById($id); 
    }
}
