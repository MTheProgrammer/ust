<?php

namespace Strix\StationaryShop\Exception;

class StationaryShopAdvantageImageValidatorException extends \Exception
{
    const MESSAGE = 'Error occurred while saving Stationary Shop Advantage image.';

    /**
     * @param string $message
     * @param \Throwable|null $previous
     */
    public function __construct(string $message = self::MESSAGE, \Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
