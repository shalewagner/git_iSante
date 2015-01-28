<?php
namespace Tests;

require_once('includes.php');

class AggregatedDataLogicTest extends \PHPUnit_Framework_TestCase {

    public function testGetAggregatedDataAsDtos()
    {
        $dtos = \AggregatedDataLogic::GetAggregatedDataAsDtos(1,1,0,0,0,false);
        $this->assertGreaterThan(10, count($dtos) );
    }

    public function testGetRawDataAsDtos()
    {
        $dtos = \AggregatedDataLogic::GetRawDataAsDtos(1,0,100);
        $this->assertEquals(100, count($dtos) );
    }

    public function testGetDataByTimeInterval()
    {
        $dtos = \AggregatedDataLogic::GetDataByTimeInterval(1,1,0,0,0);
        $this->assertGreaterThan(5, count($dtos) );
    }

    public function testGetDataAsFieldListWithAggregation()
    {
        $dtos = \AggregatedDataLogic::GetDataAsFieldList(1,1,0,0,0,0,100,1);
        $this->assertGreaterThan(10, count($dtos) );
    }

    public function testGetDataByTimeIntervalWithoutAggregation()
    {
        $dtos = \AggregatedDataLogic::GetDataAsFieldList(1,0,0,0,0,0,100,0);
        $this->assertGreaterThan(10, count($dtos) );
    }
}
