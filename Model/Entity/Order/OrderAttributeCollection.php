<?php
namespace FireGento\FastSimpleExport\Model\Entity\Order;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
class OrderAttributeCollection extends \Magento\Framework\Data\Collection
{
    public function __construct(
        EntityFactoryInterface $entityFactory,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderFactory
    )
    {
        parent::__construct($entityFactory);
        $orderCollection = $orderFactory->create();
        $connection = $orderCollection->getResource()->getConnection();
        $fields = $connection->describeTable($orderCollection->getResource()->getMainTable());
        foreach(array_keys($fields) as $fieldName){
            $item = $entityFactory->create('\FireGento\FastSimpleExport\Model\Entity\Order\OrderAttribute');
            /** @var \\FireGento\FastSimpleExport\Model\Entity\Order\OrderAttribute $item */
            $item->setAttributeCode($fieldName);
            $this->addItem($item);

        }



    }

    public function getEntityTypeCode(){
        return 'order';
    }
}