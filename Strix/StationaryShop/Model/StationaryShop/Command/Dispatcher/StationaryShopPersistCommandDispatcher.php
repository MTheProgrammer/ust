<?php
namespace Strix\StationaryShop\Model\StationaryShop\Command\Dispatcher;

use Strix\StationaryShop\Exception\StationaryShopValidatorException;
use Strix\StationaryShop\Model\ResourceModel\StationaryShopResourceModel;
use Strix\StationaryShop\Model\StationaryShop\Command\StationaryShopPersistCommandInterface;
use Strix\StationaryShop\Model\StationaryShop\Validator\StationaryShopValidatorInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Psr\Log\LoggerInterface;

class StationaryShopPersistCommandDispatcher implements StationaryShopPersistCommandDispatcherInterface
{
    /**
     * @var StationaryShopValidatorInterface
     */
    private $stationaryShopValidator;

    /**
     * @var StationaryShopResourceModel
     */
    private $stationaryShopResourceModel;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param StationaryShopValidatorInterface $stationaryShopValidator
     * @param StationaryShopResourceModel $stationaryShopResourceModel
     * @param LoggerInterface $logger
     */
    public function __construct(
        StationaryShopValidatorInterface $stationaryShopValidator,
        StationaryShopResourceModel $stationaryShopResourceModel,
        LoggerInterface $logger
    ) {
        $this->stationaryShopValidator = $stationaryShopValidator;
        $this->stationaryShopResourceModel = $stationaryShopResourceModel;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(StationaryShopPersistCommandInterface $command)
    {
        $stationaryShop = $command->getStationaryShop();

        $result = $this->stationaryShopValidator->isSatisfiedBy($stationaryShop);

        if (!empty($result)) {
            throw new StationaryShopValidatorException(__('Validation Stationary Shop Error'), null, 0, $result);
        }

        try {
            $this->stationaryShopResourceModel->save($stationaryShop);
        } catch (\PDOException $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotSaveException(__('Could not save Stationary Shop'), $e);
        }
    }
}
