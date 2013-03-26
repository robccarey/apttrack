<?php
    class JobType {
        private $id;
        private $name;
    
        public function __construct($id) {
            $query = "SELECT * FROM job_type WHERE id=".$id." LIMIT 1;";
            $result = mysql_query($query);
            if ($result){
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
