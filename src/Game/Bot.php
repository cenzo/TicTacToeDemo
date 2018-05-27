<?php

namespace App\Game;


class Bot implements MoveInterface
{

    /**
     * @var BoardValidatorInterface
     */
    private $validator;

    /**
     * @var TicTacToeStrategistInterface
     */
    private $strategist;

    /**
     * Move constructor.
     * @param BoardValidatorInterface $validator
     * @param TicTacToeStrategistInterface $strategist
     */
    public function __construct(BoardValidatorInterface $validator, TicTacToeStrategistInterface $strategist)
    {
        $this->validator = $validator;
        $this->strategist = $strategist;
    }


    /**
     * Returns an array, containing x and y coordinates for next move, and the unit that now occupies it.
     * Example: [2, 0, 'O'] - upper right corner - O player
     *
     * @param array $boardState Current board state
     * @param string $playerUnit Player unit representation
     *
     * @return array
     */
    public function makeMove($boardState, $playerUnit = 'X')
    {
        $this->validator->validate($boardState, $playerUnit);

        $botMove = $this->strategist->getNextMove($boardState, $playerUnit);

        return $botMove;
    }
}