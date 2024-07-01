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
use Madmytrych\NovaPost\Api\CityRepositoryInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Request\Http;
use Magento\Framework\UrlInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\Redirect;
use Madmytrych\NovaPost\Controller\Ajax\Search\City;

class CityTest extends TestCase
{
    /**
     * @var \Madmytrych\NovaPost\Api\CityRepositoryInterface
     */
    private CityRepositoryInterface $cityRepository;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

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
     * @var \Madmytrych\NovaPost\Controller\Ajax\Search\City
     */
    private City $cityController;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->searchCriteriaBuilder = $this->createMock(SearchCriteriaBuilder::class);
        $this->cityRepository = $this->createMock(CityRepositoryInterface::class);
        $this->resultFactory = $this->createMock(ResultFactory::class);
        $this->request = $this->createMock(Http::class);
        $this->urlInterface = $this->createMock(UrlInterface::class);
        $this->resultRedirectFactory = $this->createMock(RedirectFactory::class);
        $this->url = $this->createMock(UrlInterface::class);
        $this->cityController = new City(
            $this->searchCriteriaBuilder,
            $this->cityRepository,
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
        $result = $this->cityController->execute();
        $this->assertInstanceOf(Redirect::class, $result);
    }

    /**
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function testExecuteCitySearch()
    {
        $this->request->method('isAjax')->willReturn(true);
        $this->request->method('getParam')->with('q', null)->willReturn('query');
        $searchCriteria = $this->createMock(SearchCriteriaInterface::class);
        $this->searchCriteriaBuilder->method('addFilter')->willReturnSelf();
        $this->searchCriteriaBuilder->method('create')->willReturn($searchCriteria);
        $cityList = $this->createMock(SearchResultsInterface::class);
        $this->cityRepository->method('getList')->willReturn($cityList);
        $cityList->method('getItems')->willReturn([]);
        $resultJson = $this->createMock(Json::class);
        $this->resultFactory->method('create')->with(ResultFactory::TYPE_JSON)->willReturn($resultJson);
        $resultJson->expects($this->once())->method('setData')->with([]);
        $result = $this->cityController->execute();
        $this->assertInstanceOf(Json::class, $result);
    }
}
