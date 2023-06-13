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
use BelSmol\ShipPayExport\Api\PaymentMethodListExportInterface;
use Magento\Framework\App\Config\Initial as InitialConfig;
use Magento\Payment\Helper\Data as PaymentHelper;

/**
 * Class PaymentMethodList
 * @package BelSmol\ShipPayExport\Model\Export\PaymentMethodList
 */
class PaymentMethodList implements PaymentMethodListExportInterface
{
    protected const CSV_FILE_NAME = "payment_method_list.csv";

    private InitialConfig $initialConfig;
    private FileEditorInterface $fileEditor;
    private array $csvHeaders = [
        "Code",
        "Name",
        "Group",
        "Is Active"
    ];

    /**
     * @param InitialConfig $initial
     * @param FileEditorInterface $fileEditor
     */
    public function __construct(
        InitialConfig $initial,
        FileEditorInterface $fileEditor
    ) {
        $this->fileEditor = $fileEditor;
        $this->initialConfig = $initial;
    }

    /**
     * @return void
     */
    public function export(): void
    {
        $list = $this->initialConfig->getData('default')[PaymentHelper::XML_PATH_PAYMENT_METHODS];;

        $this->fileEditor->createEmptyFile(self::CSV_FILE_NAME);
        $this->fileEditor->writeLineToFile($this->csvHeaders, self::CSV_FILE_NAME);

        foreach ($list as $itemCode => $itemData) {
            $paymentName = $itemData['title'] ?? '';
            $paymentGroup = $itemData['group'] ?? '';
            $isActive = $itemData['active'] ?? 0;
            $csvLine = [$itemCode, $paymentName, $paymentGroup, $isActive];
            $this->fileEditor->writeLineToFile($csvLine, self::CSV_FILE_NAME);
        }
    }
}
