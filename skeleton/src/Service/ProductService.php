<?php declare(strict_types=1);

/**
 * This file is part of the project bootiq_recruiting_test.
 *
 * @author: Štěpán Balatka <stepan.balatka@seznam.cz>
 *
 * @date: 5.3.2026
 */

namespace App\Service;

use App\Provider\ProductDataProviderInterface;
use App\Counter\ProductQueryCounterInterface;
use Symfony\Contracts\Cache\CacheInterface;

/**
 * Product service
 */
class ProductService
{
    /**
     * @param CacheInterface               $cache,
     * @param ProductDataProviderInterface $provider,
     * @param ProductQueryCounterInterface $counter,
     */
    public function __construct(
        private readonly CacheInterface $cache,
        private readonly ProductDataProviderInterface $provider,
        private readonly ProductQueryCounterInterface $counter,
    ) {
    }

    /**
     * Orchestrates product data retrieval: increments counter, checks cache, and fetches from db if needed.
     *
     * @param string $id
     * 
     * @return array
     */
    public function getProduct (string $id): array
    {
        $this->counter->increment($id);

        return $this->cache->get('product_' . $id, function () use ($id) {
            
            return $this->provider->getById($id);
        });
    }
}
