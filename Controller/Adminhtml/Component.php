<?php

namespace DavidVerholen\DynamicComponentRegistry\Controller\Adminhtml;

use DavidVerholen\DynamicComponentRegistry\Api\ComponentRepositoryInterface;
use DavidVerholen\DynamicComponentRegistry\Model\Component\Builder;
use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;

abstract class Component extends Action
{
    /**
     * @var Builder
     */
    protected $componentBuilder;

    /**
     * @var ComponentRepositoryInterface
     */
    protected $componentRepository;

    /**
     * Component constructor.
     *
     * @param Action\Context               $context
     * @param Builder                      $componentBuilder
     * @param ComponentRepositoryInterface $componentRepository
     */
    public function __construct(
        Action\Context $context,
        Builder $componentBuilder,
        ComponentRepositoryInterface $componentRepository
    ) {
        parent::__construct($context);
        $this->componentBuilder = $componentBuilder;
        $this->componentRepository = $componentRepository;
    }


    /**
     * Init page
     *
     * @param Page $resultPage
     *
     * @return Page
     */
    protected function initPage(Page $resultPage)
    {
        $resultPage->setActiveMenu('DavidVerholen_DynamicComponentRegistry::dynamic_component_registry_component')
            ->addBreadcrumb(__('Dynamic Component Registry'), __('Dynamic Component Registry'));

        return $resultPage;
    }

    /**
     * Check for is allowed
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(
            'DavidVerholen_DynamicComponentRegistry::dynamic_component_registry_component'
        );
    }
}
