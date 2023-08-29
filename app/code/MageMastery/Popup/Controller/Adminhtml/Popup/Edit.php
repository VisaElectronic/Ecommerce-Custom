<?php

namespace MageMastery\Popup\Controller\Adminhtml\Popup;

use MageMastery\Popup\Api\Data\PopupInterface;
use MageMastery\Popup\Api\Data\PopupInterfaceFactory;
use MageMastery\Popup\Api\PopupRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\Page;

class Edit extends Action
{
    /**
     * Undocumented function
     *
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param PopupInterfaceFactory $popupFactory
     * @param PopupRepositoryInterface $popupRepository
     */
    public function __construct(
        Context $context,
        private readonly PopupRepositoryInterface $popupRepository,
        private readonly DataPersistorInterface $dataPersistor,
    ) {
        parent::__construct($context);   
    }

    public function execute(): ResultInterface
    {
        /** @var Page $page */
        $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $popupId = (int) $this->getRequest()->getParam('popup_id');
        if($popupId) {
            try {
                $popup = $this->popupRepository->getById($popupId);
                $this->dataPersistor->set('magemastery_popup_popup', $popup->getData());
            } catch (NoSuchEntityException $ex) {
                $this->messageManager->addErrorMessage(
                    __('The popup with the given id does not exist')
                );
            }
        }
        $page->setActiveMenu('MageMastery_Popup::popup');
        $page->addBreadcrumb(__('Popups'), __('Popups'));
        $page->addBreadcrumb(
            isset($popup) && $popup->getPopupId() ? $popup->getName() : __('New Popup'),
            isset($popup) && $popup->getPopupId() ? $popup->getName() : __('New Popup'),
        );
        $page->getConfig()->getTitle()->prepend(
            isset($popup) && $popup->getPopupId() ? $popup->getName() : __('New Popup'),
        );

        return $page;
    }
}