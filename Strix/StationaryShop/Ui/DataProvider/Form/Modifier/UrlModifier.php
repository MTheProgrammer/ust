<?php
namespace Strix\StationaryShop\Ui\DataProvider\Form\Modifier;

use Strix\StationaryShop\Model\StationaryShop\StationaryShopUrlResolverInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Store\Model\Store;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Magento\UrlRewrite\Model\UrlFinderInterface;

class UrlModifier implements ModifierInterface
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var UrlFinderInterface
     */
    private $urlFinder;

    /**
     * @var StationaryShopUrlResolverInterface
     */
    private $stationaryShopUrlResolver;

    /**
     * @param RequestInterface $request
     * @param UrlFinderInterface $urlFinder
     * @param StationaryShopUrlResolverInterface $stationaryShopUrlResolver
     */
    public function __construct(
        RequestInterface $request,
        UrlFinderInterface $urlFinder,
        StationaryShopUrlResolverInterface $stationaryShopUrlResolver
    ) {
        $this->request = $request;
        $this->urlFinder = $urlFinder;
        $this->stationaryShopUrlResolver = $stationaryShopUrlResolver;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data): array
    {
        if ($data['request_id'] === 0) {
            return $data;
        }
        $url = $this->stationaryShopUrlResolver->getUrl(
            $data['request_id'],
            $this->request->getParam('store', Store::DEFAULT_STORE_ID)
        );

        if ($url !== null) {
            $data[$data['request_id']]['general']['url'] = $url->getRequestPath();
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyMeta(array $meta): array
    {
        return $meta;
    }
}
