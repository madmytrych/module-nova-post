<?php
/**
 * Madmytrych_NovaPost
 * MIT license
 */
declare(strict_types=1);

namespace Madmytrych\NovaPost\Console\Command;

use Magento\Framework\App\Area;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\State;
use Magento\Framework\Console\Cli;
use Madmytrych\NovaPost\Cron\CityUpdate;
use Madmytrych\NovaPost\Cron\WarehouseUpdate;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TablesFillOut extends Command
{
    /**
     * @param \Magento\Framework\App\ResourceConnection $resourceConnection
     * @param \Madmytrych\NovaPost\Cron\CityUpdate $cityUpdate
     * @param \Madmytrych\NovaPost\Cron\WarehouseUpdate $warehouseUpdate
     * @param \Magento\Framework\App\State $appState
     */
    public function __construct(
        private ResourceConnection $resourceConnection,
        private CityUpdate $cityUpdate,
        private WarehouseUpdate $warehouseUpdate,
        private State $appState,
    ) {
        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    protected function configure(): void
    {
        $this->setName('novapost:tables:fillout');
        $this->setDescription('Fills out Nova Post tables');
    }

    /**
     * @inheritdoc
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->appState->setAreaCode(Area::AREA_GLOBAL);
        $connection = $this->resourceConnection->getConnection();
        $connection->beginTransaction();
        try {
            $this->cityUpdate->execute();
            $this->warehouseUpdate->execute();
            $connection->commit();
            $output->writeln("<info>Nova Post tables have been filled out</info>");
            return Cli::RETURN_SUCCESS;
        } catch (\Exception $exception) {
            $connection->rollBack();
            $output->writeln("<error>{$exception->getMessage()}</error>");
            return Cli::RETURN_FAILURE;
        }
    }
}
