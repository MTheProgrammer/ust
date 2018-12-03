<?php
namespace Strix\StationaryShop\Model\StationaryShop\Command;

use Strix\StationaryShop\Model\Api\Data\StationaryShopInterface;

class StationaryShopPersistCommand implements StationaryShopPersistCommandInterface
{
    /**
     * @var StationaryShopInterface
     */
    private $stationaryShop;

    /**
     * @param StationaryShopInterface $stationaryShop
     */
    public function __construct(StationaryShopInterface $stationaryShop)
    {
        $this->stationaryShop = $stationaryShop;
    }

    /**
     * {@inheritdoc}
     */
    public function getStationaryShop(): StationaryShopInterface
    {
        return $this->stationaryShop;
    }
}
