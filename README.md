VATIN
=====
[![Build Status](https://secure.travis-ci.org/ddeboer/vatin.png)](http://travis-ci.org/ddeboer/vatin) [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/ddeboer/vatin/badges/quality-score.png?s=6e22e3338a0ed5b4b59ca3fe18df0eb00af0aeff)](https://scrutinizer-ci.com/g/ddeboer/vatin/) [![Latest Stable Version](https://poser.pugx.org/ddeboer/vatin/v/stable.png)](https://packagist.org/packages/ddeboer/vatin)

A small PHP >= 5.3 library for validating VAT identification numbers (VATINs).

Installation
------------

This library is available on [Packagist](http://packagist.org/packages/ddeboer/vatin):

```bash
$ composer require ddeboer/vatin:@stable
```

If you want to use this library in a Symfony2 application, you can use the
[VatinBundle](https://github.com/ddeboer/vatin-bundle) instead.

Usage
-----

Validate a VAT number’s format:

```php
$validator = new \Ddeboer\Vatin\Validator();
$bool = $validator->isValid('NL123456789B01');
```

Additionally check whether the VAT number is in use, with a call to the [VAT
Information Exchange System (VIES)]
(http://ec.europa.eu/taxation_customs/vies/faq.html#item_16) SOAP web service:

```php
$validator = new \Ddeboer\Vatin\Validator();
$bool = $validator->isValid('NL123456789B01', true);
```