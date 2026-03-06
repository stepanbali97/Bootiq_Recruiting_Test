<?php

namespace Tests\Api\Controller;

use Tests\Support\ApiTester;

class ProductControllerCest
{
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
