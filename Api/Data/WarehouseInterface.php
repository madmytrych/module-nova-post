<?php
/**
 * Madmytrych_NovaPost
 * MIT license
 */
declare(strict_types=1);

namespace Madmytrych\NovaPost\Api\Data;

interface WarehouseInterface
{
    public const WAREHOUSE_TABLE_NAME = 'madmytrych_novapost_warehouse';
    public const WAREHOUSE_ID = "entity_id";
    public const REF = "ref";
    public const DESCRIPTION = "description";
    public const SETTLEMENT_TYPE = "settlement_type";
    public const SITE_KEY = "site_key";
    public const SHORT_ADDRESS = "short_address";
    public const NUMBER = "number";
    public const CITY_REF = "city_ref";
    public const CITY_DESCRIPTION = "city_description";
    public const LONGITUDE = "longitude";
    public const LATITUDE = "latitude";
    public const INDEX = "index";

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
     * Getter for SiteKey.
     *
     * @return string|null
     */
    public function getSiteKey(): ?string;

    /**
     * Setter for SiteKey.
     *
     * @param string|null $siteKey
     *
     * @return void
     */
    public function setSiteKey(?string $siteKey): void;

    /**
     * Getter for ShortAddress.
     *
     * @return string|null
     */
    public function getShortAddress(): ?string;

    /**
     * Setter for ShortAddress.
     *
     * @param string|null $shortAddress
     *
     * @return void
     */
    public function setShortAddress(?string $shortAddress): void;

    /**
     * Getter for Number.
     *
     * @return int|null
     */
    public function getNumber(): ?int;

    /**
     * Setter for Number.
     *
     * @param int|null $number
     *
     * @return void
     */
    public function setNumber(?int $number): void;

    /**
     * Getter for CityRef.
     *
     * @return string|null
     */
    public function getCityRef(): ?string;

    /**
     * Setter for CityRef.
     *
     * @param string|null $cityRef
     *
     * @return void
     */
    public function setCityRef(?string $cityRef): void;

    /**
     * Getter for CityDescription.
     *
     * @return string|null
     */
    public function getCityDescription(): ?string;

    /**
     * Setter for CityDescription.
     *
     * @param string|null $cityDescription
     *
     * @return void
     */
    public function setCityDescription(?string $cityDescription): void;

    /**
     * Getter for Longitude.
     *
     * @return string|null
     */
    public function getLongitude(): ?string;

    /**
     * Setter for Longitude.
     *
     * @param string|null $longitude
     *
     * @return void
     */
    public function setLongitude(?string $longitude): void;

    /**
     * Getter for Latitude.
     *
     * @return string|null
     */
    public function getLatitude(): ?string;

    /**
     * Setter for Latitude.
     *
     * @param string|null $latitude
     *
     * @return void
     */
    public function setLatitude(?string $latitude): void;

    /**
     * Getter for Index.
     *
     * @return int|null
     */
    public function getIndex(): ?int;

    /**
     * Setter for Index.
     *
     * @param int|null $index
     *
     * @return void
     */
    public function setIndex(?int $index): void;
}
