<?php

namespace DavidVerholen\DynamicComponentRegistry\Controller\Adminhtml\Component;

use DavidVerholen\DynamicComponentRegistry\Api\ComponentRepositoryInterface;
use DavidVerholen\DynamicComponentRegistry\Api\Data\ComponentInterface;
use DavidVerholen\DynamicComponentRegistry\Controller\Adminhtml\Component;
use DavidVerholen\DynamicComponentRegistry\Model\Component\Builder;
use DavidVerholen\DynamicComponentRegistry\Model\ComponentFactory;
use DavidVerholen\DynamicComponentRegistry\Validator\Component\ValidatorPool;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\DataObject;
use Magento\Framework\Model\AbstractModel;

class Validate extends Component
{
    /**
     * @var ValidatorPool
     */
    private $validatorPool;

    /**
     * @var ComponentFactory
     */
    private $componentFactory;

    /**
     * Validate constructor.
     *
     * @param Action\Context               $context
     * @param Builder                      $componentBuilder
     * @param ComponentRepositoryInterface $componentRepository
     * @param ValidatorPool                $validatorPool
     * @param ComponentFactory             $componentFactory
     */
    public function __construct(
        Action\Context $context,
        Builder $componentBuilder,
        ComponentRepositoryInterface $componentRepository,
        ValidatorPool $validatorPool,
        ComponentFactory $componentFactory
    ) {
        parent::__construct($context, $componentBuilder, $componentRepository);
        $this->validatorPool = $validatorPool;
        $this->componentFactory = $componentFactory;
    }


    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        /** @var ComponentInterface|AbstractModel $component */
        $component = $this->componentFactory->create();
        $component->setData($this->getRequest()->getParam('general', []));
        $errors = $this->validatorPool->validateAll($component);

        $response = new DataObject();
        $response->setData('error', (count($errors) > 0));
        $response->setData('messages', $errors);

        /** @var Json $resultJson */
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData($response);

        return $resultJson;
    }
}
