<?php
    // have POST values been provided?
    if(isset($_POST['submit'])) {
        include('../connect.php');
        $clean = array();
        $clean['email'] = mysql_real_escape_string($_POST['email']);
        $clean['password'] = mysql_real_escape_string($_POST['password']);

        $query = "SELECT id, email, last_login FROM user WHERE email='".$clean['email']."' AND password=md5('".$clean['password']."');";
        $result = mysql_query($query);
        if(!$result) {
            // invalid username/password combo - error i
            $destination = '/index.php?e=i';
        } else {
            if (mysql_num_rows($result) == 0) {
                // invalid username/password combo - error i
                $destination = '/index.php?e=i';
            } else {
                // success
				
                // prepare id/token and timeout for db/cookie
                $row = mysql_fetch_assoc($result);
                $userid = $row['id'];
                $last_login = $row['last_login'];
                $salt = 'apttrack247';
                
                $identifier = md5($salt . md5($clean['email'] . $salt));
                $token = md5(uniqid(rand(),true)); 
                $auth_timeout = time() + (60 * 60 * 24 * 7);
                
                // insert browser into sessions
                $query = "INSERT INTO session(identifier, token, browser, user, created) VALUES ('".$identifier."', '".$token."', '".mysql_escape_string($_SERVER['HTTP_USER_AGENT'])."', ".$userid.", NOW());";
                if (mysql_query($query)) {
                    // fine, set cookie
                    $cookie = $identifier.':'.$token;
                    setcookie('at', $cookie, $auth_timeout, '/');
                    $destination = 'home.php';
                    
                    session_start();
                    $_SESSION['id'] = $userid;
                    $_SESSION['auth'] = true;
                } else {
                    echo mysql_error();
                    $destination = 'index.php?e=d';
                }
            }
        }
    } else {
        // forward user to index
        $destination = 'index.php';
    }
?>

<html>
	<head>
		<meta HTTP-EQUIV="REFRESH" content="0; url=<?php echo $destination; ?>">
	</head>
	<body>
		Verifying credentials...
	</body>
</html>