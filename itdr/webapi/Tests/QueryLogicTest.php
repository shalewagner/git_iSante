<?php

namespace Tests;

require_once('includes.php');

class QueryLogicTest extends \PHPUnit_Framework_TestCase {

    public function testQueryWithSingleSimpleIndicator()
    {
        $request = new \CustomIndicatorRequest();
        $request->timeLevel=1;
        $request->geographyLevel=0;
        $request->indicatorIds=[2];
        
        $result=\QueryLogic::Query(1,$request);

        $this->assertEquals(1, count($result));
        $this->assertEquals('Chloroquine Treatments', $result[0]->name);        
        $this->assertEquals(0, $result[0]->interval0);        
        $this->assertEquals(3, $result[0]->interval1);        
        $this->assertEquals(29, $result[0]->interval8);        
        $this->assertEquals(0, $result[0]->interval9);        
    }
        
    public function testQueryWithTwoSimpleIndicator()
    {
        $request = new \CustomIndicatorRequest();
        $request->timeLevel=1;
        $request->geographyLevel=0;
        $request->indicatorIds=[1,2];
        
        $result=\QueryLogic::Query(1,$request);

        $this->assertEquals(2, count($result));
        $this->assertEquals('Malaria Diagnoses', $result[0]->name);        
        $this->assertEquals('Chloroquine Treatments', $result[1]->name); 
        $this->assertEquals(1, $result[0]->interval3);        
        $this->assertEquals(4, $result[0]->interval9);        
        $this->assertEquals(29, $result[1]->interval8);        
        $this->assertEquals(0, $result[1]->interval9);       
    }
    
    public function testQueryWithFiveIndicator()
    {
        $request = new \CustomIndicatorRequest();
        $request->timeLevel=1;
        $request->geographyLevel=0;
        $request->indicatorIds=[1,2,3,4,5];
        
        $result=\QueryLogic::Query(1,$request);

        $this->assertEquals(5, count($result));
        $this->assertEquals('Malaria Diagnoses', $result[0]->name);        
        $this->assertEquals('Chloroquine Treatments', $result[1]->name); 
        $this->assertEquals(1, $result[0]->interval3);        
        $this->assertEquals(4, $result[0]->interval9);        
        $this->assertEquals(29, $result[1]->interval8);        
        $this->assertEquals(0, $result[1]->interval9);       
    }
    
    public function testQueryWithDifferentDimensions()
    {
        $request = new \CustomIndicatorRequest();
        $request->timeLevel=1;
        $request->geographyLevel=1;
        $request->indicatorIds=[1,2,3,4,5];
        
        $result=\QueryLogic::Query(1,$request);
        $this->assertEquals(5, count($result));
    }
}
