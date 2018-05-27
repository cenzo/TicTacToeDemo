<?php

namespace App\Game;


interface BoardValidatorInterface
{
    /**
     * @param array $board
     * @param string $playerUnit
     * @return bool
     */
    public function validate($board, $playerUnit);
}