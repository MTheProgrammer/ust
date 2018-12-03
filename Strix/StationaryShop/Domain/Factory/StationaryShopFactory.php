<?php
namespace Strix\StationaryShop\Domain\Factory;

use Strix\StationaryShop\Domain\StationaryShop;
use Strix\StationaryShop\Model\Api\Data\StationaryShopInterface;
use Strix\StationaryShop\Model\StationaryShop\StationaryShopUrlResolverInterface;
use Magento\Store\Model\StoreManagerInterface;

class StationaryShopFactory implements StationaryShopFactoryInterface
{
    /**
     * @var StationaryShopUrlResolverInterface
     */
    private $stationaryShopUrlResolver;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param StationaryShopUrlResolverInterface $stationaryShopUrlResolver
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        StationaryShopUrlResolverInterface $stationaryShopUrlResolver,
        StoreManagerInterface $storeManager
    ) {
        $this->stationaryShopUrlResolver = $stationaryShopUrlResolver;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function create(
        StationaryShopInterface $stationaryShop
    ): StationaryShop {
        $store = $this->storeManager->getStore();
        $urlRewrite = $this->stationaryShopUrlResolver->getUrl($stationaryShop->getId(), $store->getId());

        return new StationaryShop(
            $stationaryShop->getName(),
            $stationaryShop->getCode(),
            rtrim($store->getUrl($urlRewrite->getRequestPath()), '/')
        );
    }
}
