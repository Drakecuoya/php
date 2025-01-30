<!DOCTYPE html>

<?php
$a = "<h1>Drakecuoya</h1>";
?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <title>Document</title>
</head>

<body>

<form>
    User: <input name: "text"></input>
</form>



   <div id="nombre">
   <!--      esto va vacío porque el ajax imprimirá aquí dentro lo del archivo nombre.php -->
    </div>

    <input type="button" , id="boton" , value="Pincha, hijueputa"></input>


</body>

<script>
    let a = 0; //Compara valores, 0 es false, 1 es true

    $("#boton").click(function () {

        // Este if-else va oscilando el valor de 0 según va entrando y accionándose

        $.ajax({ //Esto pide informacion a un lugar y lo manda a otro
            type: "POST",
            url: "array.php",
            data: { opcion: a }, //Primero va lo que nos referencia al otro archivo y después el let
            success: function (data) { //Esto nos llama a la función que nos imprime el contenido del archivo
                $("#nombre").html(data);
                //La # es para seleccionar el id del div
            }
        });
        if (a == 2) a = 0
        else a++;
    });

</script>

</html>