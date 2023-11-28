<?php
/*
 *
 *  * @author    Tigren Solutions <info@tigren.com>
 *  * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 *  * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\AdvancedCheckout\Controller\Cart;

use Magento\Checkout\Model\Sidebar;
use Magento\Backend\App\Action\Context;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use  Magento\Checkout\Model\Cart as CustomerCart;
use Magento\Framework\App\Action\Action;

/**
 * Class ClearCart
 * @package Tigren\AdvancedCheckout\Controller\Cart
 */
class ClearCart extends Action
{

    /**
     * @var CustomerCart
     */
    protected $cart;

    /**
     * @var CheckoutSession
     */
    protected $checkoutSession;

    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    public function __construct(
        Context         $context,
        CheckoutSession $checkoutSession,
        CustomerCart    $cart,
        Sidebar         $sidebar,
        JsonFactory     $jsonFactory
    )
    {
        $this->checkoutSession = $checkoutSession;
        $this->cart = $cart;
        $this->sidebar = $sidebar;
        $this->jsonFactory = $jsonFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $quoteItems = $this->checkoutSession->getQuote()->getItemsCollection();
        foreach ($quoteItems as $item) {
//            $this->sidebar->removeQuoteItem($item->getId());
            $this->cart->removeItem($item->getId())->save();
        }

        $message = __("You deleted all item from cart ");
        $this->messageManager->addErrorMessage($message);


        /** @var Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $data = [
            'message' => 'Success',
            'status' => 200,
        ];
        return $resultJson->setData($data);
    }

}
