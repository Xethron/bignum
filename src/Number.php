<?php

declare(strict_types=1);

namespace Xethron\Bignum;

use Xethron\Bignum\Exceptions\InvalidNumberException;
use Xethron\Bignum\Exceptions\InvalidScientificNotationException;

class Number
{
    /**
     * @param string|int|float $number
     *
     * @return string
     * @throws InvalidNumberException
     */
    public static function parse($number): string
    {
        if (\is_float($number)) {
            $number = self::fromFloat($number);
        } elseif (\is_int($number)) {
            $number = self::fromInt($number);
        } else {
            $number = self::fromString($number);
        }

        if ($number === '' || preg_match('/[^0-9.\-]/', $number) !== 0) {
            throw new InvalidNumberException($number);
        }

        return $number;
    }

    /**
     * @param string $number
     *
     * @return string
     */
    public static function cleanup(string $number): string
    {
        if (strpos($number, '.') !== false) {
            $number = rtrim(rtrim($number, '0'), '.');
        }

        if ($number === '-0') {
            $number = '0';
        }

        return $number;
    }

    /**
     * @param float $number
     *
     * @return string
     * @throws InvalidScientificNotationException
     */
    private static function fromFloat(float $number): string
    {
        $numberStr = (string) $number;
        $decimals = 20;
        if (\strpos($numberStr, 'E') !== false) {
            $parts = self::getScientificNotationParts($numberStr);
            // If the exponent is less than 20, increase the number of decimals
            // to always allow for 20 digits to a maximum of 52 decimal places.
            // The 52 is a limit placed on sprintf
            if ($parts['exponent'] < 20) {
                $decimals = min(abs($parts['exponent'] - 20), 52);
            } else {
                $decimals = 0;
            }
        }

        return sprintf("%.{$decimals}f", $number);
    }

    /**
     * @param int $number
     *
     * @return string
     */
    private static function fromInt(int $number): string
    {
        return (string) $number;
    }

    /**
     * @param string $number
     *
     * @return string
     * @throws InvalidScientificNotationException
     */
    private static function fromString(string $number): string
    {
        $number = trim($number);
        if (strpos($number, 'E') !== false) {
            $number = self::fromScientificNotation($number);
        }

        return $number;
    }

    /**
     * @param string $number
     *
     * @return string
     * @throws InvalidScientificNotationException
     */
    private static function fromScientificNotation(string $number): string
    {
        $parts = self::getScientificNotationParts($number);

        return bcmul($parts['base'], bcpow('10', $parts['exponent'], $parts['scale']), $parts['scale']);
    }

    /**
     * @param string $number
     *
     * @return array
     * @throws InvalidScientificNotationException
     */
    private static function getScientificNotationParts(string $number): array
    {
        $count = preg_match('/^([-+]?)(\d)(?:\.(\d+))?[Ee]([-+]?)(\d+)/', $number, $matches);

        if ($count !== 1) {
            throw new InvalidScientificNotationException($number);
        }

        list(, $sign, $intDigit, $decimalDigits, $exponentSign, $exponentDigits) = $matches;

        $base = $sign.$intDigit.'.'.$decimalDigits;
        $exponent = $exponentSign.$exponentDigits;

        $scale = 0;
        if ($exponentSign === '-') {
            $scale = (int)$exponentDigits + \strlen($decimalDigits);
        }

        return [
            'base' => $base,
            'exponent' => $exponent,
            'scale' => $scale
        ];
    }
}
