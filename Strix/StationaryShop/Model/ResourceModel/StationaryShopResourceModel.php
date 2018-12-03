<?php

namespace Strix\StationaryShop\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class StationaryShopResourceModel extends AbstractDb
{
    const TABLE_NAME = 'strix_stationary_shop';
    const ID_FIELD = 'id';

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, self::ID_FIELD);
    }
}
