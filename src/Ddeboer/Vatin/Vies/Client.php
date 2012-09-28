<?php

namespace Ddeboer\Vatin\Vies;

/**
 * A client for the VIES SOAP web service
 */
class Client
{
    /**
     * URL to WSDL
     *
     * @var string
     */
    protected $wsdl = 'http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl';

    /**
     * SOAP client
     *
     * @var \SoapClient
     */
    protected $soapClient;

    /**
     * SOAP classmap
     *
     * @var array
     */
    protected $classmap = array(
        'checkVatResponse' => 'Ddeboer\Vatin\Vies\Response\CheckVatResponse'
    );

    /**
     * Constructor
     *
     * @param string $wsdl URL to WSDL
     */
    public function __construct($wsdl = null)
    {
        if ($wsdl) {
            $this->wsdl = $wsdl;
        }
    }

    /**
     * Check VAT
     *
     * @param string $countryCode Country code
     * @param string $vatNumber   VAT number
     *
     * @return Response\CheckVatResponse
     */
    public function checkVat($countryCode, $vatNumber)
    {
        return $this->getSoapClient()->checkVat(
            array(
                'countryCode' => $countryCode,
                'vatNumber' => $vatNumber
            )
        );
    }

    /**
     * Get SOAP client
     *
     * @return \SoapClient
     */
    protected function getSoapClient()
    {
        if (null === $this->soapClient) {
            $this->soapClient = new \SoapClient(
                $this->wsdl,
                array(
                    'classmap' => $this->classmap
               )
            );
        }

        return $this->soapClient;
    }
}