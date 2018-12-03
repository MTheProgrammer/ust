<?php
namespace Strix\StationaryShop\Model\StationaryShop\Repository;

use Strix\StationaryShop\Model\Api\Data\StationaryShopInterface;
use Strix\StationaryShop\Model\ResourceModel\Collection\StationaryShopCollectionFactory;
use Strix\StationaryShop\Model\ResourceModel\StationaryShopResourceModel;
use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;

class StationaryShopRepository implements StationaryShopRepositoryInterface
{
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var StationaryShopCollectionFactory
     */
    private $stationaryShopCollectionFactory;

    /**
     * @var SearchResultsInterfaceFactory
     */
    private $searchResultsInterfaceFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @param CollectionProcessorInterface $collectionProcessor
     * @param StationaryShopCollectionFactory $stationaryShopCollectionFactory
     * @param SearchResultsInterfaceFactory $searchResultsInterfaceFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        CollectionProcessorInterface $collectionProcessor,
        StationaryShopCollectionFactory $stationaryShopCollectionFactory,
        SearchResultsInterfaceFactory $searchResultsInterfaceFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->collectionProcessor = $collectionProcessor;
        $this->stationaryShopCollectionFactory = $stationaryShopCollectionFactory;
        $this->searchResultsInterfaceFactory = $searchResultsInterfaceFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function get(int $stationaryShopId, int $websiteId = null)
    {
        $searchCriteria = $this->searchCriteriaBuilder->addFilter(
            StationaryShopResourceModel::ID_FIELD,
            $stationaryShopId
        );

        if ($websiteId !== null) {
            $searchCriteria->addFilter(StationaryShopInterface::WEBSITE_ID, $websiteId);
        }

        $searchResult = $this->getList($searchCriteria->create());
        $items = $searchResult->getItems();

        if (count($items) === 0) {
            return null;
        }

        return current($items);
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteria $searchCriteria = null): SearchResultsInterface
    {
        $collection = $this->stationaryShopCollectionFactory->create();
        if ($searchCriteria === null) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
        } else {
            $this->collectionProcessor->process($searchCriteria, $collection);
        }

        $searchResult = $this->searchResultsInterfaceFactory->create();
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);

        return $searchResult;
    }
}
