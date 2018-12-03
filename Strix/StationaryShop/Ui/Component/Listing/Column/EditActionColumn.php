<?php
namespace Strix\StationaryShop\Ui\Component\Listing\Column;

use Strix\StationaryShop\Model\Api\Data\StationaryShopInterface;
use Strix\StationaryShop\Model\ResourceModel\StationaryShopResourceModel;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class EditActionColumn extends Column
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as &$item) {
            if (isset($item[StationaryShopResourceModel::ID_FIELD])) {
                $viewUrlPath = $this->getData('config/viewUrlPath') ?: '#';
                $urlEntityParamName = $this->getData('config/urlEntityParamName') ?: StationaryShopResourceModel::ID_FIELD;
                $item[$this->getData(StationaryShopInterface::NAME)] = [
                    'view' => [
                        'href' => $this->urlBuilder->getUrl(
                            $viewUrlPath,
                            [
                                $urlEntityParamName => $item[StationaryShopResourceModel::ID_FIELD]
                            ]
                        ),
                        'label' => __('Edit')
                    ]
                ];
            }
        }

        return $dataSource;
    }
}
