<?php declare(strict_types=1);

/**
 * This file is part of the project bootiq_recruiting_test.
 *
 * @author: Štěpán Balatka <stepan.balatka@seznam.cz>
 *
 * @date: 5.3.2026
 */

namespace Tests\Unit\Service;

use App\Service\ProductService;
use App\Provider\ProductDataProviderInterface;
use App\Counter\ProductQueryCounterInterface;
use Codeception\Test\Unit;
use Mockery;
use Symfony\Contracts\Cache\CacheInterface;

class ProductServiceTest extends Unit
{
    public function testGetProductFetchesFromProviderWhenCacheMiss(): void
    {
        $productId = '123';
        $expectedProduct = ['id' => '123', 'name' => 'Test product'];

        $provider = Mockery::mock(ProductDataProviderInterface::class);
        $counter = Mockery::mock(ProductQueryCounterInterface::class);
        $cache = Mockery::mock(CacheInterface::class);

        $provider
            ->shouldReceive('getById')
            ->once()
            ->with($productId)
            ->andReturn($expectedProduct);

        $counter
            ->shouldReceive('increment')
            ->once()
            ->with($productId);

        $cache
            ->shouldReceive('get')
            ->once()
            ->with('product_' . $productId, Mockery::type(\Closure::class))
            ->andReturnUsing(function ($key, $callback) {
                return $callback();
            });

        $service = new ProductService($cache, $provider, $counter);

        $result = $service->getProduct($productId);

        $this->assertSame($expectedProduct, $result);
    }

    public function testGetProductReturnsFromCacheWithoutCallingProvider(): void
    {
        $productId = '123';
        $cachedProduct = ['id' => '123', 'name' => 'Cached product'];

        $provider = Mockery::mock(ProductDataProviderInterface::class);
        $counter = Mockery::mock(ProductQueryCounterInterface::class);
        $cache = Mockery::mock(CacheInterface::class);

        $provider
            ->shouldReceive('getById')
            ->never();

        $counter
            ->shouldReceive('increment')
            ->once()
            ->with($productId);

        $cache
           ->shouldReceive('get')
            ->once()
            ->with('product_' . $productId, $this->isInstanceOf(\Closure::class))
            ->andReturn($cachedProduct);

        $service = new ProductService($cache, $provider, $counter);

        $result = $service->getProduct($productId);

        $this->assertSame($cachedProduct, $result);
    }
}
