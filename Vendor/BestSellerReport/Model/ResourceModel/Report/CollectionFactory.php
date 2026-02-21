<?php
namespace Vendor\BestSellerReport\Model\ResourceModel\Report;

use Magento\Framework\ObjectManagerInterface;

class CollectionFactory
{
    protected $objectManager;
    protected $instanceName;

    public function __construct(
        ObjectManagerInterface $objectManager,
        $instanceName = Collection::class
    ){
        $this->objectManager = $objectManager;
        $this->instanceName = $instanceName;
    }

    public function create()
    {
        return $this->objectManager->create($this->instanceName);
    }
}