<?php
/**
 * Madmytrych_NovaPost
 * MIT license
 */
declare(strict_types=1);

namespace Madmytrych\NovaPost\Model;

use Madmytrych\NovaPost\Api\Data\CityInterface;
use Madmytrych\NovaPost\Model\ResourceModel\City as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class City extends AbstractModel implements CityInterface
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'madmytrych_novapost_city_model';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @inheritDoc
     */
    public function getCityId(): ?int
    {
        return $this->getData(self::CITY_ID) === null ? null
            : (int)$this->getData(self::CITY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setCityId(?int $cityId): void
    {
        $this->setData(self::CITY_ID, $cityId);
    }

    /**
     * @inheritDoc
     */
    public function getRef(): ?string
    {
        return $this->getData(self::REF);
    }

    /**
     * @inheritDoc
     */
    public function setRef(?string $ref): void
    {
        $this->setData(self::REF, $ref);
    }

    /**
     * @inheritDoc
     */
    public function getSettlementType(): ?string
    {
        return $this->getData(self::SETTLEMENT_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setSettlementType(?string $settlementType): void
    {
        $this->setData(self::SETTLEMENT_TYPE, $settlementType);
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): ?string
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setDescription(?string $description): void
    {
        $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * @inheritDoc
     */
    public function getArea(): ?string
    {
        return $this->getData(self::AREA);
    }

    /**
     * @inheritDoc
     */
    public function setArea(?string $area): void
    {
        $this->setData(self::AREA, $area);
    }

    /**
     * @inheritDoc
     */
    public function getAreaDescription(): ?string
    {
        return $this->getData(self::AREA_DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setAreaDescription(?string $areaDescription): void
    {
        $this->setData(self::AREA_DESCRIPTION, $areaDescription);
    }

    /**
     * @inheritDoc
     */
    public function getSettlementTypeDescription(): ?string
    {
        return $this->getData(self::SETTLEMENT_TYPE_DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setSettlementTypeDescription(?string $settlementTypeDescription): void
    {
        $this->setData(self::SETTLEMENT_TYPE_DESCRIPTION, $settlementTypeDescription);
    }
}
