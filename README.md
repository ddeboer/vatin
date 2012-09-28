[![Build Status](https://secure.travis-ci.org/ddeboer/vatin.png)](http://travis-ci.org/phpforce/soap-client)

VATIN: validation for VAT identification numbers
================================================

A small PHP 5.3 library for validating VAT identification numbers (VATINs).

Installation
------------

This library is available on [Packagist](http://packagist.org/packages/ddeboer/vatin).

If you want to use this library in a Symfony2 application, you can use the
[VatinBundle](https://github.com/ddeboer/vatin-bundle) instead.

Usage
-----

Validate a VAT number’s format:

    $validator = new \Ddeboer\Vatin\Validator();
    $bool = $validator->isValid('NL123456789B01');

Additionally check whether the VAT number is in use, with a call to the [VAT
Information Exchange System (VIES)]
(http://ec.europa.eu/taxation_customs/vies/faq.html#item_16) SOAP web service:

    $validator = new \Ddeboer\Vatin\Validator();
    $bool = $validator->isValid('NL123456789B01', true);