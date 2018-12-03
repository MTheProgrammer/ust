<?php
namespace Strix\StationaryShop\Domain\Provider;

use Strix\StationaryShop\Domain\Factory\StationaryShopFactoryInterface;
use Strix\StationaryShop\Domain\Repository\StationaryShopRepository;
use Strix\StationaryShop\Domain\StationaryShop;
use Strix\StationaryShop\Model\Api\Data\StationaryShopInterface;
use Magento\Framework\Locale\ResolverInterface;

class StationaryShopProvider implements StationaryShopProviderInterface
{
    /**
     * @var StationaryShopFactoryInterface
     */
    private $stationaryShopDomainFactory;

    /**
     * @var StationaryShopRepository
     */
    private $stationaryShopRepository;

    /**
     * @var \CollatorFactory
     */
    private $collatorFactory;

    /**
     * @var ResolverInterface
     */
    private $localeResolver;

    /**
     * @param StationaryShopFactoryInterface $stationaryShopDomainFactory
     * @param StationaryShopRepository $stationaryShopRepository
     * @param \CollatorFactory $collatorFactory
     * @param ResolverInterface $localeResolver
     */
    public function __construct(
        StationaryShopFactoryInterface $stationaryShopDomainFactory,
        StationaryShopRepository $stationaryShopRepository,
        \CollatorFactory $collatorFactory,
        ResolverInterface $localeResolver
    ) {
        $this->stationaryShopDomainFactory = $stationaryShopDomainFactory;
        $this->stationaryShopRepository = $stationaryShopRepository;
        $this->collatorFactory = $collatorFactory;
        $this->localeResolver = $localeResolver;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(array $stationaryShopIds = []): array
    {
        $stationaryShops = $this->stationaryShopRepository->getStationaryShops($stationaryShopIds);
        if (empty($stationaryShops)) {
            return [];
        }

        $result = array_map(
            function (StationaryShopInterface $stationaryShop) {
                return $this->stationaryShopDomainFactory->create(
                    $stationaryShop
                );
            },
            $stationaryShops
        );

        $collator = $this->collatorFactory->create(['arg1' => $this->localeResolver->getLocale()]);
        usort(
            $result,
            function ($a, $b) use ($collator) {
                return $collator->compare($a->getName(), $b->getName());
            }
        );

        return array_map(
            function (StationaryShop $stationaryShop) {
                return [
                    StationaryShopInterface::CODE => $stationaryShop->getCode(),
                    StationaryShopInterface::NAME => $stationaryShop->getName(),
                    'url' => $stationaryShop->getUrl(),
                ];
            },
            array_values($result)
        );
    }
}
