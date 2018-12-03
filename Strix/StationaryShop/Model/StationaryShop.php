<?php

namespace Strix\StationaryShop\Model;

use Strix\StationaryShop\Model\Api\Data\StationaryShopInterface;
use Strix\StationaryShop\Model\ResourceModel\StationaryShopResourceModel;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class StationaryShop extends AbstractModel implements IdentityInterface, StationaryShopInterface
{
    const CACHE_TAG = 'strix_stationary_shop';
    const EVENT_PREFIX = 'strix_stationary_shop';

    /**
     * @var string
     */
    protected $_eventPrefix = self::EVENT_PREFIX;

    public function getBar(): int
    {
        // TODO: Implement getBar() method.
    }

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(StationaryShopResourceModel::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getEventPrefix()
    {
        return self::EVENT_PREFIX;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentities()
    {
        return [sprintf('%s_%s', self::CACHE_TAG, $this->getId())];
    }

    /**
     * {@inheritdoc}
     */
    public function getCode(): string
    {
        return $this->getData(static::CODE);
    }

    /**
     * {@inheritdoc}
     */
    public function setCode(string $code)
    {
        $this->setData(static::CODE, $code);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->getData(static::NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function setName(string $name)
    {
        $this->setData(static::NAME, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function isActive(): bool
    {
        return (bool)$this->getData(static::ACTIVE);
    }

    /**
     * {@inheritdoc}
     */
    public function setActive(bool $active)
    {
        $this->setData(static::ACTIVE, $active);
    }

    /**
     * {@inheritdoc}
     */
    public function getPlaceId()
    {
        return $this->getData(static::PLACE_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setPlaceId(string $placeId)
    {
        $this->setData(static::PLACE_ID, $placeId);
    }

    /**
     * @return int
     */
    public function getWebsiteId(): int
    {
        return $this->getData(static::WEBSITE_ID);
    }

    /**
     * @param int $websiteId
     *
     * @return void
     */
    public function setWebsiteId(int $websiteId)
    {
        $this->setData(static::WEBSITE_ID, $websiteId);
    }
}
