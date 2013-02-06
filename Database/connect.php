<?php
    // connects to database
    
    $server = 'localhost';
    $username = 'rcarey_apttrack';
    $database = 'apttrackdb';
    $password = 'metro01';
    
    if (!mysql_connect($server, $username, $password))
    {
        exit('Error: Could not establish database connection.');
    }
    if (!mysql_select_db($database))
    {
        exit('Error: Could not select database.');
    }
    
?>
