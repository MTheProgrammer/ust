<?php
namespace Strix\StationaryShop\Domain\Provider;

interface StationaryShopProviderInterface
{
    /**
     * @param array $stationaryShopIds
     *
     * @return array
     */
    public function execute(array $stationaryShopIds = []): array;
}
