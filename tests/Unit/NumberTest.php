<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Xethron\Bignum\Exceptions\InvalidNumberException;
use Xethron\Bignum\Exceptions\InvalidScientificNotationException;
use Xethron\Bignum\Number;

/**
 * @covers \Xethron\Bignum\Number
 */
class NumberTest extends TestCase
{
    /**
     * Can parse numbers containing whitespaces
     *
     * @covers \Xethron\Bignum\Number::parse
     * @covers \Xethron\Bignum\Number::fromString
     */
    public function test_can_parse_numbers_containing_whitespaces()
    {
        $this->assertSame('10', Number::parse(' 10'));
        $this->assertSame('21', Number::parse('21 '));
        $this->assertSame('33', Number::parse(' 33 '));
        $this->assertSame('-42', Number::parse(' -42 '));
    }

    /**
     * Should trim tailing zero's
     *
     * @covers \Xethron\Bignum\Number::cleanup
     */
    public function test_should_trim_tailing_zeros()
    {
        $this->assertSame('1.23', Number::cleanup('1.230000'));
        $this->assertSame('0.1', Number::cleanup('0.100000'));
        $this->assertSame('1000', Number::cleanup('1000'));
    }

    /**
     * Cleanup negative zero
     *
     * @covers \Xethron\Bignum\Number::cleanup
     */
    public function test_cleanup_negative_zero()
    {
        $this->assertSame('0', Number::cleanup('-0'));
        $this->assertSame('0', Number::cleanup('-0.000000'));
    }

    /**
     * Converting Scientific Notation into decimal
     *
     * @covers \Xethron\Bignum\Number::parse
     * @covers \Xethron\Bignum\Number::fromString
     * @covers \Xethron\Bignum\Number::fromScientificNotation
     * @covers \Xethron\Bignum\Number::getScientificNotationParts
     */
    public function test_converting_scientific_notation_into_decimal()
    {
        $this->assertSame('1234', Number::parse('1.234E3'));
        $this->assertSame('0.001234', Number::parse('1.234E-3'));
        $this->assertSame('-12340000', Number::parse('-1.234E7'));
        $this->assertSame('-0.0000001234', Number::parse('-1.234E-7'));
    }

    /**
     * Parse really small floats
     *
     * @covers \Xethron\Bignum\Number::parse
     * @covers \Xethron\Bignum\Number::fromFloat
     */
    public function test_parse_really_small_floats()
    {
        $this->assertSame('0.000000000000123456789012345612374', Number::parse(0.000000000000123456789012345612374));
        $this->assertSame('1.00000000000123390187', Number::parse(1.00000000000123390187));
    }

    /**
     * Parse really large floats
     *
     * @covers \Xethron\Bignum\Number::parse
     * @covers \Xethron\Bignum\Number::fromFloat
     */
    public function test_parse_really_large_floats()
    {
        $this->assertSame('123456789012345.671875', Number::parse(123456789012345.671875));
        $this->assertSame('12345678901234567168.0', Number::parse(12345678901234567168));
        $this->assertSame('123456789012345667584', Number::parse(123456789012345667584));
    }

    /**
     * Parse integers
     *
     * @covers \Xethron\Bignum\Number::parse
     * @covers \Xethron\Bignum\Number::fromInt
     */
    public function test_parse_integers()
    {
        $this->assertSame('1', Number::parse(1));
        $this->assertSame('-123', Number::parse(-123));
        $this->assertSame('9223372036854775807', Number::parse(9223372036854775807));
    }

    /**
     * Throw exceptions for Invalid Numbers
     *
     * @covers \Xethron\Bignum\Number::parse
     * @covers \Xethron\Bignum\Exceptions\InvalidNumberException
     */
    public function test_throw_exceptions_for_invalid_numbers()
    {
        try {
            Number::parse('Invalid Number');
        } catch (InvalidNumberException $e) {
            $this->addToAssertionCount(1);
            $this->assertSame('Invalid Number: "Invalid Number"', $e->getMessage());

            return;
        }

        $this->fail('Expected Exception to be thrown.');
    }

    /**
     * Throw exceptions for Invalid Numbers
     *
     * @covers \Xethron\Bignum\Number::parse
     * @covers \Xethron\Bignum\Exceptions\InvalidNumberException
     */
    public function test_throw_exceptions_for_empty_numbers()
    {
        try {
            Number::parse('');
        } catch (InvalidNumberException $e) {
            $this->addToAssertionCount(1);
            $this->assertSame('Invalid Number: ""', $e->getMessage());

            return;
        }

        $this->fail('Expected Exception to be thrown.');
    }

    /**
     * Throw exceptions for Invalid Numbers
     *
     * @covers \Xethron\Bignum\Number::getScientificNotationParts
     * @covers \Xethron\Bignum\Exceptions\InvalidNumberException
     */
    public function test_throw_exceptions_for_false_sn()
    {
        try {
            Number::parse('E');
        } catch (InvalidScientificNotationException $e) {
            $this->addToAssertionCount(1);
            $this->assertSame('Invalid Number: "E"', $e->getMessage());

            return;
        }

        $this->fail('Expected Exception to be thrown.');
    }
}
