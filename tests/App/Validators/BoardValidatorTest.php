<?php

namespace Tests\App\Validators;

use App\Validators\BoardValidator;

class BoardValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BoardValidator $sut
     */
    private $sut;

    /**
     * @var array $validBoard
     */
    private $validBoard;

    public function setUp()
    {
        $this->sut= new BoardValidator();
        $this->validBoard = array(
            array('X','',''),
            array('','',''),
            array('','','')
        );

        parent::setUp();
    }

    public function tearDown()
    {
        $this->sut = null;
        $this->validBoard = null;

        parent::tearDown();
    }

    public function testEnvironment()
    {
        $this->assertNotNull($this->sut);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testIncorrectPlayerUnitThrows()
    {
        $this->sut->validate($this->validBoard, 'A');
    }

    function testCorrectPlayerUnitValidates()
    {
        $this->sut->validate($this->validBoard, 'X');
    }

    /**
     * @expectedException  \InvalidArgumentException
     */
    public function testBoardNotThreeLinesThreeColumnsThrows()
    {
        $board = array(
            array('X' , 'X', 'X'),
            array('O' , 'O'),
            array('O' )
        );

        $this->sut->validate($board, 'X');
    }

    public function testBoardThreeLinesThreeColumnValidates()
    {
        $this->sut->validate($this->validBoard, 'X');
    }

    /**
     * @expectedException  \InvalidArgumentException
     */
    public function testBoardWithInvalidSignThrows()
    {
        $invalidSigns = array(
            array('X' , 'O', 'X'),
            array('O' , 'X', 'O'),
            array('X' , ' ', 'G')
        );

        $this->sut->validate($invalidSigns, 'X');
    }

    /**
     * @expectedException  \InvalidArgumentException
     */
    public function testBoardWithIncorrectNumberOfSameUnit()
    {
        $invalidBoard = array(
            array('X','X',''),
            array('','',''),
            array('','','')
        );

        $this->sut->validate($invalidBoard, 'X');
    }


}
