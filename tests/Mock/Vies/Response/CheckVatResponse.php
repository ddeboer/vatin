<?php

namespace Ddeboer\Vatin\Test\Mock\Vies\Response;

use Ddeboer\Vatin\Vies\Response\CheckVatResponse as BaseClass;

class CheckVatResponse extends BaseClass
{
    public function __construct($valid)
    {
        $this->valid = $valid;
    }
}