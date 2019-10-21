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

    public function getTransactionId()
    {
        return $this->getParameter('transactionId');
    }

    public function setTransactionId($value)
    {
        return $this->setParameter('transactionId', $value);
    }

    public function getEmail()
    {
        return $this->getParameter('email');
    }

    public function setEmail($value)
    {
        return $this->setParameter('email', $value);
    }

    public function getMobile()
    {
        return $this->getParameter('mobile');
    }

    public function setMobile($value)
    {
        return $this->setParameter('mobile', $value);
    }

    public function getAddress()
    {
        return $this->getParameter('address');
    }

    public function setAddress($value)
    {
        return $this->setParameter('address', $value);
    }

    public function getCity()
    {
        return $this->getParameter('city');
    }

    public function setCity($value)
    {
        return $this->setParameter('city', $value);
    }

    public function getState()
    {
        return $this->getParameter('state');
    }

    public function setState($value)
    {
        return $this->setParameter('state', $value);
    }

    public function getCountry()
    {
        return $this->getParameter('country');
    }

    public function setCountry($value)
    {
        return $this->setParameter('country', $value);
    }

    public function getPostCode()
    {
        return $this->getParameter('postCode');
    }

    public function setPostCode($value)
    {
        return $this->setParameter('postCode', $value);
    }

    public function getFirstName()
    {
        return $this->getParameter('firstName');
    }

    public function setFirstName($value)
    {
        return $this->setParameter('firstName', $value);
    }

    public function getLastName()
    {
        return $this->getParameter('lastName');
    }

    public function setLastName($value)
    {
        return $this->setParameter('lastName', $value);
    }

    public function getData()
    {
        $this->validate('entityId', 'amount', 'currency');

        $data = array();

        $data['entityId'] = $this->getEntityId();
        $data['amount'] = $this->getAmount();
        $data['currency'] = $this->getCurrency();
        $data['paymentType'] = 'DB'; //Always DB
        if ($this->getTestMode()) {
            $data['testMode'] = 'EXTERNAL';
        }
        
        // Other requitred fields by some banks
        $data['merchantTransactionId'] = $this->getTransactionId();
        $data['customer.email'] = $this->getEmail();
        $data['customer.mobile'] = $this->getMobile();
        $data['billing.street1'] = $this->getAddress();
        $data['billing.city'] = $this->getCity();
        $data['billing.state'] = $this->getState();
        $data['billing.country'] = $this->getCountry();
        $data['billing.postcode'] = $this->getPostCode();
        $data['customer.givenName'] = $this->getFirstName();
        $data['customer.surname'] = $this->getLastName();
        
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
