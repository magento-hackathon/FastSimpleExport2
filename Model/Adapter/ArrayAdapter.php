<?php
namespace FireGento\FastSimpleExport\Model\Adapter;
use Magento\ImportExport\Model\Export\Adapter\AbstractAdapter;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;

class ArrayAdapter extends \Magento\ImportExport\Model\Export\Adapter\AbstractAdapter{

    /**
     * @var int
     */
    protected $length = 0;
    protected $arr = array();

    public function __construct(
        \Magento\Framework\Filesystem $filesystem,
        $destination = null,
        $destinationDirectoryCode = DirectoryList::VAR_DIR
    ) {
        parent::__construct($filesystem," ",$destinationDirectoryCode);
    }
    public function writeRow(array $rowData)
    {
        $this->arr[] = $rowData;
        $this->length++;
    }
    public function getContents()
    {
        return $this->arr;
    }
}