<?php

namespace Ddeboer\Vatin\Test;

use Ddeboer\Vatin\Validator;
use Ddeboer\Vatin\Test\Mock\Vies\Response\CheckVatResponse;
use Ddeboer\Vatin\Vies\Client;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    private $validator;

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
            ->willReturn($this->getCheckVatResponseMock(true));

        $this->validator = new Validator($client);
        $this->assertTrue($this->validator->isValid('NL002065538B01', true));
    }

    public function testInvalidWithVies()
    {
        $client = $this->getViesClientMock();
        $client
            ->expects($this->once())
            ->method('checkVat')
            ->with('NL', '123456789B01')
            ->willReturn($this->getCheckVatResponseMock(false));

        $this->validator = new Validator($client);
        $this->assertFalse($this->validator->isValid('NL123456789B01', true));
    }


    public function testWrongConnectionThrowsException()
    {
        $this->setExpectedException('\Ddeboer\Vatin\Exception\ViesException');

        $this->validator = new Validator(new Client('meh'));
        $this->validator->isValid('NL002065538B01', true);
    }

    /**
     * @return array
     */
    public function getValidVatins()
    {
        return array(
            // Examples from Wikipedia (https://en.wikipedia.org/wiki/VAT_identification_number)
            array('ATU99999999'),           // Austria
            array('BE0999999999'),          // Belgium
            array('BE1999999999'),          // Belgium
            array('HR12345678901'),         // Croatia
            array('CY99999999L'),           // Cyprus
            array('DK99999999'),            // Denmark
            array('FI99999999'),            // Finland
            array('FRXX999999999'),         // France
            array('DE999999999'),           // Germany
            array('HU12345678'),            // Hungary
            array('IE1234567T'),            // Ireland
            array('IE1234567TW'),           // Ireland
            array('IE1234567FA'),           // Ireland (since January 2013)
            array('NL999999999B99'),        // The Netherlands
            array('NO999999999'),           // Norway
            array('ES99999999R'),           // Spain
            array('SE999999999901'),        // Sweden
            array('CHE-123.456.788 TVA'),   // Switzerland
            array('GB999999973'),           // United Kingdom (standard)
            array('GBGD001'),               // United Kingdom (government departments)
            array('GBHA599'),               // United Kingdom (health authorities)

            // Examples from the EU (http://ec.europa.eu/taxation_customs/vies/faqvies.do#item_11)
            array('ATU99999999'),           // AT-Austria
            array('BE0999999999'),          // BE-Belgium
            array('BG999999999'),           // BG-Bulgaria
            array('BG9999999999'),          // BG-Bulgaria
            array('CY99999999L'),           // CY-Cyprus
            array('CZ99999999'),            // CZ-Czech Republic
            array('CZ999999999'),           // CZ-Czech Republic
            array('CZ9999999999'),          // CZ-Czech Republic
            array('DE999999999'),           // DE-Germany
            array('DK99999999'),            // DK-Denmark
            array('EE999999999'),           // EE-Estonia
            array('EL999999999'),           // EL-Greece
            array('ESX9999999X'),           // ES-Spain
            array('FI99999999'),            // FI-Finland
            array('FRXX999999999'),         // FR-France
            array('GB999999999'),           // GB-United Kingdom
            array('GB999999999999'),        // GB-United Kingdom
            array('GBGD999'),               // GB-United Kingdom
            array('GBHA999'),               // GB-United Kingdom
            array('HR99999999999'),         // HR-Croatia
            array('HU99999999'),            // HU-Hungary
            array('IE9S99999L'),            // IE-Ireland
            array('IE9999999WI'),           // IE-Ireland
            array('IT99999999999'),         // IT-Italy
            array('LT999999999'),           // LT-Lithuania
            array('LT999999999999'),        // LT-Lithuania
            array('LU99999999'),            // LU-Luxembourg
            array('LV99999999999'),         // LV-Latvia
            array('MT99999999'),            // MT-Malta
            array('NL999999999B99'),        // NL-The Netherlands
            array('PL9999999999'),          // PL-Poland
            array('PT999999999'),           // PT-Portugal
            array('RO999999999'),           // RO-Romania
            array('SE999999999999'),        // SE-Sweden
            array('SI99999999'),            // SI-Slovenia
            array('SK9999999999'),          // SK-Slovakia

            // Real world examples
            array('GB226148083'),           // Fuller's Brewery, United Kingdom
            array('NL002230884B01'),        // Albert Heijn BV., The Netherlands
            array('ESG82086810'),           // Fundación Telefónica, Spain
            array('IE9514041I'),            // Lego Systems A/S, Denmark with Irish VAT ID
            array('IE9990705T'),            // Amazon EU Sarl, Luxembourg with Irish VAT ID
            array('DK61056416'),            // Carlsberg A/S, Denmark
            array('BE0648836958'),          // Delhaize Logistics, Belgium
            array('CZ00514152'),            // Budějovický Budvar, Budweiser, Czech Republic

            // Various examples
            array('FR9X999999999'),
            array('NL123456789B01'),
            array('IE9574245O'),
            array('CHE123456788TVA')
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
            array('XX123'),
            array('GB999999973dsflksdjflsk'),
            array('BE2999999999'),          // Belgium - "the first digit following the prefix is always zero ("0") or ("1")"
            array('CHE12345678 MWST')
        );
    }

    /**
     * @return \Ddeboer\Vatin\Vies\Client
     */
    private function getViesClientMock()
    {
        return $this->getMockBuilder('\Ddeboer\Vatin\Vies\Client')
            ->disableOriginalConstructor()
            ->getMock();
    }

    private function getCheckVatResponseMock($valid)
    {
        $mock = $this->getMockBuilder('\Ddeboer\Vatin\Vies\Response\CheckVatResponse')
            ->getMock();

        $mock
            ->expects($this->any())
            ->method('isValid')
            ->willReturn($valid);

        return $mock;
    }

}
