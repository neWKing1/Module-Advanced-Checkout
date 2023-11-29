<?php
/*
 *
 *  * @author    Tigren Solutions <info@tigren.com>
 *  * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 *  * @license   Open Software License ("OSL") v. 3.0
 *
 */


namespace Tigren\AdvancedCheckout\Model;

use Tigren\AdvancedCheckout\Api\AllUsersInterface;
use Magento\Customer\Model\CustomerFactory;

class AllUsers implements AllUsersInterface
{
    /**
     * @var CustomerFactory
     */
    protected $customerFactory;

    /**
     * AllUsers constructor.
     *
     * @param CustomerFactory $customerFactory
     */
    public function __construct(
        CustomerFactory $customerFactory
    )
    {
        $this->customerFactory = $customerFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllUsers()
    {
        $customerCollection = $this->customerFactory->create()->getCollection();
        $users = [];

        foreach ($customerCollection as $customer) {
            $users[] = [
                'id' => $customer->getId(),
                'name' => $customer->getName(),
                'email' => $customer->getEmail(),
                'passsword' => $customer->getPassword(),
                // Add more customer attributes as needed
            ];
        }

        return $users;
    }
}

