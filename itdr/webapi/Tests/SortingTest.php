<?php

namespace Tests;

require_once('includes.php');

class SortingTest extends \PHPUnit_Framework_TestCase {

    public function testCustomTimeLevelSortOnDtoSorts()
    {
        $first = new \Malaria();
        $first->TimeLevel = 2000;
        $second = new \Malaria();
        $second->TimeLevel = 1900;
        $third = new \Malaria();
        $third->TimeLevel = 2100;

        $items = array();
        array_push($items, $first);
        array_push($items, $second);
        array_push($items, $third);

        usort($items,"Sorting::cmpAsc");
        $this->assertEquals($second,$items[0]);

        usort($items,"Sorting::cmpDesc");
        $this->assertEquals($third,$items[0]);
    }

    public function testGetLastFiveIntervalsDtos()
    {
        $first = new \Malaria();
        $first->TimeLevel = 2000;
        $second = new \Malaria();
        $second->TimeLevel = 1900;
        $third = new \Malaria();
        $third->TimeLevel = 2100;
        $fourth = new \Malaria();
        $fourth->TimeLevel = 2000;
        $fifth = new \Malaria();
        $fifth->TimeLevel = 1910;
        $sixth = new \Malaria();
        $sixth->TimeLevel = 1000;

        $items = array();
        array_push($items, $first);
        array_push($items, $second);
        array_push($items, $third);
        array_push($items, $fourth);
        array_push($items, $fifth);
        array_push($items, $sixth);

        $subset = \Sorting::GetSortedIntervalsDtos($items, 900);
        $this->assertEquals(6,count($subset));
        $subset = \Sorting::GetSortedIntervalsDtos($items, 1950);
        $this->assertEquals(3,count($subset));
    }
}
