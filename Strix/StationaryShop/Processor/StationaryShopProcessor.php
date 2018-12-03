<?php

namespace Strix\StationaryShop\Processor;

use Strix\StationaryShop\Exception\PlaceNearbySearchException;
use Strix\StationaryShop\Exception\StationaryShopValidatorException;
use Strix\StationaryShop\Model\Api\Data\StationaryShopAddressInterface;
use Strix\StationaryShop\Model\Api\Data\StationaryShopInterface;
use Strix\StationaryShop\Model\Api\Data\StationaryShopInterfaceFactory;
use Strix\StationaryShop\Model\ResourceModel\StationaryShopResourceModel;
use Strix\StationaryShop\Model\StationaryShop\Command\Dispatcher\StationaryShopPersistCommandDispatcherInterface;
use Strix\StationaryShop\Model\StationaryShop\Command\StationaryShopPersistCommand;
use Strix\StationaryShop\Model\StationaryShop\Repository\StationaryShopRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

class StationaryShopProcessor implements StationaryShopPersistProcessorInterface
{
    const GENERATE_PLACE_ID_FIELD = 'generate_place_id';

    /**
     * @var StationaryShopRepositoryInterface
     */
    private $stationaryShopRepository;

    /**
     * @var StationaryShopPersistCommandDispatcherInterface
     */
    private $stationaryShopPersistCommandDispatcher;

    /**
     * @var StationaryShopInterfaceFactory
     */
    private $stationaryShopFactory;

    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param StationaryShopRepositoryInterface $stationaryShopRepository
     * @param StationaryShopPersistCommandDispatcherInterface $stationaryShopPersistCommandDispatcher
     * @param StationaryShopInterfaceFactory $stationaryShopFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        StationaryShopRepositoryInterface $stationaryShopRepository,
        StationaryShopPersistCommandDispatcherInterface $stationaryShopPersistCommandDispatcher,
        StationaryShopInterfaceFactory $stationaryShopFactory,
        DataObjectHelper $dataObjectHelper,
        StoreManagerInterface $storeManager
    ) {
        $this->stationaryShopRepository = $stationaryShopRepository;
        $this->stationaryShopPersistCommandDispatcher = $stationaryShopPersistCommandDispatcher;
        $this->stationaryShopFactory = $stationaryShopFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     *
     * @throws StationaryShopValidatorException
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     * @throws PlaceNearbySearchException
     */
    public function process(array $data = [], int $shopId = null): int
    {
        unset($shopId);
        $stationaryShopId = isset($data['general'][StationaryShopResourceModel::ID_FIELD]) ?
            (int)$data['general'][StationaryShopResourceModel::ID_FIELD] : null;

        $data['general'][StationaryShopInterface::WEBSITE_ID] = $this->storeManager->getStore($data['general']['store_id'])->getWebsiteId();
        $data['general'][StationaryShopInterface::CREATED_AT] = new \DateTime();
        $data['general'][StationaryShopInterface::UPDATED_AT] = new \DateTime();

        $stationaryShop = $this->getStationaryShop($stationaryShopId);
        $this->dataObjectHelper->populateWithArray($stationaryShop, $data['general'], StationaryShopInterface::class);

        $command = new StationaryShopPersistCommand($stationaryShop);
        $this->stationaryShopPersistCommandDispatcher->dispatch($command);

        return (int)$stationaryShop->getId();
    }

    /**
     * @param int|null $stationaryShopId
     *
     * @return StationaryShopInterface
     */
    private function getStationaryShop(int $stationaryShopId = null): StationaryShopInterface
    {
        if ($stationaryShopId === null) {
            return $this->stationaryShopFactory->create();
        }

        return $this->stationaryShopRepository->get($stationaryShopId);
    }
}
