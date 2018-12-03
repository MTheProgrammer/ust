<?php

namespace Strix\StationaryShop\Block;

use Strix\StationaryShop\Domain\Provider\StationaryShopProvider;
use Strix\StationaryShop\Model\Api\Data\StationaryShopInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class View extends Template
{
    const DEFAULT_STATIONARY_SHOP_DATA = [
        'code' => '',
        'name' => 'StationaryShop',
        'url' => '',
        'addressLine1' => '',
        'addressLine2' => '',
        'postcode' => '',
        'city' => '',
        'latitude' => '0',
        'longitude' => '0',
    ];

    const DEFAULT_CONTACTS = [];
    const DEFAULT_OPENING_HOURS = [];

     /**
     * @var array
     */
    private $stationaryShopData = [];

    /**
     * @var bool
     */
    private $coordinatesUpToDate = false;

    /**
     * @var StationaryShopProvider
     */
    private $stationaryShopProvider;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @param Context $context
     * @param StationaryShopProvider $stationaryShopProvider
     * @param RequestInterface $request
     */
    public function __construct(
        Context $context,
        StationaryShopProvider $stationaryShopProvider,
        RequestInterface $request
    ) {
        parent::__construct($context);
        $this->stationaryShopProvider = $stationaryShopProvider;
        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    protected function _prepareLayout()
    {
        $shop = $this->getStationaryShopData();
        if (array_key_exists(StationaryShopInterface::NAME, $shop)) {
            $this->pageConfig->getTitle()->set($this->escapeHtml($shop[StationaryShopInterface::NAME]));
        }

        return parent::_prepareLayout();
    }

    /**
     * @return array
     */
    public function getStationaryShopData(): array
    {
        if (!empty($this->stationaryShopData)) {
            return $this->stationaryShopData;
        }

        $stationaryShopData = [];
        $shopId = $this->request->getParam('shop_id');
        if ($shopId !== null) {
            $stationaryShopData = current($this->stationaryShopProvider->execute([$shopId]));
        }

        $this->coordinatesUpToDate = true;

        if ($stationaryShopData) {
            $this->stationaryShopData = $stationaryShopData;
            return $stationaryShopData;
        }

        return static::DEFAULT_STATIONARY_SHOP_DATA;
    }
}
