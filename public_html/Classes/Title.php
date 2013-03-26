<?php

    class Title {
        private $id;
        private $title;
        
        public function __construct($id) {
            $query = "SELECT * FROM titles WHERE id=".$id." LIMIT 1;";
            $result = mysql_query($query);
            if ($result){
                $row = mysql_fetch_assoc($result);
                $this->id = $row['id'];
                $this->title = $row['title'];
            }
        }
        
        public function getID() {
            return $this->id;
        }
        
        public function getTitle() {
            return $this->title;
        }
    }
?>