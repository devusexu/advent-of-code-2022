<?php

declare(strict_types=1);

namespace Xu\AdventOfCode2022\day5;

class Bonus
{
    public function solve(): string
    {
        $solution = new Solution();

        [$stackInput, $instructionInput] = $solution->getInput('input');

        $emptyStacks = $this->initializeStacks();
        $positions = $solution->getStackPositions($stackInput);

        $stacks = $this->getStacks($stackInput, $positions, $emptyStacks);

        $instructions = $solution->getInstructions($instructionInput);

        $this->moveCrates($stacks, $instructions);

        return $this->getMessage($stacks);
    }

    private function initializeStacks(): array
    {
        return array_fill(1, Solution::NUMBER_OF_STACKS, []);
    }

    private function getStacks(array $stackInput, array $positions, array $stacks): array
    {
        // start from the bottom crate, push each layer into stacks
        for ($i = count($stackInput) - 1; $i >= 0; $i--) {
            foreach ($positions as $key => $position) {
                $crate = $stackInput[$i][$position] ?? ' ';

                if ($crate !== ' ') {
                    $stacks[$key + 1][] = $crate;
                }
            }
        }

        return $stacks;
    }

    private function moveCrates(array &$stacks, array $instructions): void
    {
        foreach ($instructions as $instruction) {
            [$numberOfMovement, $from, $target] = $instruction;

            $numberOfMovement = min((int)$numberOfMovement, count($stacks[$from]));

            // extract crates from 'from' stack
            $crates = array_splice($stacks[$from], -$numberOfMovement);

            // add it to 'target' stack
            array_push($stacks[$target], ...$crates);
        }
    }

    private function getMessage(array $stacks): string
    {
        $message = '';

        // concat the first crate of each stack (the end of the array)
        foreach ($stacks as $stack) {
            $message .= $stack[count($stack) - 1];
        }

        return $message;
    }
}
