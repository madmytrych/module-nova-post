/**
 * Madmytrych_NovaPost
 * MIT license
 */
define([
    'Magento_Ui/js/form/element/abstract',
    'Madmytrych_NovaPost/js/model/shipping-nova-post',
    'ko',
    'jquery'
], function (
    ComponentAbstract,
    novaPost,
    ko,
    $
) {

    return ComponentAbstract.extend({
        defaults: {
            labelNP: 'Choose city',
            isNovaPostMethodSelected: novaPost.isNovaPostMethodSelected,
            cityName: ko.observable(novaPost.cityName),
            cityRef: ko.observable(novaPost.cityRef),
            regionName: ko.observable(novaPost.regionName),
            isCityChosen: novaPost.isCityChosen
        },
        initialize: function () {
            var self = this;
            this._super();
            novaPost.cityName.subscribe((value) => {
                this.value(value);
            });
        }
    });
});
