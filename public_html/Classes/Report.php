<?php

    class Report {
        private $id;
        private $name;
        private $instructions;
        private $creator;
        private $created;
        private $created_format;
        private $object;
        private $gen_count;
        private $title;
        private $description;
        
        private $fields;
        private $all_data;
        
        private $headers;
        
        private $r;
        private $uid;
        private $proj;
        
        // report functionality
        public function __construct($r, $uid, $proj = null) {
            if(!$r) return;
            if(!$uid) return;
            
            $this->r = $r;
            $this->uid = $uid;
            $this->proj = $proj;
            
            $this->getReportInfo($this->r);
        }
        
        public function generateReport() {
            
            $this->getReportFields($this->r);
            
            
            // get all $object ids
            $qry_obj = ''; 
            switch ($this->object->getName()) {
                // TODO: make query more selective for improvements to efficiency
                case "USER":
                    $qry_obj = "SELECT id FROM user;";
                    break;
                case "PROJECT":
                    $qry_obj = "SELECT id FROM project;";
                    break;
                case "JOB":
                    if (isset($this->proj) && $this->proj !== null) {
                        $qry_obj = "SELECT id FROM job WHERE job.project=".$this->proj.";";
                    } else {
                        $qry_obj = "SELECT id FROM job;";
                    }
                    break;
            }
            
            
            
            $res_obj = mysql_query($qry_obj);
            $all_rows = array();
            if ($res_obj) {
                while ($row_obj = mysql_fetch_assoc($res_obj)) {
                    $all_rows[] = $row_obj['id'];
                }
                mysql_free_result($res_obj);
            }
            
            $this->all_data = array();
            foreach ($all_rows as $obj) {
                $temp = array();
                $temp['id'] = $obj;
                
                // TODO: remove if poor performance
                switch ($this->object->getName()) {
                    case "PROJECT":
                        $NEEDED = true;
                        $p = new Project($obj);
                        break;
                    case "JOB":
                        $j = new Job($obj);
                        // does current user own job? or did they create it?
                        if (($this->uid == $j->getOwnerID())||($this->uid == $j->getCreatorID())) {
                            $NEEDED = false;
                        } else {
                            $NEEDED = true;
                            $p = new Project($j->getProjectID());
                        }
                        
                        break;
                    default:
                        $NEEDED = false;
                }
                //if ($NEEDED) {
                    //var_dump($p->userCanRead($uid));
                    //echo "got to here";
                    if (!$NEEDED) {
                        $RES = true;
                    } else {
                        $RES = canReadProject($p, new User($this->uid));
                        unset($p);
                    }
                    if ($RES) {
                        $crit = true; // does row pass criteria check?
                        foreach ($this->fields as $fld) {
                            if ($crit === true) {
                                $qry_cell = $fld->getQuery().$obj.";";
                                $res_cell = mysql_query($qry_cell);
                                if ($res_cell) {
                                    $row_cell = mysql_fetch_assoc($res_cell);
                                    $val = $row_cell[$fld->getReference()];

                                    // compare $val against $fld->criteria
                                    // TODO: handle dynamic criteria fields, e.g. ||me.id|| ...
                                    if ('x'.$fld->getCriteria() !== 'x') {
                                        // substitute keywords
                                        $keywords = array('||me.id||', '||now||');
                                        $new = array(mysql_escape_string($this->uid), time());
                                        $temp_crit = str_replace($keywords, $new, $fld->getCriteria());

                                        $crit_bits = explode('::', $temp_crit);
                                        $func = $crit_bits[0];
                                        switch ($func) {
                                            case "EQ":
                                                if ($fld->getTypeID() === '1') {
                                                    // field is single value
                                                    if ($val !== $crit_bits[1]) {
                                                        // does not match criteria
                                                        $crit = false;
                                                    }
                                                } else {
                                                    // field is list of values
                                                    $values = explode(', ', $val);
                                                    $crits = explode(', ', $crit_bits[1]);
                                                    
                                                    
                                                    // loop through crits
                                                    $crit = true;
                                                    foreach($crits as $c) {
                                                        // does a value match each crit?
                                                        $found = false;
                                                        foreach($values as $v) {
                                                            if ($v == $c) {
                                                                $found = true;
                                                            }
                                                        }
                                                        if (!$found) {
                                                            $crit = false;
                                                        }
                                                    }
                                                    
                                                }
                                                break;
                                            case "NE":
                                                if ($val === $crit_bits[1]) {
                                                    // fails criteria
                                                    $crit = fail;
                                                }
                                                break;
                                            case "GT":
                                                if ($val <= $crit_bits[1]) {
                                                    // fails criteria
                                                    $crit = false;
                                                }
                                                break;
                                            case "LT":
                                                if ($val >= $crit_bits[1]) {
                                                    // fails criteria
                                                    $crit = false;
                                                }
                                                break;
                                            case "GE":
                                                if ($val < $crit_bits[1]) {
                                                    // fails criteria
                                                    $crit = false;
                                                }
                                                break;
                                            case "LE":
                                                if ($val > $crit_bits[1]){
                                                    // fails criteria
                                                    $crit = false;
                                                }
                                                break;
                                            case "BT":
                                                if ($val >= $crit_bits[1] && $val <= $crit_bits[2]) {
                                                    // matches criteria
                                                } else {
                                                    // fails criteria
                                                    $crit = false;
                                                }
                                                break;
                                            case "NB":
                                                if ($val <= $crit_bits[1] || $val >= $crit_bits[2]) {
                                                    // matches criteria
                                                } else {
                                                    // fails criteria
                                                    $crit = false;
                                                }
                                                break;
                                        }
                                    }
                                    // is field to be displayed?
                                    if ($fld->getVisible() === '1') {
                                        $temp[$fld->getReference()] = $val;
                                    }

                                    // should we prepare a link?
                                    if ('x'.$fld->getLinkPre() !== 'x') {
                                        $qry_cell_link = $fld->getLinkQuery().$obj.";";
                                        $res_cell_link = mysql_query($qry_cell_link);
                                        if ($res_cell_link) {
                                            if (mysql_num_rows($res_cell_link) > 0) {
                                                $row_cell_link = mysql_fetch_row($res_cell_link);
                                                $temp[$fld->getReference().'_link'] = $fld->getLinkPre().$row_cell_link[0];
                                            }
                                            mysql_free_result($res_cell_link);
                                        } else {
                                            $temp[$fld->getReference().'_link'] = '';
                                        }
                                    } else {
                                        $temp[$fld->getReference().'_link'] = '';
                                    }
                                    mysql_free_result($res_cell);
                                }
                            }
                            
                        }
                        if ($crit === true) {
                            $this->all_data[] = $temp;
                        }
                    }
                //}
            }

            //var_dump($this->all_data);
            
            // do sorting
            $this->sortPrep();

            $this->prepareHeaders();

            $this->updateGeneratedCounter();
        }
        private function getReportInfo($r) {
            $query = "SELECT *, DATE_FORMAT(created, '%d-%b-%y %H:%i') as created_format FROM report WHERE id=".$r.";";
            $result = mysql_query($query);
            if ($result) {
                $row = mysql_fetch_assoc($result);
                
                $this->id = $row['id'];
                $this->name = $row['name'];
                $this->instructions = $row['instructions'];
                $this->creator = new User($row['creator']);
                $this->created = $row['created'];
                $this->created_format = $row['created_format'];
                $this->object = new Object($row['object']);
                $this->gen_count = $row['gen_count'];
                $this->title = $row['title'];
                $this->description = $row['description'];
            }
            mysql_free_result($result);
        }
        private function getReportFields($r) {
            $this->fields = array();
            $query = "SELECT * FROM report_field WHERE report=".$r.";";
            $result = mysql_query($query);
            if ($result) {
                while ($row = mysql_fetch_assoc($result)) {
                    $this->fields[] = new ReportField($r, $row['field']);
                }
            }
            mysql_free_result($result);
        }
        private function sortPrep() {
            $sort_order = array();
            foreach ($this->fields as $fld) {
                // KEY  sort of 0 indicates 'dont sort'
                //      sort of +n indicates 'sort me nth ascending'
                //      sort of -n indicates 'sort me nth descnding'
                if ($fld->getSort() != 0) {
                    $temp = array();
                    $temp['ref'] = $fld->getReference();
                    if ($fld->getSort() > 0) {
                        $temp['dir'] = 'ASC';
                    } else if ($fld->getSort() < 0) {
                        $temp['dir'] = 'DESC';
                    }
                    $temp['order'] = abs($fld->getSort());
                    $sort_order[] = $temp;
                }
            }
            // sort sort_order array to finish sort prep
            $sort_size = count($sort_order);
            if ($sort_size > 0) {
                for ($i=0; $i<$sort_size; $i++) {
                    for ($j=0; $j<$sort_size-1-$i; $j++) {
                        $tempA = $sort_order[$j+1];
                        $tempB = $sort_order[$j];
                        if ($tempA['order'] < $tempB['order']) {
                            $sort_order[$j+1] = $tempB;
                            $sort_order[$j] = $tempA;
                        }
                    }
                }

                // sort all rows
                $this->sortRows($sort_order);
            }
        }
        private function sortRows($s) {
            $rows = count($this->all_data);
            for ($i=0; $i<$rows; $i++) {
                for ($j=0; $j<$rows-1-$i; $j++) {
                    $sorted = false;
                    $min_sort = 0;
                    $max_sort = count($s);
                    while ($sorted === false) {
                        if ($min_sort < $max_sort) {
                            $sort = $s[$min_sort];
                            $direction = $sort['dir'];
                            $reference = $sort['ref'];

                            $tempA = $this->all_data[$j+1];
                            $tempB = $this->all_data[$j];

                            switch ($direction) {
                                case 'ASC':
                                    if ($tempA[$reference] < $tempB[$reference]) {
                                        // swap elements
                                        $this->all_data[$j+1] = $tempB;
                                        $this->all_data[$j] = $tempA;
                                        $sorted = true;
                                    } else if ($tempA[$reference] === $tempB[$reference]) {
                                        // sort by next column
                                        $min_sort++;
                                    } else {
                                        $sorted = true;
                                    }
                                    break;
                                case 'DESC':
                                    if ($tempA[$sort['ref']] > $tempB[$sort['ref']]) {
                                        // swap elements
                                        $this->all_data[$j+1] = $tempB;
                                        $this->all_data[$j] = $tempA;
                                        $sorted = true;
                                    } else if ($tempA[$sort['ref']] === $tempB[$sort['ref']]) {
                                        // sort by next column
                                        $min_sort++;
                                    } else {
                                        $sorted = true;
                                    }
                                    break;
                            }
                        } else {
                            $sorted = true;
                        }
                    }
                }
            }
        }
        private function prepareHeaders() {
            $this->headers = array();
            foreach ($this->fields as $f) {
                // is field to be displayed?
                if ($f->getVisible() === '1') {
                    // yes
                    $tmp = array();
                    $tmp['ref'] = $f->getReference();
                    $tmp['label'] = $f->getLabel();
                    $pos = $f->getPosition();
                    $this->headers[$pos] = $tmp;
                }
            }
        }
        private function updateGeneratedCounter() {
            $new_gen_count = $this->gen_count + 1;
            $query = "UPDATE report SET gen_count=".$new_gen_count." WHERE id=".$this->id.";";
            mysql_query($query);
            if (mysql_affected_rows() > 0) {
                // ok
            } else {
                // error
            }
        }
        
        // attribute getters
        public function getID() {
            return $this->id;
        }
        public function getName() {
            return $this->name;
        }
        public function getInstructions() {
            return $this->instructions;
        }
        public function getCreator() {
            return $this->creator;
        }
        public function getCreatorID() {
            return $this->creator->getID();
        }
        public function getCreatorFullName() {
            return $this->creator->getFullName();
        }
        public function getCreatorEmail() {
            return $this->creator->getEmail();
        }
        public function getCreated($format = null) {
            if (isset($format)) {
                return $this->created_format;
            } else {
                return $this->created;
            }
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
        public function getGenCount() {
            return $this->gen_count;
        }
        public function getTitle() {
            return $this->title;
        }
        public function getDescription() {
            return $this->description;
        }
        public function getHeaders() {
            return $this->headers;
        }
        public function getAllData() {
            return $this->all_data;
        }
        public function getFields() {
            return $this->fields;
        }
    }
?>
