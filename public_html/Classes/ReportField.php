<?php
    class ReportField {
        
        var $label;
        var $reference;
        var $object;
        var $query;
        
        var $visible;
        var $sort;
        var $criteria;
        var $position;
        
        var $link_pre;
        var $link_qry;
        
        function __construct($r, $f) {
            
            // get field data
            $qry_f = "SELECT * FROM field WHERE id=".$f.";";
            $res_f = mysql_query($qry_f);
            if ($res_f) {
                $row_f = mysql_fetch_assoc($res_f);
                
                $this->reference = $row_f['reference'];
                $this->object = new Object($row_f['object']);
                $this->query = $row_f['query'];
                $this->link_pre = $row_f['link_pre'];
                $this->link_qry = $row_f['link_query'];
            }
            mysql_free_result($res_f);
            
            // get reportfield data
            $qry_rf = "SELECT * FROM report_field WHERE report=".$r." AND field=".$f.";";
            $res_rf = mysql_query($qry_rf);
            if ($res_rf) {
                $row_rf = mysql_fetch_assoc($res_rf);
                
                $this->label = $row_rf['label'];
                $this->visible = $row_rf['visible'];
                $this->sort = $row_rf['sort'];
                $this->criteria = $row_rf['criteria'];
                $this->position = $row_rf['position'];
            }
            mysql_free_result($res_rf);
        }
        
    }
?>
