<?php
namespace Strix\StationaryShop\Model\StationaryShop\Validator;

use Strix\StationaryShop\Model\Api\Data\StationaryShopInterface;

class StationaryShopAndValidator implements StationaryShopValidatorInterface
{
    /**
     * @var StationaryShopValidatorInterface[]
     */
    private $validators;

    /**
     * @param StationaryShopValidatorInterface[] $validators
     */
    public function __construct(array $validators = [])
    {
        $this->validators = $validators;
    }

    /**
     * {@inheritdoc}
     */
    public function isSatisfiedBy(StationaryShopInterface $stationaryShop): array
    {
        $result = [];
        foreach ($this->validators as $validator) {
            $validatorResult = $validator->isSatisfiedBy($stationaryShop);
            if ($validatorResult) {
                $result[] = current($validatorResult);
            }
        }

        return $result;
    }
}
