<?php

declare(strict_types=1);

namespace Xu\AdventOfCode2022\day3;

use SplFileObject;

class Solution
{
    public static function solve(): int
    {
        $file = new SplFileObject("input");
        $totalPriority = 0;

        while (!$file->eof()) {
            // trim the new line character
            $line = trim($file->fgets());
            $letterArray = str_split($line);
            $length = count($letterArray);

            // split the line in half, then find the common letter
            $firstHalf = array_slice($letterArray, 0, $length / 2);
            $secondHalf = array_slice($letterArray, $length - $length / 2);
            $commonType = array_intersect($firstHalf, $secondHalf);

            // sum the priority of the letter
            $totalPriority += self::computePriority(reset($commonType));
        }

        return $totalPriority;
    }

    private static function computePriority(string $letter): int
    {
        // ascii value of lowercase letters: a -> 97
        if (preg_match("/[a-z]/", $letter)) {
            return ord($letter) - 96;
        }

        // ascii value of uppercase letters: A -> 65
        return ord($letter) - 38;
    }
}
