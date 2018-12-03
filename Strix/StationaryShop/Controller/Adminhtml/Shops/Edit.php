<?php

namespace Strix\StationaryShop\Controller\Adminhtml\Shops;

use Strix\StationaryShop\Model\Api\Data\StationaryShopInterface;
use Strix\StationaryShop\Model\ResourceModel\StationaryShopResourceModel;
use Strix\StationaryShop\Model\StationaryShop\Repository\StationaryShopRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Strix_StationaryShop::shops_manager_shops_edit';

    /**
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * @var StationaryShopRepositoryInterface
     */
    private $stationaryShopRepository;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param StationaryShopRepositoryInterface $stationaryShopRepository
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        StationaryShopRepositoryInterface $stationaryShopRepository
    ) {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
        $this->stationaryShopRepository = $stationaryShopRepository;
    }

    /**
     * (@inheritdoc}
     */
    public function execute()
    {
        try {
            $stationaryShopId = (int)$this->getRequest()->getParam(StationaryShopResourceModel::ID_FIELD);
            $stationaryShop = $this->stationaryShopRepository->get($stationaryShopId);

            if (!$this->isStationaryShopAllowedByUserWebsite($stationaryShop)) {
                return $this->processRedirect(__('Stationary Shop can not be modify by user privileges.'));
            }

            $editStationaryShopPage = $this->pageFactory->create();
            $editStationaryShopPage->setActiveMenu('Strix_StationaryShop::shops');
            $editStationaryShopPage->getConfig()->getTitle()->prepend(
                __('Edit Stationary Shop %1 (id: %2)', $stationaryShop->getName(), $stationaryShopId)
            );

            return $editStationaryShopPage;
        } catch (NoSuchEntityException $e) {
            return $this->processRedirect($e->getMessage());
        }
    }

    /**
     * @param string $message
     *
     * @return Redirect
     */
    private function processRedirect(string $message): Redirect
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/index');
        $this->messageManager->addErrorMessage($message);

        return $resultRedirect;
    }

    /**
     * @param StationaryShopInterface $stationaryShop
     *
     * @return bool
     */
    private function isStationaryShopAllowedByUserWebsite(StationaryShopInterface $stationaryShop): bool
    {
        // FIXME: websiteid
        $websiteIds = [0];
        return in_array($stationaryShop->getWebsiteId(), $websiteIds);
    }
}
