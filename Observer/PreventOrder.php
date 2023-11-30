<?php
/*
 *
 *  * @author    Tigren Solutions <info@tigren.com>
 *  * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 *  * @license   Open Software License ("OSL") v. 3.0
 *
 */


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
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\TestFramework\Inspection\Exception;
use Psr\Log\LoggerInterface;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;

/**
 * Class CreateCustomerAccount
 * @package Tigren\AdvancedCheckout\Observer
 */
class PreventOrder implements ObserverInterface
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
    protected $objectManager;
    protected $redirect;

    /**
     * @param LoggerInterface $logger
     * @param CustomerFactory $customerFactory
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        LoggerInterface                                   $logger,
        CustomerFactory                                   $customerFactory,
        StoreManagerInterface                             $storeManager,
        \Magento\Customer\Model\Session                   $customerSession,
        \Magento\Framework\ObjectManagerInterface         $objectManager,
        MessageManagerInterface                           $messageManager,
        \Magento\Framework\App\Response\RedirectInterface $redirect
    )
    {
        $this->_storeManager = $storeManager;
        $this->objectManager = $objectManager;
        $this->logger = $logger;
        $this->customerFactory = $customerFactory;
        $this->customerSession = $customerSession;
        $this->messageManager = $messageManager;
        $this->redirect = $redirect;
    }

    /**
     * @param Observer $observer
     * @return void
     * @throws LocalizedException
     */
    public function execute(Observer $observer)
    {

        if ($this->customerSession->isLoggedIn()) {
            $customerId = $this->customerSession->getCustomer()->getId();

            $orderCollection = $this->objectManager->create('Magento\Sales\Model\ResourceModel\Order\Collection')
                ->addFieldToSelect('*')
                ->addFieldToFilter('customer_id', $customerId);

            $count = 0;
            foreach ($orderCollection as $order) {
                if ($order->getStatus() != 'complete') {
                    ++$count;
                    $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
                    $logger = new \Zend_Log();
                    $logger->addWriter($writer);
                    $logger->info($count);
                    $logger->info($order->getStatus());
                }
            }
            if ($count > 0) {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('You have an order that is not complete. Please wait to complete the order before creating a new order')
                );
            }
        }

    }
}
