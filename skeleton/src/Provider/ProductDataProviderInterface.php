<?php declare(strict_types=1);

/**
 * This file is part of the project bootiq_recruiting_test.
 *
 * @author: Štěpán Balatka <stepan.balatka@seznam.cz>
 *
 * @date: 4.3.2026
 */

namespace App\Provider;

/**
 * unifying adapter over IElasticSearchDriver::findById() and IMySQLDriver::findProduct()
 */
interface ProductDataProviderInterface
{
    /**
     * Returns product data by its ID.
     *
     * @param string $id
     * @return array
     */
    public function getById(string $id): array;
}
