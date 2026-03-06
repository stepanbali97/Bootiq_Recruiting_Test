<?php declare(strict_types=1);

/**
 * This file is part of the project bootiq_recruiting_test.
 *
 * @author: Štěpán Balatka <stepan.balatka@seznam.cz>
 *
 * @date: 5.3.2026
 */

namespace App\Provider;

use Psr\Log\LoggerInterface;
use Throwable;

/**
 * Fallback product provider
 */
class FallbackProductProvider implements ProductDataProviderInterface
{
    /**
     * @param ElasticSearchProductProvider $elasticProvider
     * @param MySQLProductProvider         $mysqlProvider
     * @param LoggerInterface              $logger
     * @param bool                         $forceMysql 
     */
    public function __construct(
        private readonly ElasticSearchProductProvider $elasticProvider,
        private readonly MySQLProductProvider $mysqlProvider,
        private readonly LoggerInterface $logger,
        private readonly bool $forceMysql
    ) {
    }

    /**
     * Retrieves product data by ID, using ElasticSearch as primary source with a fail-safe fallback to MySQL.
     *
     * @param string $id
     * 
     * @return array
     */
    public function getById(string $id): array
    {   
        if ($this->forceMysql) {
            return $this->mysqlProvider->getById($id);
        }

        try {
            return $this->elasticProvider->getById($id);
        } catch (Throwable $e) {
            $this->logger->error('ElasticSearch failed, falling back to MySQL.', [
                'product_id' => $id,
                'error' => $e->getMessage()
            ]);

            return $this->mysqlProvider->getById($id);
        }
    }
}
