<?php declare(strict_types=1);

/**
 * This file is part of the project bootiq_recruiting_test.
 *
 * @author: Štěpán Balatka <stepan.balatka@seznam.cz>
 *
 * @date: 6.3.2026
 */

namespace Tests\Unit\Provider;

use App\Provider\ElasticSearchProductProvider;
use App\Provider\FallbackProductProvider;
use App\Provider\MySqlProductProvider;
use Codeception\Test\Unit;
use Exception;
use Mockery;
use Psr\Log\LoggerInterface;

class FallbackProductProviderTest extends Unit
{
    public function testUsesMysqlWhenForceMysqlIsTrue(): void
    {
        $productId = '123';
        $expectedProduct = ['id' => '123'];

        $elastic = Mockery::mock(ElasticSearchProductProvider::class);
        $mysql = Mockery::mock(MySqlProductProvider::class);
        $logger = Mockery::mock(LoggerInterface::class);

        $elastic->shouldReceive('getById')->never();

        $mysql
            ->shouldReceive('getById')
            ->once()
            ->with($productId)
            ->andReturn($expectedProduct);

        $provider = new FallbackProductProvider(
            $elastic,
            $mysql,
            $logger,
            true
        );

        $result = $provider->getById($productId);

        $this->assertSame($expectedProduct, $result);
    }

    public function testUsesElasticWhenAvailable(): void
    {
        $productId = '123';
        $expectedProduct = ['id' => '123'];

        $elastic = Mockery::mock(ElasticSearchProductProvider::class);
        $mysql = Mockery::mock(MySqlProductProvider::class);
        $logger = Mockery::mock(LoggerInterface::class);

        $elastic
            ->shouldReceive('getById')
            ->once()
            ->with($productId)
            ->andReturn($expectedProduct);

        $mysql->shouldReceive('getById')->never();
        $logger->shouldReceive('error')->never();

        $provider = new FallbackProductProvider(
            $elastic,
            $mysql,
            $logger,
            false
        );

        $result = $provider->getById($productId);

        $this->assertSame($expectedProduct, $result);
    }

    public function testFallsBackToMysqlWhenElasticFails(): void
    {
        $productId = '123';
        $expectedProduct = ['id' => '123'];

        $elastic = Mockery::mock(ElasticSearchProductProvider::class);
        $mysql = Mockery::mock(MySqlProductProvider::class);
        $logger = Mockery::mock(LoggerInterface::class);

        $elastic
            ->shouldReceive('getById')
            ->once()
            ->with($productId)
            ->andThrow(new Exception('Elastic failure'));

        $mysql
            ->shouldReceive('getById')
            ->once()
            ->with($productId)
            ->andReturn($expectedProduct);

        $logger
            ->shouldReceive('error')
            ->once();

        $provider = new FallbackProductProvider(
            $elastic,
            $mysql,
            $logger,
            false
        );

        $result = $provider->getById($productId);

        $this->assertSame($expectedProduct, $result);
    }
}
