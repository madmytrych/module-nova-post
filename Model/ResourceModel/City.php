<?php
/**
 * Madmytrych_NovaPost
 * MIT license
 */
declare(strict_types=1);

namespace Madmytrych\NovaPost\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Madmytrych\NovaPost\Api\Data\CityInterface;

class City extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'madmytrych_novapost_city_resource_model';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(CityInterface::CITY_TABLE_NAME, CityInterface::ENTITY_ID);
        $this->_useIsObjectNew = true;
    }
}
