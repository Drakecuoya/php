<!DOCTYPE html>

<?php
session_start();
if (isset($_SESSION["log"])) {
    if ($_SESSION["log"] == false) {
        include("./security/sec.php");
    }
} else {
    include("./security/sec.php"); //Así con esto no entra aunque no logeemos.
}
if (isset($_SESSION["time"]) && time() - $_SESSION["time"] > 1000) {

    ?>
    <script>

        alert('Se te desconectará por inactividad');
        window.location.href = "../logout.php";

    </script>
    <?php
    exit();
} else {
    $_SESSION["time"] = time();
}

include "language.php"; //Con este include llamamos al language que hace el control de idiomas

?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/tabla.css">
    <title>index</title>
</head>

<div class="title">
    <h1 class="title"><?php echo $idioma->palabras->bienve . " " . $_SESSION["name"] ?></h1>
</div> <!-- Este echo llama a que nos traigan del language las palabras traducidas -->

<div id="imagenamigos">
    <img id="friends" src="./iconos/high-five.png" alt="amigos">
</div>
<div id="cuadroAmigos"></div>


<?php
if ($_SESSION["nivel"] == 0) { ?>
    <!-- Con este if ocultamos la tabla de administración para que no se muestre a los usuarios normales -->

    <div id="gotoadmin">
        <img src="./iconos/settings.png" alt="admin" id="admin">
    </div>
    <div id="tablaAdmin"></div>
<?php } ?>


<ul>
    <li>
        <form action="logout.php" method="post">
            <div id="out">
                <button id="botonout" , value="LOG OUT">LOGOUT</button>
            </div>
        </form>
    </li>

    <form action="./controladores/controlador_galeria.php" method="post" enctype="multipart/form-data">
        <!-- El enctype encripta la información -->
        <div id="uploader">
            <li> <input type="file" id="upload" name="uploads[]" accept="image/*" multiple></li>
            <!-- Botón de eler archivo -->
        </div>
        <li> <input type="submit" id="uploadfile" value="ENVIAR ARCHIVO"> <!-- Botón para enviar el archivo --></li>
        <input name="opt" type="hidden" value="0">
    </form>
</ul>

<div id="galeria"></div> <!-- Aunque esté vacío, aquí se muestra la galería que viene desde el otro archivo -->

</body>

<script>
    $(document).ready(function () {
        $.ajax({ //Con ese ajax llamamos a que nos muestre la tablaAdmin
            type: "POST",
            url: "tablaAdmin.php",
            success: function (data) {
                $("#tablaAdmin").html(data);
            }
        })

        $("#tablaAdmin").hide();
        $("#admin").click( //Esta función es para que en el botón admin nos muestre la tabla porque justo antes especificamos que esté oculta
            function () {
                $("#tablaAdmin").toggle("slow");
            }
        );


        $.ajax({ //Con este ajax llamamos a que nos muestre la galería
            type: "POST",
            url: "galeria.php",
            success: function (data) {
                $("#galeria").html(data);
            }
        })

        $.ajax({ //Con ese ajax llamamos a que nos muestre la tablaAdmin
            type: "POST",
            url: "cuadroAmigos.php",
            success: function (data) {
                $("#cuadroAmigos").html(data);
            }
        })

        $("#cuadroAmigos").hide();

        $("#friends").click( //Esto es para hacer toggle
            function () {
                $("#cuadroAmigos").toggle("slow");

            }
        );
    });

</script>

</html>