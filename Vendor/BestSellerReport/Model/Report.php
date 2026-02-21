<?php
namespace Vendor\BestSellerReport\Model;

use Magento\Framework\Model\AbstractModel;

class Report extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Vendor\BestSellerReport\Model\ResourceModel\Report::class);
    }
}
