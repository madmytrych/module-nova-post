<?php
/**
 * Madmytrych_NovaPost
 * MIT license
 */
declare(strict_types=1);

namespace Madmytrych\NovaPost\Model\Import;

use Madmytrych\NovaPost\Model\Config;
use Madmytrych\NovaPost\Service\GuzzleHttpHandler;
use Madmytrych\NovaPost\Model\ResourceModel\WarehouseRepository;

class Warehouse
{
    /**
     * @param \Madmytrych\NovaPost\Service\GuzzleHttpHandler $httpHandler
     * @param \Madmytrych\NovaPost\Model\ResourceModel\WarehouseRepository $warehouseRepository
     */
    public function __construct(
        private GuzzleHttpHandler $httpHandler,
        private WarehouseRepository $warehouseRepository
    ) {
    }

    /**
     * Imports/updates warehouses
     *
     * @return void
     * @throws \Exception
     */
    public function execute(): void
    {
        $pageNum = 1;
        do {
            $importData = $this->httpHandler->execute(
                Config::API_NP_MODEL_ADDRESS,
                Config::API_NP_METHOD_WAREHOUSES,
                [
                    Config::API_NP_PAGE => $pageNum
                ]
            );
            $pageNum++;
            foreach ($importData as $warehouse) {
                $this->updateWarehouseData($warehouse);
            }
        } while (!empty($importData));
    }

    /**
     * Updates data
     *
     * @param array $warehouseObject
     *
     * @return void
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    private function updateWarehouseData(array $warehouseObject): void
    {
        /** @var \Madmytrych\NovaPost\Api\Data\WarehouseInterface $warehouse */
        $warehouse = $this->warehouseRepository->getByWarehouseSiteKey((int)$warehouseObject['SiteKey']);
        if ($warehouse->getSiteKey() !== $warehouseObject['SiteKey']) {
            $warehouse->setSiteKey($warehouseObject['SiteKey']);
        }
        if ($warehouse->getShortAddress() !== $warehouseObject['ShortAddress']) {
            $warehouse->setShortAddress($warehouseObject['ShortAddress']);
        }
        if ($warehouse->getLongitude() !== $warehouseObject['Longitude']) {
            $warehouse->setLongitude($warehouseObject['Longitude']);
        }
        if ($warehouse->getLatitude() !== $warehouseObject['Latitude']) {
            $warehouse->setLatitude($warehouseObject['Latitude']);
        }
        if ($warehouse->getDescription() !== $warehouseObject['Description']) {
            $warehouse->setDescription($warehouseObject['Description']);
        }
        if ($warehouse->getRef() !== $warehouseObject['Ref']) {
            $warehouse->setRef($warehouseObject['Ref']);
        }
        if ((int)$warehouse->getNumber() !== (int)$warehouseObject['Number']) {
            $warehouse->setNumber((int)$warehouseObject['Number']);
        }
        if ($warehouse->getCityRef() !== $warehouseObject['CityRef']) {
            $warehouse->setCityRef($warehouseObject['CityRef']);
        }
        if ($warehouse->getSettlementType() !== $warehouseObject['SettlementTypeDescription']) {
            $warehouse->setSettlementType($warehouseObject['SettlementTypeDescription']);
        }
        if ($warehouse->getCityDescription() !== $warehouseObject['CityDescription']) {
            $warehouse->setCityDescription($warehouseObject['CityDescription']);
        }
        if ($warehouse->hasDataChanges()) {
            $this->warehouseRepository->save($warehouse);
        }
    }
}
