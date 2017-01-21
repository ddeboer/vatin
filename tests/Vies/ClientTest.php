<?php

namespace Ddeboer\Vatin\Test\Vies;

use Ddeboer\Vatin\Vies\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testCheckVat()
    {
        $client = new Client();
        $response = $client->checkVat('NL', '123456789B01');

        $this->assertInstanceOf('\Ddeboer\Vatin\Vies\Response\CheckVatResponse', $response);
        $this->assertFalse($response->isValid());
        $this->assertEquals('NL', $response->getCountryCode());
        $this->assertEquals('123456789B01', $response->getVatNumber());
        $this->assertInstanceOf('\DateTime', $response->getRequestDate());
        $this->assertEquals('---', $response->getName());
        $this->assertEquals('---', $response->getAddress());
    }
}