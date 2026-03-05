<?php declare(strict_types=1);

/**
 * This file is part of the project bootiq_recruiting_test.
 *
 * @author: Štěpán Balatka <stepan.balatka@seznam.cz>
 *
 * @date: 4.3.2026
 */

namespace App\Cache;

interface ProductCacheInterface
{
    /**
     * Returns cached product data or null if not found.
     *
     * @param string $id
     * @return array|null
     */
    public function get(string $id): ?array;

    /**
     * Stores product data in cache.
     *
     * @param string $id
     * @param array $data
     */
    public function set(string $id, array $data): void;
}
