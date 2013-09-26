<?php

namespace Ddeboer\Vatin\Vies\Response;

class CheckVatResponse
{
    protected $countryCode;

    protected $vatNumber;

    protected $requestDate;

    protected $valid;

    protected $name;

    protected $address;

    public function getCountryCode()
    {
        return $this->countryCode;
    }

    public function getVatNumber()
    {
        return $this->vatNumber;
    }

    public function getRequestDate()
    {
        if (!$this->requestDate instanceof \DateTime) {
            $this->requestDate = new \DateTime($this->requestDate);
        }

        return $this->requestDate;
    }

    public function isValid()
    {
        return $this->valid;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAddress()
    {
        return $this->address;
    }
}