<?php

    class Report {
        var $id;
        var $name;
        var $instructions;
        var $creator;
        var $created;
        var $object;
        var $gen_count;
        var $title;
        var $description;
        
        var $fields;
        var $all_data;
        
        var $headers;
        
        function __construct($r, $uid, $proj = null) {
            if(!$r) return;
            if(!$uid) return;
            
            $this->getReportInfo($r);
            $this->getReportFields($r);
            
            
            // get all $object ids
            $qry_obj = ''; 
            switch ($this->object->name) {
                // TODO: make query more selective for improvements to efficiency
                case "USER":
                    $qry_obj = "SELECT id FROM user;";
                    break;
                case "PROJECT":
                    $qry_obj = "SELECT id FROM project WHERE clean=0;";
                    break;
                case "JOB":
                    if (isset($proj) && $proj !== null) {
                        $qry_obj = "SELECT id FROM job WHERE clean=0 AND job.project=".$proj.";";
                    } else {
                        $qry_obj = "SELECT id FROM job WHERE clean=0;";
                    }
            }
            
            
            
            $res_obj = mysql_query($qry_obj);
            $all_rows = array();
            if ($res_obj) {
                while ($row_obj = mysql_fetch_assoc($res_obj)) {
                    $all_rows[] = $row_obj['id'];
                }
            }
            mysql_free_result($res_obj);
            
            $this->all_data = array();
            foreach ($all_rows as $obj) {
                $temp = array();
                $temp['id'] = $obj;
                
                // TODO: remove if poor performance
                switch ($this->object->name) {
                    case "PROJECT":
                        $NEEDED = true;
                        $p = new Project($obj);
                        break;
                    case "JOB":
                        $NEEDED = true;
                        $j = new Job($obj);
                        $p = new Project($j->project);
                        break;
                    default:
                        $NEEDED = false;
                }
                if ($NEEDED) {
                    //var_dump($p->userCanRead($uid));
                    //echo "got to here";
                    $RES = canReadProject($p, new User($uid));
                    if ($RES) {
                        $crit = true; // does row pass criteria check?
                        foreach ($this->fields as $fld) {
                            if ($crit === true) {
                                $qry_cell = $fld->query.$obj.";";
                                $res_cell = mysql_query($qry_cell);
                                if ($res_cell) {
                                    $row_cell = mysql_fetch_assoc($res_cell);
                                    $val = $row_cell[$fld->reference];

                                    // compare $val against $fld->criteria
                                    // TODO: handle dynamic criteria fields, e.g. ||me.id|| ...
                                    if ('x'.$fld->criteria !== 'x') {
                                        // substitute keywords
                                        $keywords = '||me.id||';
                                        $new = mysql_escape_string($uid);
                                        $temp_crit = str_replace($keywords, $new, $fld->criteria);

                                        $crit_bits = explode('::', $temp_crit);
                                        $func = $crit_bits[0];
                                        switch ($func) {
                                            case "EQ":
                                                if ($val === $crit_bits[1]) {
                                                    // matches criteria
                                                } else {
                                                    // does not match criteria
                                                    $crit = false;
                                                }
                                                break;
                                            case "NE":
                                                if ($val === $crit_bits[1]) {
                                                    // matches criteria
                                                } else {
                                                    // fails criteria
                                                    $crit = fail;
                                                }
                                                break;
                                            case "GT":
                                                if ($val > $crit_bits[1]) {
                                                    // matches criteria
                                                } else {
                                                    // fails criteria
                                                    $crit = false;
                                                }
                                                break;
                                            case "LT":
                                                if ($val < $crit_bits[1]) {
                                                    // matches criteria
                                                } else {
                                                    // fails criteria
                                                    $crit = false;
                                                }
                                                break;
                                            case "GE":
                                                if ($val >= $crit_bits[1]) {
                                                    // matches criteria
                                                } else {
                                                    // fails criteria
                                                    $crit = false;
                                                }
                                                break;
                                            case "LE":
                                                if ($val <= $crit_bits[1]) {
                                                    // matches criteria
                                                } else {
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
                                    if ($fld->visible === '1') {
                                        $temp[$fld->reference] = $val;
                                    }

                                    // should we prepare a link?
                                    if ('x'.$fld->link_pre !== 'x') {
                                        $qry_cell_link = $fld->link_qry.$obj.";";
                                        $res_cell_link = mysql_query($qry_cell_link);
                                        if ($res_cell_link) {
                                            if (mysql_num_rows($res_cell_link) > 0) {
                                                $row_cell_link = mysql_fetch_row($res_cell_link);
                                                $temp[$fld->reference.'_link'] = $fld->link_pre.$row_cell_link[0];
                                            }
                                            mysql_free_result($res_cell_link);
                                        } else {
                                            $temp[$fld->reference.'_link'] = '';
                                        }
                                    } else {
                                        $temp[$fld->reference.'_link'] = '';
                                    }
                                }
                            }
                            mysql_free_result($res_cell);
                        }
                        if ($crit === true) {
                            $this->all_data[] = $temp;
                        }
                    }
                }
            }

            // do sorting
            $this->sortPrep();

            $this->prepareHeaders();

            $this->updateGeneratedCounter();
        }
        
        function getReportInfo($r) {
            $query = "SELECT * FROM report WHERE id=".$r.";";
            $result = mysql_query($query);
            if ($result) {
                $row = mysql_fetch_assoc($result);
                
                $this->id = $row['id'];
                $this->name = $row['name'];
                $this->instructions = $row['instructions'];
                $this->creator = new User($row['creator']);
                $this->created = $row['created'];
                $this->object = new Object($row['object']);
                $this->gen_count = $row['gen_count'];
                $this->title = $row['title'];
                $this->description = $row['description'];
            }
            mysql_free_result($result);
        }
        
        function getReportFields($r) {
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
        
        function sortPrep() {
            $sort_order = array();
            foreach ($this->fields as $fld) {
                // KEY  sort of 0 indicates 'dont sort'
                //      sort of +n indicates 'sort me nth ascending'
                //      sort of -n indicates 'sort me nth descnding'
                if ($fld->sort != 0) {
                    $temp = array();
                    $temp['ref'] = $fld->reference;
                    if ($fld->sort > 0) {
                        $temp['dir'] = 'ASC';
                    } else if ($fld->sort < 0) {
                        $temp['dir'] = 'DESC';
                    }
                    $temp['order'] = abs($fld->sort);
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
        function sortRows($s) {
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
        function prepareHeaders() {
            $this->headers = array();
            foreach ($this->fields as $f) {
                // is field to be displayed?
                if ($f->visible === '1') {
                    // yes
                    $tmp = array();
                    $tmp['ref'] = $f->reference;
                    $tmp['label'] = $f->label;
                    $pos = $f->position;
                    $this->headers[$pos] = $tmp;
                }
            }
        }
        function updateGeneratedCounter() {
            $new_gen_count = $this->gen_count + 1;
            $query = "UPDATE report SET gen_count=".$new_gen_count." WHERE id=".$this->id.";";
            $result = mysql_query($query);
            if ($result) {
                // ok
            } else {
                // error
            }
        }
    }
?>
