<?php
    class ReportField {
        
        private $label;
        private $reference;
        private $object;
        private $query;
        
        private $visible;
        private $sort;
        private $criteria;
        private $position;
        
        private $link_pre;
        private $link_qry;
        private $type;
        
        public function __construct($r, $f) {
            
            // get field data
            $qry_f = "SELECT * FROM field WHERE id=".$f." LIMIT 1;";
            $res_f = mysql_query($qry_f);
            if ($res_f) {
                $row_f = mysql_fetch_assoc($res_f);
                
                $this->reference = $row_f['reference'];
                $this->object = new Object($row_f['object']);
                $this->query = $row_f['query'];
                $this->link_pre = $row_f['link_pre'];
                $this->link_qry = $row_f['link_query'];
                $this->type = $row_f['type'];
            }
            mysql_free_result($res_f);
            
            // get reportfield data
            $qry_rf = "SELECT * FROM report_field WHERE report=".$r." AND field=".$f." LIMIT 1;";
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
        
        public function getLabel() {
            return $this->label;
        }
        public function getReference() {
            return $this->reference;
        }
        public function getObject() {
            return $this->object;
        }
        public function getObjectID() {
            return $this->object->getID();
        }
        public function getObjectText() {
            return $this->object->getName();
        }
        public function getQuery() {
            return $this->query;
        }
        public function getVisible() {
            return $this->visible;
        }
        public function getSort() {
            return $this->sort;
        }
        public function getCriteria() {
            return $this->criteria;
        }
        public function getPosition() {
            return $this->position;
        }
        public function getLinkPre() {
            return $this->link_pre;
        }
        public function getLinkQuery() {
            return $this->link_qry;
        }
        public function getTypeID() {
            return $this->type;
        }
    }
?>
