<?php declare(strict_types=1);

/**
 * This file is part of the project bootiq_recruiting_test.
 *
 * @author: Štěpán Balatka <stepan.balatka@seznam.cz>
 *
 * @date: 5.3.2026
 */

namespace App\Counter;

/**
 * Product query counter interface
 */
interface ProductQueryCounterInterface
{
    /**
     * Increases the query count for the specified product.
     *
     * @param string $id
     */
    public function increment(string $id): void;
}
