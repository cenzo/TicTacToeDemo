<?php


namespace Tests\App\Game;

use App\Game\BoardValidatorInterface;
use App\Game\TicTacToeStrategistInterface;
use App\Game\Bot;

class BotTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var BoardValidatorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $validator;

    /**
     * @var TicTacToeStrategistInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $strategist;

    /**
     * @var Bot
     */
    private $sut;

    public function setUp() : void
    {
        $this->validator = $this->getMockBuilder(BoardValidatorInterface::class)->getMock();
        $this->strategist = $this->getMockBuilder(TicTacToeStrategistInterface::class)->getMock();

        $this->sut =  new Bot($this->validator, $this->strategist);

        parent::setUp();
    }

    protected function tearDown()
    {
        $this->validator = null;
        $this->strategist = null;
        $this->sut = null;

        parent::tearDown();
    }

    public function testEnvironment()
    {
        $this->assertTrue(!is_null($this->sut));
    }

    public function testMovingShouldReturnArray()
    {
        // given
        $this->strategist->expects($this->any())->method('getNextMove')->willReturn(array());

        // when
        $nextMove = $this->sut->makeMove(array(), 'X');

        // then
        $this->AssertTrue(is_array($nextMove));
    }

    public function testMoveShouldValidateInput()
    {
        // given
        $invalidBoard = array();
        $invalidPlayer = "I";

        $this->validator->expects($this->once())
            ->method('validate');

        // when -> then
        $this->sut->makeMove($invalidBoard, $invalidPlayer);
    }

    public function testMoveShouldUseStrategistToChooseNextMove()
    {
        // given
        $board = array();
        $player = 'X';
        $this->strategist->expects($this->once())->method('getNextMove')->willReturn(array());

        // when -> then
        $this->sut->makeMove($board, $player);
    }
}
