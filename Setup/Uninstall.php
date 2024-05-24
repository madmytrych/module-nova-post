<?php
declare(strict_types=1);

namespace Madmytrych\NovaPost\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface;
use Madmytrych\NovaPost\Api\Data\CityInterface;
use Madmytrych\NovaPost\Api\Data\WarehouseInterface;

class Uninstall implements UninstallInterface
{
    /**
     * @inheritdoc
     */
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context): void
    {
        $tables = $this->getTables();
        $setup->startSetup();
        foreach ($tables as $table) {
            if ($setup->getConnection()->isTableExists($table)) {
                $setup->getConnection()->dropTable($table);
            }
        }
        $setup->endSetup();
    }

    /**
     * Get all tables list
     *
     * @return array
     */
    protected function getTables(): array
    {
        return [
            CityInterface::CITY_TABLE_NAME,
            WarehouseInterface::WAREHOUSE_TABLE_NAME,
        ];
    }
}
