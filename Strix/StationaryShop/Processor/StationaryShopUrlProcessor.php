<?php
namespace Strix\StationaryShop\Processor;

use Strix\StationaryShop\Model\StationaryShop\StationaryShopUrlResolverInterface;
use Magento\Store\Model\Store;
use Magento\UrlRewrite\Model\Exception\UrlAlreadyExistsException;
use Magento\UrlRewrite\Model\UrlFinderInterface;
use Magento\UrlRewrite\Model\UrlPersistInterface;
use Magento\UrlRewrite\Service\V1\Data\UrlRewrite;
use Magento\UrlRewrite\Service\V1\Data\UrlRewriteFactory;

class StationaryShopUrlProcessor implements StationaryShopPersistProcessorInterface
{
    /**
     * @var UrlFinderInterface
     */
    private $urlFinder;

    /**
     * @var StationaryShopUrlResolverInterface
     */
    private $stationaryShopUrlResolver;

    /**
     * @var UrlPersistInterface
     */
    private $urlPersist;

    /**
     * @var UrlRewriteFactory
     */
    private $urlRewriteFactory;

    /**
     * @param UrlFinderInterface $urlFinder
     * @param UrlPersistInterface $urlPersist
     * @param UrlRewriteFactory $urlRewriteFactory
     * @param StationaryShopUrlResolverInterface $stationaryShopUrlResolver
     */
    public function __construct(
        UrlFinderInterface $urlFinder,
        UrlPersistInterface $urlPersist,
        UrlRewriteFactory $urlRewriteFactory,
        StationaryShopUrlResolverInterface $stationaryShopUrlResolver
    ) {
        $this->urlFinder = $urlFinder;
        $this->stationaryShopUrlResolver = $stationaryShopUrlResolver;
        $this->urlPersist = $urlPersist;
        $this->urlRewriteFactory = $urlRewriteFactory;
    }

    /**
     * {@inheritdoc}
     *
     * @throws UrlAlreadyExistsException
     */
    public function process(array $data = [], int $shopId = null): int
    {
        $targetPath = $this->stationaryShopUrlResolver->getTargetPath($shopId);
        $url = $this->getStationaryShopUrl($shopId, (int)$data['general']['store_id']);
        $url->setEntityType(StationaryShopUrlResolverInterface::ENTITY_TYPE);
        $url->setEntityId($shopId);
        $url->setRequestPath($data['general']['url']);
        $url->setTargetPath($targetPath);
        $url->setStoreId($data['general']['store_id']);
        $url->setIsAutogenerated(0);

        $this->urlPersist->replace([$url]);

        return $shopId;
    }

    /**
     * @param int $shopId
     * @param int $storeId
     *
     * @return UrlRewrite
     */
    private function getStationaryShopUrl(int $shopId, int $storeId = Store::DEFAULT_STORE_ID): UrlRewrite
    {
        $url = $this->stationaryShopUrlResolver->getUrl($shopId, $storeId);

        if ($url === null) {
            $url = $this->urlRewriteFactory->create();
        }

        return $url;
    }
}