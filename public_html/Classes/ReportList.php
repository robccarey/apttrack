<?php

    class ReportList {
        
        var $report;
        
        var $list_name;
        var $list_content;
        
        function __construct($r, $uid, $proj = null) {
            
            // get report content
            if (isset($proj)) {
                $this->report = new Report($r, $uid, $proj);
            } else {
                $this->report = new Report($r, $uid);
            }
            
            
            $this->list_name = $this->report->title;
            
            //$this->list_content = '
            //            <ul data-role="listview" data-theme="d" data-divider-theme="d">';
            $this->list_content = '';
            
            $num_cols = count($this->report->headers);
            if ($num_cols > 3) {
                $num_cols = 3;
            }
            
            $field = array();
            for ($i=1; $i<=$num_cols; $i++) {
                $tmp = $this->report->headers[$i];
                $field[$i] = $tmp['ref'];
            }
            
            $num_rows = count($this->report->all_data);
            if ($num_rows > 0) {
                for ($i=0; $i<$num_rows; $i++) {
                    $row = $this->report->all_data[$i];
                    $this->list_content .= '<li>';
                    if ('x'.$row[$field[1].'_link'] !== 'x') {
                        // insert link
                        $this->list_content .= '<a href="'.$row[$field[1].'_link'].'">';
                    }
                    $this->list_content .= '<h4 style="color: #000000;">'.$row[$field[1]].'</h4>';
                    $this->list_content .= '<p class="muted">'.$row[$field[2]].'</p>';
                    $this->list_content .= '<p class="muted">Last updated:<strong> '.$row[$field[3]].'</strong></p>';
                    
                    if ('x'.$row[$field[1].'_link'] !== 'x') {
                        // close link
                        $this->list_content .= '</a>';
                    }
                    $this->list_content .= '</li>';
                }
                //$this->list_content .= '</ul>';
            } else {
                $this->list_content = '<li>0 items found</li>';
            }
            
        }
    }
?>
