<?php

declare(strict_types=1);

namespace Xu\AdventOfCode2022\day4;

use SplFileObject;

class Bonus
{
    public static function solve(): int
    {
        $file = new SplFileObject("input");
        $pairCount = 0;

        while (!$file->eof()) {
            // trim the new line character
            $line = trim($file->fgets());

            // find if a range is overlapped with another range
            if (self::isOverlapped(Solution::getPair($line))) {
                $pairCount++;
            }
        }

        return $pairCount;
    }
    private static function isOverlapped(array $pair): bool
    {
        return ($pair[1][1] >= $pair[0][0] && $pair[1][1] <= $pair[0][1])
            || ($pair[1][0] >= $pair[0][0] && $pair[1][0] <= $pair[0][1])
            || ($pair[1][0] <= $pair[0][0] && $pair[1][1] >= $pair[0][1]);
    }
}
