<?php

namespace App\Validators;


use App\Game\BoardValidatorInterface;

/**
 * Class BoardValidator
  */
class BoardValidator implements BoardValidatorInterface
{

    /**
     * @param array $board
     * @param string $playerUnit
     */
    public function validate($board, $playerUnit)
    {
        $this->validatePlayerUnit($playerUnit);

        $this->validateBoard($board);
    }

    /**
     * @param string $playerUnit
     */
    private function validatePlayerUnit($playerUnit)
    {
        if ($playerUnit != 'X' && $playerUnit != 'O')
            throw new \InvalidArgumentException("Invalid player unit, player unit should be X or O");
    }

    /**
     * @param array $board
     */
    private function validateBoard($board)
    {
        $this->validateNumberOfRow($board);
        $this->validateRows($board);
        $this->validateNumberOfSigns($board);
    }

    /**
     * @param array $board
     */
    private function validateNumberOfRow($board)
    {
        if (count($board) != 3)
            throw new \InvalidArgumentException("Invalid Board, board should be 3x3");
    }

    /**
     * @param array $board
     */
    private function validateRows($board)
    {
        foreach ($board as $row) {
            $this->validateNumberOfColumns($row);
            $this->validateItemsValue($row);
        }
    }

    /**
     * @param array $row
     */
    private function validateNumberOfColumns($row)
    {
        if (count($row) != 3)
            throw new \InvalidArgumentException("Invalid Board, board should be 3x3");
    }

    /**
     * @param array $row
     */
    private function validateItemsValue($row)
    {
        foreach ($row as $value) {
            if (!in_array($value, array('X', 'O', '')))
                throw new \InvalidArgumentException("Invalid Sign, Allowed signs are X or O");
        }
    }

    private function validateNumberOfSigns($board)
    {
        $sumOfX = 0;
        $sumOfO = 0;
        foreach ($board as $row)
        {
            foreach ($row as $item)
            {
                if($item == 'X')
                    $sumOfX++;

                if($item == 'O')
                    $sumOfO++;
            }
        }
        if ($sumOfX - $sumOfO >= 2)
            throw new \InvalidArgumentException("Each Player should have a move one each turn");
    }
}