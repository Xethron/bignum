# Bignum library for PHP
[![codecov](https://codecov.io/gh/Xethron/bignum/graph/badge.svg?token=77SL86KV17)](https://codecov.io/gh/Xethron/bignum)

Intelligent wrapper for BCMath.

## Why use this library?
BCMath is a great library, but it has some shortfalls.
This library aims to address those shortfalls.

### Features
* Adds serialisation of numbers:
  * Serialises Floats
  * Serialises Strings
  * Understands Scientific Notation
  * Throws exceptions for invalid values
* Adds Rounding
* All results are rounded

## Installation
The recommended way to install this is through composer:

```bash
composer require "xethron/bignum"
```

## Usage
```php
<?php

use Xethron\Bignum\Math;

Math::add(7, 3); // 10
Math::subtract('1', '0.000001'); // 0.999999

// Default 20 precision
Math::divide(1, 3); // 0.33333333333333333333

// Set precision to 4 decimals
$third = Math::divide(1, 3, 4); // 0.3333
// Set precision to 2, resulting in rounding 0.9999 to 1
$one = Math::multiply($third, 3, 2); // 1

Math::round(0.5678); // 1
Math::round(0.16, 1); // 0.2
```

## Contribution Guidelines
Please open any issues for discussion before starting any work to avoid new features not getting approved.

This project follows the Symfony coding standards.

## Contributors
Bernhard Breytenbach ([@BBreyten](https://twitter.com/BBreyten))

## License
The library is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

