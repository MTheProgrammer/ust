<?php
namespace Strix\StationaryShop\Controller\Adminhtml\Shops;

use Strix\StationaryShop\Exception\PlaceNearbySearchException;
use Strix\StationaryShop\Model\ResourceModel\StationaryShopResourceModel;
use Strix\StationaryShop\Processor\StationaryShopPersistProcessorInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\Store;

class Save extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Strix_StationaryShop::shops_manager_shops_save';

    /**
     * @var StationaryShopPersistProcessorInterface
     */
    private $stationaryShopPersistProcessor;

    /**
     * @param Context $context
     * @param StationaryShopPersistProcessorInterface $stationaryShopPersistProcessor
     */
    public function __construct(
        Context $context,
        StationaryShopPersistProcessorInterface $stationaryShopPersistProcessor
    ) {
        parent::__construct($context);
        $this->stationaryShopPersistProcessor = $stationaryShopPersistProcessor;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(): ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $request = $this->getRequest();
        $data = $request->getParams();

        if (!$request->isPost() || empty($data['general'])) {
            $this->messageManager->addErrorMessage(__('Wrong request.'));
            $this->processRedirectAfterFailureSave($resultRedirect);

            return $resultRedirect;
        }

        try {
            $stationaryShopId = $this->stationaryShopPersistProcessor->process($data);
            $this->messageManager->addSuccessMessage(__('Stationary Shop has been saved.'));
            $this->processRedirectAfterSuccessSave($resultRedirect, $stationaryShopId, $data['general']['store_id']);
        } catch (LocalizedException $e) {
            $this->processException($e, $resultRedirect);
        } catch (\Zend_Db_Statement_Exception $e) {
            $this->processException($e, $resultRedirect);
        } catch (\InvalidArgumentException $e) {
            $this->processException($e, $resultRedirect, false);
        } catch (PlaceNearbySearchException $e) {
            $this->processException($e, $resultRedirect);
        }

        return $resultRedirect;
    }

    /**
     * @param Redirect $resultRedirect
     * @param int|null $stationaryShopId
     * @param int $storeId
     *
     * @return void
     */
    private function processRedirectAfterFailureSave(
        Redirect $resultRedirect,
        int $stationaryShopId = null,
        int $storeId = Store::DEFAULT_STORE_ID
    ) {
        if ($stationaryShopId === null) {
            $resultRedirect->setPath('*/*/create');
        } else {
            $resultRedirect->setPath(
                '*/*/edit',
                [
                    StationaryShopResourceModel::ID_FIELD => $stationaryShopId,
                    'store' => $storeId,
                    '_current' => true,
                ]
            );
        }
    }

    /**
     * @param Redirect $resultRedirect
     * @param int $stationaryShopId
     * @param int $storeId
     *
     * @return void
     */
    private function processRedirectAfterSuccessSave(
        Redirect $resultRedirect,
        int $stationaryShopId,
        int $storeId = Store::DEFAULT_STORE_ID
    ) {
        if ($this->getRequest()->getParam('back')) {
            $resultRedirect->setPath(
                '*/*/edit',
                [
                    StationaryShopResourceModel::ID_FIELD => $stationaryShopId,
                    'store' => $storeId,
                    '_current' => true,
                ]
            );
        } elseif ($this->getRequest()->getParam('redirect_to_new')) {
            $resultRedirect->setPath(
                '*/*/create',
                [
                    'store' => $storeId,
                    '_current' => true,
                ]
            );
        } else {
            $resultRedirect->setPath('*/*/');
        }
    }

    /**
     * @param \Exception $e
     * @param Redirect $resultRedirect
     * @param int $storeId
     * @param bool $exceptionMessage
     *
     * @return void
     */
    private function processException(
        \Exception $e,
        Redirect $resultRedirect,
        int $storeId = Store::DEFAULT_STORE_ID,
        $exceptionMessage = true
    ) {
        $this->messageManager->addErrorMessage(__('Could not save Stationary Shop.'));
        if ($exceptionMessage) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }

        $params = $this->getRequest()->getParams();
        if (isset($params['general'][StationaryShopResourceModel::ID_FIELD])) {
            $this->processRedirectAfterFailureSave(
                $resultRedirect,
                $params['general'][StationaryShopResourceModel::ID_FIELD],
                $params['general']['store_id']
            );
        } else {
            $this->processRedirectAfterFailureSave($resultRedirect, null, $storeId);
        }
    }
}
