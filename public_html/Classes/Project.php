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
        
        
        function __construct($id) {
            $query = "SELECT * FROM project WHERE id=".$id." LIMIT 1;";
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
            }
        }
        
        function getID() {
            return $this->id;
        }
        
        function getName() {
            return $this->name;
        }
    }
?>
