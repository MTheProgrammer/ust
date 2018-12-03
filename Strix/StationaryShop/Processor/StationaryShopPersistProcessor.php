<?php
namespace Strix\StationaryShop\Processor;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

class StationaryShopPersistProcessor implements StationaryShopPersistProcessorInterface
{
    /**
     * @var StationaryShopPersistProcessorInterface[]
     */
    private $processors;

    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param ResourceConnection $resourceConnection
     * @param LoggerInterface $logger
     * @param StationaryShopPersistProcessorInterface[] $processors
     */
    public function __construct(ResourceConnection $resourceConnection, LoggerInterface $logger, array $processors = [])
    {
        $this->processors = $processors;
        $this->resourceConnection = $resourceConnection;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     *
     * @throws LocalizedException
     * @throws \Zend_Db_Statement_Exception
     */
    public function process(array $data = [], int $shopId = null): int
    {
        $connection = $this->resourceConnection->getConnection();
        $connection->beginTransaction();
        try {
            foreach ($this->processors as $processor) {
                $shopId = $processor->process($data, $shopId);
            }
            $connection->commit();

            return $shopId;
        } catch (\Zend_Db_Statement_Exception $e) {
            $this->logger->error($e->getMessage());
            $connection->rollBack();
            throw $e;
        } catch (LocalizedException $e) {
            $connection->rollBack();
            throw $e;
        }
    }
}
