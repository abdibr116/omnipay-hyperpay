# Omnipay: HyperPay

**PayPal driver for the Omnipay PHP payment processing library**

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP. This package implements HyperPay support for Omnipay.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply require `league/omnipay` and `omnipay/hyperpay` with Composer:

```
composer require league/omnipay omnipay/hyperpay
```


## Basic Usage

The following gateway is provided by this package:

* HyperPay_COPYandPAY (HyperPay COPYandPAY Checkout)

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.

## Example

A basic usage example of HyperPay COPYandPAY Checkout is provided in `example` folder. To run the example, run Composer installation, then navigate to `example` and run local PHP server as following:

```
composer install
cd example
php -S localhost:8000
```


## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.