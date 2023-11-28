/*
 *
 *  * @author    Tigren Solutions <info@tigren.com>
 *  * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 *  * @license   Open Software License ("OSL") v. 3.0
 *
 */

define(['jquery'], function ($) {
    'use strict';
    return function (SwatchRenderer) {
        $.widget('mage.SwatchRenderer', $['mage']['SwatchRenderer'], {
            _init: function () {
                console.log('Custom Swatch Renderer init function call successfully'); // you can write here your code according to your requirement this._super();
            }
        });
        return $['mage']['SwatchRenderer']; // Return flow of original action.
    };
});
