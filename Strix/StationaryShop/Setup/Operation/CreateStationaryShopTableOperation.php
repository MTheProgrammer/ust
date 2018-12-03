<?php
namespace Strix\StationaryShop\Setup\Operation;

use Strix\StationaryShop\Model\Api\Data\StationaryShopInterface;
use Strix\StationaryShop\Model\ResourceModel\StationaryShopResourceModel;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\SchemaSetupInterface;

class CreateStationaryShopTableOperation implements OperationInterface
{
    /**
     * {@inheritdoc}
     */
    public function execute(SchemaSetupInterface $setup)
    {
        if (!$setup->tableExists(StationaryShopResourceModel::TABLE_NAME)) {
            $stationaryShopTable = $this->createTable($setup);
            $setup->getConnection()->createTable($stationaryShopTable);
        }
    }

    /**
     * @param SchemaSetupInterface $setup
     *
     * @return Table
     * @throws \Zend_Db_Exception
     */
    private function createTable(SchemaSetupInterface $setup): Table
    {
        $stationaryShopTable = $setup->getTable(StationaryShopResourceModel::TABLE_NAME);

        return $setup->getConnection()->newTable($stationaryShopTable)->addColumn(
            StationaryShopResourceModel::ID_FIELD,
            Table::TYPE_INTEGER,
            null,
            [
                'identity' => true,
                'nullable' => false,
                'primary' => true,
                'unsigned' => true,
            ]
        )->addColumn(
            StationaryShopInterface::WEBSITE_ID,
            Table::TYPE_SMALLINT,
            5,
            [
                'nullable' => false,
                'unsigned' => true,
            ]
        )->addColumn(
            StationaryShopInterface::CODE,
            Table::TYPE_TEXT,
            3,
            [
                'nullable' => false,
            ]
        )->addColumn(
            StationaryShopInterface::NAME,
            Table::TYPE_TEXT,
            255,
            [
                'nullable' => false,
            ]
        )->addColumn(
            StationaryShopInterface::ACTIVE,
            Table::TYPE_BOOLEAN,
            null,
            [
                'nullable' => false,
            ]
        )->addColumn(
            StationaryShopInterface::CREATED_AT,
            Table::TYPE_DATETIME,
            null,
            [
                'nullable' => false,
            ]
        )->addColumn(
            StationaryShopInterface::UPDATED_AT,
            Table::TYPE_DATETIME,
            null,
            [
                'nullable' => false,
            ]
        )->addForeignKey(
            sprintf('%s_website_id_fk', StationaryShopResourceModel::TABLE_NAME),
            StationaryShopInterface::WEBSITE_ID,
            'store_website',
            'website_id'
        )->addIndex(
            'FULLTEXT_DATA_INDEX',
            [StationaryShopInterface::NAME],
            ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
        );
    }
}
