<?php

    class ReportList {
        
        private $report;
        
        private $list_name;
        private $list_content;
        
        private $rep_headers;
        private $rep_all_data;
        
        public function __construct($r, $uid, $proj = null) {
            
            // get report content
            if (isset($proj)) {
                $this->report = new Report($r, $uid, $proj);
            } else {
                $this->report = new Report($r, $uid);
            }
            $this->report->generateReport();
            
            $this->list_name = $this->report->getTitle();
            
            //$this->list_content = '
            //            <ul data-role="listview" data-theme="d" data-divider-theme="d">';
            $this->list_content = '';
            
            $this->rep_headers = $this->report->getHeaders();
            
            $num_cols = count($this->rep_headers);
            if ($num_cols > 3) {
                $num_cols = 3;
            }
            
            $field = array();
            for ($i=1; $i<=$num_cols; $i++) {
                $tmp = $this->rep_headers[$i];
                $field[$i] = $tmp['ref'];
            }
            
            $this->rep_all_data = $this->report->getAllData();
            $num_rows = count($this->rep_all_data);
            if ($num_rows > 0) {
                for ($i=0; $i<$num_rows; $i++) {
                    $row = $this->rep_all_data[$i];
                    $this->list_content .= '<li>';
                    if ('x'.$row[$field[1].'_link'] !== 'x') {
                        // insert link
                        $this->list_content .= '<a href="'.$row[$field[1].'_link'].'">';
                    }
                    $this->list_content .= '<h4 style="color: #000000;">'.$row[$field[1]];
                    $this->list_content .= '<small> '.$row[$field[2]].'</small></h4>';
                    $this->list_content .= '<p class="muted">Last updated:<strong> '.$row[$field[3]].'</strong></p>';
                    
                    if ('x'.$row[$field[1].'_link'] !== 'x') {
                        // close link
                        $this->list_content .= '</a>';
                    }
                    $this->list_content .= '</li>';
                }
                //$this->list_content .= '</ul>';
            } else {
                $this->list_content = '<li><a class="muted">0 items found</a></li>';
            }
            
        }
        
        public function getReport() {
            return $this->report;
        }
        public function getName() {
            return $this->list_name;
        }
        public function getContent() {
            return $this->list_content;
        }
    }
?>
