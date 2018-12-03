<?php

namespace Strix\StationaryShop\Exception\Gallery;

class UnsupportedGalleryItemTypeException extends StationaryShopGalleryException
{
    const MESSAGE = 'Unsupported gallery type: %s.';

    /**
     * @param string $type
     * @param string $message
     * @param \Throwable|null $previous
     */
    public function __construct(string $type, string $message = self::MESSAGE, \Throwable $previous = null)
    {
        parent::__construct(sprintf($message, $type), 0, $previous);
    }
}
