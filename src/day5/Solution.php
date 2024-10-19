<?php

declare(strict_types=1);

namespace Xu\AdventOfCode2022\day5;

use Ds\Stack;
use SplFileObject;

class Solution
{
    private const int NUMBER_OF_STACKS = 9;
    private const int NUMBER_OF_INITIAL_LAYERS = 8;
    private const int STARTING_LINE_NUMBER_OF_INSTRUCTION = 10;

    public function solve(): string
    {
        [$stackInput, $instructionInput] = $this->getInput('input');

        $stacks = $this->getStacks($stackInput);

        $instructions = $this->getInstructions($instructionInput);

        $this->moveCrates($stacks, $instructions);

        return $this->getMessage($stacks);
    }

    public function getInput(string $filename): array
    {
        $file = new SplFileObject($filename);
        $input = [];

        while (!$file->eof()) {
            $line = trim($file->fgets());
            $input[] = $line;
        }

        $stackInput = $this->getStackInput($input);
        $instructionInput = $this->getInstructionInput($input);

        return [$stackInput, $instructionInput];
    }

    private function getStackInput(array $input): array
    {
        return array_slice($input, 0, self::NUMBER_OF_INITIAL_LAYERS);
    }

    private function getInstructionInput(array $input): array
    {
        return array_slice($input, self::STARTING_LINE_NUMBER_OF_INSTRUCTION);
    }

    private function getStacks(array $stackInput): array
    {
        $stacks = $this->initializeStacks();

        $stackData = $this->formatStackInput($stackInput);

        $positions = $this->getStackPositions($stackData);

        // start from the bottom crate, push each layer into stacks
        for ($i = count($stackData) - 1; $i >= 0; $i--) {
            foreach ($positions as $key => $position) {
                $crate = $stackData[$i][$position] ?? ' ';

                if ($crate !== ' ') {
                    $stacks[$key + 1]->push($crate);
                }
            }
        }

        return $stacks;
    }

    private function initializeStacks(): array
    {
        $stacks = [];

        for ($i = 1; $i <= self::NUMBER_OF_STACKS; $i++) {
            $stacks[$i] = new Stack();
        }

        return $stacks;
    }

    public function formatStackInput(array $stackInput): array
    {
        // replace [ or ] with one space for each crate
        $format = function (string $string) {
            return preg_replace('/[\[\]]/', ' ', $string);
        };

        return array_map($format, $stackInput);
    }

    public function getStackPositions(array $stackData): array
    {
        preg_match_all(
            '/[A-Z]/',
            $stackData[self::NUMBER_OF_INITIAL_LAYERS - 1],
            $matches,
            PREG_OFFSET_CAPTURE
        );

        // Extract the positions of each bottom crate
        return array_map(function ($match) {
            return $match[1]; // Extract the position of each match
        }, $matches[0]);
    }

    public function getInstructions(array $instructionInput): array
    {
        $instructions = [];

        foreach ($instructionInput as $line) {
            preg_match_all(
                '/\d+/',
                $line,
                $matches
            );

            $instructions[] = $matches[0];
        }

        return $instructions;
    }

    private function moveCrates(array &$stacks, array $instructions): void
    {
        foreach ($instructions as $instruction) {
            [$numberOfMovement, $from, $target] = $instruction;

            $numberOfMovement = min($numberOfMovement, $stacks[$from]->capacity());

            for ($i = 0; $i < $numberOfMovement; $i++) {
                $crate = $stacks[$from]->pop();
                $stacks[$target]->push($crate);
            }
        }
    }

    private function getMessage(array $stacks): string
    {
        $message = '';

        // concat the first crate of each stack
        foreach ($stacks as $stack) {
            $message .= $stack->peek();
        }

        return $message;
    }
}
