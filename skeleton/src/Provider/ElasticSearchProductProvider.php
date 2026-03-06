<?php declare(strict_types=1);

/**
 * This file is part of the project bootiq_recruiting_test.
 *
 * @author: Štěpán Balatka <stepan.balatka@seznam.cz>
 *
 * @date: 5.3.2026
 */

namespace App\Provider;

use App\Model\IElasticSearchDriver;

/**
 * ElasticSearch product provider
 */
class ElasticSearchProductProvider implements ProductDataProviderInterface
{
    private $elasticDriver;

    /**
     * @param IElasticSearchDriver $elasticDriver
     */
    public function __construct(IElasticSearchDriver $elasticDriver)
    {
        $this->elasticDriver = $elasticDriver;
    }

    /**
     * Returns product data by its ID from ElasticSearch driver.
     *
     * @param string $id
     *
     * @return array
     */
    public function getById(string $id): array
    {
        return $this->elasticDriver->findById($id);
    }
}
