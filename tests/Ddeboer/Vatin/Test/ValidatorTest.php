<?php

namespace Ddeboer\Vatin\Test;

use Ddeboer\Vatin\Validator;

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
        $this->validator->setViesClient(new \Ddeboer\Vatin\Vies\Client());
        $this->assertTrue($this->validator->isValid('NL002065538B01', true));
    }

    public function testInvalidWithVies()
    {
        $this->validator->setViesClient(new \Ddeboer\Vatin\Vies\Client());
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

    public function getInvalidVatins()
    {
        return array(
            array(null),
            array(''),
            array('123456789'),
            array('XX123')
        );
    }
}