/**
 * Madmytrych_NovaPost
 * MIT license
 */
define([
    'ko',
    'Magento_Checkout/js/model/quote',
], function (
    ko,
    quote,
) {
    'use strict';
    var cityName = ko.observable(''),
        regionName = ko.observable(''),
        streetName = ko.observable(''),
        cityRef = ko.observable(''),
        streetRef = ko.observable(''),
        isNovaPostMethodSelected = ko.computed(function () {
            // this.resetVars();
            return quote.shippingMethod() ?
                quote.shippingMethod()['method_code'] === 'madmytrych_novapost' :
                false
        }),

        isCityChosen = ko.computed(function () {
            return !cityName().length > 0;
        }), isStreetChosen = ko.computed(function () {
            return streetName();
        });
        return {
            isNovaPostMethodSelected: isNovaPostMethodSelected,
            regionName: regionName,
            cityName: cityName,
            cityRef: cityRef,
            streetRef: streetRef,
            streetName: streetName,
            isCityChosen: isCityChosen,
            isStreetChosen: isStreetChosen,
    };

});
