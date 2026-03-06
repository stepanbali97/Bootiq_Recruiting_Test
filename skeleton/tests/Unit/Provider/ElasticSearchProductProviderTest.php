<?php declare(strict_types=1);

/**
 * This file is part of the project bootiq_recruiting_test.
 *
 * @author: Štěpán Balatka <stepan.balatka@seznam.cz>
 *
 * @date: 6.3.2026
 */

namespace Tests\Unit\Provider;

use App\Model\IElasticSearchDriver;
use App\Provider\ElasticSearchProductProvider;
use Codeception\Test\Unit;
use Mockery;

/**
 * ElasticSearch product provider test
 */
class ElasticSearchProductProviderTest extends Unit
{
    /**
     * @return void
     */
    public function testGetByIdReturnsProductFromDriver(): void
    {
        $productId = '123';

        $expectedProduct = [
            'id' => $productId,
            'name' => 'Test product'
        ];

        $elasticSearchDriver = Mockery::mock(IElasticSearchDriver::class);

        $elasticSearchDriver
            ->shouldReceive('findById')
            ->once()
            ->with($productId)
            ->andReturn($expectedProduct);

        $provider = new ElasticSearchProductProvider($elasticSearchDriver);

        $result = $provider->getById($productId);

        $this->assertSame($expectedProduct, $result);
    }

    /**
     * @return void
     */
    protected function _after(): void
    {
        Mockery::close();
    }
}
