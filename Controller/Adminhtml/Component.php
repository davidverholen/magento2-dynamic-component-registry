<?php

namespace DavidVerholen\DynamicComponentRegistry\Controller\Adminhtml;

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
     * Component constructor.
     *
     * @param Action\Context $context
     * @param Builder        $componentBuilder
     */
    public function __construct(
        Action\Context $context,
        Builder $componentBuilder
    ) {
        parent::__construct($context);
        $this->componentBuilder = $componentBuilder;
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
        $resultPage->setActiveMenu('DavidVerholen_Teaser::teaser_group')
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
