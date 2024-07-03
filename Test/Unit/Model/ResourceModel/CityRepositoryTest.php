<?php
declare(strict_types=1);

namespace Madmytrych\NovaPost\Test\Unit\Model\ResourceModel;

use PHPUnit\Framework\TestCase;
use Madmytrych\NovaPost\Model\ResourceModel\CityRepository;
use Madmytrych\NovaPost\Model\ResourceModel\City as ResourceModel;
use Madmytrych\NovaPost\Model\CityFactory;
use Madmytrych\NovaPost\Model\ResourceModel\City\CollectionFactory;
use Madmytrych\NovaPost\Model\City;
use Madmytrych\NovaPost\Model\ResourceModel\City\Collection;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsFactory;
use Magento\Framework\Exception\CouldNotDeleteException;

class CityRepositoryTest extends TestCase
{
    /**
     * @var \Madmytrych\NovaPost\Model\ResourceModel\City
     */
    private $resourceModelMock;

    /**
     * @var \Madmytrych\NovaPost\Model\CityFactory
     */
    private $cityFactoryMock;

    /**
     * @var \Madmytrych\NovaPost\Model\ResourceModel\City\CollectionFactory
     */
    private $collectionFactoryMock;

    /**
     * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
     */
    private $collectionProcessorMock;

    /**
     * @var \Magento\Framework\Api\SearchResultsFactory
     */
    private $searchResultsFactoryMock;

    /**
     * @var \Madmytrych\NovaPost\Model\ResourceModel\CityRepository
     */
    private $cityRepository;

    protected function setUp(): void
    {
        $this->resourceModelMock = $this->createMock(ResourceModel::class);
        $this->cityFactoryMock = $this->createMock(CityFactory::class);
        $this->collectionFactoryMock = $this->createMock(CollectionFactory::class);
        $this->collectionProcessorMock = $this->createMock(CollectionProcessorInterface::class);
        $this->searchResultsFactoryMock = $this->createMock(SearchResultsFactory::class);
        $this->cityRepository = new CityRepository(
            $this->resourceModelMock,
            $this->cityFactoryMock,
            $this->collectionFactoryMock,
            $this->collectionProcessorMock,
            $this->searchResultsFactoryMock
        );
    }

    public function testGetByCityId()
    {
        $cityId = 123;
        $cityMock = $this->getMockBuilder(City::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getData'])
            ->getMock();
        $this->cityFactoryMock->method('create')->willReturn($cityMock);
        $this->resourceModelMock->expects($this->once())
            ->method('load')
            ->with($cityMock, $cityId, \Madmytrych\NovaPost\Api\Data\CityInterface::CITY_ID);
        $result = $this->cityRepository->getByCityId($cityId);
        $this->assertSame($cityMock, $result);
    }

    public function testGetById()
    {
        $id = 123;
        $cityMock = $this->getMockBuilder(City::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getData'])
            ->getMock();
        $this->cityFactoryMock->method('create')->willReturn($cityMock);
        $this->resourceModelMock->expects($this->once())
            ->method('load')
            ->with($cityMock, $id);
        $result = $this->cityRepository->getById($id);
        $this->assertSame($cityMock, $result);
    }

    public function testGet()
    {
        $value = 'some_value';
        $field = 'some_field';
        $cityMock = $this->getMockBuilder(City::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getData'])
            ->getMock();
        $this->cityFactoryMock->method('create')->willReturn($cityMock);
        $this->resourceModelMock->expects($this->once())
            ->method('load')
            ->with($cityMock, $value, $field);
        $result = $this->cityRepository->get($value, $field);
        $this->assertSame($cityMock, $result);
    }

    public function testGetList()
    {
        $criteriaMock = $this->createMock(SearchCriteriaInterface::class);
        $collectionMock = $this->createMock(Collection::class);
        $searchResultsMock = $this->createMock(\Magento\Framework\Api\SearchResults::class);
        $items = [$this->createMock(City::class)];
        $this->collectionFactoryMock->method('create')->willReturn($collectionMock);
        $this->collectionProcessorMock->expects($this->once())
            ->method('process')
            ->with($criteriaMock, $collectionMock);
        $collectionMock->method('getItems')->willReturn($items);
        $collectionMock->method('getSize')->willReturn(count($items));
        $this->searchResultsFactoryMock->method('create')->willReturn($searchResultsMock);
        $searchResultsMock->expects($this->once())->method('setSearchCriteria')->with($criteriaMock);
        $searchResultsMock->expects($this->once())->method('setItems')->with($items);
        $searchResultsMock->expects($this->once())->method('setTotalCount')->with(count($items));
        $result = $this->cityRepository->getList($criteriaMock);
        $this->assertSame($searchResultsMock, $result);
    }

    public function testDelete()
    {
        $cityMock = $this->createMock(City::class);
        $this->resourceModelMock->expects($this->once())->method('delete')->with($cityMock);
        $result = $this->cityRepository->delete($cityMock);
        $this->assertTrue($result);
    }

    public function testDeleteThrowsException()
    {
        $cityMock = $this->createMock(City::class);
        $this->resourceModelMock->expects($this->once())->method('delete')->with($cityMock)
            ->will($this->throwException(new \Exception('Error message')));
        $this->expectException(CouldNotDeleteException::class);
        $this->expectExceptionMessage('Could not delete the city: Error message');
        $this->cityRepository->delete($cityMock);
    }

    public function testSave()
    {
        $cityMock = $this->createMock(City::class);
        $this->resourceModelMock->expects($this->once())->method('save')->with($cityMock);
        $result = $this->cityRepository->save($cityMock);
        $this->assertTrue($result);
    }

    public function testSaveThrowsException()
    {
        $cityMock = $this->createMock(City::class);
        $this->resourceModelMock->expects($this->once())->method('save')
            ->with($cityMock)->will($this->throwException(new \Exception('Error message')));
        $this->expectException(CouldNotDeleteException::class);
        $this->expectExceptionMessage('Could not save the city: Error message');
        $this->cityRepository->save($cityMock);
    }

    public function testDeleteById()
    {
        $cityId = 123;
        $cityMock = $this->getMockBuilder(City::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getData'])
            ->getMock();
        $this->cityFactoryMock->method('create')->willReturn($cityMock);
        $this->resourceModelMock->expects($this->once())->method('load')->with($cityMock, $cityId);
        $this->resourceModelMock->expects($this->once())->method('delete')->with($cityMock);
        $result = $this->cityRepository->deleteById($cityId);
        $this->assertTrue($result);
    }
}
