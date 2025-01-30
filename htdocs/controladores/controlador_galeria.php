<?php
session_start();

include "funcionesgaleria.php";
if (isset($_SESSION["log"])) {
    if ($_SESSION["log"] == false) {
        include("./security/sec.php");
    }
} else {
    include("./security/sec.php"); //Así con esto no entra aunque no logeemos.
}

if (isset($_SESSION["time"]) && time() - $_SESSION["time"] > 10) {
    ?>
    <script>alert('Se te desconectará por inactividad');
        window.location.href = "../logout.php";
    </script>
    <?php
    exit();
} else {
    $_SESSION["time"] = time();
}


$opt = $_POST["opt"];

$gallery = new gallery();

switch ($opt) {
    case 0:
        if ($_SESSION["log"] == false) {
            include "../security/sec.php";
        }
        ;
        if (!empty($_FILES["uploads"]["name"]["0"])) {
            $gallery->uploads($_FILES); //$_FILES es una variable global

        } else {
            ?>
            <script>
                alert("No pueden enviarse archivos vacios")
                window.location.href = "../index.php";
            </script> <?php
        }
        break;

    case 1:
        if ($_SESSION["log"] == false) {
            include "../security/sec.php";
        }
        ;
        $id = filter_input(INPUT_POST, 'ids', FILTER_SANITIZE_NUMBER_INT);
        $gallery->erasePhoto($id);
        break;

    case 2:
        if ($_SESSION["log"] == false) {
            include "../security/sec.php";
        }
        ;
        $names = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id = filter_input(INPUT_POST, 'ids', FILTER_SANITIZE_NUMBER_INT);
        $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $gallery->updatePhoto($names, $id, $descripcion);
        break;

    case 3:
        $id = filter_input(INPUT_POST, 'ids', FILTER_SANITIZE_NUMBER_INT);
        $fav = filter_input(INPUT_POST, 'fav', FILTER_SANITIZE_NUMBER_INT);
        $gallery->favPhoto($fav, $id);
        break;

    case 4:
        $id = filter_input(INPUT_POST, 'ids', FILTER_SANITIZE_NUMBER_INT);
        $trash = filter_input(INPUT_POST, 'trash', FILTER_SANITIZE_NUMBER_INT);
        $gallery->trashCan($trash, $id);
        break;
}