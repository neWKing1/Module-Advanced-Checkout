<?php
/*
 *
 *  * @author    Tigren Solutions <info@tigren.com>
 *  * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 *  * @license   Open Software License ("OSL") v. 3.0
 *
 */


namespace Tigren\AdvancedCheckout\Api;

interface AllUsersInterface
{
    /**
     * Get information about all users
     *
     * @return array
     */
    public function getAllUsers();
}
