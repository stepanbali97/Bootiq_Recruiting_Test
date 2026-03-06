<?php declare(strict_types=1);

/**
 * This file is part of the project bootiq_recruiting_test.
 *
 * @author: Štěpán Balatka <stepan.balatka@seznam.cz>
 *
 * @date: 5.3.2026
 */

namespace App\Provider;

use App\Model\IMySQLDriver;

/**
 * MySql product provider
 */
class MySqlProductProvider implements ProductDataProviderInterface
{
    private $mysqlDriver;

    /**
     * @param IMySQLDriver $mysqlDriver
     */
    public function __construct(IMySQLDriver $mysqlDriver)
    {
        $this->mysqlDriver = $mysqlDriver;
    }

    /**
     * Returns product data by its ID from MySQL driver.
     *
     * @param string $id
     *
     * @return array
     */
    public function getById(string $id): array
    {
        return $this->mysqlDriver->findProduct($id);
    }
}
