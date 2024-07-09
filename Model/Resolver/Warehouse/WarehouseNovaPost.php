<?php
/**
 * Madmytrych_NovaPost
 * MIT license
 */
declare(strict_types=1);

namespace Madmytrych\NovaPost\Model\Resolver\Warehouse;

use Madmytrych\NovaPost\Api\WarehouseRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Query\ResolverInterface;

class WarehouseNovaPost implements ResolverInterface
{

    /**
     * @inheritdoc
     */
    public function __construct(
        private SearchCriteriaBuilder $searchCriteriaBuilder,
        private WarehouseRepositoryInterface $warehouseRepository
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
        $productsData = $this->getWarehouseListData($this->getCityRef($args), $this->getDescription($args));
        return ['warehouses' => $productsData];
    }

    /**
     * Get city ref string
     *
     * @param array $args
     * @return string
     * @throws GraphQlInputException
     */
    private function getCityRef(array $args): string
    {
        if (!is_string($args['cityRef']) || empty($args['cityRef'])) {
            throw new GraphQlInputException(__('"cityRef" of warehouses should be specified'));
        }

        return $args['cityRef'];
    }

    /**
     * Get warehouse description
     *
     * @param array $args
     * @return string
     * @throws GraphQlInputException
     */
    private function getDescription(array $args): string
    {
        if (!is_string($args['description']) || empty($args['description'])) {
            throw new GraphQlInputException(__('"description" of warehouses should be specified'));
        }

        return $args['description'];
    }

    /**
     * Get warehouses list
     *
     * @param string $cityRef
     * @param string $description
     * @return array
     * @throws \Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException
     */
    private function getWarehouseListData(string $cityRef, string $description): array
    {
        try {
            /** @var \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria */
            $searchCriteria = $this->searchCriteriaBuilder
                ->addFilter('city_ref', $cityRef)
                ->addFilter('description', '%' . $description . '%', 'like')
                ->create();
            $items = $this->warehouseRepository->getList($searchCriteria)->getItems();
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
