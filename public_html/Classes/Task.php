<?php

    class Task {
        
        var $id;
        var $name;
        var $description;
        var $owner;
        var $creator;
        var $created;
        var $date_start;
        var $date_end;
        var $updater;
        var $updated;
        var $status;
        
        var $tags;
        
        function __construct($t){
            
            // get main task stuff
            $query = "SELECT * FROM task WHERE id=".$t.";";
            $result = mysql_query($query);
            if($result){
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
            }
            mysql_free_result($result);
            
            // get deliverable tags
            $this->tags = array();
            $qry_t = "SELECT task, tag FROM tag_task WHERE task=".$t.";";
            $res_t = mysql_query($qry_t);
            if($res_t){
                while ($row_t = mysql_fetch_assoc($res_t)){
                    $this->tags[] = new Tag($res_t['tag']);
                }
            }
            mysql_free_result($res_t);
        }
        
        function getID(){
            return $this->id;
        }
        
        function getName(){
           return $this->name;
        }
        
        function getDescription(){
            return $this->description;
        }
    }
?>
