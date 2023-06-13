<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the GNU General Public License v3 (GPL 3.0)
 * It is also available through the world-wide-web at this URL:
 * https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @author https://github.com/annysmolyan
 * @category BelSmol
 * @package BelSmol_ShipPayExport
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License v3 (GPL 3.0)
 */

namespace BelSmol\ShipPayExport\Model;

use Exception;
use BelSmol\ShipPayExport\Api\FileEditorInterface;
use Magento\Framework\Filesystem\DirectoryList;

/**
 * Class CsvFileEditor
 * @package BelSmol\ShipPayExport\Model
 */
class CsvFileEditor implements FileEditorInterface
{
    protected const APPEND_MODE = "a";
    protected const WRITE_MODE = "w";

    private DirectoryList $directoryList;

    /**
     * @param DirectoryList $directoryList
     */
    public function __construct(DirectoryList $directoryList)
    {
        $this->directoryList = $directoryList;
    }

    /**
     * @param string $fileName
     * @param string $path
     * @return void
     * @throws Exception
     */
    public function createEmptyFile(string $fileName, string $path = ''): void
    {
        $fullPath = $this->getCsvFullPath($fileName, $path);
        $csv = fopen($fullPath, self::WRITE_MODE);
        $this->closeFile($csv);
    }

    /**
     * @param array $data
     * @param string $fileName
     * @param string $path
     * @return void
     * @throws Exception
     */
    public function writeLineToFile(array $data, string $fileName, string $path = ''): void
    {
        $fullPath = $this->getCsvFullPath($fileName, $path);
        $csv = fopen($fullPath, self::APPEND_MODE);
        fputcsv($csv, $data);
        $this->closeFile($csv);
    }

    /**
     * @param string $fileName
     * @param string $path
     * @return string
     */
    protected function getCsvFullPath(string $fileName, string $path = ''): string
    {
        return $this->directoryList->getRoot() . $path . '/' . $fileName;
    }

    /**
     * @param $csv
     * @return void
     * @throws Exception
     */
    protected function closeFile($csv): void
    {
        if (!is_resource($csv)) {
            throw new Exception("Resource type is expecting, but instead given " . gettype($csv));
        }

        fclose($csv);
    }
}
