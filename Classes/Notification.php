<?php

    class Notification {
        
        public function sendMessage($to = '##notset##', $body = '##notset##') {
            if ($to == '##notset##' || $body == '##notset##') {
                return false;
            } else {
                // TODO: implement mail sending
                return true;
            }
        }
        
        public function generateReport( $id = '##notset##' ) {
            if ($id === '##notset##') {
                return false;
            } else {
                /**
                 * @todo implement report generation
                 */
                return true;
            }
        }
    }
?>
