<?php
namespace Strix\StationaryShop\Domain;

class StationaryShop
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $url;

    /**
     * @param string $name
     * @param string $code
     * @param string $url
     */
    public function __construct(
        string $name,
        string $code,
        string $url
    ) {
        $this->name = $name;
        $this->code = $code;
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
}
