<?php
/**
 * HyperPay Purchase Request
 */

namespace Omnipay\HyperPay\Message;

class CompletePurchaseRequest extends PurchaseRequest
{
    public function getResourcePath()
    {
        return $this->getParameter('resourcePath');
    }

    public function setResourcePath($value)
    {
        return $this->setParameter('resourcePath', urldecode($value));
    }

    public function getData()
    {
        $this->validate('entityId');

        $data = array();

        $data['entityId'] = $this->getEntityId();
        
        return $data;
    }

    public function sendData($data)
    {
        try {
            $httpResponse = $this->httpClient->request(
                'GET',
                $this->getEndpoint() . '?entityId='.$this->getEntityId(),
                array(
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->getAccessToken(),
                    'Content-Type' => 'application/x-www-form-urlencoded',
                )
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

    public function getEndpoint()
    {
        return parent::getEndpoint() . $this->getResourcePath();
    }

    protected function createResponse($data, $statusCode)
    {
        return $this->response = new CompletePurchaseResponse($this, $data, $statusCode);
    }
}
