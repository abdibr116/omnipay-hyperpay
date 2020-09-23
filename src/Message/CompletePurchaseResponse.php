<?php

namespace Omnipay\HyperPay\Message;

/**
 * HyperPay Complete Purchase Response
 */
class CompletePurchaseResponse extends PurchaseResponse
{
    public function isSuccessful()
    {
        //First, decode result code if exists
        if (isset($this->data['result'])
        && empty($this->data['result']['parameterErrors'])
        && $this->getCode() < 400) {
            if (!empty($this->data['result']['code'])) {
                $code = $this->data['result']['code'];
                $success = false;
                switch ($code) {
                    case (preg_match('/^(000\.000\.|000\.100\.1|000\.[36])/', $code) ? true : false):
                    case (preg_match('/^(000\.400\.0|000\.400\.100)/', $code) ? true : false):
                        $success = true;
                        break;
                    default:
                        $success = false;
                }

                return $success;
            }

            return false;
        }

        return false;
    }
    
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

    public function getTransactionReference()
    {
        if (!empty($this->data['id'])) {
            return $this->data['id'];
        }

        return '';
    }
}
