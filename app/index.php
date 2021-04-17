<?php

$config = parse_ini_file('../wskz_config.ini');

include 'models/users.php';

$template = '';

if (isset($_GET['register']) ) {
    if (isset($_POST['login']) ) {
        
        $users = new Users($pdo);
        $users->insert($_POST);
        
        if ( $messages = $users->getErrorMessages() ) {
            $_SESSION['error_messages'] = $messages;
        } else {
            $_SESSION['user_data'] = $users->getSessionUserData();
        }
    }
    $template = 'views/register.phtml';
} else {
    if (isset($_SESSION['login']) ) {
    }
}
?>
<html>
    <head>
    </head>
    <body>
        <p>Witaj na stronie</p>
        <?php include $template; ?>
    </body>
</html>
