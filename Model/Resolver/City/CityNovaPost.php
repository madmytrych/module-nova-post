<?php
/**
 * Madmytrych_NovaPost
 * MIT license
 */
declare(strict_types=1);

namespace Madmytrych\NovaPost\Model\Resolver\City;

use Madmytrych\NovaPost\Api\CityRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Query\ResolverInterface;

class CityNovaPost implements ResolverInterface
{
    /**
     * @inheritdoc
     */
    public function __construct(
        private SearchCriteriaBuilder $searchCriteriaBuilder,
        private CityRepositoryInterface $cityRepository

    ) {
    }

    /**
     * Resolver
     *
     * @param \Magento\Framework\GraphQl\Config\Element\Field $field
     * @param $context
     * @param \Magento\Framework\GraphQl\Schema\Type\ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     * @throws \Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException
     * @throws \Magento\Framework\GraphQl\Exception\GraphQlInputException
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $productsData = $this->getCityListData($this->getCityName($args));
        return ['cities' => $productsData];
    }

    /**
     * Get city name
     *
     * @param array $args
     * @return string
     * @throws GraphQlInputException
     */
    private function getCityName(array $args): string
    {
        if (!is_string($args['city']) || empty($args['city'])) {
            throw new GraphQlInputException(__('"city name(`description`)" of cities should be specified'));
        }

        return $args['city'];
    }

    /**
     * Get city list
     *
     * @param string $query
     * @return array
     * @throws \Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException
     */
    private function getCityListData(string $query): array
    {
        try {
            /** @var \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria */
            $searchCriteria = $this->searchCriteriaBuilder
                ->addFilter('description', '%' . $query . '%', 'like')
                ->create();
            $items = $this->cityRepository->getList($searchCriteria)->getItems();
            $responseData = [];
            foreach ($items as $item) {
                $responseData[] = $item->getData();
            }
        } catch (GraphQlNoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        return $responseData;
    }
}
