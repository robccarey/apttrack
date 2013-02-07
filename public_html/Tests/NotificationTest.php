<?php

    require_once dirname(__FILE__) . '/../Classes/Notification.php';
    class NotificationTest extends PHPUnit_Framework_TestCase {
        protected $object;
        protected function setUp() {
            $this->object = new Notification;
        }
        protected function tearDown() {

        }

        public function testSendMessage() {
            
            $to = 'robcarey1990@gmail.com';
            $body = 'This is simply a test message.';
            
            $res1 = $this->object->sendMessage($to, $body);
            $this->assertTrue($res1);
        }

        public function testGenerateReport() {
            $res1 = $this->object->generateReport(1);
            $this->assertTrue($res1);
            
            $res2 = $this->object->generateReport();
            $this->assertFalse($res2);
        }

    }
?>
