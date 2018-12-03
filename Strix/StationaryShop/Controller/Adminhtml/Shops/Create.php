<?php

namespace Strix\StationaryShop\Controller\Adminhtml\Shops;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Create extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Strix_StationaryShop::shops_manager_shops_create';

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
        $createStationaryShopPage = $this->pageFactory->create();

        $createStationaryShopPage->setActiveMenu('Strix_StationaryShop::shops');
        $createStationaryShopPage->getConfig()->getTitle()->prepend(__('New Stationary Shop'));

        return $createStationaryShopPage;
    }
}
