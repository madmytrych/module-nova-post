<?php
/**
 * Madmytrych_NovaPost
 * MIT license
 */
declare(strict_types=1);

namespace Madmytrych\NovaPost\Api\Data;

interface CityInterface
{
    public const CITY_TABLE_NAME = 'madmytrych_novapost_city';
    public const ENTITY_ID = "entity_id";
    public const CITY_ID = "city_id";
    public const REF = "ref";
    public const SETTLEMENT_TYPE = "settlement_type";
    public const DESCRIPTION = "description";
    public const AREA_DESCRIPTION = "area_description";
    public const AREA = "area";
    public const SETTLEMENT_TYPE_DESCRIPTION = "settlement_type_description";

    /**
     * Getter for CityId.
     *
     * @return int|null
     */
    public function getCityId(): ?int;

    /**
     * Setter for CityId.
     *
     * @param int|null $cityId
     *
     * @return void
     */
    public function setCityId(?int $cityId): void;

    /**
     * Getter for Ref.
     *
     * @return string|null
     */
    public function getRef(): ?string;

    /**
     * Setter for Ref.
     *
     * @param string|null $ref
     *
     * @return void
     */
    public function setRef(?string $ref): void;

    /**
     * Getter for SettlementType.
     *
     * @return string|null
     */
    public function getSettlementType(): ?string;

    /**
     * Setter for SettlementType.
     *
     * @param string|null $settlementType
     *
     * @return void
     */
    public function setSettlementType(?string $settlementType): void;

    /**
     * Getter for Description.
     *
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * Setter for Description.
     *
     * @param string|null $description
     *
     * @return void
     */
    public function setDescription(?string $description): void;

    /**
     * Getter for Area.
     *
     * @return string|null
     */
    public function getArea(): ?string;

    /**
     * Setter for Area.
     *
     * @param string|null $area
     *
     * @return void
     */
    public function setArea(?string $area): void;

    /**
     * Getter for Area Description.
     *
     * @return string|null
     */
    public function getAreaDescription(): ?string;

    /**
     * Setter for Area Description .
     *
     * @param string|null $areaDescription
     *
     * @return void
     */
    public function setAreaDescription(?string $areaDescription): void;

    /**
     * Getter for SettlementTypeDescription.
     *
     * @return string|null
     */
    public function getSettlementTypeDescription(): ?string;

    /**
     * Setter for SettlementTypeDescription.
     *
     * @param string|null $settlementTypeDescription
     *
     * @return void
     */
    public function setSettlementTypeDescription(?string $settlementTypeDescription): void;
}
