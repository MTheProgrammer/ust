<?php
namespace Strix\StationaryShop\Model\StationaryShop\Repository;

use Strix\StationaryShop\Model\Api\Data\StationaryShopInterface;
use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchResultsInterface;

interface StationaryShopRepositoryInterface
{
    /**
     * Get Stationary Shop by id
     *
     * @param int $stationaryShopId
     * @param int|null $websiteId
     *
     * @return StationaryShopInterface|null
     */
    public function get(int $stationaryShopId, int $websiteId = null);

    /**
     * @param SearchCriteria|null $searchCriteria
     *
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteria $searchCriteria = null): SearchResultsInterface;
}

