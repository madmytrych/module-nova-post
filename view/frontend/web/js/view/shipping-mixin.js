/**
 * Madmytrych_NovaPost
 * MIT license
 */
define([], function () {
    'use strict';

    return function (Component) {
        return Component.extend({
            defaults: {
                template: 'Madmytrych_NovaPost/shipping',
                shippingMethodItemTemplate: 'Madmytrych_NovaPost/shipping-address/shipping-method-item',
            },
        });
    }
});
