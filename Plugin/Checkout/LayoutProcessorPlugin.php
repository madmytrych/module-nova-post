<?php
/**
 * Madmytrych_NovaPost
 * MIT license
 */
declare(strict_types=1);

namespace Madmytrych\NovaPost\Plugin\Checkout;

use Magento\Checkout\Block\Checkout\LayoutProcessor;

class LayoutProcessorPlugin
{
    /**
     * Inserts Component into checkout
     *
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     *
     * @return array
     */
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array $jsLayout
    ) {
        if (isset($jsLayout['components']['checkout']
            ['children']['steps']['children']['shipping-step']
            ['children']['shippingAddress']
            ['children']['shipping-address-fieldset']
            ['children']['street']
            ['children'])) {
            $streetField = reset($jsLayout['components']['checkout']
            ['children']['steps']
            ['children']['shipping-step']
            ['children']['shippingAddress']
            ['children']['shipping-address-fieldset']
            ['children']['street']['children']);
            $streetField['component'] = 'Madmytrych_NovaPost/js/form/element/input-street';
            $streetField['config']['elementTmpl'] = 'Madmytrych_NovaPost/form/element/street-input';
            $jsLayout['components']['checkout']['children']
            ['steps']['children']['shipping-step']['children']
            ['shippingAddress']['children']['shipping-address-fieldset']
            ['children']['street']
            ['children'] = [$streetField];
        }
        return $jsLayout;
    }
}
