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
 * ElasticSearch
 */
class ElasticSearch implements IElasticSearchDriver
{
    public function findById($id): array
    {
        return ['123abc'];
    }
}
