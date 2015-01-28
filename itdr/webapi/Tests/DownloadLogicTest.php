<?php

namespace Tests;

require_once('includes.php');

class DownloadLogicTest extends \PHPUnit_Framework_TestCase {

    public function testGetCsvFormattedRawDataBySubjectId()
    {
        $csv = \DownloadLogic::GetCsvFormattedRawDataBySubjectId(1, 0, 100);
        $this->assertGreaterThan(100, strlen($csv));
    }

    public function testGetCsvFormattedAggregatedDataBySubjectId()
    {
        $csv = \DownloadLogic::GetCsvFormattedAggregatedDataBySubjectId(1,1,0,0,0);
        $this->assertGreaterThan(100, strlen($csv));
    }
}
