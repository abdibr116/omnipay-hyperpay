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
        return isset($this->data['result']) && empty($this->data['result']['parameterErrors']) && $this->getCode() < 400;
    }

    public function getErrors(){
        if(isset($this->data['result']) && isset($this->data['result']['parameterErrors'])){
            return $this->data['result']['parameterErrors'];
        }

        return null;
    }

    public function getCheckoutId(){
        if (!empty($this->data['id'])) {
            return $this->data['id'];
        }

        return null;
    }

    public function getResultCode(){
        if (!empty($this->data['result']) && !empty($this->data['result']['code'])) {
            return $this->data['result']['code'];
        }

        return null;
    }

    public function getDescription(){
        if (!empty($this->data['result']) && !empty($this->data['result']['description'])) {
            return $this->data['result']['description'];
        }

        return null;
    }

    public function getCode()
    {
        return $this->statusCode;
    }

}
