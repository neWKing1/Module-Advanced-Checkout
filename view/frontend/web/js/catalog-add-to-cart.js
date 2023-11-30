define([
    'jquery',
    'mage/translate',
    'jquery/ui',
    'mage/url',
    'Magento_Catalog/js/product/view/product-ids-resolver',
], function ($, $t,alert, urlBuilder, idsResolver) {
    'use strict';

    return function (widget) {
        console.log('catalog-add-to-cart-mixin');
        $.widget('mage.catalogAddToCart', widget, {
            /**
             * Handler for the form 'submit' event
             *
             * @param {jQuery} form
             */
            submitForm: function (form) {
                var productIds = idsResolver(form)[0];
                $.ajax({
                    url: urlBuilder.build("tigren/cart/addtocart"),
                    method: "POST",
                    data: {
                        id: productIds,
                    },
                    success: function (response) {
                        console.log(response)
                        if(response.popup != true) {
                            // this._super();
                        }
                    }
                })
                this._super(form);
            },
        });
        return $.mage.catalogAddToCart;
    }
});
