<?php
namespace Strix\StationaryShop\Setup\Operation;

use Magento\Framework\Setup\SchemaSetupInterface;

interface OperationInterface
{
    /**
     * @param SchemaSetupInterface $setup
     *
     * @return void
     * @throws \Zend_Db_Exception
     */
    public function execute(SchemaSetupInterface $setup);
}
