<?php
    class JobComment {
        private $id;
        private $message;
        private $user;
        private $time;
        private $time_format;
        
        public function __construct($c) {
            $query = "SELECT *, DATE_FORMAT(time, '%d-%b-%y %H:%i') as time_format FROM job_comment WHERE id=".$c." LIMIT 1;";
            $result = mysql_query($query);
            if ($result) {
                $row = mysql_fetch_assoc($result);
                $this->id = $row['id'];
                $this->message = $row['comment'];
                $this->user = new User($row['user']);
                $this->time = $row['time'];
                $this->time_format = $row['time_format'];
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
            return $this->user->getFullName();
        }
        public function getUserEmail() {
            return $this->user->getEmail();
        }
        public function getTime($format = null) {
            if (isset($format)) {
                return $this->time_format;
            } else {
                return $this->time;
            }
        }
    }
?>