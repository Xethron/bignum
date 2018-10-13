<?php

declare(strict_types=1);

namespace Xethron\Bignum;

class Math
{
    const SCALE = 20;

    /**
     * @param string|int|float $leftOperand
     * @param string|int|float $rightOperand
     * @param int $scale
     *
     * @return string
     * @throws Exceptions\InvalidNumberException
     */
    public static function add($leftOperand, $rightOperand, int $scale = self::SCALE): string
    {
        $leftOperand = Number::parse($leftOperand);
        $rightOperand = Number::parse($rightOperand);

        return self::round(bcadd($leftOperand, $rightOperand, $scale+1), $scale);
    }

    /**
     * @param string|int|float $leftOperand
     * @param string|int|float $rightOperand
     * @param int $scale
     *
     * @return string
     * @throws Exceptions\InvalidNumberException
     */
    public static function subtract($leftOperand, $rightOperand, int $scale = self::SCALE): string
    {
        $leftOperand = Number::parse($leftOperand);
        $rightOperand = Number::parse($rightOperand);

        return self::round(bcsub($leftOperand, $rightOperand, $scale+1), $scale);
    }

    /**
     * @param string|int|float $leftOperand
     * @param string|int|float $rightOperand
     * @param int $scale
     *
     * @return string
     * @throws Exceptions\InvalidNumberException
     */
    public static function divide($leftOperand, $rightOperand, int $scale = self::SCALE): string
    {
        $leftOperand = Number::parse($leftOperand);
        $rightOperand = Number::parse($rightOperand);

        return self::round(bcdiv($leftOperand, $rightOperand, $scale+1), $scale);
    }

    /**
     * @param string|int|float $leftOperand
     * @param string|int|float $rightOperand
     * @param int $scale
     *
     * @return string
     * @throws Exceptions\InvalidNumberException
     */
    public static function multiply($leftOperand, $rightOperand, int $scale = self::SCALE): string
    {
        $leftOperand = Number::parse($leftOperand);
        $rightOperand = Number::parse($rightOperand);

        return self::round(bcmul($leftOperand, $rightOperand, $scale+1), $scale);
    }

    /**
     * @param string|int|float $leftOperand
     * @param string|int|float $rightOperand
     * @param int $scale
     *
     * @return string
     * @throws Exceptions\InvalidNumberException
     */
    public static function power($leftOperand, $rightOperand, int $scale = self::SCALE): string
    {
        $leftOperand = Number::parse($leftOperand);
        $rightOperand = Number::parse($rightOperand);

        return self::round(bcpow($leftOperand, $rightOperand, $scale+1), $scale);
    }

    /**
     * @param string|int|float $leftOperand
     * @param int $scale
     *
     * @return string
     * @throws Exceptions\InvalidNumberException
     */
    public static function round($leftOperand, int $scale = 0): string
    {
        $leftOperand = Number::parse($leftOperand);
        $rightOperand = '0.'.str_repeat('0', $scale).'5';

        if ($leftOperand[0] === '-') {
            $result = bcsub($leftOperand, $rightOperand, $scale);
        } else {
            $result = bcadd($leftOperand, $rightOperand, $scale);
        }

        return Number::cleanup($result);
    }
}
