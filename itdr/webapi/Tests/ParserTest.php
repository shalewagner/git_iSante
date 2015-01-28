<?php

namespace Tests;

require_once('includes.php');

class ParserTest extends \PHPUnit_Framework_TestCase {    
    
    // supported equations
    // a                    -> (a>0)
    // a and b              -> (a>0) AND (b>0)
    // a and b and not c    -> (a>0) AND (b>0) AND (c=0)
    // a or b               -> (a>0) OR (b>0)
    // (a and b) or c       -> (a>0) AND (b>0) OR (c>0)
    // a and b and (c or d) -> (a>0) AND (b>0) AND (c>0 OR d>0)
    
    // a > 0
    // a>0 && b>0
    // a>0 && b>0 and c==0
    // a>0 || b>0
    // (a>0 && b>0) || c>0
    // a>0 && b>0 and (c>0 or d>0)
    
    public function testRegexBasic()
    {        
        $test = preg_split(
            '@([\d\.]+)|(\+|\-|\*|/|\>|\<|\(|\)|\&&|\|\||\!)@',
        	"(1+1)",
        	null,
        	PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
        );
        
        $this->assertEquals(5, count($test));        
    }   
    
    public function testRegexWithGT()
    {        
        $test = preg_split(
            '@([\d\.]+)|(\+|\-|\*|/|\>|\<|\(|\)|\&&|\|\||\!)@',
        	"(1>1)",
        	null,
        	PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
        );
        
        $this->assertEquals(5, count($test));        
    }    
    public function testRegexWithBooleans()
    {        
        $test = preg_split(
            '@([\d\.]+)|(\+|\-|\*|/|\>|\<|\(|\)|\&&|\|\||\!)@',
        	"(1&&1)||(2<1)",
        	null,
        	PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
        );
        
        $this->assertEquals(11, count($test));        
    }    

    public function testTokenizeEquation()
    {
        $equation = "1+3";
        $builder = new \Parser();
        $result = $builder->set_content($equation)->tokenize()->get_tokens();//->parse()->evaluate();
        $this->assertEquals(3, count($result));

        $result = $builder->set_content("(1 AND 1) OR (2<1)")->tokenize()->get_tokens();//->parse()->evaluate();
        $this->assertEquals(11, count($result));    
    }
    
    public function testParseEquation()
    {        
        $equation = "1<3";
        $builder = new \Parser();
        $result = $builder->set_content($equation)->tokenize()->parse();//->evaluate();
        $this->assertEquals(3, count($result->get_tree()->get_operations()));

        $result = $builder->set_content("(1>0 AND 2>1) OR (2<1)")->tokenize()->parse();//->evaluate();
        $this->assertEquals(3, count($result->get_tree()->get_operations()));    
    }
    
    public function testEvaluateNonScopedEquation()
    {
        $equation = "1<3";
        $builder = new \Parser();
        $result = $builder->set_content($equation)->tokenize()->parse()->evaluate();
        $this->assertEquals(true, $result);
    }
    
    public function testEvaluateScopedEquationWithAnd()
    {        
        $builder = new \Parser();
        $result = $builder->set_content("((1>0) AND (2>1))")->tokenize()->parse()->evaluate();
        $this->assertEquals(true, $result);    
    }
    
    public function testEvaluateScopedEquationWithEquals()
    {        
        $builder = new \Parser();
        $result = $builder->set_content("((1>0) AND (2=1))")->tokenize()->parse()->evaluate();
        $this->assertEquals(false, $result);    
    }
    
    public function testEvaluateScopedEquationWithOr()
    {        
        $builder = new \Parser();
        $result = $builder->set_content("((1>0) OR (2=1))")->tokenize()->parse()->evaluate();
        $this->assertEquals(true, $result);    
    }
}
