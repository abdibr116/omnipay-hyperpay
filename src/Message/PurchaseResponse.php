<?php
/**
 * HyperPay Purchase Response
 */

namespace Omnipay\HyperPay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * HyperPay Purchase Response
 */
class PurchaseResponse extends AbstractResponse
{
    protected $statusCode;

    public function __construct(RequestInterface $request, $data, $statusCode = 200)
    {
        parent::__construct($request, $data);
        $this->statusCode = $statusCode;
    }

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
                    case (preg_match('/^(000\.200)/', $code) ? true : false):
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

    public function getMessage()
    {
        if (!empty($this->data['result']) && !empty($this->data['result']['description'])) {
            return $this->data['result']['description'];
        }

        return null;
    }

    public function getErrors()
    {
        if (isset($this->data['result']) && isset($this->data['result']['parameterErrors'])) {
            return $this->data['result']['parameterErrors'];
        }

        return null;
    }

    public function getCheckoutId()
    {
        if (!empty($this->data['id'])) {
            return $this->data['id'];
        }

        return null;
    }

    public function getResultCode()
    {
        if (!empty($this->data['result']) && !empty($this->data['result']['code'])) {
            return $this->data['result']['code'];
        }

        return null;
    }

    public function getCode()
    {
        return $this->statusCode;
    }

    public function getTransactionReference(){
        if (!empty($this->data['id'])) {
            return $this->data['id'];
        }

        return null;
    }
}
