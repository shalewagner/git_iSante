<?php

namespace Tests;

require_once('includes.php');

class EquationFormatterTest extends \PHPUnit_Framework_TestCase {

    public function testFormatEquationWithAddition()
    {
        $equation = "({malariadx}"." + "."{malariadxa})";
        $expected = "((malariadx + malariadxa)>0)";
        $result = \EquationFormatter::FormatEquation($equation);
        $this->assertEquals($expected, $result);
    }

    public function testFormatEquationWithAnd()
    {
        $equation = "{malariadx} AND {malariadxa}";
        $expected = "(malariadx>0) AND (malariadxa>0)";
        $result = \EquationFormatter::FormatEquation($equation);
        $this->assertEquals($expected, $result);
    }
    
    public function testFormatEquationWithOr()
    {
        $equation = "{malariadx} OR {malariadxa}";
        $expected = "(malariadx>0) OR (malariadxa>0)";
        $result = \EquationFormatter::FormatEquation($equation);
        $this->assertEquals($expected, $result);
    }
    
    public function testFormatEquationWithNOT()
    {
        $equation = "{malariadx} AND NOT {malariadxa}";
        $expected = "(malariadx>0) AND (malariadxa=0)";
        $result = \EquationFormatter::FormatEquation($equation);
        $this->assertEquals($expected, $result);
    }
    
    public function testRemoveFieldTokenDelimiters()
    {
        $equation = "({malariadx}>0) AND ({malariadxa}=0)";
        $expected = "(malariadx>0) AND (malariadxa=0)";
        $result = \EquationFormatter::RemoveFieldTokenDelimiters($equation);
        $this->assertEquals($expected, $result);
    }
}
