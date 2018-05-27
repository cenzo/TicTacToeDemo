<?php

namespace App\Tests\App\Game;

use App\Game\Game;
use App\Game\GameStatusVerifierInterface;
use App\Game\MoveInterface;
use App\Model\Result;

class GameTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Game $sut
     */
    private $sut;

    /**
     * @var GameStatusVerifierInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $verifier;

    /**
     * @var MoveInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $mover;


    protected function setUp()
    {
        $this->mover =$this->getMockBuilder(MoveInterface::class)->getMock();
        $this->verifier = $this->getMockBuilder(GameStatusVerifierInterface::class)->getMock();
        $this->sut = new Game($this->mover, $this->verifier);

        parent::setUp();
    }

    protected function tearDown()
    {
        $this->mover = null;
        $this->verifier = null;
        $this->sut = null;

        parent::tearDown();
    }

    public function testIfPlayerWinsNoBotMoveAreTaken()
    {
        // given
        $this->verifier->expects($this->once())->method('verifyStatus')->willReturn(array('gameCompleted' => 1, 'message' => 'm'));
        $board = array();
        $playerUnit = 'X';

        $this->mover->expects($this->never())->method('makeMove');

        // when
        /**
         * @var Result $result
         */
        $result = $this->sut->playNextMove($board, $playerUnit);

        // then
        $this->assertEquals(1, $result->gameCompleted);
        $this->assertEquals('m', $result->message);
        $this->assertEquals(array(), $result->nextMove);
    }


    public function testIfPlayerDoNotWinsBotMoves()
    {
        $this->verifier->expects($this->exactly(2))->method('verifyStatus')->willReturn(array('gameCompleted' => 0, 'message' => 'm'));
        $board = array();
        $playerUnit = 'X';

        $this->mover->expects($this->once())->method('makeMove');

        $result = $this->sut->playNextMove($board, $playerUnit);
    }


}
