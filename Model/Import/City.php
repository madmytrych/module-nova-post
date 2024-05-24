<?php
/**
 * Madmytrych_NovaPost
 * MIT license
 */
declare(strict_types=1);

namespace Madmytrych\NovaPost\Model\Import;

use Madmytrych\NovaPost\Model\Config;
use Madmytrych\NovaPost\Service\GuzzleHttpHandler;
use Madmytrych\NovaPost\Model\ResourceModel\CityRepository;

class City
{
    /**
     * @param \Madmytrych\NovaPost\Service\GuzzleHttpHandler $httpHandler
     * @param \Madmytrych\NovaPost\Model\ResourceModel\CityRepository $cityRepository
     */
    public function __construct(
        private GuzzleHttpHandler $httpHandler,
        private CityRepository $cityRepository
    ) {
    }

    /**
     * Imports/updates cities
     *
     * @return void
     * @throws \Exception
     */
    public function execute()
    {
        $importData = $this->httpHandler->execute(
            Config::API_NP_MODEL_ADDRESS,
            Config::API_NP_METHOD_CITIES
        );
        foreach ($importData as $city) {
            $this->updateCityData($city);
        }
    }

    /**
     * Update city data if necessary
     *
     * @param array $cityObject
     *
     * @return void
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    private function updateCityData(array $cityObject): void
    {
        $city = $this->cityRepository->getByCityId($cityObject['CityID']);
        if ($city->getArea() !== $cityObject['Area']) {
            $city->setArea($cityObject['Area']);
        }
        if ($city->getAreaDescription() !== $cityObject['AreaDescription']) {
            $city->setAreaDescription($cityObject['AreaDescription']);
        }
        if ((int)$city->getCityId() !== (int)$cityObject['CityID']) {
            $city->setCityId((int)$cityObject['CityID']);
        }
        if ($city->getDescription() !== $cityObject['Description']) {
            $city->setDescription($cityObject['Description']);
        }
        if ($city->getRef() !== $cityObject['Ref']) {
            $city->setRef($cityObject['Ref']);
        }
        if ($city->getSettlementType() !== $cityObject['SettlementType']) {
            $city->setSettlementType($cityObject['SettlementType']);
        }
        if ($city->getSettlementTypeDescription() !== $cityObject['SettlementTypeDescription']) {
            $city->setSettlementTypeDescription($cityObject['SettlementTypeDescription']);
        }
        if ($city->hasDataChanges()) {
            $this->cityRepository->save($city);
        }
    }
}
