<?php

namespace DavidVerholen\DynamicComponentRegistry\Controller\Adminhtml\Component;

use DavidVerholen\DynamicComponentRegistry\Controller\Adminhtml\Component;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

class Save extends Component
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
        $generalData = $this->getRequest()->getParam('general');

        if (!$generalData) {
            return $resultRedirect->setPath('*/*/');
        }

        $id = $this->getRequest()->getParam('id', null);

        /** @var \DavidVerholen\DynamicComponentRegistry\Model\Component $component */
        $component = $this->componentBuilder->build($id);

        if ($id && !$component->getId()) {
            $this->messageManager->addError(__('This Component no longer exists.'));
            return $resultRedirect->setPath('*/*/');
        }

        $component->setData($generalData);

        try {
            $this->componentRepository->save($component);
            $this->messageManager->addSuccess(__('You saved the Component. Run \'bin/magento setup:upgrade\' to update the module configuration'));
            $this->_session->setFormData(false);
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            $this->_session->setFormData($generalData);

            return $resultRedirect->setPath(
                '*/*/edit',
                ['id' => $this->getRequest()->getParam('id')]
            );
        }

        if ($this->getRequest()->getParam('back')) {
            return $resultRedirect->setPath(
                '*/*/edit',
                ['id' => $component->getId()]
            );
        }

        return $resultRedirect->setPath('*/*/');
    }
}
