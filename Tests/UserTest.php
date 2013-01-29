<?php

    require_once dirname(__FILE__) . '/../Classes/User.php';
    class UserTest extends PHPUnit_Framework_TestCase {
        protected $object;
        protected function setUp() {
            $this->object = new User;
        }
        protected function tearDown() {
        
        }
        
       
        public function testSetUsername() {
            $name = 'something';
            $this->assertTrue($this->object->setUsername($name));
            
            $name = 'something else';
            $this->assertTrue($this->object->setUsername($name));
            
            $name = 'null';
            $this->assertTrue($this->object->setUsername($name));
            
            $name = 'random';//
            $this->assertFalse($this->object->setUsername());
        }
        
        public function testGetUsername() {
            $name = 'something';
            $this->object->setUsername($name);
            $this->assertEquals($name, $this->object->getUsername());
            
            $name = 'something else';
            $this->object->setUsername($name);
            $this->assertEquals($name, $this->object->getUsername());
            
            $name = '';
            $this->object->setUsername($name);
            $this->assertEquals($name, $this->object->getUsername());
        }
    }
?>
