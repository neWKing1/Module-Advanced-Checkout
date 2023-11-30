/*
 *
 *  * @author    Tigren Solutions <info@tigren.com>
 *  * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 *  * @license   Open Software License ("OSL") v. 3.0
 *
 */

define([
    'jquery',
    'Magento_Catalog/js/catalog-add-to-cart',
    'mage/translate'
], function ($, catalogAddToCart, __) {
    'use strict';

    return {
        /**
         * Override the add to cart action to prevent duplicates.
         * @param {Object} action
         * @returns {Object}
         */
        'catalogAddToCart': function (action) {
            // Retrieve cart items from local storage
            var cartItems = JSON.parse(localStorage.getItem('mage-cart-items')) || [];

            // Check if product is already in the cart
            var productId = action.product.sku;
            var productInCart = cartItems.find(function (item) {
                return item.sku === productId;
            });

            if (productInCart) {
                // Display error message if product is already added
                $.mage.message({
                    message: __('This product is already in your cart.'),
                    type: 'error'
                });

                // Prevent further default add to cart action
                return false;
            }

            // Proceed with the default add to cart action
            return catalogAddToCart.apply(this, arguments);
        }
    };
});
