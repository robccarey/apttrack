<?php
    class Deliverable {
        
        var $id;
        var $name;
        var $description;
        var $owner;
        var $creator;
        var $created;
        var $date_end;
        var $updated;
        var $updater;
        var $status;
        var $project_id;
        var $project_name;
        var $tags;
        
        function __construct($d){
            
            // get main deliverable stuff
            $query = "SELECT * FROM deliverable WHERE id=".$d.";";
            $result = mysql_query($query);
            if($result){
                $row = mysql_fetch_assoc($result);
                
                $this->id = $row['id'];
                $this->name = $row['name'];
                $this->description = $row['description'];
                $this->owner = new User($row['owner']);
                $this->creator = new User($row['creator']);
                $this->created = $row['created'];
                $this->date_end = $row['date_end'];
                $this->status = new Status($row['status']);
                $this->project_id = $row['project'];
                $this->updated = $row['updated'];
                $this->updater = new User($row['updater']);
            }
            mysql_free_result($result);
            
            // get parent project name
            $qry_proj_name = "SELECT name FROM project WHERE id=".$this->project_id.";";
            $res_proj_name = mysql_query($qry_proj_name);
            if ($res_proj_name) {
                $row_proj_name = mysql_fetch_assoc($res_proj_name);
                $this->project_name = $row_proj_name['name'];
            }
            mysql_free_result($res_proj_name);
            
            // get deliverable tags
            $this->tags = array();
            $qry_tags = "SELECT deliverable, tag FROM tag_deliverable WHERE deliverable=".$d.";";
            $res_tags = mysql_query($qry_tags);
            if($res_tags){
                while ($row_tags = mysql_fetch_assoc($res_tags)){
                    $this->tags[] = new Tag($res_tags['tag']);
                }
            }
            mysql_free_result($res_tags);
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
