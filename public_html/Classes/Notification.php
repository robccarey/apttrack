<?php
    // references - http://webcheatsheet.com/php/send_email_text_html_attachment.php
    
    // TODO: handle html mails
    // TODO: handle pdf attachments

    class Notification {
        
        var $to;
        var $subject;
        var $body;
        var $attachment;
        
        function setRecipient($r) {
            $this->to = mysql_real_escape_string($r);
        }
        
        function setSubject($s) {
            $this->subject = mysql_real_escape_string($s);
        }
        
        function setBody($b) {
            $this->body = ($b);
        }
        
        function sendMail() {
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
