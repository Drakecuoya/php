<?php
session_start();


$_SESSION["estado"] = 0;
include "./security/connectbd.php";
$con = $bd->prepare("UPDATE usuarios SET estado = ? WHERE id = ?");
$con->bind_param('ii', $_SESSION['estado'], $_SESSION['id']);
$con->execute();

$_SESSION = array();
session_destroy();

header("Location: login.php");
exit();