<?php declare(strict_types=1);

/**
 * This file is part of the project bootiq_recruiting_test.
 *
 * @author: Štěpán Balatka <stepan.balatka@seznam.cz>
 *
 * @date: 6.3.2026
 */

namespace Tests\Unit\Model;

use App\Model\MySQL;
use Codeception\Test\Unit;

/**
 * MySQL test
 */
class MySQLTest extends Unit
{
    /**
     * @return void
     */
    public function testFindById(): void
    {
        $mysql = new MySQL();
        $result = $mysql->findProduct('123abc');

        $this->assertIsArray($result);
        $this->assertSame(['123abc'], $result);
    }
}
