<?php
    class Object {
        
        private $id;
        private $name;
        
        public function __construct($o) {
            $query = "SELECT * FROM object WHERE id=".$o." LIMIT 1;";
            $result = mysql_query($query);
            if ($result) {
                $row = mysql_fetch_assoc($result);
                $this->id = $row['id'];
                $this->name = $row['name'];
                mysql_free_result($result);
            }
        }
        public function getID() {
            return $this->id;
        }
        public function getName() {
            return $this->name;
        }
    }
?>