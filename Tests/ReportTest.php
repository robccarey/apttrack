<?php

require_once dirname(__FILE__) . '/../Classes/Report.php';
    class ReportTest extends PHPUnit_Framework_TestCase {
        protected $object;
        protected function setUp() {
            $this->object = new Report;
        }
        protected function tearDown() {
            //
        }
        
        function testDummyPassingTest() {
            $this->assertTrue(true);
        }
    }
?>
