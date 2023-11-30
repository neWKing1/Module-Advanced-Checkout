define([
    'jquery',
    'mage/translate',
    'jquery/ui',
    'mage/url',
    'Magento_Catalog/js/product/view/product-ids-resolver',
], function ($, $t, alert, urlBuilder, idsResolver) {
    'use strict';

    return function (widget) {
        // var self = this;
        console.log('catalog-add-to-cart-mixin');
        $.widget('mage.catalogAddToCart', widget, {

            /**
             * Handler for the form 'submit' event
             *
             * @param {jQuery} form
             */
            submitForm: function (form) {
                var productIds = idsResolver(form)[0];
                var self = this;
                console.log(self);
                // debugger;
                $.ajax({
                    url: urlBuilder.build("tigren/cart/addtocart"),
                    method: "POST",
                    data: {
                        id: productIds,
                    },
                    success: function (response) {
                        if (!response.popup) {
                            // Check if _super is defined before calling it
                            // self._super(form);
                            // debugger;
                            self.ajaxSubmit(form);
                        }
                    }
                });
            },
            ajaxSubmit: function (form) {
                return this._super(form);
            }
        });

        return $.mage.catalogAddToCart;
    };
});
