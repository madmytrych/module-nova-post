<?php
declare(strict_types=1);

namespace Madmytrych\NovaPost\Test\Unit\Model\Import;

use PHPUnit\Framework\TestCase;
use Madmytrych\NovaPost\Service\GuzzleHttpHandler;
use Madmytrych\NovaPost\Model\ResourceModel\WarehouseRepository;
use Madmytrych\NovaPost\Model\Import\Warehouse as ImportWarehouse;
use Madmytrych\NovaPost\Model\Warehouse;
use Madmytrych\NovaPost\Model\Config;

class WarehouseTest extends TestCase
{
    private $httpHandlerMock;
    private $warehouseRepositoryMock;
    private $warehouseMock;
    private $importWarehouse;

    protected function setUp(): void
    {
        $this->httpHandlerMock = $this->createMock(GuzzleHttpHandler::class);
        $this->warehouseRepositoryMock = $this->createMock(WarehouseRepository::class);
        $this->warehouseMock = $this->createMock(Warehouse::class);

        $this->importWarehouse = new ImportWarehouse(
            $this->httpHandlerMock,
            $this->warehouseRepositoryMock
        );
    }

    public function testExecute()
    {
        $importData = [
            [
                'SiteKey' => '123',
                'ShortAddress' => 'Address 1',
                'Longitude' => '24.12345',
                'Latitude' => '49.12345',
                'Description' => 'Warehouse 1',
                'Ref' => 'ref_1',
                'Number' => '1',
                'CityRef' => 'city_ref_1',
                'SettlementTypeDescription' => 'Type 1',
                'CityDescription' => 'City 1'
            ],
        ];
        $this->httpHandlerMock->expects($this->any())
            ->method('execute')
            ->willReturnOnConsecutiveCalls($importData, []);
        $this->warehouseRepositoryMock->expects($this->once())
            ->method('getByWarehouseSiteKey')
            ->with(123)
            ->willReturn($this->warehouseMock);
        $this->warehouseMock->expects($this->once())->method('getSiteKey')->willReturn('123');
        $this->warehouseMock->expects($this->once())->method('getShortAddress')->willReturn('Old Address');
        $this->warehouseMock->expects($this->once())->method('setShortAddress')->with('Address 1');
        $this->warehouseMock->expects($this->once())->method('getLongitude')->willReturn('0.00000');
        $this->warehouseMock->expects($this->once())->method('setLongitude')->with('24.12345');
        $this->warehouseMock->expects($this->once())->method('getLatitude')->willReturn('0.00000');
        $this->warehouseMock->expects($this->once())->method('setLatitude')->with('49.12345');
        $this->warehouseMock->expects($this->once())->method('getDescription')->willReturn('Old Description');
        $this->warehouseMock->expects($this->once())->method('setDescription')->with('Warehouse 1');
        $this->warehouseMock->expects($this->once())->method('getRef')->willReturn('old_ref');
        $this->warehouseMock->expects($this->once())->method('setRef')->with('ref_1');
        $this->warehouseMock->expects($this->once())->method('getNumber')->willReturn(0);
        $this->warehouseMock->expects($this->once())->method('setNumber')->with(1);
        $this->warehouseMock->expects($this->once())->method('getCityRef')->willReturn('old_city_ref');
        $this->warehouseMock->expects($this->once())->method('setCityRef')->with('city_ref_1');
        $this->warehouseMock->expects($this->once())->method('getSettlementType')->willReturn('Old Type');
        $this->warehouseMock->expects($this->once())->method('setSettlementType')->with('Type 1');
        $this->warehouseMock->expects($this->once())->method('getCityDescription')->willReturn('Old City');
        $this->warehouseMock->expects($this->once())->method('setCityDescription')->with('City 1');
        $this->warehouseMock->expects($this->once())->method('hasDataChanges')->willReturn(true);
        $this->warehouseRepositoryMock->expects($this->once())
            ->method('save')
            ->with($this->warehouseMock);

        $this->importWarehouse->execute();
    }
}
