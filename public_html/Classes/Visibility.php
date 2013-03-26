<?php

    class Visibility {
        
        private $id;
        private $name;
        private $description;
        
        public function __construct($v) {
            $query = "SELECT * FROM visibility WHERE id=".$v." LIMIT 1;";
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
        
        public function getID(){
            return $this->id;
        }
        
        public function getName() {
            return $this->name;
        }
        
        public function getDescription() {
            return $this->description;
        }
    }
?>
