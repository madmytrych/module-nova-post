<?php
/**
 * Madmytrych_NovaPost
 * MIT license
 */
declare (strict_types = 1);

namespace Madmytrych\NovaPost\Model\Resolver\City;

use Madmytrych\NovaPost\Api\Data\CityInterface;
use Magento\Framework\GraphQl\Query\Resolver\IdentityInterface;

class CityNovaPostIdentity implements IdentityInterface
{
    /**
     * @var string
     */
    private $cacheTag = CityInterface::CITY_TABLE_NAME;


    /**
     * Get identities
     *
     * @param array $resolvedData
     * @return string[]
     */
    public function getIdentities(array $resolvedData): array
    {
        $ids = [];
        $items = $resolvedData['cities'] ?? [];
        foreach ($items as $item) {
            if (is_array($item) && !empty($item[CityInterface::CITY_ID])) {
                $ids[] = sprintf('%s_%s', $this->cacheTag, $item[CityInterface::CITY_ID]);
                $ids[] = sprintf('%s_%s', $this->cacheTag, $item[CityInterface::REF]);
            }
        }
        if (!empty($ids)) {
            array_unshift($ids, $this->cacheTag);
        }
        return $ids;
    }
}
