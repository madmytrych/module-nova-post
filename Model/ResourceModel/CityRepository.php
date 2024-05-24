<?php
/**
 * Madmytrych_NovaPost
 * MIT license
 */
declare(strict_types=1);

namespace Madmytrych\NovaPost\Model\ResourceModel;

use Madmytrych\NovaPost\Api\CityRepositoryInterface;
use Madmytrych\NovaPost\Api\Data\CityInterface;
use Madmytrych\NovaPost\Api\Data\CitySearchResultsInterfaceFactory;
use Madmytrych\NovaPost\Model\CityFactory;
use Madmytrych\NovaPost\Model\ResourceModel\City\CollectionFactory;
use Madmytrych\NovaPost\Model\ResourceModel\City as ResourceModel;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsFactory;
use Magento\Framework\Exception\CouldNotDeleteException;

/**
 * City repository.
 *
 * CRUD operations for City entity
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.TooManyFields)
 */
class CityRepository implements CityRepositoryInterface
{
    /**
     * @param \Madmytrych\NovaPost\Model\ResourceModel\City $cityResourceModel
     * @param \Madmytrych\NovaPost\Model\CityFactory $cityFactory
     * @param \Madmytrych\NovaPost\Model\ResourceModel\City\CollectionFactory $cityCollectionFactory
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     * @param \Magento\Framework\Api\SearchResultsFactory $searchResultsFactory
     */
    public function __construct(
        private ResourceModel $cityResourceModel,
        private CityFactory $cityFactory,
        private CollectionFactory $cityCollectionFactory,
        private CollectionProcessorInterface $collectionProcessor,
        private SearchResultsFactory $searchResultsFactory
    ) {
    }

    /**
     * Get by Nova Post City Id field (not entity_id)
     *
     * @param string $cityId
     * @return \Madmytrych\NovaPost\Model\City
     */
    public function getByCityId(string $cityId): CityInterface
    {
        $cityModel = $this->cityFactory->create();
        $this->cityResourceModel->load($cityModel, $cityId, CityInterface::CITY_ID);

        return $cityModel;
    }

    /**
     * Get by entity_id
     *
     * @param int $id
     * @return \Madmytrych\NovaPost\Model\City
     */
    public function getById(int $id)
    {
        $cityModel = $this->cityFactory->create();
        $this->cityResourceModel->load($cityModel, $id);

        return $cityModel;
    }

    /**
     * Get by field/value
     *
     * @param mixed $value
     * @param string $field
     * @return \Madmytrych\NovaPost\Model\City
     */
    public function get($value, $field = null)
    {
        $cityModel = $this->cityFactory->create();
        $this->cityResourceModel->load($cityModel, $value, $field);

        return $cityModel;
    }

    /**
     * Load City data collection by given search criteria
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Magento\Framework\Api\SearchResults|mixed
     */
    public function getList(SearchCriteriaInterface $criteria): mixed
    {
        $collection = $this->cityCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * Delete City
     *
     * @param \Madmytrych\NovaPost\Api\Data\CityInterface $city
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(CityInterface $city): bool
    {
        try {
            $this->cityResourceModel->delete($city);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the city: %1', $exception->getMessage())
            );
        }
        return true;
    }

    /**
     * Delete City
     *
     * @param \Madmytrych\NovaPost\Api\Data\CityInterface $cityObject
     *
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function save(CityInterface $cityObject): bool
    {
        try {
            $this->cityResourceModel->save($cityObject);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not save the city: %1', $exception->getMessage())
            );
        }
        return true;
    }

    /**
     * Delete City by given City Identity
     *
     * @param int $cityId
     *
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById(int $cityId): bool
    {
        return $this->delete($this->getById($cityId));
    }
}
