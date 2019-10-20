<?php

namespace Omnipay\HyperPay\Message;

/**
 * HyperPay Complete Purchase Response
 */
class CompletePurchaseResponse extends PurchaseResponse
{
    public function getCheckoutId()
    {
        //Not implemented
        return null;
    }

    public function getCard()
    {
        if (!empty($this->data['card'])) {
            return $this->data['card'];
        }

        return null;
    }
}
