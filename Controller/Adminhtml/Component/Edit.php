<?php

namespace DavidVerholen\DynamicComponentRegistry\Controller\Adminhtml\Component;

use DavidVerholen\DynamicComponentRegistry\Controller\Adminhtml\Component;
use DavidVerholen\DynamicComponentRegistry\Model\Component as ComponentModel;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

class Edit extends Component
{

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $componentId = $this->getRequest()->getParam('id', false);

        /** @var ComponentModel $component */
        $component = $this->componentBuilder->build((int)$componentId);

        if (false !== $componentId && !$component->getId()) {
            $this->messageManager->addError(__('This Component no longer exists.'));
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

            return $resultRedirect->setPath('*/*/');
        }

        $data = $this->_session->getData('form_data', true);
        if (!empty($data)) {
            $component->setData($data);
        }

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $this->initPage($resultPage)->addBreadcrumb(
            $component->getId() ? __('Edit Component') : __('New Component'),
            $component->getId() ? __('Edit Component') : __('New Component')
        );

        $resultPage->getConfig()->getTitle()->prepend(__('Component'));
        $resultPage->getConfig()->getTitle()->prepend(
            $component->getId() ? $component->getName() : __('New Component')
        );

        return $resultPage;
    }
}
