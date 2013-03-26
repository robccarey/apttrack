<?php
    // references - http://webcheatsheet.com/php/send_email_text_html_attachment.php
    
    // TODO: handle html mails
    // TODO: handle pdf attachments

    class Notification {
        
        private $to;
        private $subject;
        private $body;
        private $attachment;
        
        public function setRecipient($r) {
            $this->to = mysql_real_escape_string($r);
        }
        
        public function setSubject($s) {
            $this->subject = mysql_real_escape_string($s);
        }
        
        public function setBody($b) {
            $this->body = mysql_real_escape_string($b);
        }
        
        public function setAttachment($a) {
            $this->attachment = $a;
        }
        
        public function sendMail() {
            $t = $this->to;
            $s = $this->subject;
            $b = $this->body;
            
            $h = 'From: noreply.apttrack@rcarey.co.uk' . "\r\n" .
                    'Reply-To: noreply.apttrack@rcarey.co.uk' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
            if (@mail($t, $s, $b, $h)) {
                return true;
            } else {
                return false;
            }
        }
    }
?>
