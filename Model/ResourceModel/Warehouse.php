<?php
/**
 * Madmytrych_NovaPost
 * MIT license
 */
declare(strict_types=1);

namespace Madmytrych\NovaPost\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Madmytrych\NovaPost\Api\Data\WarehouseInterface;

class Warehouse extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'madmytrych_novapost_warehouse_resource_model';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(WarehouseInterface::WAREHOUSE_TABLE_NAME, WarehouseInterface::WAREHOUSE_ID);
        $this->_useIsObjectNew = true;
    }
}
