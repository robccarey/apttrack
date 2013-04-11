<?php

    class ReportPDF {
        
        private $report;
        
        private $table_start;
        private $table_header;
        private $table_body;
        private $table_footer;
        private $table_end;
        
        private $rep_headers;
        private $rep_all_data;
        
        public function __construct($r, $uid, $proj = null) {
            // prep table start tags
            $this->table_start = '<table id="repTable" class="table table-hover table-condensed">';
            
            // get report content
            if (isset($proj)) {
                $this->report = new Report($r, $uid, $proj);
            } else {
                $this->report = new Report($r, $uid);
            }
            $this->report->generateReport();
            
            // prep report heads
            $this->rep_headers = $this->report->getHeaders();
            $num_cols = count($this->rep_headers);
            $this->table_header = '<thead><tr>';
            for ($i=1; $i<=$num_cols; $i++)
            {
                $tmp = $this->rep_headers[$i];
                if ($i === 1) {
                    $this->table_header .= '<th>'.$tmp['label'].'</th>';
                } else {
                    $this->table_header .= '<th data-priority="'.$i.'">'.$tmp['label'].'</th>';
                }
            }
            $this->table_header .= '</tr></thead>';
            
            // prep report body
            $this->table_body = '<tbody>';
            $this->rep_all_data = $this->report->getAllData();
            $num_rows = count($this->rep_all_data);
            if ($num_rows > 0) {
                for ($i=0; $i<$num_rows; $i++)
                {
                    $row = $this->rep_all_data[$i];
                    $this->table_body .= '<tr>';
                    for ($j=1; $j<=$num_cols; $j++)
                    {
                        $col = $this->rep_headers[$j];
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
                //$this->table_body .= '<tr colspan="'.$num_cols.'">0 items found.</tr>';
            }
            $this->table_body .= '</tbody>';
            
            // table footer
            $this->table_footer = '<tfoot>';
            $this->table_footer .= '<tr colspan="'.$num_cols.'"><p class="muted">'.$num_rows.' items found.</p></tr>';
            $this->table_footer .= '</tfoot>';
            
            // close table
            $this->table_end = '</table>';
        }
        
        public function getReport() {
            return $this->report;
        }
        public function getStart() {
            return $this->table_start;
        }
        public function getHeader() {
            return $this->table_header;
        }
        public function getBody() {
            return $this->table_body;
        }
        public function getFooter() {
            return $this->table_footer;
        }
        public function getEnd() {
            return $this->table_end;
        }
        public function getReportName() {
            return $this->report->getName();
        }
        public function getReportDescription() {
            return $this->report->getDescription();
        }
    }
?>
