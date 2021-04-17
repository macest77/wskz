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
    } else {
        header('Location: index.php');
    }
    $template = 'views/register.phtml';
} else {
    if (isset($_SESSION['login']) ) {
        $logged = $_SESSION['login'];
    } else {

    }
}
?>
<!doctype html>
<html lang="en">
    <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    </head>
    <body style="margin:auto;width: 70%; border: solid 1px #777; border-radius: 10px">
        <p style="text-align: center;">Witaj na stronie</p>
    <?php if (empty($logged) ) 
        echo '<p style="float:right"><a href="index.php?register=1">Zarejestruj się</a></p>'; ?>
    <?php if ($template != '' )
        include $template; ?>
        <div style="clear: both"></div>
    </body>
</html>
