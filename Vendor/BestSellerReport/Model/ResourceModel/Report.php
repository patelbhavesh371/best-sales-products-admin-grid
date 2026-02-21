<?php
namespace Vendor\BestSellerReport\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Report extends AbstractDb
{
    protected function _construct()
    {
        // no real table needed but required
        $this->_init('sales_order_item', 'item_id');
    }
}
