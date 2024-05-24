/**
 * Madmytrych_NovaPost
 * MIT license
 */
define([
    'Magento_Ui/js/form/element/abstract',
    'Madmytrych_NovaPost/js/model/shipping-nova-post',
    'ko',
    'jquery',
    'mage/translate'
], function (
    ComponentAbstract,
    novaPost,
    ko,
    $,
    $t
) {

    return ComponentAbstract.extend({
        defaults: {
            labelNP: 'Choose warehouse',
            cityRef: ko.observable(novaPost.cityRef),
            isNovaPostMethodSelected: novaPost.isNovaPostMethodSelected,
            streetName: ko.observable(novaPost.streetName),
            streetRef: ko.observable(novaPost.streetRef),
            isStreetChosen: novaPost.isStreetChosen,
            warehouses: ko.observableArray([])
        },
        initialize: function () {
            var self = this;
            this._super();
            novaPost.streetName.subscribe(function (value) {
                self.value(value);
            });
            novaPost.isNovaPostMethodSelected.subscribe((value) => {
                if (value === false) {
                    $("fieldset.street span").text($t(self.label));
                    this.reset('');
                } else {
                    $("fieldset.street span").text($t(self.labelNP));
                }
            });
        },
    });
});
