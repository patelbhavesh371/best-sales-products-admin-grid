<?php
namespace Vendor\BestSellerReport\Controller\Adminhtml\Report;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $resultPageFactory;

    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory
    ){
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $page = $this->resultPageFactory->create();
        $page->setActiveMenu('Vendor_BestSellerReport::report');
        $page->getConfig()->getTitle()->prepend(__('Best Seller Report'));
        return $page;
    }
}