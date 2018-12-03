<?php

namespace Strix\StationaryShop\Model\ResourceModel\Collection;

use Strix\StationaryShop\Model\ResourceModel\StationaryShopResourceModel;
use Strix\StationaryShop\Model\StationaryShop;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class StationaryShopCollection extends AbstractCollection
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(StationaryShop::class, StationaryShopResourceModel::class);
    }
}
