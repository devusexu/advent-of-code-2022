<?php

declare(strict_types=1);

namespace Xu\AdventOfCode2022\day3;

use SplFileObject;

class Bonus
{
    public static function solve(): int
    {
        $file = new SplFileObject("input");
        $totalPriority = 0;
        $temporaryGroup = [];
        $counter = 0;

        while (!$file->eof()) {
            if ($counter === 3) {
                $commonType = self::getCommonType($temporaryGroup);
                $totalPriority += self::getPriority($commonType);

                $temporaryGroup = [];
                $counter = 0;
                continue;
            }

            $line = trim($file->fgets());
            $temporaryGroup[] = $line;
            $counter++;
        }

        // add the last group
        $commonType = self::getCommonType($temporaryGroup);
        $totalPriority += self::getPriority($commonType);

        return $totalPriority;
    }

    private static function getCommonType(array $group): string
    {
        $commonType = array_intersect(...array_map('str_split', $group));

        // use reset to get the first and only common letter
        return reset($commonType);
    }

    private static function getPriority(string $letter): int
    {
        // ascii value of lowercase letters: a -> 97
        if (preg_match("/[a-z]/", $letter)) {
            return ord($letter) - 96;
        }

        // ascii value of uppercase letters: A -> 65
        return ord($letter) - 38;
    }
}
