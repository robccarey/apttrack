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
            $this->to = htmlspecialchars($r);
        }
        
        function setSubject($s) {
            $this->subject = htmlscecialchars($s);
        }
        
        function setBody($b) {
            $this->body = htmlspecialchars($b);
        }
        
        function sendMail() {
            $t = $this->to;
            $s = $this->subject;
            $b = $this->body;
            
            
            $h = 'From: noreply@rcarey.co.uk' . "\r\n" .
                    'Reply-To: noreply@rcarey.co.uk' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
            if (@mail($t, $s, $b, $h)) {
                return true;
            } else {
                return false;
            }
        }
    }
?>
