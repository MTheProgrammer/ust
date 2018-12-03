<?php
namespace Strix\StationaryShop\Ui\DataProvider\Form\Modifier;

use Magento\Framework\App\RequestInterface;
use Magento\Store\Model\Store;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;

class StoreIdModifier implements ModifierInterface
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data): array
    {
        $storeId = $this->request->getParam('store', Store::DEFAULT_STORE_ID);
        if ($data['request_id'] === 0) {
            $data['']['general']['store_id'] = $storeId;

            return $data;
        }

        $data[$data['request_id']]['general']['store_id'] = $storeId;

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyMeta(array $meta): array
    {
        return $meta;
    }
}
