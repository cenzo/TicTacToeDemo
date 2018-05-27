<?php

namespace App\Game;


interface TicTacToeStrategistInterface
{
    /**
     * @param array $boardState
     * @param string $playerUnit
     *
     * @return array $nextMove
     *
     */
    function getNextMove($boardState, $playerUnit);
}