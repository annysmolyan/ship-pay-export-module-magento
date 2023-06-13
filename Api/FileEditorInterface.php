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

namespace BelSmol\ShipPayExport\Api;

/**
 * Interface FileEditorInterface
 * @package BelSmol\ShipPayExport\Api
 *
 * DONT USE preference for this interface. Use di to inject right implementation
 */
interface FileEditorInterface
{
    /**
     * @param string $fileName
     * @param string $path
     */
    public function createEmptyFile(string $fileName, string $path = '');

    /**
     * @param array $data
     * @param string $fileName
     * @param string $path
     * @return void
     */
    public function writeLineToFile(array $data, string $fileName, string $path = ''): void;
}
