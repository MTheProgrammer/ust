<?php
namespace Strix\StationaryShop\Domain\Repository;

use Strix\StationaryShop\Model\Api\Data\StationaryShopInterface;
use Strix\StationaryShop\Model\ResourceModel\StationaryShopResourceModel;
use Strix\StationaryShop\Model\StationaryShop\Repository\StationaryShopRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\StoreManagerInterface;

class StationaryShopRepository
{
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var StationaryShopRepositoryInterface
     */
    private $stationaryShopRepository;


    /**
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param StoreManagerInterface $storeManager
     * @param StationaryShopRepositoryInterface $stationaryShopRepository
     */
    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        StoreManagerInterface $storeManager,
        StationaryShopRepositoryInterface $stationaryShopRepository
    ) {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->storeManager = $storeManager;
        $this->stationaryShopRepository = $stationaryShopRepository;
    }

    /**
     * @param array $stationaryShopIds
     *
     * @return StationaryShopInterface[]
     */
    public function getStationaryShops(array $stationaryShopIds = []): array
    {
        try {
            if (!empty($stationaryShopIds)) {
                $this->searchCriteriaBuilder->addFilter(
                    StationaryShopResourceModel::ID_FIELD,
                    $stationaryShopIds,
                    'in'
                );
            }

            $this->searchCriteriaBuilder->addFilter(
                StationaryShopInterface::WEBSITE_ID,
                $this->storeManager->getWebsite()->getId()
            )->addFilter(
                StationaryShopInterface::ACTIVE,
                StationaryShopInterface::STATIONARY_SHOP_ACTIVE
            );

            $searchResult = $this->stationaryShopRepository->getList($this->searchCriteriaBuilder->create());

            return $searchResult->getItems();
        } catch (LocalizedException $e) {
            return [];
        }
    }
}
