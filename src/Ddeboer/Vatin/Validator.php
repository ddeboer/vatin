<?php

namespace Ddeboer\Vatin;

use Ddeboer\Vatin\Vies\Client;

/**
 * Validate a VAT identification number (VATIN)
 *
 * @link http://en.wikipedia.org/wiki/VAT_identification_number
 * @link http://sima.cat/nif.php
 * @link https://github.com/jonathanmaron/zf2_proposal/blob/master/library/Zend/Validator/Vatin.php
 */
class Validator
{
    /**
     * Regular expression patterns per country code
     *
     * @var array
     */
    protected $patterns = array(
        'AT' => 'U[A-Z\d]{8}',
        'BE' => '0\d{9}',
        'BG' => '\d{9,10}',
        'DE' => '\d{9}',
        'NL' => '\d{9}[A-Z]\d{2}',
        'GB' => '\d{9}|\d{12}|(GD|HA)\d{3})'
    );

    /**
     * Client for the VIES web service
     *
     * @var Client
     */
    protected $viesClient;

    /**
     * Set VIES client
     *
     * @param Client $viesClient Client for the VIES web service
     */
    public function setViesClient(Client $viesClient)
    {
        $this->viesClient = $viesClient;
    }

    /**
     * Returns true if value is a valid VAT identification number, false
     * otherwise
     *
     * @param string $value          Value
     * @param bool   $checkExistence In addition to checking the VATIN's format
     *                               for validity, also check whether the VATIN
     *                               exists. This requires a call to the VIES
     *                               web service.
     *
     * @return bool
     */
    public function isValid($value, $checkExistence = false)
    {
        if (null === $value || '' === $value) {
            return false;
        }

        $countryCode = substr($value, 0, 2);
        $vatin = substr($value, 2);

        if (false === $this->isValidCountryCode($countryCode)) {
            return false;
        }

        if (0 === preg_match('/'.$this->patterns[$countryCode].'/', $vatin)) {
            return false;
        }

        if (true === $checkExistence) {
            if (null === $this->viesClient) {
                throw new \Exception(
                    'For checking VATIN existence, VIES client must be set'
                );
            }
            $result = $this->viesClient->checkVat($countryCode, $vatin);

            return $result->isValid();
        }

        return true;
    }

    /**
     * Returns true if value is valid country code, false otherwise
     *
     * @param string $value Value
     *
     * @return bool
     */
    public function isValidCountryCode($value)
    {
        return isset($this->patterns[$value]);
    }
}