<?php

namespace Omnipay\HyperPay;

use Omnipay\Tests\GatewayTestCase;

class COPYandPAYGatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new COPYandPAYGateway($this->getHttpClient(), $this->getHttpRequest());

        $this->options = array(
            'amount' => '10.00',
            'currency'  => 'SAR'
        );
    }
}
