<?php

    require_once dirname(__FILE__) . '/../Classes/Nettuts.php';
    class NettutsTest extends PHPUnit_Framework_TestCase {
        protected $object;
        protected function setUp() {
            $this->object = new Nettuts;
        }
        protected function tearDown() {
            
        }
        
        function testDummyPassingTest() {
            $this->assertTrue(true);
        }
    }
?>
