<?php

namespace Tests;
require_once('includes.php');

class RepositoryTest extends \PHPUnit_Framework_TestCase {

    public function testGetConnection()
    {
        $con = \Repository::GetConnection();

        $this->assertContains('localhost', $con->host_info );

        \Repository::CloseConnection($con);
    }

    public function testFetchAll()
    {
        $sql = "Select * from vw_malaria LIMIT 0, 100";

        $rows = \Repository::FetchAll($sql);

        $this->assertEquals(100, count($rows));
    }

    public function testGetRawCount()
    {
        $count = \Repository::GetRawCount(1);

        $this->assertGreaterThan(1000, $count);
    }

    public function testGetRawData()
    {
        $rows = \Repository::GetRawData(1, 0, 100);

        $this->assertEquals(100, count($rows));
    }

    public function testGetAggregatedData()
    {
        $rows = \Repository::GetAggregatedData(1, 0, 0, 0);

        $this->assertGreaterThan(10, count($rows));

        $rows = \Repository::GetAggregatedData(1, 1, 0, 0);

        $this->assertGreaterThan(10, count($rows));

        $rows = \Repository::GetAggregatedData(1, 1, 1, 0);

        $this->assertGreaterThan(10, count($rows));

        $rows = \Repository::GetAggregatedData(1, 1, 1, 1);

        $this->assertGreaterThan(10, count($rows));
    }

    public function testGetAggregatedDataFilteredByAgeAndGender()
    {
        $rows = \Repository::GetAggregatedData(1, 0, 0, 0);

        $this->assertGreaterThan(10, count($rows));

        $rows = \Repository::GetAggregatedData(1, 1, 0, 0);

        $this->assertGreaterThan(10, count($rows));

        $rows = \Repository::GetAggregatedData(1, 1, 1, 0);

        $this->assertGreaterThan(10, count($rows));

        $rows = \Repository::GetAggregatedData(1, 1, 1, 1);

        $this->assertGreaterThan(10, count($rows));
    }
}
