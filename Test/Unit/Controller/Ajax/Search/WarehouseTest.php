<?php
/**
 * Madmytrych_NovaPost
 * MIT license
 */
declare(strict_types=1);

namespace Madmytrych\NovaPost\Test\Unit\Controller\Ajax\Search;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use PHPUnit\Framework\TestCase;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Madmytrych\NovaPost\Api\WarehouseRepositoryInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Request\Http;
use Magento\Framework\UrlInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\Redirect;
use Madmytrych\NovaPost\Controller\Ajax\Search\Warehouse;

class WarehouseTest extends TestCase
{
    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @var \Madmytrych\NovaPost\Api\WarehouseRepositoryInterface
     */
    private WarehouseRepositoryInterface $warehouseRepository;

    /**
     * @var \Magento\Framework\Controller\ResultFactory
     */
    private ResultFactory $resultFactory;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    private Http $request;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    private UrlInterface $urlInterface;

    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory
     */
    private RedirectFactory $resultRedirectFactory;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    private UrlInterface $url;

    /**
     * @var \Madmytrych\NovaPost\Controller\Ajax\Search\Warehouse
     */
    private Warehouse $warehouseController;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->searchCriteriaBuilder = $this->createMock(SearchCriteriaBuilder::class);
        $this->warehouseRepository = $this->createMock(WarehouseRepositoryInterface::class);
        $this->resultFactory = $this->createMock(ResultFactory::class);
        $this->request = $this->createMock(Http::class);
        $this->urlInterface = $this->createMock(UrlInterface::class);
        $this->resultRedirectFactory = $this->createMock(RedirectFactory::class);
        $this->url = $this->createMock(UrlInterface::class);
        $this->warehouseController = new Warehouse(
            $this->searchCriteriaBuilder,
            $this->warehouseRepository,
            $this->resultFactory,
            $this->request,
            $this->urlInterface,
            $this->resultRedirectFactory,
            $this->url
        );
    }

    /**
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function testExecuteNonAjaxRequest()
    {
        $this->request->method('isAjax')->willReturn(false);
        $resultRedirect = $this->createMock(Redirect::class);
        $this->resultRedirectFactory->method('create')->willReturn($resultRedirect);
        $this->url->method('getUrl')->willReturn('noroute');
        $resultRedirect->expects($this->once())->method('setUrl')->with('noroute')->willReturnSelf();
        $result = $this->warehouseController->execute();
        $this->assertInstanceOf(Redirect::class, $result);
    }

    /**
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function testExecuteWarehouseSearch()
    {
        $this->request->method('isAjax')->willReturn(true);
        $this->request->method('getParam')->willReturnMap([
            ['cityRef', null, 'cityRefValue'],
            ['q', null, 'query']
        ]);
        $searchCriteria = $this->createMock(SearchCriteriaInterface::class);
        $this->searchCriteriaBuilder->method('addFilter')->willReturnSelf();
        $this->searchCriteriaBuilder->method('create')->willReturn($searchCriteria);
        $warehouseList = $this->createMock(SearchResultsInterface::class);
        $this->warehouseRepository->method('getList')->willReturn($warehouseList);
        $warehouseList->method('getItems')->willReturn([]);
        $resultJson = $this->createMock(Json::class);
        $this->resultFactory->method('create')->with(ResultFactory::TYPE_JSON)->willReturn($resultJson);
        $resultJson->expects($this->once())->method('setData')->with([]);
        $result = $this->warehouseController->execute();
        $this->assertInstanceOf(Json::class, $result);
    }
}
