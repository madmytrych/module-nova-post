<?php
/**
 * Madmytrych_NovaPost
 * MIT license
 */
declare(strict_types=1);

namespace Madmytrych\NovaPost\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\Module\Manager;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Config
{
    /**
     * Nova Post API public constants
     */
    public const API_NP_KEY = 'apiKey';
    public const API_NP_METHOD_PROPERTIES = 'methodProperties';
    public const API_NP_MODEL_ADDRESS = 'Address';
    public const API_NP_MODEL_NAME = 'modelName';
    public const API_NP_CALLED_METHOD = 'calledMethod';
    public const API_NP_METHOD_WAREHOUSES = 'getWarehouses';
    public const API_NP_METHOD_CITIES = 'getCities';
    public const API_NP_PAGE = 'Page';
    public const CONFIG_PATH_ACTIVE = 'carriers/madmytrych_novapost/active';
    public const CONFIG_PATH_API_URL = 'carriers/madmytrych_novapost/api_url';
    public const CONFIG_PATH_API_KEY = 'carriers/madmytrych_novapost/api_key';

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Encryption\EncryptorInterface $encryptor
     */
    public function __construct(
        private ScopeConfigInterface $scopeConfig,
        private Manager $moduleManager,
        private StoreManagerInterface $storeManager,
        private EncryptorInterface $encryptor
    ) {
    }

    /**
     * Is enabled?
     *
     * @param string|null $code
     * @return bool
     */
    public function isEnabled(string $code = null): bool
    {
        $path = self::CONFIG_PATH_ACTIVE;
        if ($code == null) {
            return (bool)$this->getConfigValue($path);
        }
        return (bool)$this->getConfigValue($path, ScopeInterface::SCOPE_WEBSITE, $code);
    }

    /**
     * Returns decrypted API key
     *
     * @param string|null $code
     *
     * @return string
     */
    public function getApiKey(string $code = null): string
    {
        $path = self::CONFIG_PATH_API_KEY;
        if ($code == null) {
            return $this->encryptor->decrypt($this->getConfigValue($path));
        }
        return $this->encryptor->decrypt($this->getConfigValue($path, ScopeInterface::SCOPE_WEBSITE, $code));
    }

    /**
     * Return API url
     *
     * @param string|null $code
     *
     * @return string
     */
    public function getApiUrl(string $code = null): string
    {
        $path = self::CONFIG_PATH_API_URL;
        if ($code == null) {
            return (string)$this->getConfigValue($path);
        }
        return (string)$this->getConfigValue($path, ScopeInterface::SCOPE_WEBSITE, $code);
    }

    /**
     * Gets config value
     *
     * @param string $path
     * @param string $scope
     * @param string|null $code
     *
     * @return string|null
     */
    private function getConfigValue(
        string $path,
        string $scope = ScopeInterface::SCOPE_STORE,
        string $code = null
    ): ?string {
        return $this->scopeConfig->getValue(
            $path,
            $scope,
            $code
        );
    }
}
