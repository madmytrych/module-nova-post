<?php
/**
 * Madmytrych_NovaPost
 * MIT license
 */
declare(strict_types=1);

namespace Madmytrych\NovaPost\Model;

use Madmytrych\NovaPost\Api\Data\WarehouseInterface;
use Madmytrych\NovaPost\Model\ResourceModel\Warehouse as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class Warehouse extends AbstractModel implements WarehouseInterface
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'madmytrych_novapost_warehouse_model';

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
    public function getSiteKey(): ?string
    {
        return $this->getData(self::SITE_KEY);
    }

    /**
     * @inheritDoc
     */
    public function setSiteKey(?string $siteKey): void
    {
        $this->setData(self::SITE_KEY, $siteKey);
    }

    /**
     * @inheritDoc
     */
    public function getShortAddress(): ?string
    {
        return $this->getData(self::SHORT_ADDRESS);
    }

    /**
     * @inheritDoc
     */
    public function setShortAddress(?string $shortAddress): void
    {
        $this->setData(self::SHORT_ADDRESS, $shortAddress);
    }

    /**
     * @inheritDoc
     */
    public function getNumber(): ?int
    {
        return $this->getData(self::NUMBER) === null ? null
            : (int)$this->getData(self::NUMBER);
    }

    /**
     * @inheritDoc
     */
    public function setNumber(?int $number): void
    {
        $this->setData(self::NUMBER, $number);
    }

    /**
     * @inheritDoc
     */
    public function getCityRef(): ?string
    {
        return $this->getData(self::CITY_REF);
    }

    /**
     * @inheritDoc
     */
    public function setCityRef(?string $cityRef): void
    {
        $this->setData(self::CITY_REF, $cityRef);
    }

    /**
     * @inheritDoc
     */
    public function getCityDescription(): ?string
    {
        return $this->getData(self::CITY_DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setCityDescription(?string $cityDescription): void
    {
        $this->setData(self::CITY_DESCRIPTION, $cityDescription);
    }

    /**
     * @inheritDoc
     */
    public function getLongitude(): ?string
    {
        return $this->getData(self::LONGITUDE);
    }

    /**
     * @inheritDoc
     */
    public function setLongitude(?string $longitude): void
    {
        $this->setData(self::LONGITUDE, $longitude);
    }

    /**
     * @inheritDoc
     */
    public function getLatitude(): ?string
    {
        return $this->getData(self::LATITUDE);
    }

    /**
     * @inheritDoc
     */
    public function setLatitude(?string $latitude): void
    {
        $this->setData(self::LATITUDE, $latitude);
    }

    /**
     * @inheritDoc
     */
    public function getIndex(): ?int
    {
        return $this->getData(self::INDEX) === null ? null
            : (int)$this->getData(self::INDEX);
    }

    /**
     * @inheritDoc
     */
    public function setIndex(?int $index): void
    {
        $this->setData(self::INDEX, $index);
    }
}
