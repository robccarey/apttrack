<?php

    class RelDateTime {
        
        private $stamp;
        
        public function __construct($s) {
            $this->stamp = $s;
        }
        
        public function getRelStamp() {
            $now = time();
            $output = '';
            
            
            $secs = abs($now - $this->stamp);
            if ($secs < 60 ) {
                $output = $secs.' seconds';
            } else if ($secs < 3600) {
                $mins = number_format($secs / 60);
                $output = $mins.' minutes';
            } else if ($secs < 86400) {
                $hours = number_format($secs / 3600);
                $output = $hours.' hours';
            } else {
                $days = number_format($secs / 86400);
                $output = $days.' days';
            }
            
            if ($now >= $this->stamp) {
                // stamp in past
                return $output.' ago';
            } else {
                // stamp in future
                return 'in '.$output;
            }
        }
        
        
        
    }
?>
