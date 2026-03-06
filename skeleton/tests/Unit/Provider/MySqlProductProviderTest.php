<?php declare(strict_types=1);

/**
 * This file is part of the project bootiq_recruiting_test.
 *
 * @author: Štěpán Balatka <stepan.balatka@seznam.cz>
 *
 * @date: 6.3.2026
 */

namespace Tests\Unit\Provider;

use App\Model\IMySQLDriver;
use App\Provider\MySqlProductProvider;
use Codeception\Test\Unit;
use Mockery;

class MySqlProductProviderTest extends Unit
{
    protected function _after(): void
    {
        Mockery::close();
    }

    public function testGetByIdReturnsProductFromDriver(): void
    {
        $productId = '123';

        $expectedProduct = [
            'id' => $productId,
            'name' => 'Test product'
        ];

        $mysqlDriver = Mockery::mock(IMySQLDriver::class);

        $mysqlDriver
            ->shouldReceive('findProduct')
            ->once()
            ->with($productId)
            ->andReturn($expectedProduct);

        $provider = new MySqlProductProvider($mysqlDriver);

        $result = $provider->getById($productId);

        $this->assertSame($expectedProduct, $result);
    }
}
