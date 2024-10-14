<?php

declare(strict_types=1);

namespace Xu\AdventOfCode2022\day2;

use SplFileObject;

class Solution
{
    public static function solve(): int
    {
        $file = new SplFileObject("input");
        $points = 0;

        while (!$file->eof()) {
            $line = $file->fgets();

            // trim the new line character
            $points += self::COMBINATIONS[trim($line)];
        }

        return $points;
    }

    private const array COMBINATIONS = [
            // win
            'A Y' => 8,
            'B Z' => 9,
            'C X' => 7,
            // draw
            'A X' => 4,
            'B Y' => 5,
            'C Z' => 6,
            // lost
            'A Z' => 3,
            'B X' => 1,
            'C Y' => 2
    ];
}
