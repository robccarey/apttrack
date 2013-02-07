<?php
    class Tag {
        var $id;
        var $tag;
        var $created;
        
        function __construct($t) {
            $query = "SELECT * FROM tags WHERE id=".$t.";";
            $result = mysql_query($query);
            if ($result) {
                $row = mysql_fetch_assoc($result);
                $this->id = $row['id'];
                $this->tag = $row['tag'];
                $this->created = $row['created'];
            }
        }
        
        function getID() {
            return $this->id;
        }
        
        function getTag() {
            return $this->tag;
        }
        
        function getCreated() {
            return $this->created;
        }
    }
?>
