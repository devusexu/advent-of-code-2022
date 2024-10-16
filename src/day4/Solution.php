<?php

declare(strict_types=1);

namespace Xu\AdventOfCode2022\day4;

use SplFileObject;

class Solution
{
    public static function solve(): int
    {
        $file = new SplFileObject("input");
        $pairCount = 0;

        while (!$file->eof()) {
            // trim the new line character
            $line = trim($file->fgets());

            // find if a range is fully contained within another range
            if (self::isFullyOverlapped(self::getPair($line))) {
                $pairCount++;
            }
        }

        return $pairCount;
    }

    // 1-3,2-4 => [[1, 3], [2, 4]]
    private static function getPair(string $line): array
    {
        return array_map(
            fn($range) => explode('-', $range),
            explode(',', $line)
        );
    }

    private static function isFullyOverlapped(array $pair): bool
    {
        // range 1 contains range 2 or range 2 contains range 1
        return ($pair[0][0] <= $pair[1][0] && $pair[0][1] >= $pair[1][1])
            || ($pair[1][0] <= $pair[0][0] && $pair[1][1] >= $pair[0][1]);
    }
}
