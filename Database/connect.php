<?php
    // connects to 'fyp' database
    
    $server = '';
    $username = '';
    $database = '';
    $password = '';
    
    if (!mysql_connect($server, $username, $password))
    {
        exit('Error: Could not establish database connection.');
    }
    if (!mysql_select_db($database))
    {
        exit('Error: Could not select database.');
    }
    
?>
