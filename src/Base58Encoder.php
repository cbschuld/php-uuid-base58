<?php

declare(strict_types = 1);

/*

Very Special thanks for Mika Tuupola for his work on the Base58 conversion

This encoder/decoder is based on his work:
https://github.com/tuupola/base58

Copyright (c) 2020 Chris Schuld <cbschuld@gmail.com>
Copyright (c) 2017-2019 Mika Tuupola

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:
The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

*/


namespace cbschuld;

use InvalidArgumentException;

class Base58Encoder
{

    private static $_BASE58_ALPHABET = "123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz";

    /**
     * Encode given data to a base58 string
     * @param string $data
     * @return string encoded string
     */
    public function encode(string $data): string
    {
        $data = str_split($data);
        $data = array_map("ord", $data);

        $leadingZeroes = 0;
        while (!empty($data) && 0 === $data[0]) {
            $leadingZeroes++;
            array_shift($data);
        }

        $converted = $this->baseConvert($data, 256, 58);

        if (0 < $leadingZeroes) {
            $converted = array_merge(
                array_fill(0, $leadingZeroes, 0),
                $converted
            );
        }

        return implode("", array_map(function ($index) {
            return self::$_BASE58_ALPHABET[$index];
        }, $converted));
    }

    /**
     * Decode given base58 string back to data
     * @param string $data
     * @return string
     */
    public function decode(string $data): string
    {
        $this->validateInput($data);

        $data = str_split($data);
        $data = array_map(function ($character) {
            return strpos(self::$_BASE58_ALPHABET, $character);
        }, $data);

        $leadingZeroes = 0;
        while (!empty($data) && 0 === $data[0]) {
            $leadingZeroes++;
            array_shift($data);
        }

        $converted = $this->baseConvert($data, 58, 256);

        if (0 < $leadingZeroes) {
            $converted = array_merge(
                array_fill(0, $leadingZeroes, 0),
                $converted
            );
        }

        return implode("", array_map("chr", $converted));
    }

    private function validateInput(string $data): void
    {
        /* If the data contains characters that aren't in the character set. */
        if (strlen($data) !== strspn($data, self::$_BASE58_ALPHABET)) {
            $valid = str_split(self::$_BASE58_ALPHABET);
            $invalid = str_replace($valid, "", $data);
            $invalid = count_chars($invalid, 3);
            throw new InvalidArgumentException(
                "Data contains invalid characters \"{$invalid}\""
            );
        }
    }

    /**
     * Convert an integer between arbitrary bases
     * @see http://codegolf.stackexchange.com/a/21672
     * @param array $source
     * @param int $sourceBase
     * @param int $targetBase
     * @return array
     */
    public function baseConvert(array $source, int $sourceBase, int $targetBase): array
    {
        $result = [];
        while ($count = count($source)) {
            $quotient = [];
            $remainder = 0;
            for ($i = 0; $i !== $count; $i++) {
                $accumulator = $source[$i] + $remainder * $sourceBase;
                /* Same as PHP 7 intdiv($accumulator, $targetBase) */
                $digit = ($accumulator - ($accumulator % $targetBase)) / $targetBase;
                $remainder = $accumulator % $targetBase;
                if (count($quotient) || $digit) {
                    $quotient[] = $digit;
                }
            }
            array_unshift($result, $remainder);
            $source = $quotient;
        }

        return $result;
    }
}