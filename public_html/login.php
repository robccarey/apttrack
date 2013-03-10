<?php
    // have POST values been provided?
    if(isset($_POST['submit'])) {
        include('../connect.php');
        $clean = array();
        $clean['email'] = mysql_real_escape_string($_POST['email']);
        $clean['password'] = mysql_real_escape_string($_POST['password']);

        $query = "SELECT id, last_login FROM user WHERE email='".$clean['email']."' AND password=md5('".$clean['password']."');";
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
                $salt = 'abcdef';
                $ident = md5($salt . md5($clean['email'] . $salt));
                $token = md5(uniqid(rand(),true));
                $auth_timeout = time() + (60 * 60 * 24 * 7);

                // update users login tokens
                $query = "UPDATE user SET identifier='".$ident."', login_token='".$token."', login_timeout=".$auth_timeout.", prev_login='".$last_login."', last_login=NOW() WHERE id=".$userid.";";
                $result2 = mysql_query($query);
                if(!$result2) {
                    echo mysql_error();
                    // error updating db - error d
                    $destination = 'index.php?e=d';
                } else {
                    $cookie = $ident.':'.$token;
                    setcookie('auth', $cookie, $auth_timeout, '/');
                    $destination = 'home.php';
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