<?php
namespace Strix\StationaryShop\Model\StationaryShop;

use Magento\Store\Model\Store;
use Magento\UrlRewrite\Model\UrlFinderInterface;
use Magento\UrlRewrite\Service\V1\Data\UrlRewrite;

/**
 * Class StationaryShopUrlResolver
 */
class StationaryShopUrlResolver implements StationaryShopUrlResolverInterface
{
    /**
     * @var UrlFinderInterface
     */
    private $urlFinder;

    /**
     * @param UrlFinderInterface $urlFinder
     */
    public function __construct(UrlFinderInterface $urlFinder)
    {
        $this->urlFinder = $urlFinder;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl(int $shopId, int $storeId = Store::DEFAULT_STORE_ID)
    {
        return $this->urlFinder->findOneByData(
            [
                UrlRewrite::TARGET_PATH => $this->getTargetPath($shopId),
                UrlRewrite::STORE_ID => $storeId
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getListUrl(int $shopId): array
    {
        return $this->urlFinder->findAllByData([UrlRewrite::TARGET_PATH => $this->getTargetPath($shopId)]);
    }

    /**
     * {@inheritdoc}
     */
    public function getTargetPath(int $shopId): string
    {
        return static::TARGET_PATH_PREFIX . $shopId;
    }
}
