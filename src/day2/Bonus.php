<?php

declare(strict_types=1);

namespace Xu\AdventOfCode2022\day2;

use SplFileObject;

class Bonus
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
            // lose
            'A X' => 3,
            'B X' => 1,
            'C X' => 2,
            // draw
            'A Y' => 4,
            'B Y' => 5,
            'C Y' => 6,
            // win
            'A Z' => 8,
            'B Z' => 9,
            'C Z' => 7
    ];
}
