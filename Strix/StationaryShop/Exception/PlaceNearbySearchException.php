<?php

namespace Strix\StationaryShop\Exception;

class PlaceNearbySearchException extends \Exception
{
    const MESSAGE = 'Error occurred during place nearby search.';

    /**
     * @param string $message
     * @param \Throwable|null $previous
     */
    public function __construct(string $message = self::MESSAGE, \Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
