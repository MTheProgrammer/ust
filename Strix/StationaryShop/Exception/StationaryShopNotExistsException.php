<?php

namespace Strix\StationaryShop\Exception;

use Throwable;

class StationaryShopNotExistsException extends \Exception
{
    const MESSAGE = 'No Stationary shop exists with code %s.';

    /**
     * @param string         $shopCode
     * @param Throwable|null $previous
     */
    public function __construct(string $shopCode, Throwable $previous = null)
    {
        $message = sprintf(self::MESSAGE, $shopCode);
        parent::__construct($message, 0, $previous);
    }
}
