<?php
/**
 * Madmytrych_NovaPost
 * MIT license
 */
declare(strict_types=1);

namespace Madmytrych\NovaPost\Cron;

use Madmytrych\NovaPost\Model\Import\City;

class CityUpdate
{
    /**
     * @param \Madmytrych\NovaPost\Model\Import\City $city
     */
    public function __construct(
        private City $city
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
        $this->city->execute();
    }
}
