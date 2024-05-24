/**
 * Madmytrych_NovaPost
 * MIT license
 */
var config = {
    'config': {
        'mixins': {
            'Magento_Checkout/js/view/shipping': {
                'Madmytrych_NovaPost/js/view/shipping-mixin': true
            }
        }
    },
    map: {
        '*': {
            novaPostSearch: 'Madmytrych_NovaPost/js/form/nova-post-search'
        }
    }
}
