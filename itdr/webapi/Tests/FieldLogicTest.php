<?php

namespace Tests;

require_once('includes.php');

class FieldLogicTest extends \PHPUnit_Framework_TestCase {

    public function testGetFieldsAsDtosUsingRawParameter()
    {
        $dtos = \FieldLogic::GetFieldsAsDtos(1,1);
        $this->assertGreaterThan(10, count($dtos) );
    }

    public function testGetFieldsAsDtosUsingAggregateParameter()
    {
        $dtos = \FieldLogic::GetFieldsAsDtos(1,1);
        $this->assertGreaterThan(10, count($dtos) );
    }
}
