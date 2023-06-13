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

namespace BelSmol\ShipPayExport\Model\Export;

use BelSmol\ShipPayExport\Api\FileEditorInterface;
use BelSmol\ShipPayExport\Api\ShippingMethodListExportInterface;
use Magento\Shipping\Model\Config\Source\Allmethods;

/**
 * Class ShippingMethodList
 * @package BelSmol\ShipPayExport\Model\Export
 */
class ShippingMethodList implements ShippingMethodListExportInterface
{
    protected const CSV_FILE_NAME = "shipping_method_list.csv";

    private Allmethods $shipmentMethodsSource;
    private FileEditorInterface $fileEditor;
    private array $csvHeaders = [
        "Code",
    ];

    /**
     * @param Allmethods $shipmentMethodsSource
     * @param FileEditorInterface $fileEditor
     */
    public function __construct(
        Allmethods $shipmentMethodsSource,
        FileEditorInterface $fileEditor
    ) {
        $this->shipmentMethodsSource = $shipmentMethodsSource;
        $this->fileEditor = $fileEditor;
    }

    /**
     * Export list of shipping info
     * @return void
     */
    public function export(): void
    {
        $this->fileEditor->createEmptyFile(self::CSV_FILE_NAME);
        $this->fileEditor->writeLineToFile($this->csvHeaders, self::CSV_FILE_NAME);

        $list = $this->shipmentMethodsSource->toOptionArray();

        foreach ($list as $itemCode => $itemData) {
            $csvLine = [$itemCode];
            $this->fileEditor->writeLineToFile($csvLine, self::CSV_FILE_NAME);
        }
    }
}
