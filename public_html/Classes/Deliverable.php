<?php
    class Deliverable {
        
        var $id;
        var $name;
        var $description;
        var $owner;
        var $creator;
        var $created;
        var $date_end;
        var $status;
        
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
            }
            mysql_free_result($result);
            
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
