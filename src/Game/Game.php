<?php


namespace App\Game;


use App\Model\Result;

class Game implements GameInterface
{
    /**
     * @var MoveInterface $bot
     */
    private $bot;

    /**
     * @var GameStatusVerifierInterface $verifier
     */
    private $verifier;

    public function __construct(MoveInterface $mover, GameStatusVerifierInterface $verifier)
    {
        $this->bot = $mover;
        $this->verifier = $verifier;
    }

    /**
     * @param array $board
     * @param string $playerUnit
     * @return Result mixed
     */
    public function playNextMove($board, $playerUnit)
    {
        $nextMove = [];
        $gameStatus = $this->verifier->verifyStatus($board, $playerUnit);

        if ($gameStatus["gameCompleted"] == 0) {

            $nextMove = $this->bot->makeMove($board, $playerUnit);
            $actualBoard = $this->buildCompleteBoard($board, $nextMove);

            $gameStatus = $this->verifier->verifyStatus($actualBoard, $playerUnit == 'X' ? 'X' : 'O');
        }

        return $this->buildResult($gameStatus, $nextMove);
    }

    /**
     * @param array $board
     * @param array $nextMove
     * @return array
     */
    private function buildCompleteBoard($board, $nextMove)
    {
        $actualBoard = $board;
        $actualBoard[$nextMove[1]][$nextMove[0]] = $nextMove[2];

        return $actualBoard;
    }

    /**
     * @param array $gameStatus
     * @param array $nextMove
     * @return Result
     */
    private function buildResult($gameStatus, $nextMove)
    {
        $result = new Result();

        $result->gameCompleted = $gameStatus["gameCompleted"];
        $result->message = $gameStatus["message"];
        $result->nextMove = $nextMove;

        return $result;
    }
}