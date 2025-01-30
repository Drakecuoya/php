<?php
session_start();
include "funcionesbd.php";

$opt = filter_input(INPUT_POST, 'opt', FILTER_SANITIZE_NUMBER_INT);

$users = new user();


switch ($opt) {

    default: //Redirige en caso de dar casos vacíos, falsos o en 0
        header("location: ../login.php");
        exit;

    case 1:
        $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id = filter_input(INPUT_POST, 'ids', FILTER_SANITIZE_NUMBER_INT);
        $mail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


        if (empty($user) || empty($pass)) {
            echo 'No puede crearse usuarios en blanco';
        }
        if ($users->createuser($user, $mail, $pass, $name)) {
            echo 'Usuario creado con éxito';
        } else {
            echo 'El usuario ya existe. Por favor, elija otro nombre de usuario';
        }
        break;
    case 2:
        if ($_SESSION["log"] == false) {
            include "../security/sec.php";
        }
        ;

        if ($_SESSION["nivel"] == 0) {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $level = filter_input(INPUT_POST, 'nivel', FILTER_SANITIZE_NUMBER_INT);
            $mail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $id = filter_input(INPUT_POST, 'ids', FILTER_SANITIZE_NUMBER_INT);
            $activity =  filter_input(INPUT_POST, 'actividad', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $users->updateuser($name, $mail, $level, $activity, $id);
        }

        break;
    case 3:
        if ($_SESSION["log"] == false) {
            include "../security/sec.php";
        }
        ;

        if ($_SESSION["nivel"] == 0) {
            $id = filter_input(INPUT_POST, 'ids', FILTER_SANITIZE_NUMBER_INT);
            $users->eraseuser($id);
        }

        break;

    case 4:        

        
        $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $mail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (empty($user) || empty($pass)) {
            ?>
            <script>
                alert("No puede crearse usuarios en blanco");
                window.location.href = "../index.php";
            </script><?php
            break;
        }
        if ($users->autologin($user, $mail, $pass, $name)) {
            echo '<script>
                    alert("Usuario creado con éxito");
                    window.location.href = "../index.php";
                </script>';
        } else {
            echo '<script>
                    alert("El usuario ya existe. Por favor, elija otro nombre de usuario.");
                    window.history.back();
                </script>';
        }
        break;

    case 5:
        $id = filter_input(INPUT_POST, 'ids', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $users->addfriend($id);
        break;

    case 6:
        $id = filter_input(INPUT_POST, 'ids', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $users->removefriend($id);
        break;
}