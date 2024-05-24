<?php
/**
 * Madmytrych_NovaPost
 * MIT license
 */
declare(strict_types=1);

namespace Madmytrych\NovaPost\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface CityRepositoryInterface
{
    /**
     * Save city
     *
     * @param \Madmytrych\NovaPost\Api\Data\CityInterface $cityObject
     *
     * @return bool
     */
    public function save(Data\CityInterface $cityObject): bool;

    /**
     * Load by city id.
     *
     * @param string $cityId
     *
     * @return \Madmytrych\NovaPost\Api\Data\CityInterface
     */
    public function getByCityId(string $cityId): Data\CityInterface;

    /**
     * Get list by searchcriteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria): mixed;

    /**
     * Delete city.
     *
     * @param \Madmytrych\NovaPost\Api\Data\CityInterface $city
     *
     * @return bool
     */
    public function delete(Data\CityInterface $city): bool;

    /**
     * Delete by id
     *
     * @param int $cityId
     *
     * @return bool
     */
    public function deleteById(int $cityId): bool;
}
