<?php
/**
 * Madmytrych_NovaPost
 * MIT license
 */
declare(strict_types=1);

namespace Madmytrych\NovaPost\Api;

interface WarehouseRepositoryInterface
{
    /**
     * Save warehouse.
     *
     * @param \Madmytrych\NovaPost\Api\Data\WarehouseInterface $warehouse
     */
    public function save(Data\WarehouseInterface $warehouse);

    /**
     * Retrieve warehouse by entity id.
     *
     * @param int $entityId
     */
    public function getById(int $entityId);

    /**
     * Retrieve warehouse by site key.
     *
     * @param int $siteKey
     */
    public function getByWarehouseSiteKey(int $siteKey);

    /**
     * Retrieve warehouses matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchSearchCriteria
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchSearchCriteria);

    /**
     * Delete warehouse.
     *
     * @param \Madmytrych\NovaPost\Api\Data\WarehouseInterface $warehouse
     */
    public function delete(Data\WarehouseInterface $warehouse);

    /**
     * Delete warehouse by ID.
     *
     * @param int $warehouseId
     */
    public function deleteById(int $warehouseId);
}
