<?php
namespace Strix\StationaryShop\Model\StationaryShop\Command\Dispatcher;

use Strix\StationaryShop\Exception\StationaryShopValidatorException;
use Strix\StationaryShop\Model\StationaryShop\Command\StationaryShopPersistCommandInterface;
use Magento\Framework\Exception\CouldNotSaveException;

interface StationaryShopPersistCommandDispatcherInterface
{
    /**
     * @param StationaryShopPersistCommandInterface $command
     *
     * @return void
     *
     * @throws StationaryShopValidatorException
     * @throws CouldNotSaveException
     */
    public function dispatch(StationaryShopPersistCommandInterface $command);
}
