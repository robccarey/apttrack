<?php
    class Status {
        var $id;
        var $name;
        var $description;
    
        function __construct($id) {
            $query = "SELECT * FROM status WHERE id=".$id." LIMIT 1;";
            $result = mysql_query($query);
            if ($result){
                $row = mysql_fetch_assoc($result);
                $this->id = $row['id'];
                $this->name = $row['name'];
                $this->description = $row['description'];
            }
        }
        
        function getID() {
            return $this->id;
        }
        
        function getName() {
            return $this->name;
        }
        
        function getDescription() {
            return $this->description;
        }
    }
?>
