<?php

declare(strict_types=1);

namespace Xu\AdventOfCode2022\day1;

use SplFileObject;

class Bonus
{
    public static function solve(): int
    {
        $file = new SplFileObject("input.txt");
        $currentCalories = 0;
        $inventory = [];

        while (!$file->eof()) {
            $line = $file->fgets();

            if (trim($line) === '') {
                $inventory[] = $currentCalories;
                $currentCalories = 0;
                continue;
            }

            $currentCalories += (int) $line;
        }

        // store the last elf's calories
        $inventory[] = $currentCalories;

        rsort($inventory);

        return $inventory[0] + $inventory[1] + $inventory[2];
    }
}
