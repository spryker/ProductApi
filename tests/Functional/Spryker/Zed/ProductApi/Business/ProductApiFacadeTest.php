<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Functional\Spryker\Zed\ProductApi\Business;

use Codeception\TestCase\Test;
use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiFilterTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;
use Spryker\Zed\ProductApi\Business\ProductApiFacade;

/**
 * @group Functional
 * @group Spryker
 * @group Zed
 * @group ProductApi
 * @group Business
 * @group ProductApiFacadeTest
 */
class ProductApiFacadeTest extends Test
{

    /**
     * @return void
     */
    public function testGet()
    {
        $productApiFacade = new ProductApiFacade();

        $idProduct = 1;

        $resultTransfer = $productApiFacade->getProduct($idProduct);

        $this->assertInstanceOf(ApiItemTransfer::class, $resultTransfer);

        $id = $resultTransfer->getId();
        $this->assertNotEmpty($id);

        $newData = $resultTransfer->getData();
        $this->assertNotEmpty($newData['id_product_abstract']);
    }

    /**
     * @return void
     */
    public function testFind()
    {
        $productApiFacade = new ProductApiFacade();

        $apiRequestTransfer = new ApiRequestTransfer();
        $apiFilterTransfer = new ApiFilterTransfer();
        $apiRequestTransfer->setFilter($apiFilterTransfer);

        $resultTransfer = $productApiFacade->findProducts($apiRequestTransfer);

        $this->assertInstanceOf(ApiCollectionTransfer::class, $resultTransfer);
        $this->assertGreaterThan(1, count($resultTransfer->getData()));

        $data = $resultTransfer->getData();
        $this->assertNotEmpty($data[0]['id_product_abstract']);
    }

    /**
     * @return void
     */
    public function testAdd()
    {
        $productApiFacade = new ProductApiFacade();

        $apiDataTransfer = new ApiDataTransfer();
        $apiDataTransfer->setData([
            'sku' => 'sku' . time(),
            'attributes' => [],
            'product_concretes' => [],
            'id_tax_set' => 1,
        ]);

        $resultTransfer = $productApiFacade->addProduct($apiDataTransfer);

        $this->assertInstanceOf(ApiItemTransfer::class, $resultTransfer);

        $id = $resultTransfer->getId();
        $this->assertNotEmpty($id);

        $newData = $resultTransfer->getData();
        $this->assertNotEmpty($newData['id_product_abstract']);
    }

    /**
     * @return void
     */
    public function testEdit()
    {
        $productApiFacade = new ProductApiFacade();

        $apiDataTransfer = new ApiDataTransfer();
        $data = [
            'sku' => 'sku' . time(). 'new',
            'attributes' => [],
            'product_concretes' => [],
            'id_tax_set' => 1,
        ];
        $apiDataTransfer->setData($data);

        $idProduct = 1;
        $resultTransfer = $productApiFacade->updateProduct($idProduct, $apiDataTransfer);

        $this->assertInstanceOf(ApiItemTransfer::class, $resultTransfer);

        $id = $resultTransfer->getId();
        $this->assertNotEmpty($id);

        $newData = $resultTransfer->getData();
        $this->assertNotEmpty($newData['id_product_abstract']);
        $this->assertSame($data['sku'], $newData['sku']);
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $productApiFacade = new ProductApiFacade();

        $idProductAbstract = 1;
        $apiDataTransfer = new ApiDataTransfer();
        $apiDataTransfer->setData([
            'id_product_abstract' => 1,
            'sku' => 'sku' . time() . '-update',
            'attributes' => [],
            'product_concretes' => [],
            'id_tax_set' => 1,
        ]);

        $resultTransfer = $productApiFacade->updateProduct($idProductAbstract, $apiDataTransfer);

        $this->assertInstanceOf(ApiItemTransfer::class, $resultTransfer);
    }

}
