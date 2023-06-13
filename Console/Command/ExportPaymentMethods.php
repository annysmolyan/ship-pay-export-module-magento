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

namespace BelSmol\ShipPayExport\Console\Command;

use Exception;
use BelSmol\ShipPayExport\Api\PaymentMethodListExportInterface as ExportModel;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ExportPaymentMethods
 * @package BelSmol\ShipPayExport\Console\Command
 */
class ExportPaymentMethods extends Command
{
    protected const COMMAND_NAME = "belsmol:export:export-payment-method-list";

    private ExportModel $exportModel;
    private State $state;

    /**
     * @param ExportModel $exportModel
     * @param State $state
     * @param string|null $name
     */
    public function __construct(
        ExportModel $exportModel,
        State $state,
        string $name = null
    ) {
        parent::__construct($name);
        $this->exportModel = $exportModel;
        $this->state = $state;
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription("Export list of current magento payment methods");

        parent::configure();
    }

    /**
     * Export all payment methods from Magento
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Export in progress.</info>');

        try {
            $this->state->setAreaCode(Area::AREA_ADMINHTML);
            $this->exportModel->export();
            $output->writeln('<info>Export done.</info>');
        } catch (Exception $exception){
            $errorMsg = sprintf('<error>%s</error>', $exception->getMessage());
            $output->writeln($errorMsg);
        }
    }
}
