<?php
    class Object {
        
        var $id;
        var $name;
        
        function __construct($o) {
            $query = "SELECT * FROM object WHERE id=".$o.";";
            $result = mysql_query($query);
            if ($result) {
                $row = mysql_fetch_assoc($result);
                
                $this->id = $row['id'];
                $this->name = $row['name'];
            }
            mysql_free_result($result);
        }
    }
?>
