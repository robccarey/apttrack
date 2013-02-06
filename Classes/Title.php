<?php

    class Title {
        var $id;
        var $title;
        
        function __construct($id) {
            $query = "SELECT * FROM titles WHERE id=".$id." LIMIT 1;";
            $result = mysql_query($query);
            if ($result){
                $row = mysql_fetch_assoc($result);
                $this->id = $row['id'];
                $this->title = $row['title'];
            }
        }
        
        function getID() {
            return $this->id;
        }
        
        function getTitle() {
            return $this->title;
        }
    }
?>