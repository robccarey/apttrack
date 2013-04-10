<?php
    class ProjectComment {
        private $id;
        private $message;
        private $user;
        private $time;
        private $relstamp;
        
        public function __construct($c) {
            $query = "SELECT id, comment, user, DATE_FORMAT(time, '%d-%b-%y %H:%i') as time, UNIX_TIMESTAMP(time) as unix FROM project_comment WHERE id=".$c." LIMIT 1;";
            $result = mysql_query($query);
            if ($result) {
                $row = mysql_fetch_assoc($result);
                $this->id = $row['id'];
                $this->message = $row['comment'];
                $this->user = new User($row['user']);
                $this->time = $row['time'];
                $this->relstamp = new RelDateTime($row['unix']);
                mysql_free_result($result);
            }
        }
        public function getID() {
            return $this->id;
        }
        public function getMessage() {
            return $this->message;
        }
        public function getUser() {
            return $this->user;
        }
        public function getUserID() {
            return $this->user->getID();
        }
        public function getUserFullName() {
            return $this->user->getFormalName();
        }
        public function getUserEmail() {
            return $this->user->getEmail();
        }
        public function getTime() {
            return $this->time;
        }
        public function getRelTime() {
            return $this->relstamp->getRelStamp();
        }
    }
?>
