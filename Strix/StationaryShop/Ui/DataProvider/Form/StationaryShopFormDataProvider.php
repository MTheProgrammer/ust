<?php
namespace Strix\StationaryShop\Ui\DataProvider\Form;

use Strix\StationaryShop\Model\ResourceModel\Collection\StationaryShopCollectionFactory;
use Magento\Framework\Api\Filter;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;

class StationaryShopFormDataProvider extends AbstractDataProvider
{
    /**
     * @var PoolInterface
     */
    private $pool;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param StationaryShopCollectionFactory $stationaryShopCollectionFactory
     * @param PoolInterface $pool
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        StationaryShopCollectionFactory $stationaryShopCollectionFactory,
        PoolInterface $pool,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $stationaryShopCollectionFactory->create();
        $this->pool = $pool;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $this->getCollectionData();
        /** @var ModifierInterface $modifier */
        foreach ($this->pool->getModifiersInstances() as $modifier) {
            $this->data = $modifier->modifyData($this->data);
        }

        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function getMeta()
    {
        $meta = parent::getMeta();

        /** @var ModifierInterface $modifier */
        foreach ($this->pool->getModifiersInstances() as $modifier) {
            $meta = $modifier->modifyMeta($meta);
        }

        return $meta;
    }

    /**
     * {@inheritdoc}
     */
    public function addFilter(Filter $filter)
    {
        $this->data['request_id'] = (int)$filter->getValue();
        parent::addFilter($filter);
    }

    /**
     * @return void
     */
    private function getCollectionData()
    {
        foreach ($this->collection->getItems() as $item) {
            $this->data[$this->data['request_id']]['general'] = $item->getData();
        }
    }
}
