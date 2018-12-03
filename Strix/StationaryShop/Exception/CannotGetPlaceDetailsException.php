<?php

namespace Strix\StationaryShop\Exception;

class CannotGetPlaceDetailsException extends \Exception
{
    const MESSAGE = 'Error occurred while getting place details.';

    /**
     * @param string $message
     * @param \Throwable|null $previous
     */
    public function __construct(string $message = self::MESSAGE, \Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
