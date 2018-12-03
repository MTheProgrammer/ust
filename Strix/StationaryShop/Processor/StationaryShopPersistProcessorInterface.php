<?php
namespace Strix\StationaryShop\Processor;

interface StationaryShopPersistProcessorInterface
{
    /**
     * @param array $data
     * @param int|null $shopId
     *
     * @return int
     */
    public function process(array $data = [], int $shopId = null): int;
}
