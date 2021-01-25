<?php
namespace EonInfosys\Catalog\Model;

use EonInfosys\Catalog\Api\ProductAttributeImgInterface;
//\Magento\Catalog\Api\ProductRepositoryInterface ;

class GetProductImageUrl implements ProductAttributeImgInterface {
    /**
     * @var \Magento\Store\Model\App\Emulation
     */
    protected $appEmulation;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;
    /**
     * @var \Magento\Catalog\Helper\Image
     */
    protected $imageHelper;
    /**
     * @param \Magento\Store\Model\App\Emulation              $appEmulation
     * @param \Magento\Store\Model\StoreManagerInterface      $storeManager
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Catalog\Helper\Image                   $imageHelper
     */
    public function __construct(
       \Magento\Store\Model\App\Emulation $appEmulation,
       \Magento\Store\Model\StoreManagerInterface $storeManager,
       \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
       \Magento\Catalog\Helper\Image $imageHelper
    ) {
       $this->appEmulation = $appEmulation;
       $this->storeManager = $storeManager;
       $this->productRepository = $productRepository;
       $this->imageHelper = $imageHelper;
    }
    public function getProductImageUrl($sku) {
       $storeId = $this->storeManager->getStore()->getId();
       $product = $this->productRepository->get($sku);
       $this->appEmulation->startEnvironmentEmulation($storeId, \Magento\Framework\App\Area::AREA_FRONTEND, true);
       if (!$product) {
           $response = [
               [
                   "code" => '301',
                   "message" => "SKU " . $productSku . " Not Found On Magento",
               ],
           ];
           return $response;
       } else {
           $image_url = $this->imageHelper->init($product, 'product_thumbnail_image')->getUrl();
           $response = [
               [
                   "product_image_url" => $image_url,
               ],
           ];
           return $response;
       }
       $this->appEmulation->stopEnvironmentEmulation();
    }
}
