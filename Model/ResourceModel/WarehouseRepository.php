<?php
/**
 * Madmytrych_NovaPost
 * MIT license
 */
declare(strict_types=1);

namespace Madmytrych\NovaPost\Model\ResourceModel;

use Madmytrych\NovaPost\Api\WarehouseRepositoryInterface;
use Madmytrych\NovaPost\Api\Data\WarehouseInterface;
use Madmytrych\NovaPost\Api\Data\WarehouseSearchResultsInterfaceFactory;
use Madmytrych\NovaPost\Model\ResourceModel\Warehouse\CollectionFactory;
use Madmytrych\NovaPost\Model\WarehouseFactory;
use Madmytrych\NovaPost\Model\ResourceModel\Warehouse as ResourceModel;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\Api\SearchResultsFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Madmytrych\NovaPost\Model\Warehouse as WarehouseModel;

class WarehouseRepository implements WarehouseRepositoryInterface
{

    /**
     * @param \Madmytrych\NovaPost\Model\ResourceModel\Warehouse $warehouseResourceModel
     * @param \Madmytrych\NovaPost\Model\WarehouseFactory $warehouseFactory
     * @param \Madmytrych\NovaPost\Model\ResourceModel\Warehouse\CollectionFactory $warehouseCollectionFactory
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     * @param \Magento\Framework\Api\SearchResultsFactory $searchResultsFactory
     */
    public function __construct(
        private ResourceModel $warehouseResourceModel,
        private WarehouseFactory $warehouseFactory,
        private CollectionFactory $warehouseCollectionFactory,
        private CollectionProcessorInterface $collectionProcessor,
        private SearchResultsFactory $searchResultsFactory
    ) {
    }

    /**
     * Get warehouse by entity id.
     *
     * @param int $entityId
     *
     * @return \Madmytrych\NovaPost\Model\Warehouse
     */
    public function getById(int $entityId): WarehouseModel
    {
        $warehouseModel = $this->warehouseFactory->create();
        $this->warehouseResourceModel->load($warehouseModel, $entityId);

        return $warehouseModel;
    }

    /**
     * Get warehouse by site key.
     *
     * @param string $siteKey
     *
     * @return \Madmytrych\NovaPost\Model\Warehouse
     */
    public function getByWarehouseSiteKey($siteKey): WarehouseModel
    {
        $warehouseModel = $this->warehouseFactory->create();
        $this->warehouseResourceModel->load($warehouseModel, $siteKey, WarehouseInterface::SITE_KEY);

        return $warehouseModel;
    }

    /**
     * Get by field/value
     *
     * @param string $value
     * @param string|null $field
     *
     * @return \Madmytrych\NovaPost\Model\Warehouse
     */
    public function get(string $value, string $field = null): WarehouseModel
    {
        $warehouseModel = $this->warehouseFactory->create();
        $this->warehouseResourceModel->load($warehouseModel, $value, $field);

        return $warehouseModel;
    }

    /**
     * Load Warehouse data collection by given search criteria
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @return \Magento\Framework\Api\SearchResults
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResults
    {
        $collection = $this->warehouseCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Delete Warehouse
     *
     * @param \Madmytrych\NovaPost\Api\Data\WarehouseInterface $warehouse
     *
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(WarehouseInterface $warehouse): bool
    {
        try {
            $this->warehouseResourceModel->delete($warehouse);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the warehouse: %1', $exception->getMessage())
            );
        }
        return true;
    }

    /**
     * Delete Warehouse
     *
     * @param \Madmytrych\NovaPost\Api\Data\WarehouseInterface $warehouse
     *
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function save(WarehouseInterface $warehouse): bool
    {
        try {
            $this->warehouseResourceModel->save($warehouse);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not save the warehouse: %1', $exception->getMessage())
            );
        }
        return true;
    }

    /**
     * Delete Warehouse by given Warehouse Identity
     *
     * @param int $warehouseId
     *
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $warehouseId): bool
    {
        return $this->delete($this->getById($warehouseId));
    }
}
