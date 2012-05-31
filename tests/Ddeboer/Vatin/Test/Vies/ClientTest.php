<?php

namespace Ddeboer\Vatin\Test\Vies;

use Ddeboer\Vatin\Vies\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testCheckVat()
    {
        $client = new Client();
        $client->checkVat('NL', '123456789B01');
    }
}