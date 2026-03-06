<?php declare(strict_types=1);

/**
 * This file is part of the project bootiq_recruiting_test.
 *
 * @author: Štěpán Balatka <stepan.balatka@seznam.cz>
 *
 * @date: 5.3.2026
 */

namespace App\Model;

/**
 * MySQL
 */
class MySQL implements IMySQLDriver
{
    public function findProduct($id): array
    {
        return ['123abc'];
    }
}
