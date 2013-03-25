<?php
    class Project {
        var $id;
        var $name;
        var $description;
        var $owner;
        var $creator;
        var $created;
        var $date_start;
        var $date_end;
        
        var $start_format;
        var $end_format;
        var $created_format;
        var $updated_format;
        
        var $updater;
        var $updated;
        var $status;
        var $visibility;
        var $health;
        var $priority;
        
        var $tags;
        var $tasks;
        var $deliverables;
        var $comments;
        var $subscribers;
        
        function __construct($p){
            
            // get main project content
            $query = "SELECT *,
                DATE_FORMAT(date_start, '%d-%b-%y') as start_format,
                DATE_FORMAT(date_end, '%d-%b-%y') as end_format,
                DATE_FORMAT(created, '%d-%b-%y') as created_format,
                DATE_FORMAT(updated, '%d-%b-%y') as updated_format
                FROM project WHERE id=".$p." LIMIT 1;";
            $result = mysql_query($query);
            if ($result) {
                $row = mysql_fetch_assoc($result);
                
                $this->id = $row['id'];
                $this->name = $row['name'];
                $this->description = $row['description'];
                $this->owner = new User($row['owner']);
                $this->creator = new User($row['creator']);
                $this->created = $row['created'];
                $this->date_start = $row['date_start'];
                $this->date_end = $row['date_end'];
                $this->updater = new User($row['updater']);
                $this->updated = $row['updated'];
                $this->status = new Status($row['status']);
                $this->visibility = new Visibility($row['visibility']);
                $this->health = new Health($row['health']);
                $this->priority = new Priority($row['priority']);

                $this->start_format = $row['start_format'];
                $this->end_format = $row['end_format'];
                $this->updated_format = $row['updated_format'];
                $this->created_format = $row['created_format'];
                mysql_free_result($result);
            }
        }
        
        function getComments() {
            $this->comments = array();
            $query = "SELECT id FROM project_comment WHERE project=".$this->id." ORDER BY time DESC;";
            $result = mysql_query($query);
            if ($result) {
                while ($row = mysql_fetch_assoc($result)) {
                    $this->comments[] = new ProjectComment($row['id']);
                }
            }
        }
        
        function getTags() {
            $this->tags = array();
            $query = "SELECT project, tag FROM tag_project WHERE project=".$this->id.";";
            $result = mysql_query($query);
            if ($result){
                while ($row = mysql_fetch_assoc($result)) {
                    $this->tags[] = new Tag($row['tag']);
                }
            }
            mysql_free_result($result);
        }
        
        function getDeliverables() {
            $this->deliverables = array();
            $query = "SELECT id FROM job WHERE type=2 AND project=".$this->id.";";
            $result = mysql_query($query);
            if($result){
                while ($row = mysql_fetch_assoc($result)){
                    $this->deliverables[] = new Deliverable($row['id']);
                }
            }
            mysql_free_result($result);
        }
        
        function getTasks() {
            $this->tasks = array();
            $qry_tasks = "SELECT id FROM job WHERE type=1 AND project=".$this->id.";";
            $res_tasks = mysql_query($qry_tasks);
            if($res_tasks){
                while ($row_tasks = mysql_fetch_assoc($res_tasks)){
                    $this->tasks[] = new Task($row_tasks['id']);
                }
            }
            mysql_free_result($res_tasks);
        }
        
        function userCanRead($userID) {
            $query = "SELECT COUNT(*) as res FROM project_user WHERE project=".$this->id." AND user=".$userID.";";
            $result = mysql_query($query);
            if ($result) {
                if (mysql_num_rows($result) > 0) {
                    $row = mysql_fetch_assoc($result);
                    if ($row['res'] === '0') {
                        return false;
                    } else {
                        return true;
                    }
                }
                mysql_free_result($result);
            }
        }
        
        function userCanEdit($userID) {
            $query = "SELECT COUNT(*) as res FROM project_user WHERE project=".$this->id." AND user=".$userID." AND can_edit=1;";
            $result = mysql_query($query);
            if($result) {
                if (mysql_num_rows($result) > 0) {
                    $row = mysql_fetch_assoc($result);
                    if ($row['res'] === '0') {
                        return false;
                    } else {
                        return true;
                    }
                }
                mysql_free_result($result);
            }
        }
            
    }
?>
