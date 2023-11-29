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
 */

namespace Tigren\AdvancedCheckout\Controller\Ajax;


use Magento\Catalog\Model\ProductRepository;
use Magento\Checkout\Model\Cart;
use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Psr\Log\LoggerInterface;
use Magento\Framework\Controller\Result\JsonFactory;

/**
 * Class Index
 * @package Tigren\AdvancedCheckout\Controller\Ajax
 */
class Index extends Action
{

    /**
     * @var
     */
    protected $_chekoutsession;
    /**
     * @var ProductRepository
     */
    protected $_productRepository;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var Cart
     */
    protected $cart;

    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    public function __construct(
        Context           $context,
        Cart              $cart,
        LoggerInterface   $logger,
        ProductRepository $productRepository,
        Session           $_chekoutsession,
        jsonFactory       $jsonFactory
    )
    {
        $this->_chekoutsession = $_chekoutsession;
        $this->cart = $cart;
        $this->_productRepository = $productRepository;
        $this->jsonFactory = $jsonFactory;
        parent::__construct($context);
    }

    /**
     * @return $this
     */
    public function execute()
    {

        $isShowPopup = false;
        $sku = $this->getRequest()->getParam('sku');
        $product = $this->_productRepository->get($sku);

            $items = $this->cart->getQuote()->getAllVisibleItems();
            foreach ($items as $item) {
                if ($product->getSku() == $item->getProduct()->getSku() && $product->getAllowMultiOrder() == 0) {
                    $isShowPopup = true;
                }
            }

        /** @var Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $data = [
            'message' => 'Success',
            'status' => 200,
            'popup' => $isShowPopup,
        ];
        return $resultJson->setData($data);
    }
}
