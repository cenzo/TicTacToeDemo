<?php


namespace App\Game;


use App\Model\Result;

interface GameInterface
{

    /**
     * @param array $board
     * @param string $playerUnit
     * @return Result mixed
     */
    function playNextMove($board, $playerUnit);

}