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
        
        function __construct($r, $uid) {
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
            
            // get report fields
            $this->fields = array();
            $qry_f = "SELECT * FROM report_field WHERE report=".$r.";";
            $res_f = mysql_query($qry_f);
            if ($res_f) {
                while ($row_f = mysql_fetch_assoc($res_f)) {
                    $this->fields[] = new ReportField($r, $row_f['field']);
                }
            }
            mysql_free_result($res_f);
            
            // get all $object ids
            $qry_obj = ''; 
            switch ($this->object->name) {
                // TODO: make query more selective for improvements to efficiency
                case "USER":
                    $qry_obj = "SELECT id FROM user;";
                    break;
                case "PROJECT":
                    $qry_obj = "SELECT id FROM project;";
                    break;
                case "TASK":
                    $qry_obj = "SELECT id FROM task;";
                    break;
                case "DELIVERABLE":
                    $qry_obj = "SELECT id FROM deliverable;";
                    break;
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
                $crit = true; // does row pass criteria check?
                foreach ($this->fields as $fld) {
                    if ($crit === true) {
                        $qry_cell = $fld->query.$obj.";";
                        $res_cell = mysql_query($qry_cell);
                        if ($res_cell) {
                            $row_cell = mysql_fetch_assoc($res_cell);
                            $val = $row_cell[$fld->reference];

                            // compare $val against $fld->criteria
                            // TODO: handle dynamic criteria fields, e.g. $$NOW()$$ ...
                            if ('x'.$fld->criteria !== 'x') {
                                // substitute keywords
                                $keywords = '||me.id||';
                                $new = mysql_escape_string($uid);
                                $temp_crit = str_replace($keywords, $new, $fld->criteria, $count);
                                
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
                            // assuming passes criteria check
                            $temp[$fld->reference] = $val;
                            
                            // should we prepare a link?
                            if ('x'.$fld->link_pre !== 'x') {
                                $qry_cell_link = $fld->link_qry.$obj.";";
                                $res_cell_link = mysql_query($qry_cell_link);
                                if ($res_cell_link) {
                                    $row_cell_link = mysql_fetch_row($res_cell_link);
                                    $temp[$fld->reference.'_link'] = $fld->link_pre.$row_cell_link[0];
                                } else {
                                    $temp[$fld->reference.'_link'] = '';
                                }
                                mysql_free_result($res_cell_link);
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
            
            // TODO: sort report data
            // prepare sort order
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
                //var_dump($sort_order);

                // sort all rows
                $rows = count($this->all_data);
                for ($i=0; $i<$rows; $i++) {
                    for ($j=0; $j<$rows-1-$i; $j++) {
                        $sorted = false;
                        $min_sort = 0;
                        $max_sort = count($sort_order);
                        while ($sorted === false) {
                            if ($min_sort < $max_sort) {
                                $sort = $sort_order[$min_sort];
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
            
            // prepare report headers
            $this->headers = array();
            foreach ($this->fields as $fld) {
                $tmp = array();
                $tmp['ref'] = $fld->reference;
                $tmp['label'] = $fld->label;
                $pos = $fld->position;
                $this->headers[$pos] = $tmp;
            }
            
            // update report generated counter
            $new_gen_count = $this->gen_count + 1;
            $qry_gen = "UPDATE report SET gen_count=".$new_gen_count." WHERE id=".$this->id.";";
            $res_gen = mysql_query($qry_gen);
            if ($res_gen) {
                // ok
            } else {
                // error
            }
        }
    }
?>
