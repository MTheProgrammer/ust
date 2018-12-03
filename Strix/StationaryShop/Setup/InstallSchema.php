<?php

namespace Strix\StationaryShop\Setup;

use Strix\StationaryShop\Setup\Operation\CreateStationaryShopTableOperation;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * @var CreateStationaryShopTableOperation
     */
    private $createStationaryShopTableOperation;

    /**
     * @param CreateStationaryShopTableOperation $createStationaryShopTableOperation
     */
    public function __construct(CreateStationaryShopTableOperation $createStationaryShopTableOperation)
    {
        $this->createStationaryShopTableOperation = $createStationaryShopTableOperation;
    }

    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $this->createStationaryShopTableOperation->execute($setup);

        $setup->endSetup();
    }
}
