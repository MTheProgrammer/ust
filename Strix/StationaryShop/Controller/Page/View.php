<?php
namespace Strix\StationaryShop\Controller\Page;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\View\Result\PageFactory;

class View extends Action
{
    private $pageFactory;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(Context $context, PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;

        return parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $shopId = $this->getRequest()->getParam('shop_id');
        if ($shopId === null) {
            throw new NotFoundException(__('Parameter is incorrect'));
        }

        return $this->pageFactory->create();
    }
}
