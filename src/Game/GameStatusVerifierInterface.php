<?php

namespace App\Game;


interface GameStatusVerifierInterface
{

    /**
     * @param array $board
     * @param string $playerUnit
     * @return array mixed
     */
    function verifyStatus($board, $playerUnit);

}