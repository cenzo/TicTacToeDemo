<?php

namespace App\Tests\App\Strategist;

use App\Strategists\DumbPlayer;

class DumbPlayerTest extends \PHPUnit_Framework_TestCase
{

    function testGetNextMoveWithFullBoardReturnVoid()
    {
        $board = array (
            array('X', 'O', 'X'),
            array('X', 'X', 'O'),
            array('O', 'O', 'X')
        );
        $sut = new DumbPlayer();

        $nextMove = $sut->getNextMove($board, 'X');

        $this->assertTrue(is_null($nextMove));
    }

    function testNonEmptyMoveReturnFisrtAvailablePosition()
    {
        $board = array (
            array('X', ' ', 'X'),
            array('X', 'X', 'O'),
            array('O', 'O', 'X')
        );

        $sut = new DumbPlayer();

        $nextMove = $sut->getNextMove($board, 'O');


        $this->assertEquals(array(1,0,'X'), $nextMove);
    }


    function testRespondToFirstMove()
    {
        $board = array (
            array("X", "", ""),
            array("", "", ""),
            array("", "", "")
        );

        $sut = new DumbPlayer();

        $nextMove = $sut->getNextMove($board, 'O');


        $this->assertEquals(array(1,0,'X'), $nextMove);
    }
}
