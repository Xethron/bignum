<?php

namespace Xethron\Bignum\Exceptions;

class InvalidNumberException extends \Exception
{
    public function __construct(string $number)
    {
        parent::__construct('Invalid Number: "'.$number.'"');
    }
}
