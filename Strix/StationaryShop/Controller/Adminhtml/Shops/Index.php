<?php

namespace Strix\StationaryShop\Controller\Adminhtml\Shops;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Strix_StationaryShop::shops_manager_shops';

    /**
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(Context $context, PageFactory $pageFactory)
    {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
    }

    /**
     * (@inheritdoc}
     */
    public function execute()
    {
        $stationaryShopPage = $this->pageFactory->create();

        $stationaryShopPage->setActiveMenu('Strix_StationaryShop::shops');
        $stationaryShopPage->getConfig()->getTitle()->prepend(__('Manage Stationary Shops'));

        return $stationaryShopPage;
    }
}
