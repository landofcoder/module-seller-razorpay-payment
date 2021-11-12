<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/terms
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lofmp_Razorpay
 * @copyright  Copyright (c) 2021 Landofcoder (https://www.landofcoder.com/)
 * @license    https://landofcoder.com/terms
 */

namespace Lofmp\Razorpay\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Checkout\Model\Session;
use Lof\MarketPlace\Observer\OrderStatusChanged;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class WebhookOrderPlacedAfter extends OrderStatusChanged
{
    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        //disable the function if the module split order was enabled
        $paymentId = $observer->getPayment();
        $transport = $observer->getTransport();
        $magento_quote_id = $transport->getData("magento_quote_id");
        $orderId = $transport->getData("magento_order_id");
        $amount_captured = $transport->getData("amount_captured");
        $splitOrder = $this->helper->isEnableModule('Lofmp_SplitOrder');
        if (!$splitOrder || !$this->helper->getConfig('module/enabled', null, 'lofmp_split_order')) {
            $this->createSellerOrdersByOrderId($orderId);
        }
    }

}
