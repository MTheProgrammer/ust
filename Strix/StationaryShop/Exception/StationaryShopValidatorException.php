<?php
namespace Strix\StationaryShop\Exception;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Phrase;

class StationaryShopValidatorException extends LocalizedException
{
    /**
     * @var array
     */
    private $validationResult;

    /**
     * @param Phrase $phrase
     * @param \Exception $cause
     * @param int $code
     * @param array $validationResult
     */
    public function __construct(Phrase $phrase, \Exception $cause = null, $code = 0, array $validationResult = [])
    {
        parent::__construct($phrase, $cause, $code);
        $this->validationResult = $validationResult;
    }

    /**
     * @inheritdoc
     */
    public function getErrors()
    {
        return $this->validationResult;
    }
}
