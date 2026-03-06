<?php declare(strict_types=1);

/**
 * This file is part of the project bootiq_recruiting_test.
 *
 * @author: Štěpán Balatka <stepan.balatka@seznam.cz>
 *
 * @date: 6.3.2026
 */

namespace Tests\Api\Controller;

use Tests\Support\ApiTester;

/**
 * Product controller cest
 */
class ProductControllerCest
{
    /**
     * @param ApiTester $I
     * 
     * @return void
     */
    public function getProductReturnsJson(ApiTester $I): void
    {
        $productId = '123';

        $I->sendGET('/product-info/' . $productId);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'id' => $productId
        ]);
    }
}
