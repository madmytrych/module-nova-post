<?php
/**
 * Madmytrych_NovaPost
 * MIT license
 */
declare (strict_types = 1);

namespace Madmytrych\NovaPost\Model\Resolver\Warehouse;

use Madmytrych\NovaPost\Api\Data\WarehouseInterface;
use Magento\Framework\GraphQl\Query\Resolver\IdentityInterface;

class WarehouseNovaPostIdentity implements IdentityInterface
{
    /**
     * @var string
     */
    private $cacheTag = WarehouseInterface::WAREHOUSE_TABLE_NAME;

    /**
     * Get identities
     *
     * @param array $resolvedData
     * @return string[]
     */
    public function getIdentities(array $resolvedData): array
    {
        $ids = [];
        $items = $resolvedData['warehouses'] ?? [];
        foreach ($items as $item) {
            if (is_array($item) && !empty($item[WarehouseInterface::NUMBER])) {
                $ids[] = sprintf('%s_%s', $this->cacheTag, $item[WarehouseInterface::NUMBER]);
                $ids[] = sprintf('%s_%s', $this->cacheTag, $item[WarehouseInterface::CITY_REF]);
            }
        }
        if (!empty($ids)) {
            array_unshift($ids, $this->cacheTag);
        }
        return $ids;
    }
}
