<?php
namespace Strix\StationaryShop\Model\StationaryShop;

use Magento\Store\Model\Store;
use Magento\UrlRewrite\Service\V1\Data\UrlRewrite;

/**
 * Interface StationaryShopUrlResolverInterface
 */
interface StationaryShopUrlResolverInterface
{
    /**
     * Entity Type representation in url_rewrite table
     */
    const ENTITY_TYPE = 'stationaryshops';

    /**
     * Shop url parameter
     */
    const STATIONARY_SHOP_URL_PARAMETER = 'shop_id';

    /**
     * Module, vies, action and parameter name
     */
    const TARGET_PATH_PREFIX = self::ENTITY_TYPE . '/page/view/' . self::STATIONARY_SHOP_URL_PARAMETER . '/';

    /**
     * @param int $shopId
     * @param int $storeId
     *
     * @return UrlRewrite|null
     */
    public function getUrl(int $shopId, int $storeId = Store::DEFAULT_STORE_ID);

    /**
     * @param int $shopId
     *
     * @return UrlRewrite[]
     */
    public function getListUrl(int $shopId): array;

    /**
     * @param int $shopId
     *
     * @return string
     */
    public function getTargetPath(int $shopId): string;
}
