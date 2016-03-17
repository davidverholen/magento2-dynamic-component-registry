<?php

namespace DavidVerholen\DynamicComponentRegistry\Controller\Adminhtml\Component;

use DavidVerholen\DynamicComponentRegistry\Controller\Adminhtml\Component;
use DavidVerholen\DynamicComponentRegistry\Model\Component as ComponentModel;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

class Delete extends Component
{
    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $id = $this->getRequest()->getParam('id');

        if (!$id) {
            $this->messageManager->addError(__('We can\'t find a Component to delete.'));
            return $resultRedirect->setPath('*/*/');
        }

        try {
            /** @var ComponentModel $component */
            $component = $this->componentBuilder->build($id);
            $component->delete();
            $this->messageManager->addSuccess(__('You deleted the Component.'));
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
