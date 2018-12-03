<?php
namespace Strix\StationaryShop\Router;

use Strix\StationaryShop\Model\StationaryShop\Repository\StationaryShopRepositoryInterface;
use Strix\StationaryShop\Model\StationaryShop\StationaryShopUrlResolverInterface;
use Magento\Framework\App\Action\Forward;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Url;

class StationaryShopRouter implements RouterInterface
{
    /**
     * @var StationaryShopRepositoryInterface
     */
    private $stationaryShopRepository;

    /**
     * @var ActionFactory
     */
    private $actionFactory;

    /**
     * @param StationaryShopRepositoryInterface $stationaryShopRepository
     * @param ActionFactory $actionFactory
     */
    public function __construct(
        StationaryShopRepositoryInterface $stationaryShopRepository,
        ActionFactory $actionFactory
    ) {
        $this->stationaryShopRepository = $stationaryShopRepository;
        $this->actionFactory = $actionFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function match(RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');
        $stationaryShopId = (int)trim($identifier, StationaryShopUrlResolverInterface::TARGET_PATH_PREFIX);
        if (strpos($identifier, StationaryShopUrlResolverInterface::TARGET_PATH_PREFIX) !== false
            && $request->getModuleName() === null
        ) {
            if (!$this->isShopExists($stationaryShopId)) {
                return null;
            }

            $request->setModuleName('stationaryshops')
                ->setControllerName('page')
                ->setActionName('view')
                ->setParam(
                    StationaryShopUrlResolverInterface::STATIONARY_SHOP_URL_PARAMETER,
                    $stationaryShopId
                );
            $request->setAlias(Url::REWRITE_REQUEST_PATH_ALIAS, $stationaryShopId);
        } else {
            return null;
        }

        return $this->actionFactory->create(Forward::class);
    }

    /**
     * @param int $stationaryShopId
     *
     * @return bool
     */
    private function isShopExists(int $stationaryShopId): bool
    {
        return $this->stationaryShopRepository->get($stationaryShopId) !== null;
    }
}
