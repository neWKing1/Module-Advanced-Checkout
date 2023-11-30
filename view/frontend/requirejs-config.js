/*
 *
 *  * @author    Tigren Solutions <info@tigren.com>
 *  * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 *  * @license   Open Software License ("OSL") v. 3.0
 *
 */

var config = {
    // "map": {
    //     "*": {
    //         "Magento_Catalog/js/catalog-add-to-cart": "Tigren_AdvancedCheckout/js/prevent-duplicate-cart"
    //     }
    // },
    paths: {
        'scriptByDuongDh': "Tigren_AdvancedCheckout/example"
    },
    config: {
        mixins: {
            'Magento_Catalog/js/catalog-add-to-cart': {
                'Tigren_AdvancedCheckout/js/catalog-add-to-cart': true
            },
            'Magento_Swatches/js/swatch-renderer': {
                'Tigren_AdvancedCheckout/js/swatch-renderer-mixin': true
            }
        }
    }

};
