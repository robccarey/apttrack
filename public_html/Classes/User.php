<?php

    class User {
        var $id;
        var $title;
        var $fname;
        var $sname;
        var $email;
        var $prev_login;
        
        function __construct($id) {
            $this->id = $id;
            $this->refresh();
        }
        
        function refresh() {
            $query = "SELECT * FROM user WHERE id=".$this->id." LIMIT 1;";
            $result = mysql_query($query);
            if ($result){
                $row = mysql_fetch_assoc($result);
                $this->title = new Title($row['title']);
                $this->fname = $row['forename'];
                $this->sname = $row['surname'];
                $this->email = $row['email'];
                $this->prev_login = $row['prev_login'];
            }
        }
        
        function getID() {
            return $this->id;
        }
        
        function getTitleID() {
            return $this->title->getID();
        }
        
        function getTitleText() {
            return $this->title->getTitle();
        }
        
        function getForename() {
            return $this->fname;
        }
        
        function getSurname() {
            return $this->sname;
        }
        
        function getEmail() {
            return $this->email;
        }
        
        function getFullName() {
            return $this->fname.' '.$this->sname;
        }
        
        function getFormalName() {
            $out = $this->getTitleText().'. '.$this->getFullName();
            return $out;
        }
        
        function getPrevLogin() {
            return $this->prev_login;
        }
    }
?>