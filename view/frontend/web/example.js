/*
 *
 *  * @author    Tigren Solutions <info@tigren.com>
 *  * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 *  * @license   Open Software License ("OSL") v. 3.0
 *
 */

define([], function(){
    alert("A simple Example module");
    console.log("A simple Example module");
    return function(config) {
        console.log(config);

    }
});
