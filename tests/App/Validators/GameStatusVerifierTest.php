<?php
/**
 * Created by PhpStorm.
 * User: maurizio
 * Date: 27/05/18
 * Time: 11.34
 */

namespace App\Tests\App\Validators;

use App\Game\BoardValidatorInterface;
use App\Validators\GameStatusVerifier;
use Prophecy\Exception\InvalidArgumentException;

class GameStatusVerifierTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var GameStatusVerifier $sut
     */
    private $sut;

    /**
     * @var BoardValidatorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $validator;


    protected function setUp()
    {
        $this->validator = $this->getMockBuilder(BoardValidatorInterface::class)->getMock();

        $this->sut = new GameStatusVerifier($this->validator);

        parent::setUp();
    }


    protected function tearDown()
    {
        $this->sut = null;
        $this->validator = null;

        parent::tearDown();
    }

    public function testInvalidBoardShouldSetGameCompletedAndErrorMessage()
    {
        // given
        $this->validator->expects($this->any())->method('validate')->willThrowException(new \InvalidArgumentException("ex message"));
        $invalidBoard = array();

        // when
        $result = $this->sut->verifyStatus($invalidBoard, "X");

        // then
        $this->assertEquals(1, $result["gameCompleted"]);
        $this->assertEquals("ex message", $result["message"]);
    }


    public function testValidIncompleteBoardReturnStatusAndNextPlayerMoveIndication()
    {
        // given
        $this->validator->expects($this->any())->method('validate');
        $incompleteBoard = array(
            array('X','O',''),
            array('','',''),
            array('','','')
        );

        // when
        $result = $this->sut->verifyStatus($incompleteBoard, "X");


        // then
        $this->assertEquals(0, $result["gameCompleted"]);
        $this->assertEquals("Your turn to move", $result["message"]);

    }

    public function testValidCompleteBoardReturnsWinnerDiagonal()
    {
        $this->validator->expects($this->any())->method('validate');
        $incompleteBoard = array(
            array('X','O','O'),
            array('','X',''),
            array('','','X')
        );

        // when
        $result = $this->sut->verifyStatus($incompleteBoard, "X");


        // then
        $this->assertEquals(1, $result["gameCompleted"]);
        $this->assertEquals("The winner is the X player", $result["message"]);
    }

    public function testValidCompleteBoardReturnsWinnerAntiDiagonal()
    {
        $this->validator->expects($this->any())->method('validate');
        $incompleteBoard = array(
            array('','O','X'),
            array('','X',''),
            array('X','','O')
        );

        // when
        $result = $this->sut->verifyStatus($incompleteBoard, "X");


        // then
        $this->assertEquals(1, $result["gameCompleted"]);
        $this->assertEquals("The winner is the X player", $result["message"]);
    }

    public function testValidCompleteBoardReturnsWinnerRow()
    {
        $this->validator->expects($this->any())->method('validate');
        $incompleteBoard = array(
            array('X','X','X'),
            array('','O',''),
            array('','','O')
        );

        // when
        $result = $this->sut->verifyStatus($incompleteBoard, "X");


        // then
        $this->assertEquals(1, $result["gameCompleted"]);
        $this->assertEquals("The winner is the X player", $result["message"]);
    }

    public function testValidCompleteBoardReturnsWinnerColumn()
    {
        $this->validator->expects($this->any())->method('validate');
        $incompleteBoard = array(
            array('X','X','O'),
            array('','','O'),
            array('','','O')
        );

        // when
        $result = $this->sut->verifyStatus($incompleteBoard, "X");


        // then
        $this->assertEquals(1, $result["gameCompleted"]);
        $this->assertEquals("The winner is the O player", $result["message"]);
    }


    public function testValidFullBoardReturnsCompletedNoWinner()
    {
        $this->validator->expects($this->any())->method('validate');
        $incompleteBoard = array(
            array('O','X','O'),
            array('X','O','X'),
            array('X','O','X')
        );

        // when
        $result = $this->sut->verifyStatus($incompleteBoard, "X");


        // then
        $this->assertEquals(1, $result["gameCompleted"]);
        $this->assertEquals("Tied Game", $result["message"]);
    }
}
