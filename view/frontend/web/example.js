/*
 *
 *  * @author    Tigren Solutions <info@tigren.com>
 *  * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 *  * @license   Open Software License ("OSL") v. 3.0
 *
 */
define([
    'jquery',
], function ($) {
    'use strict';
    $('#some-element').click(function () {
        console.log("A simple Example module");
    });

    return function (config) {
        console.log(config);
    };
});
