<?php
/*
 *
 *  * @author    Tigren Solutions <info@tigren.com>
 *  * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 *  * @license   Open Software License ("OSL") v. 3.0
 *
 */


/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\AdvancedCheckout\Observer;

use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\TestFramework\Inspection\Exception;
use Psr\Log\LoggerInterface;

/**
 * Class CreateCustomerAccount
 * @package Tigren\AdvancedCheckout\Observer
 */
class CreateCustomerAccount implements ObserverInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var
     */
    protected $_request;

    /**
     * @var CustomerFactory
     */
    protected $customerFactory;

    /**
     * @param LoggerInterface $logger
     * @param CustomerFactory $customerFactory
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        LoggerInterface                 $logger,
        CustomerFactory                 $customerFactory,
        StoreManagerInterface           $storeManager,
        \Magento\Customer\Model\Session $customerSession
    )
    {
        $this->_storeManager = $storeManager;
        $this->logger = $logger;
        $this->customerFactory = $customerFactory;
        $this->customerSession = $customerSession;
    }

    /**
     * @param Observer $observer
     * @return void
     * @throws LocalizedException
     */
    public function execute(Observer $observer)
    {

        if (!$this->customerSession->isLoggedIn()) {
            try {

                $order = $observer->getData('order');
                $shippingAddress = $order->getShippingAddress();
                $f_name = $shippingAddress->getFirstname();
                $l_name = $shippingAddress->getLastname();
                $email = $shippingAddress->getEmail();
                $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
                $logger = new \Zend_Log();
                $logger->addWriter($writer);
                $logger->info(print_r($f_name, true));
                // Get Website ID
                $websiteId = $this->_storeManager->getWebsite()->getWebsiteId();

                // Instantiate object (this is the most important part)
                $customer = $this->customerFactory->create();
                $customer->setWebsiteId($websiteId);

                // Preparing data for new customer
                $customer->setEmail($email);
                $customer->setFirstname($f_name);
                $customer->setLastname($l_name);
                $customer->setPassword("password");

                // Save data
                $customer->save();
            } catch (Exception $e) {
                $this->logger->info($e->getMessage());
            }

        }

    }
}
