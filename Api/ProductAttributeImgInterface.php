<?php
namespace EonInfosys\Catalog\Api;


interface ProductAttributeImgInterface {
    /**
     * @api
     * @param string $sku
     * @return int[]
     */
    public function getProductImageUrl($sku);
}
