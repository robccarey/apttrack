<?php

    class User {
        private $id;
        private $title;
        private $fname;
        private $sname;
        private $email;
        private $login_prev;
        private $login_last;
        
        public function __construct($id) {
            $this->id = $id;
            $this->refresh();
        }
        
        public function refresh() {
            $query = "SELECT title, forename, surname, email,
                DATE_FORMAT(prev_login, '%d-%b-%y %H:%i') as prev_login,
                DATE_FORMAT(last_login, '%d-%b-%y %H:%i') as last_login 
                FROM user WHERE id=".$this->id." LIMIT 1;";
            $result = mysql_query($query);
            if ($result){
                $row = mysql_fetch_assoc($result);
                $this->title = new Title($row['title']);
                $this->fname = $row['forename'];
                $this->sname = $row['surname'];
                $this->email = $row['email'];
                $this->login_prev = $row['prev_login'];
                $this->login_last = $row['last_login'];
            }
        }
        
        public function getID() {
            return $this->id;
        }
        
        public function getTitleID() {
            return $this->title->getID();
        }
        
        public function getTitleText() {
            return $this->title->getTitle();
        }
        
        public function getForename() {
            return $this->fname;
        }
        
        public function getSurname() {
            return $this->sname;
        }
        
        public function getEmail() {
            return $this->email;
        }
        
        public function getFullName() {
            return $this->fname.' '.$this->sname;
        }
        
        public function getFormalName() {
            return $this->getTitleText().'. '.$this->getFullName();
        }
        
        public function getPrevLogin() {
            if ((isset($this->login_prev))&&('x'.$this->login_prev !== 'x')) {
                return $this->login_prev;
            } else {
                return $this->login_last;
            }
        }
    }
?>