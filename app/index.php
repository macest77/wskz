<?php

$config = parse_ini_file('../wskz_config.ini');

include 'models/users.php';
include 'models/functions.php';

$functions = new Functions();
$pdo = $functions->create_pdo($config);

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
    include 'views/register.phtml';
}
