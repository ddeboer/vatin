<?php

namespace Ddeboer\Vatin\Vies;

use SoapFault;
use Ddeboer\Vatin\Exception\ViesException;

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
    private $wsdl = 'http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl';

    /**
     * SOAP client
     *
     * @var \SoapClient
     */
    private $soapClient;

    /**
     * SOAP classmap
     *
     * @var array
     */
    private $classmap = array(
        'checkVatResponse' => 'Ddeboer\Vatin\Vies\Response\CheckVatResponse'
    );

    /**
     * Constructor
     *
     * @param string|null $wsdl URL to WSDL
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
     * @throws ViesException
     */
    public function checkVat($countryCode, $vatNumber)
    {
        try {
            return $this->getSoapClient()->checkVat(
                array(
                    'countryCode' => $countryCode,
                    'vatNumber' => $vatNumber
                )
            );
        } catch (SoapFault $e) {
            throw new ViesException('Error communicating with VIES service', 0, $e);
        }
    }

    /**
     * Get SOAP client
     *
     * @return \SoapClient
     */
    private function getSoapClient()
    {
        if (null === $this->soapClient) {
            $this->soapClient = new \SoapClient(
                $this->wsdl,
                array(
                    'classmap' => $this->classmap,
                    'user_agent' => 'Mozilla', // the request fails unless a (dummy) user agent is specified
                    'exceptions' => true,
                )
            );
        }

        return $this->soapClient;
    }
}
