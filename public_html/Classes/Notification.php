<?php
    // references - http://webcheatsheet.com/php/send_email_text_html_attachment.php
    
    // TODO: handle html mails

    class Notification {
        
        private $to;
        private $subject;
        private $body;
        private $attachName;
        private $attachFullPath;
        private $attachType;
        
        public function setRecipient($r) {
            $this->to = $r;
        }
        
        public function setSubject($s) {
            $this->subject = $s;
        }
        
        public function setBody($b) {
            $msg = '<html><body>';
            $msg .= $b;
            $msg .= '</body></html>';
            
            
            $this->body = $msg;
        }
        
        public function setAttachment($name, $fullpath, $contType) {
            $this->attachName = $name;
            $this->attachFullPath = $fullpath;
            $this->attachType = $contType;
        }
        
        public function sendMail() {
            $t = $this->to;
            $s = $this->subject;
            $b = $this->body;
            if (isset($this->attachName)) {
                return $this->myMail($t, $s, $b, $this->attachName, $this->attachType, $this->attachFullPath);
            } else {
                
                //$h = 'From: noreply.apttrack@rcarey.co.uk' . "\r\n" .
                //        'Reply-To: noreply.apttrack@rcarey.co.uk' . "\r\n" .
                //        'X-Mailer: PHP/' . phpversion();
                $headers = "From: noreply.apttrack@rcarey.co.uk" . "\r\n";
                $headers .= "Reply-To: noreply.apttrack@rcarey.co.uk" . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                $headers .= "X-Mailer: PHP/" . phpversion();
                
                
                return @mail($t, $s, $b, $headers);
            }
        }
        
        private function myMail($to, $subject, $mail_msg, $filename, $contentType, $pathToFilename){
            $random_hash = md5(date('r', time()));
            $headers = "From: noreply.apttrack@rcarey.co.uk\r\nReply-To: ".$to;
            $headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\"";
            $attachment = chunk_split(base64_encode(file_get_contents($pathToFilename)));
            ob_start();
            echo "
--PHP-mixed-$random_hash
Content-Type: multipart/alternative; boundary=\"PHP-alt-$random_hash\"

--PHP-alt-$random_hash
Content-Type: text/html; charset=\"utf-8\"
Content-Transfer-Encoding: 7bit

$mail_msg

--PHP-alt-$random_hash--

--PHP-mixed-$random_hash
Content-Type: $contentType; name=\"$filename\" 
Content-Transfer-Encoding: base64 
Content-Disposition: attachment 

$attachment
--PHP-mixed-$random_hash--
";
           $message = ob_get_clean();
           $fh=fopen('log.txt','w');
           fwrite($fh,$message);
           $mail_sent = @mail( $to, $subject, $message, $headers );
           return $mail_sent ? true : false;
        }
        
        
        
    }
?>
