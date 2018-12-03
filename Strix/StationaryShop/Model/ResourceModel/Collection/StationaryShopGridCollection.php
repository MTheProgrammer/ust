<?php

namespace Strix\StationaryShop\Model\ResourceModel\Collection;

use Strix\StationaryShop\Model\Api\Data\StationaryShopInterface;
use Strix\StationaryShop\Model\ResourceModel\StationaryShopResourceModel;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;
use Psr\Log\LoggerInterface;

class StationaryShopGridCollection extends SearchResult
{
    /**
     * {@inheritdoc}
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager
    ) {
        $mainTable = StationaryShopResourceModel::TABLE_NAME;
        $resourceModel = StationaryShopResourceModel::class;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel);
    }

    /**
     * {@inheritdoc}
     */
    protected function _renderFiltersBefore()
    {
        $websiteIds = [0];
        $this->getSelect()->where(
            StationaryShopInterface::WEBSITE_ID . ' IN ("' . implode('","', $websiteIds) . '")'
        );

        parent::_renderFiltersBefore();
    }
}
