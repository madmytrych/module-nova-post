<?php
/**
 * Madmytrych_NovaPost
 * MIT license
 */
declare(strict_types=1);

namespace Madmytrych\NovaPost\Controller\Ajax\Search;

use Madmytrych\NovaPost\Api\WarehouseRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\UrlInterface;

class Warehouse implements HttpGetActionInterface, HttpPostActionInterface
{
    /**
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Madmytrych\NovaPost\Api\WarehouseRepositoryInterface $warehouseRepository
     * @param \Magento\Framework\Controller\ResultFactory $resultFactory
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Framework\UrlInterface $urlInterface
     * @param \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory
     * @param \Magento\Framework\UrlInterface $url
     */
    public function __construct(
        private SearchCriteriaBuilder $searchCriteriaBuilder,
        private WarehouseRepositoryInterface $warehouseRepository,
        private ResultFactory $resultFactory,
        private Http $request,
        private UrlInterface $urlInterface,
        private RedirectFactory $resultRedirectFactory,
        private UrlInterface $url
    ) {
    }

    /**
     * Returns suggested city/warehouse
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(): Json|ResultInterface|ResponseInterface|Redirect
    {
        if (!$this->request->isAjax()) {
            $resultRedirect = $this->resultRedirectFactory->create();
            $norouteUrl = $this->url->getUrl('noroute');
            return $resultRedirect->setUrl($norouteUrl);
        }
            /** @var \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria */
            $searchCriteria = $this->searchCriteriaBuilder
                ->addFilter('city_ref', $this->request->getParam('cityRef'))
                ->addFilter('description', '%' . $this->request->getParam('q') . '%', 'like')
                ->create();
            $items = $this->warehouseRepository->getList($searchCriteria)->getItems();
        $responseData = [];
        foreach ($items as $item) {
            $responseData[] = $item->getData();
        }
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData($responseData);
        return $resultJson;
    }
}
