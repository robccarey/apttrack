<?php
    class Tag {
        private $id;
        private $tag;
        private $created;
        
        public function __construct($t) {
            $query = "SELECT id, tag, DATE_FORMAT(created, '%d-%b-%y %H:%i') as created FROM tags WHERE id=".$t.";";
            $result = mysql_query($query);
            if ($result) {
                $row = mysql_fetch_assoc($result);
                $this->id = $row['id'];
                $this->tag = $row['tag'];
                $this->created = $row['created'];
            }
        }
        
        public function getID() {
            return $this->id;
        }
        
        public function getTag() {
            return $this->tag;
        }
        
        public function getCreated() {
            return $this->created;
        }
    }
?>
