<?php
namespace Strix\StationaryShop\Model\StationaryShop\Command;

use Strix\StationaryShop\Model\Api\Data\StationaryShopInterface;

interface StationaryShopPersistCommandInterface
{
    /**
     * @return StationaryShopInterface
     */
    public function getStationaryShop(): StationaryShopInterface;
}
