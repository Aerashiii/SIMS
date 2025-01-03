<?php
session_start();

session_unset();
session_destroy();

header('Location: /SIMS/pages/login.php');
exit;
?>
