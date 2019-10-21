<?php

namespace Omnipay\HyperPay;

use Omnipay\Common\AbstractGateway;

/**
 * HyperPay COPYandPAY Class
 */
class COPYandPAYGateway extends AbstractGateway
{
    public function getName()
    {
        return 'HyperPay COPYandPAY';
    }

    public function getDefaultParameters()
    {
        return array(
            'accessToken'   => '',
            'entityId'      => '',
            'testMode'      => false
        );
    }

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

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\HyperPay\Message\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\HyperPay\Message\CompletePurchaseRequest', $parameters);
    }
}
