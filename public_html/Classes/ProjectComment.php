<?php
    class ProjectComment {
        var $id;
        var $message;
        var $user;
        var $time;
        
        function __construct($c) {
            $query = "SELECT id, comment, user, DATE_FORMAT(time, '%d-%b-%y %H:%i') as time FROM project_comment WHERE id=".$c.";";
            $result = mysql_query($query);
            if ($result) {
                $row = mysql_fetch_assoc($result);
                $this->id = $row['id'];
                $this->message = $row['comment'];
                $this->user = new User($row['user']);
                $this->time = $row['time'];
                mysql_free_result($result);
            }
        }
    }
?>
