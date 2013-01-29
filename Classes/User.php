<?php

    class User {
        var $name = 'start';
        
        function setUsername( $n='##blank##' ) {
            if ($n === '##blank##') {
                return false;
            } else {
                $this->name = $n;
                return true;
            }
            
        }
        function getUsername() {
            return $this->name;
        }
    }
?>
