<?php

namespace Strix\StationaryShop\Exception\Gallery;

class ImageMediaUrlNotExistsException extends StationaryShopGalleryException
{
    const MESSAGE = 'Image media URL does not exist: %s.';

    /**
     * @param string $url
     * @param string $message
     * @param \Throwable|null $previous
     */
    public function __construct(string $url, string $message = self::MESSAGE, \Throwable $previous = null)
    {
        parent::__construct(sprintf($message, $url), 0, $previous);
    }
}
