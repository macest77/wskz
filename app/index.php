<?php

$config = parse_ini_file('../config.ini');

include 'models/users.php';
include 'models/functions.php';

$functions = new Functions();
$pdo = $functions->create_pdo($config);

if (isset($_GET['register']) ) {
    if (isset($_POST['login']) ) {
        
        $users = new Users($pdo);
        $users->insert($_POST);
    }
    include 'views/register.phtml';
}
