/*
 *
 *  * @author    Tigren Solutions <info@tigren.com>
 *  * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 *  * @license   Open Software License ("OSL") v. 3.0
 *
 */

var config = {
    // map: {
    //     "*": {
    //         scriptByDuongDh:
    //     },
    // },
    paths: {
        'scriptByDuongDh': "Tigren_AdvancedCheckout/js/path/to/script"
    },
    deps: [
        'scriptByDuongDh',
    ],
    shim: {
        'scriptByDuongDh': {
            'deps': ['jquery']
        }
    },
};
