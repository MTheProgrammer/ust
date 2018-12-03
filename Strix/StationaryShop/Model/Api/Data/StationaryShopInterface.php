<?php
declare(strict_types=1);

namespace Strix\StationaryShop\Model\Api\Data;

interface StationaryShopInterface
{
    public const WEBSITE_ID = 'website_id';
    public const CODE = 'code';
    public const NAME = 'name';
    public const ACTIVE = 'active';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    public const STATIONARY_SHOP_ACTIVE = 1;

    /**
     * @return int
     */
    public function getWebsiteId(): int;

    /**
     * @param int $websiteId
     * @return void
     */
    public function setWebsiteId(int $websiteId): void;

    /**
     * @return string
     */
    public function getCode(): string;

    /**
     * @param string $code
     *
     * @return void
     */
    public function setCode(string $code): void;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     *
     * @return void
     */
    public function setName(string $name): void;

    /**
     * @return bool
     */
    public function isActive(): bool;

    /**
     * @param bool $active
     *
     * @return void
     */
    public function setActive(bool $active): void;

}
