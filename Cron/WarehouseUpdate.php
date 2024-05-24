<?php
/**
 * Madmytrych_NovaPost
 * MIT license
 */
declare(strict_types=1);

namespace Madmytrych\NovaPost\Cron;

use Madmytrych\NovaPost\Model\Import\Warehouse;

class WarehouseUpdate
{
    /**
     * @param \Madmytrych\NovaPost\Model\Import\Warehouse $warehouse
     */
    public function __construct(
        private Warehouse $warehouse
    ) {
    }

    /**
     * Cronjob Description
     *
     * @return void
     * @throws \Exception
     */
    public function execute(): void
    {
        $this->warehouse->execute();
    }
}
