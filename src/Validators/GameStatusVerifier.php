<?php

namespace App\Validators;


use App\Game\BoardValidatorInterface;
use App\Game\GameStatusVerifierInterface;

class GameStatusVerifier implements GameStatusVerifierInterface
{
    /**
     * @var BoardValidatorInterface $validator
     */
    private $validator;

    public function __construct(BoardValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param $board
     * @param $playerUnit
     * @return mixed
     */
    public function verifyStatus($board, $playerUnit)
    {
        try{
            $this->validator->validate($board, $playerUnit);
            $winner = $this->findWinner($board);

            if ($winner != "")
                return array(
                    "gameCompleted" => 1,
                    "message"=> "The winner is the $winner player");

            if($this->fullBoard($board))
                return array(
                    "gameCompleted" => 1,
                    "message"=> "Tied Game");
            else
                return array(
                    "gameCompleted" => 0,
                    "message"=> "Your turn to move");


        }
        catch (\InvalidArgumentException $ex)
        {
            return array (
                "gameCompleted" => 1,
                "message"=> $ex->getMessage()
                );
        }
    }

    /**
     * @param array $board
     * @return bool
     */
    private function fullBoard($board)
    {
        $freePosition = false;
        foreach ($board as $row) {
            foreach ($row as $item) {
                if ($item =='' || $item == ' ')
                    $freePosition = true;
            }
        }

        return !$freePosition;
    }

    /**
     * @param array $board
     * @return string
     */
    private function findWinner($board)
    {
        $countX = 0;
        $countO = 0;

        foreach ($this->getWins() as $win) {
            foreach ($win as $position) {
                if($board[$position[0]][$position[1]] == 'X')
                    $countX ++;
                if($board[$position[0]][$position[1]] == 'O')
                    $countO ++;
            }
            if ($countX == 3)
                return 'X';

            if ($countO == 3)
                return 'O';

            $countX = $countO = 0;
        }
        return "";
    }

    /**
     * @return array
     */
    private function getWins()
    {
        $wins = array(
            array(
                array(0,0),
                array(1,1),
                array(2,2)
            ),
            array(
                array(2,0),
                array(1,1),
                array(0,2)
            )
        );

        for($i=0 ; $i<3; ++$i)
        {
            $wins[] =
                array(

                    array(0,$i),
                    array(1,$i),
                    array(2,$i)
                );
            $wins[] =
                array(
                    array($i,0),
                    array($i,1),
                    array($i,2)
                );
        }

        return $wins;
    }
}