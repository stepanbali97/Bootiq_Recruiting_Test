<?php declare(strict_types=1);

/**
 * This file is part of the project bootiq_recruiting_test.
 *
 * @author: Štěpán Balatka <stepan.balatka@seznam.cz>
 *
 * @date: 4.3.2026
 */

namespace App\Counter;

interface ProductQueryCounterInterface
{
    /**
     * Increments query counter for given product ID.
     *
     * @param string $id
     */
    public function increment(string $id): void;
}
