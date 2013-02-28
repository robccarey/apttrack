<?php

    class Visibility {
        
        var $id;
        var $name;
        var $description;
        
        function __construct($v) {
            $query = "SELECT * FROM visibility WHERE id=".$v.";";
            $result = mysql_query($query);
            if ($result) {
                if (mysql_num_rows($result) > 0) {
                    $row = mysql_fetch_assoc($result);
                    
                    $this->id = $row['id'];
                    $this->name = $row['name'];
                    $this->description = $row['description'];
                }
                mysql_free_result($result);
            }
        }
        
        function getID(){
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
