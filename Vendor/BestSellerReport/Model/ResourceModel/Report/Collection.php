<?php
namespace Vendor\BestSellerReport\Model\ResourceModel\Report;

use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class Collection extends SearchResult
{
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        $mainTable = 'sales_order_item',
        $resourceModel = null
    ) {
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $mainTable,
            $resourceModel
        );
    }

    protected function _initSelect()
    {
        parent::_initSelect();

        $this->getSelect()->reset(\Zend_Db_Select::COLUMNS);

        // join order table
        $this->getSelect()->join(
            ['so' => $this->getTable('sales_order')],
            'main_table.order_id = so.entity_id',
            []
        );

        // columns
        $this->getSelect()->columns([
            'month' => new \Zend_Db_Expr("DATE_FORMAT(so.created_at,'%Y-%m')"),
            'sku' => 'main_table.sku',
            'name' => 'main_table.name',
            'qty_ordered' => new \Zend_Db_Expr('SUM(main_table.qty_ordered)')
        ]);

        // conditions
        $this->getSelect()->where('main_table.parent_item_id IS NULL');
        $this->getSelect()->where("so.state != 'canceled'");

        // group by month + sku
        $this->getSelect()->group([
            new \Zend_Db_Expr("DATE_FORMAT(so.created_at,'%Y-%m')"),
            'main_table.sku'
        ]);

        // order best sellers
        $this->getSelect()->order('month DESC');
        $this->getSelect()->order('qty_ordered DESC');

        return $this;
    }

    /**
     * 🔥 LIMIT 5 RECORD PER MONTH AFTER LOAD
     */
    protected function _afterLoad()
    {
        parent::_afterLoad();

        $data = [];
        $monthCount = [];

        foreach ($this->_items as $item) {
            $month = $item->getData('month');

            if (!isset($monthCount[$month])) {
                $monthCount[$month] = 0;
            }

            if ($monthCount[$month] < 5) {
                $data[] = $item;
                $monthCount[$month]++;
            }
        }

        $this->_items = $data;
        return $this;
    }
}