<?php

declare(strict_types=1);

namespace Xu\AdventOfCode2022\day1;

use SplFileObject;

class Solution
{
    public static function solve(): int
    {
        $file = new SplFileObject("input.txt");
        $maxCalories = 0;
        $currentCalories = 0;

        while (!$file->eof()) {
            $line = $file->fgets();

            if (trim($line) === '') {
                $maxCalories = max($maxCalories, $currentCalories);
                $currentCalories = 0;
                continue;
            }

            $currentCalories += (int) $line;
        }

        // check the last elf's calories
        return max($maxCalories, $currentCalories);
    }
}
