<?php declare(strict_types=1);

/**
 * This file is part of the project bootiq_recruiting_test.
 *
 * @author: Štěpán Balatka <stepan.balatka@seznam.cz>
 *
 * @date: 6.3.2026
 */

namespace Tests\Unit\Model;

use App\Model\ElasticSearch;
use Codeception\Test\Unit;

class ElasticSearchTest extends Unit
{
    public function testFindById(): void
    {
        $elasticSearch = new ElasticSearch();
        $result = $elasticSearch->findById('123abc');

        $this->assertIsArray($result);
        $this->assertSame(['123abc'], $result);
    }
}
