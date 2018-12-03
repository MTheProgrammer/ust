<?php
namespace Strix\StationaryShop\Domain\Factory;

use Strix\StationaryShop\Domain\StationaryShop;
use Strix\StationaryShop\Model\Api\Data\StationaryShopInterface;

interface StationaryShopFactoryInterface
{
    /**
     * @param StationaryShopInterface $stationaryShop
     *
     * @return StationaryShop
     */
    public function create(
        StationaryShopInterface $stationaryShop
    ): StationaryShop;
}
