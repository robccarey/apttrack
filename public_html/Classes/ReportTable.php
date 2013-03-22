<?php

    class ReportTable {
        
        var $report;
        
        var $table_start;
        var $table_header;
        var $table_body;
        var $table_end;
        
        function __construct($r, $uid, $proj = null) {
            // prep table start tags
            $this->table_start = '<table id="repTable" class="table table-hover table-condensed">';
            
            // get report content
            if (isset($proj)) {
                $this->report = new Report($r, $uid, $proj);
            } else {
                $this->report = new Report($r, $uid);
            }
            
            // prep report heads
            $num_cols = count($this->report->headers);
            $this->table_header = '<thead><tr>';
            for ($i=1; $i<=$num_cols; $i++)
            {
                $tmp = $this->report->headers[$i];
                if ($i === 1) {
                    $this->table_header .= '<th>'.$tmp['label'].'</th>';
                } else {
                    $this->table_header .= '<th data-priority="'.$i.'">'.$tmp['label'].'</th>';
                }
            }
            $this->table_header .= '</tr></thead>';
            
            // prep report body
            $this->table_body = '<tbody>';
            $num_rows = count($this->report->all_data);
            if ($num_rows > 0) {
                for ($i=0; $i<$num_rows; $i++)
                {
                    $row = $this->report->all_data[$i];
                    $this->table_body .= '<tr>';
                    for ($j=1; $j<=$num_cols; $j++)
                    {
                        $col = $this->report->headers[$j];
                        $this->table_body .= '<td>';
                        if ('x'.$row[$col['ref'].'_link'] !== 'x' ) {
                            $this->table_body .= '<a href="'.$row[$col['ref'].'_link'].'">';
                            $this->table_body .= $row[$col['ref']];
                            $this->table_body .= '</a>';
                        } else {
                            $this->table_body .= $row[$col['ref']];
                        }
                            $this->table_body .= '</td>';
                    }
                    echo '</tr>';
                }
            } else {
                // zero rows in output
                $this->table_body .= '<tr colspan="'.$num_cols.'">0 items found.</tr>';
            }
            $this->table_body .= '</tbody>';
            
            // TODO: prep report footer
            
            // close table
            $this->table_end = '</table>';
        }
        
    }
?>
