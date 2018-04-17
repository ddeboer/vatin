<?php

namespace Ddeboer\Vatin\Test\Vies;

use Ddeboer\Vatin\Vies\Client;
use Ddeboer\Vatin\Vies\Response\CheckVatResponse;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testCheckVat()
    {
        $client = new Client();
        $response = $client->checkVat('NL', '123456789B01');

        $this->assertInstanceOf(CheckVatResponse::class, $response);
        $this->assertFalse($response->isValid());
        $this->assertEquals('NL', $response->getCountryCode());
        $this->assertEquals('123456789B01', $response->getVatNumber());
        $this->assertInstanceOf('\DateTime', $response->getRequestDate());
        $this->assertEquals('---', $response->getName());
        $this->assertEquals('---', $response->getAddress());
    }
}