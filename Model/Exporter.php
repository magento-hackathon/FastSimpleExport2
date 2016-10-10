<?php
namespace FireGento\FastSimpleExport\Model;
class Exporter
{
    /**
     * @var \Magento\ImportExport\Model\ExportFactory
     */
    protected $exportFactory;
    /**
     * @var array
     */
    protected $settings;

    /**
     * Exporter constructor.
     * @param \FireGento\FastSimpleExport\Model\Export\ExportFactory $exportFactory
     */
    public function __construct(
        \FireGento\FastSimpleExport\Model\Export\ExportFactory $exportFactory
    )
    {
        $this->exportFactory = $exportFactory;
    }
    /**
     * @return \Magento\ImportExport\Model\Export
     */
    public function createExportModel(){
        $importModel = $this->exportFactory->create();
        $importModel->setData($this->settings);
        return $importModel;
    }
    /**
     * @param string $entityCode
     */
    public function setEntityCode($entityCode)
    {
        $this->settings['entity'] = $entityCode;

    }
    public function export(){
        $export = $this->createExportModel();
        /*
        $filter =  $export->filterAttributeCollection(
            $export->getEntityAttributeCollection()
        );
        var_dump($filter->toArray());
        */
        $export->setData(\Magento\ImportExport\Model\Export::FILTER_ELEMENT_GROUP,array());
        $export->setData("file_format","array");


        return $export->export();
    }

}