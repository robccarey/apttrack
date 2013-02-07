<?php
    class Project {
        var $id;
        var $name;
        var $description;
        var $owner;
        var $creator;
        var $created;
        var $date_start;
        var $updater;
        var $updated;
        var $status;
        var $visibility;
        
        var $tags;
        var $tasks;
        var $deliverables;
        
        function __construct($p){
            
            // get main project content
            $query = "SELECT * FROM project WHERE id=".$p." LIMIT 1;";
            $result = mysql_query($query);
            if ($result){
                $row = mysql_fetch_assoc($result);
                $this->id = $row['id'];
                $this->name = $row['name'];
                $this->description = $row['description'];
                $this->owner = new User($row['owner']);
                $this->creator = new User($row['creator']);
                $this->created = $row['created'];
                $this->date_start = $row['date_start'];
                $this->updater = new User($row['updater']);
                $this->updated = $row['updated'];
                $this->status = new Status($row['status']);
                $this->visibility = new Visibility($row['visibility']);
            }
            mysql_free_result($result);
            
            // get tags
            $this->tags = array();
            $qry_t = "SELECT project, tag FROM tag_project WHERE project=".$p.";";
            $res_t = mysql_query($qry_t);
            if ($res_t){
                while ($row_t = mysql_fetch_assoc($res_t)) {
                    $this->tags[] = new Tag($row_t['tag']);
                }
            }
            mysql_free_result($res_t);
            
            // get tasks
            $this->tasks = array();
            $qry_tasks = "SELECT id FROM task WHERE project=".$p.";";
            $res_tasks = mysql_query($qry_tasks);
            if($res_tasks){
                while ($row_tasks = mysql_fetch_assoc($res_tasks)){
                    $this->tasks = new Task($row_tasks['id']);
                }
            }
            mysql_free_result($res_tasks);
            
            // get deliverables
            $this->deliverables = array();
            $qry_d = "SELECT id FROM deliverable WHERE project=".$p.";";
            $res_d = mysql_query($qry_d);
            if($res_d){
                while ($row_d = mysql_fetch_assoc($res_d)){
                    $this->deliverables[] = new Deliverable($row_d['id']);
                }
            }
            mysql_free_result($res_d);
            
            
        }
        
        function getID(){
            return $this->id;
        }
        
        function getName(){
            return $this->name;
        }
        
        public function getDescription(){
            return $this->description;
        }
        
        function getUpdated(){
            return $this->updated;
        }
    }
?>
