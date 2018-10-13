<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Xethron\Bignum\Math;

/**
 * @covers \Xethron\Bignum\Math
 */
class MathTest extends TestCase
{
    /**
     * Can add two numbers
     *
     * @covers \Xethron\Bignum\Math::add
     * @uses \Xethron\Bignum\Number
     */
    public function test_can_add_two_numbers()
    {
        $this->assertSame('100', Math::add(20, 80));
        $this->assertSame('-60', Math::add(20, -80));
        $this->assertSame('0.3', Math::add('0.1', '0.2', 1));
    }

    /**
     * Can add really big numbers and really small numbers together
     *
     * @covers \Xethron\Bignum\Math::add
     * @uses \Xethron\Bignum\Number
     */
    public function test_can_add_really_big_numbers_and_really_small_numbers_together()
    {
        $result = Math::add('12345678901234567890', '0.123456789123456789', 20);
        $this->assertSame('12345678901234567890.123456789123456789', $result);
    }

    /**
     * Can subtract two numbers
     *
     * @covers \Xethron\Bignum\Math::subtract
     * @uses \Xethron\Bignum\Number
     */
    public function test_can_subtract_two_numbers()
    {
        $this->assertSame('30', Math::subtract(50, 20));
        $this->assertSame('100', Math::subtract(20, -80));
        $this->assertSame('-0.1', Math::subtract('0.1', '0.2', 1));
    }

    /**
     * Can subtract a really small number from a really big number
     *
     * @covers \Xethron\Bignum\Math::subtract
     * @uses \Xethron\Bignum\Number
     */
    public function test_can_subtract_a_really_small_number_from_a_really_big_number()
    {
        $result = Math::subtract('12345678901234567890', '1.123456789123456789', 20);
        $this->assertSame('12345678901234567888.876543210876543211', $result);
    }

    /**
     * Can divide two numbers
     *
     * @covers \Xethron\Bignum\Math::divide
     * @uses \Xethron\Bignum\Number
     */
    public function test_can_divide_two_numbers()
    {
        $this->assertSame('30', Math::divide(90, 3));
        $this->assertSame('-100', Math::divide(-120, '1.2'));
        $this->assertSame('6.2', Math::divide('124', '20', 1));
    }

    /**
     * Division with a really large and precise answer
     *
     * @covers \Xethron\Bignum\Math::divide
     * @uses \Xethron\Bignum\Number
     */
    public function test_division_with_a_really_large_and_precise_answer()
    {
        $result = Math::divide('1000000000000000', '3', 9);
        $this->assertSame('333333333333333.333333333', $result);
    }

    /**
     * Can multiply two numbers
     *
     * @covers \Xethron\Bignum\Math::multiply
     * @uses \Xethron\Bignum\Number
     */
    public function test_can_multiply_two_numbers()
    {
        $this->assertSame('90', Math::multiply(30, 3));
        $this->assertSame('-120', Math::multiply(-100, '1.2'));
        $this->assertSame('0.9', Math::multiply('0.3', '3', 1));
    }

    /**
     * Can multiply two large numbers together
     *
     * @covers \Xethron\Bignum\Math::multiply
     * @uses \Xethron\Bignum\Number
     */
    public function test_can_multiply_two_large_numbers_together()
    {
        $result = Math::multiply('1234567890.123456789', '987654321.0987654321', 9);
        $this->assertSame('1219326311370217952.237463801', $result);
    }

    /**
     * Can parse numbers containing whitespaces
     *
     * @covers \Xethron\Bignum\Math::add
     * @covers \Xethron\Bignum\Math::subtract
     * @covers \Xethron\Bignum\Math::divide
     * @covers \Xethron\Bignum\Math::multiply
     * @uses \Xethron\Bignum\Number
     */
    public function test_can_parse_numbers_containing_whitespaces()
    {
        $this->assertSame('100', Math::add(' 20', '80 '));
        $this->assertSame('-60', Math::subtract(' 20', '80 '));
        $this->assertSame('33', Math::divide(' 99', '3 '));
        $this->assertSame('88', Math::multiply(' 22', '4 '));
    }

    /**
     * Correctly reading really small numbers
     *
     * @covers \Xethron\Bignum\Math::add
     * @covers \Xethron\Bignum\Math::subtract
     * @covers \Xethron\Bignum\Math::divide
     * @covers \Xethron\Bignum\Math::multiply
     * @uses \Xethron\Bignum\Number
     */
    public function test_correctly_reading_really_small_numbers()
    {
        $number = 0.0000012345;
        $this->assertSame('0.1000012345', Math::add('0.1', $number, 10));
        $this->assertSame('0.0999987655', Math::subtract('0.1', $number, 10));
        $this->assertSame('0.000002469', Math::divide($number, '0.5', 10));
        $this->assertSame('0.000002469', Math::multiply($number, '2', 10));
    }

    /**
     * Can Round numbers
     *
     * @covers \Xethron\Bignum\Math::round
     * @uses \Xethron\Bignum\Number
     */
    public function test_can_round_numbers()
    {
        $this->assertSame('1', Math::round('1.1'));
        $this->assertSame('2', Math::round('1.5'));
        $this->assertSame('1.78', Math::round('1.777', 2));
        $this->assertSame('1', Math::round('0.9999999999', 5));
        $this->assertSame('-2', Math::round('-1.5'));
    }
}
