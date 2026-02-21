<?php
namespace Vendor\BestSellerReport\Controller\Adminhtml\Report;

use Magento\Backend\App\Action;
use Magento\Framework\App\Response\Http\FileFactory;
use Vendor\BestSellerReport\Model\ResourceModel\Report\CollectionFactory;

class ExportCsv extends Action
{
    protected $fileFactory;
    protected $collectionFactory;

    public function __construct(
        Action\Context $context,
        FileFactory $fileFactory,
        CollectionFactory $collectionFactory
    ){
        parent::__construct($context);
        $this->fileFactory = $fileFactory;
        $this->collectionFactory = $collectionFactory;
    }

    public function execute()
    {
        $fileName = 'bestseller_report.csv';
        $collection = $this->collectionFactory->create();

        $content = "Month,SKU,Product Name,Qty Sold\n";

        foreach ($collection as $item) {
            $content .= $item->getMonth().",".
                        $item->getSku().",".
                        $item->getName().",".
                        $item->getQtyOrdered()."\n";
        }

        return $this->fileFactory->create(
            $fileName,
            $content,
            \Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR
        );
    }
}
