<?php
    class Priority {
        var $id;
        var $name;
    
        function __construct($id) {
            $query = "SELECT * FROM priority WHERE id=".$id." LIMIT 1;";
            $result = mysql_query($query);
            if ($result){
                $row = mysql_fetch_assoc($result);
                $this->id = $row['id'];
                $this->name = $row['name'];
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
