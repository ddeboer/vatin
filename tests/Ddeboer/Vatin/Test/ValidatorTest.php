<?php

namespace Ddeboer\Vatin\Test;

use Ddeboer\Vatin\Validator;
use Ddeboer\Vatin\Test\Mock\Vies\Response\CheckVatResponse;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    protected $validator;

    public function setUp()
    {
        $this->validator = new Validator();
    }

    /**
     * @dataProvider getValidVatins
     */
    public function testValid($value)
    {
        $this->assertTrue($this->validator->isValid($value));
    }

    /**
     * @dataProvider getInvalidVatins
     */
    public function testInvalid($value)
    {
        $this->assertFalse($this->validator->isValid($value));
    }

    public function testValidWithVies()
    {
        $client = $this->getViesClientMock();
        $client
            ->expects($this->once())
            ->method('checkVat')
            ->with('NL', '002065538B01')
            ->will($this->returnValue(new CheckVatResponse(true)));

        $this->validator->setViesClient($client);
        $this->assertTrue($this->validator->isValid('NL002065538B01', true));
    }

    public function testInvalidWithVies()
    {
        $client = $this->getViesClientMock();
        $client
            ->expects($this->once())
            ->method('checkVat')
            ->with('NL', '123456789B01')
            ->will($this->returnValue(new CheckVatResponse(false)));

        $this->validator->setViesClient($client);
        $this->assertFalse($this->validator->isValid('NL123456789B01', true));
    }

    /**
     * @return array
     */
    public function getValidVatins()
    {
        return array(
            array('NL123456789B01')
        );
    }

    /**
     * @return array
     */
    public function getInvalidVatins()
    {
        return array(
            array(null),
            array(''),
            array('123456789'),
            array('XX123')
        );
    }

    /**
     * @return \Ddeboer\Vatin\Vies\Client
     */
    protected function getViesClientMock()
    {
        return $this->getMockBuilder('\Ddeboer\Vatin\Vies\Client')
            ->disableOriginalConstructor()
            ->getMock();
    }
}