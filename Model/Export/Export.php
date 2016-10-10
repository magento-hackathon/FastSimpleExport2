<?php
namespace FireGento\FastSimpleExport\Model\Export;
class Export extends \Magento\ImportExport\Model\Export{
    /**
     * Export data.
     *
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function export()
    {
        if (isset($this->_data[self::FILTER_ELEMENT_GROUP])) {
            $this->addLogComment(__('Begin export of %1', $this->getEntity()));
            $result = $this->_getEntityAdapter()->setWriter($this->_getWriter())->export();
            return $result;
        } else {
            throw new \Magento\Framework\Exception\LocalizedException(__('Please provide filter data.'));
        }
    }
}