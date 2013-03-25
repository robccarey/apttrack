<?php
    // references: http://stackoverflow.com/questions/3258634/php-how-to-send-http-response-code
    if (!function_exists('http_response_code'))
    {
        function http_response_code($newcode = NULL)
        {
            static $code = 200;
            if($newcode !== NULL)
            {
                header('X-PHP-Response-Code: '.$newcode, true, $newcode);
                if(!headers_sent())
                    $code = $newcode;
            }       
            return $code;
        }
    }

    // has a method been specified?
    if(isset($_POST['method']) || (isset($_GET['method']))) {
        
        require('../connect.php');
        require('functions.php');
        $valid_session = checkLogin();
        // is user authenticated?
        if ($valid_session > 0) {
            require('Classes/User.php');
            require('Classes/Title.php');
            $CURRENT_USER = new User($valid_session);
            
            if (isset($_POST['method'])) {
                $meth = $_POST['method'];
            } else {
                $meth = $_GET['method'];
            }
            // what is requested method?
            if ($meth === 'relatedSearch') {
                $term = mysql_escape_string($_POST['term']);
                $query = "SELECT * FROM job WHERE name LIKE '%".$term."%';";
                $result = mysql_query($query);
                if ($result) {
                    // all ok
                    $output = '<ul class="nav nav-tab nav-stacked">';
                    while ($row = mysql_fetch_assoc($result)) {
                        $output .= '<li><a class="muted">'.$row['name'].'</a></li>';
                    }
                    $output .= '</ul>';
                    http_response_code(201);
                    echo $output;
                    mysql_free_result($result);
                } else {
                    // error
                    http_response_code(500);
                }
            } else {
                // invalid requested method
                http_response_code(405);
            }
        } else {
            // invalid user
            http_response_code(401);
        }
    } else {
        http_response_code(400);
    }
?>
