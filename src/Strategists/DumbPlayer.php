<?php


namespace App\Strategists;


use App\Game\TicTacToeStrategistInterface;

class DumbPlayer implements TicTacToeStrategistInterface
{

    /**
     * @param array $boardState
     * @param string $playerUnit
     *
     * @return array $nextMove
     *
     */
    function getNextMove($boardState, $playerUnit)
    {
        $availablePosition = null;

        foreach ($boardState as $b => $row) {
            foreach ($row as $a => $item) {
                if ($item == ' ' || $item == '')
                    $availablePosition[] = array($a, $b, $playerUnit == 'X' ? 'O' : 'X');
            }
        }

        return count($availablePosition) > 0 ? $availablePosition[0] : null;
    }
}