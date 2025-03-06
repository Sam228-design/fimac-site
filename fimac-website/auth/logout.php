<?php
require_once 'auth.php';

$auth = new Auth();
$result = $auth->logout();

if ($result['success']) {
    $_SESSION['success'] = $result['message'];
} else {
    $_SESSION['error'] = $result['message'];
}

header('Location: login.php');
exit();
?>
