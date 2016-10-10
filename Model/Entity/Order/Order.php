<?php
/**
 * *
 *  * Copyright © Elias Kotlyar - All rights reserved.
 *  * See LICENSE.md bundled with this module for license details.
 *
 */
namespace FireGento\FastSimpleExport\Model\Entity\Order;

/**
 * Export entity customer model
 */

class Order extends \Magento\ImportExport\Model\Export\Entity\AbstractEav
{
    /**#@+
     * Permanent column names.
     *
     * Names that begins with underscore is not an attribute. This name convention is for
     * to avoid interference with same attribute name.
     */

    const COLUMN_STORE = '_store';

    /**#@-*/

    /**#@+
     * Attribute collection name
     */
    const ATTRIBUTE_COLLECTION_NAME = 'FireGento\FastSimpleExport\Model\Entity\Order\OrderAttributeCollection';


    /**#@-*/

    /**
     * Overridden attributes parameters.
     *
     * @var array
     */
    protected $_attributeOverrides = [
        'created_at' => ['backend_type' => 'datetime'],
        'reward_update_notification' => ['source_model' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean'],
        'reward_warning_notification' => ['source_model' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean'],
    ];

    /**
     * Array of attributes codes which are disabled for export
     *
     * @var string[]
     */
    protected $_disabledAttributes = ['default_billing', 'default_shipping'];

    /**
     * Attributes with index (not label) value.
     *
     * @var string[]
     */
    protected $_indexValueAttributes = ['store_id'];

    /**
     * Permanent entity columns.
     *
     * @var string[]
     */
    protected $_permanentAttributes = [self::COLUMN_STORE];

    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\Collection|mixed
     */
    protected $orderCollection;


    /**
     * Order constructor.
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\ImportExport\Model\Export\Factory $collectionFactory
     * @param \Magento\ImportExport\Model\ResourceModel\CollectionByPagesIteratorFactory $resourceColFactory
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate
     * @param \Magento\Eav\Model\Config $eavConfig
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\ImportExport\Model\Export\Factory $collectionFactory,
        \Magento\ImportExport\Model\ResourceModel\CollectionByPagesIteratorFactory $resourceColFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderFactory,
        array $data = []
    )
    {
        parent::__construct(
            $scopeConfig,
            $storeManager,
            $collectionFactory,
            $resourceColFactory,
            $localeDate,
            $eavConfig,
            $data
        );

        $this->orderCollection = $orderFactory->create();

        $this->_initAttributeValues()->_initStores()->_initWebsites(true);
    }

    /**
     * Export process.
     *
     * @return string
     */
    public function export()
    {
        $writer = $this->getWriter();
        $writer->setHeaderCols($this->_getHeaderColumns());
        $this->_exportCollectionByPages($this->_getEntityCollection());
        return $writer->getContents();
    }

    /**
     * {@inheritdoc}
     */
    protected function _getHeaderColumns()
    {
        $validAttributeCodes = $this->_getExportAttributeCodes();
        return array_merge($this->_permanentAttributes, $validAttributeCodes);
    }

    /**
     * Get customers collection
     *
     * @return \Magento\Customer\Model\ResourceModel\Customer\Collection
     */
    protected function _getEntityCollection()
    {
        return $this->orderCollection;
    }

    /**
     * Export given customer data
     *
     * @param \Magento\Customer\Model\Customer $item
     * @return void
     */
    public function exportItem($item)
    {
        $row = $item->getData();
        $row[self::COLUMN_STORE] = $this->_storeIdToCode[$item->getStoreId()];
        $this->getWriter()->writeRow($row);
    }


    /**
     * EAV entity type code getter.
     *
     * @return string
     */
    public function getEntityTypeCode()
    {
        return $this->getAttributeCollection()->getEntityTypeCode();
    }

    /**
     * Retrieve list of overridden attributes
     *
     * @return array
     */
    public function getOverriddenAttributes()
    {
        return $this->_attributeOverrides;
    }

}
