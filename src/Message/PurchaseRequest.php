<?php
/**
 * HyperPay Purchase Request
 */

namespace Omnipay\HyperPay\Message;

use Omnipay\Common\Message\AbstractRequest;

class PurchaseRequest extends AbstractRequest
{
    protected $liveEndpoint = 'https://oppwa.com';
    protected $testEndpoint = 'https://test.oppwa.com';
    
    public function getEntityId()
    {
        return $this->getParameter('entityId');
    }

    public function setEntityId($value)
    {
        return $this->setParameter('entityId', $value);
    }

    public function getAccessToken()
    {
        return $this->getParameter('accessToken');
    }

    public function setAccessToken($value)
    {
        return $this->setParameter('accessToken', $value);
    }

    public function getCheckoutId()
    {
        return $this->getParameter('checkoutId');
    }

    public function setCheckoutId($value)
    {
        return $this->setParameter('checkoutId', $value);
    }
    
    public function getAmount()
    {
        return $this->getParameter('amount');
    }

    public function setAmount($value)
    {
        return $this->setParameter('amount', $value);
    }

    public function getCurrency()
    {
        return $this->getParameter('currency');
    }

    public function setCurrency($value)
    {
        return $this->setParameter('currency', $value);
    }

    public function getPaymentType()
    {
        return $this->getParameter('paymentType');
    }

    public function setPaymentType($value)
    {
        return $this->setParameter('paymentType', $value);
    }

    public function getData()
    {
        $this->validate('entityId', 'amount', 'currency', 'paymentType');

        $data = array();

        $data['entityId'] = $this->getEntityId();
        $data['amount'] = $this->getAmount();
        $data['currency'] = $this->getCurrency();
        $data['paymentType'] = $this->getPaymentType();
        if ($this->getTestMode()) {
            $data['testMode'] = 'EXTERNAL';
        }
        
        /*ًTODO should be added later
        $data['merchantTransactionId'] = '';
        $data['customer.email'] = '';
        $data['billing.street1'] = '';
        $data['billing.city'] = '';
        $data['billing.state'] = '';
        $data['billing.country'] = '';
        $data['billing.postcode'] = '';
        $data['customer.givenName'] = '';
        $data['customer.surname'] = '';*/
        
        return $data;
    }

    public function sendData($data)
    {
        try {
            $httpResponse = $this->httpClient->request(
                'POST',
                $this->getEndpoint() . '/v1/checkouts',
                array(
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->getAccessToken(),
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ),
                http_build_query($data, '', '&')
            );
            
            // Empty response body should be parsed also as and empty array
            $body = (string) $httpResponse->getBody()->getContents();
            $jsonToArrayResponse = !empty($body) ? json_decode($body, true) : array();
            return $this->response = $this->createResponse($jsonToArrayResponse, $httpResponse->getStatusCode());
        } catch (\Exception $e) {
            throw new InvalidResponseException(
                'Error communicating with payment gateway: ' . $e->getMessage(),
                $e->getCode()
            );
        }
    }

    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    protected function createResponse($data, $statusCode)
    {
        return $this->response = new PurchaseResponse($this, $data, $statusCode);
    }
}
