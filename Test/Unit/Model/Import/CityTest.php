<?php
declare(strict_types=1);

namespace Madmytrych\NovaPost\Test\Unit\Model\Import;

use PHPUnit\Framework\TestCase;
use Madmytrych\NovaPost\Service\GuzzleHttpHandler;
use Madmytrych\NovaPost\Model\ResourceModel\CityRepository;
use Madmytrych\NovaPost\Model\Import\City;
use Madmytrych\NovaPost\Model\Config;
use Madmytrych\NovaPost\Model\City as CityModel;

class CityTest extends TestCase
{
    private $httpHandler;
    private $cityRepository;
    private $cityImporter;

    protected function setUp(): void
    {
        $this->httpHandler = $this->createMock(GuzzleHttpHandler::class);
        $this->cityRepository = $this->createMock(CityRepository::class);

        $this->cityImporter = new City($this->httpHandler, $this->cityRepository);
    }

    public function testExecute()
    {
        $importData = [
            [
                'CityID' => 1,
                'Area' => 'Area1',
                'AreaDescription' => 'AreaDescription1',
                'Description' => 'Description1',
                'Ref' => 'Ref1',
                'SettlementType' => 'Type1',
                'SettlementTypeDescription' => 'TypeDescription1'
            ],
            [
                'CityID' => 2,
                'Area' => 'Area2',
                'AreaDescription' => 'AreaDescription2',
                'Description' => 'Description2',
                'Ref' => 'Ref2',
                'SettlementType' => 'Type2',
                'SettlementTypeDescription' => 'TypeDescription2'
            ]
        ];

        $this->httpHandler->method('execute')
            ->with(Config::API_NP_MODEL_ADDRESS, Config::API_NP_METHOD_CITIES)
            ->willReturn($importData);

        $cityMocks = [];
        foreach ($importData as $cityData) {
            $cityMocks[] = $this->createCityMock($cityData);
        }

        $this->cityRepository->expects($this->exactly(2))
            ->method('getByCityId')
            ->withConsecutive(
                [$importData[0]['CityID']],
                [$importData[1]['CityID']]
            )
            ->willReturnOnConsecutiveCalls(...$cityMocks);

        $this->cityRepository->expects($this->exactly(2))
            ->method('save')
            ->withConsecutive(
                [$cityMocks[0]],
                [$cityMocks[1]]
            );

        $this->cityImporter->execute();
    }

    private function createCityMock(array $data)
    {
        $cityMock = $this->getMockBuilder(CityModel::class)
            ->disableOriginalConstructor()
            ->getMock();

        $cityMock->method('getArea')->willReturn($data['Area']);
        $cityMock->method('getAreaDescription')->willReturn($data['AreaDescription']);
        $cityMock->method('getCityId')->willReturn($data['CityID']);
        $cityMock->method('getDescription')->willReturn($data['Description']);
        $cityMock->method('getRef')->willReturn($data['Ref']);
        $cityMock->method('getSettlementType')->willReturn($data['SettlementType']);
        $cityMock->method('getSettlementTypeDescription')->willReturn($data['SettlementTypeDescription']);

        $cityMock->expects($this->any())->method('hasDataChanges')->willReturn(true);
        $cityMock->expects($this->any())->method('setArea');
        $cityMock->expects($this->any())->method('setAreaDescription');
        $cityMock->expects($this->any())->method('setCityId');
        $cityMock->expects($this->any())->method('setDescription');
        $cityMock->expects($this->any())->method('setRef');
        $cityMock->expects($this->any())->method('setSettlementType');
        $cityMock->expects($this->any())->method('setSettlementTypeDescription');

        return $cityMock;
    }
}
