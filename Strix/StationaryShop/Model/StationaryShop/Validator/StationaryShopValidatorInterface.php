<?php
namespace Strix\StationaryShop\Model\StationaryShop\Validator;

use Strix\StationaryShop\Model\Api\Data\StationaryShopInterface;

/**
 * Interface StationaryShopValidatorInterface
 */
interface StationaryShopValidatorInterface
{
    /**
     * @param StationaryShopInterface $stationaryShop
     *
     * @return array
     */
    public function isSatisfiedBy(StationaryShopInterface $stationaryShop): array;
}
