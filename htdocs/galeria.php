<?php
session_start();
$_SESSION["id"];

if ($_SESSION["log"] == false) {
    include("./security/sec.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>

<body>
    <div class="botones">
        
        <button type="input" value="FAVORITOS" id="fav">FAVORITOS</button>
        <button type="submit" value="QUITAR FAVORITOS" id="desfav" laid="<?php echo $fila['id_foto'] ?>">QUITAR FAVORITOS</button>
        <button type="submit" value="ENVIAR A PAPELERA" id="trashcan">ENVIAR A PAPELERA</button>
        

    </div>

    <?php
    if (file_exists("fotos/fotos_{$_SESSION["id"]}") == true) { //Si existe la carpeta, sigue el if
        if (count(scandir("fotos/fotos_{$_SESSION["id"]}")) > 2) { //Esto revisa si tiene archivos
            $handle = opendir("fotos/fotos_{$_SESSION["id"]}"); //Aquí creamos una variable para no escribir todo el codigo para abrir el directorio
            ?>
            <br><br>
            <button type="button" id="buttoncan">ENSEÑAR PAPELERA</button>
            <div class="can">
                <h1>PAPELERA DE RECICLAJE</h1>
                <input type="submit" value="RESTAURAR" id="restcan">
                <button type="submit" id="botonborrarfotos">BORRAR SELECCIÓN</button>

                <div class="galeriatrash">
                    <?php
                    include "security/connectbd.php"; //Se incluye la conexión a la base de datos
                    $con = $bd->prepare("SELECT * FROM FOTOS_" . $_SESSION['id'] . " WHERE trash = 1"); //Hacemos la query
                    $con->execute(); //Ejecutamos
                    $res = $con->get_result(); //Sacamos resultado y lo almacenamos como array
                    for ($i = 0; $i < $res->num_rows; $i++) { //Recorremos el array
                        $fila = $res->fetch_assoc(); //Almacenamos los resultados legibles en una nueva variable para ir volcándola más adelante
            
                        ?>
                        <div class="marco">
                            <div class="imagen">
                                <img id="myImg" src="fotos/fotos_<?php echo $_SESSION["id"] . "/" . $fila["nombre_disco"] ?>"
                                    alt="Placeholder">
                            </div>

                            <div class="nombre">
                                <input type="checkbox" class="checkphoto" laid="<?php echo $fila['id_foto'] ?>">
                                <input id="nombrefoto_<?php echo $fila['id_foto'] ?>" value="<?php echo $fila["nombre_foto"] ?>">

                                <button class="botonact" laid="<?php echo $fila['id_foto'] ?>"><img
                                        src="./iconos/cloud-upload-alt.png"></button>
                                <textarea
                                    id="descripcion_<?php echo $fila['id_foto'] ?>"><?php echo $fila["descripcion"] ?></textarea>
                                <br>

                                <br>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                
            <div class="galfav">
                <h1>FAVORITOS</h1>
                <div class="galeria_fav"> <!-- Esto solo debería verse si hay favoritos -->

                    <?php
                    include "security/connectbd.php"; //Se incluye la conexión a la base de datos
                    $con = $bd->prepare("SELECT * FROM FOTOS_" . $_SESSION['id'] . " WHERE fav = 1 and trash = 0"); //Hacemos la query
                    $con->execute(); //Ejecutamos
                    $res = $con->get_result(); //Sacamos resultado y lo almacenamos como array
                    for ($i = 0; $i < $res->num_rows; $i++) { //Recorremos el array
                        $fila = $res->fetch_assoc(); //Almacenamos los resultados legibles en una nueva variable para ir volcándola más adelante
            
                        ?>
                        <div class="marco">
                            <div class="imagen">
                                <img id="myImg" src="fotos/fotos_<?php echo $_SESSION["id"] . "/" . $fila["nombre_disco"] ?>"
                                    alt="Placeholder">
                            </div>

                            <div class="nombre">
                                <input type="checkbox" class="checkphoto" laid="<?php echo $fila['id_foto'] ?>">

                                <input id="nombrefoto_<?php echo $fila['id_foto'] ?>" value="<?php echo $fila["nombre_foto"] ?>">

                                <button class="botonact" laid="<?php echo $fila['id_foto'] ?>"><img
                                        src="./iconos/cloud-upload-alt.png"></button>
                                <textarea
                                    id="descripcion_<?php echo $fila['id_foto'] ?>"><?php echo $fila["descripcion"] ?></textarea>

                                <br>
                            </div>
                        </div>
                        <?php } ?>
                </div>   
            </div>

            <div class="galeriamain">
                <h1>GALERIA</h1>
                <div class="galeria">

                    <?php
                    include "security/connectbd.php"; //Se incluye la conexión a la base de datos
                    $con = $bd->prepare("SELECT * FROM FOTOS_" . $_SESSION['id'] . " WHERE fav = 0 and trash = 0"); //Hacemos la query
                    $con->execute(); //Ejecutamos
                    $res = $con->get_result(); //Sacamos resultado y lo almacenamos como array
                    for ($i = 0; $i < $res->num_rows; $i++) { //Recorremos el array
                        $fila = $res->fetch_assoc(); //Almacenamos los resultados legibles en una nueva variable para ir volcándola más adelante
            
                        ?>
                        <div class="marco">
                            <div class="imagen">
                                <img id="myImg" src="fotos/fotos_<?php echo $_SESSION["id"] . "/" . $fila["nombre_disco"] ?>"
                                    alt="Placeholder">
                            </div>

                            <div class="nombre">
                                <input type="checkbox" class="checkphoto" laid="<?php echo $fila['id_foto'] ?>">
                                <input id="nombrefoto_<?php echo $fila['id_foto'] ?>" value="<?php echo $fila["nombre_foto"] ?>">

                                <button class="botonact" laid="<?php echo $fila['id_foto'] ?>"><img
                                        src="./iconos/cloud-upload-alt.png"></button>
                                <textarea
                                    id="descripcion_<?php echo $fila['id_foto'] ?>"><?php echo $fila["descripcion"] ?></textarea>
                                <br>

                                <br>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                </div>
            </div>



            <?php
        }

    }

    ?>
</body>
<script>
    $(document).ready(function () {
        let ids = [];
        $("#botonborrarfotos").click( //Función para que cuando marquemos los checkboxes y pulsemos en borrar, mande la opción al controlador
            function () {
                $(".checkphoto").each(
                    function () {
                        if ($(this).is(":checked"))
                            ids.push($(this).attr("laid"))
                    });
                let opt = 1;
                for (var i = 0; i < ids.length; i++) {
                    $.ajax({
                        type: "POST",
                        url: "controladores/controlador_galeria.php",
                        data: {
                            ids: ids[i],
                            opt: opt

                        }
                    });
                };
                alert("Imagenes borradas con exito");
                setTimeout("location.reload(true);", 1000) //Con 1100 no lo hará instantáneo
            });

        $(".botonact").click(function () { //Funcionará pinchando en CUALQUIER botón de actualizar

            var id = $(this).attr("laid");
            let name = $("#nombrefoto_" + id).val();
            let descripcion = $("#descripcion_" + id).val();
            let opt = 2;

            $.ajax({
                type: "POST",
                url: "./controladores/controlador_galeria.php",
                data: {
                    ids: id,
                    name: name,
                    opt: opt,
                    descripcion: descripcion
                },
                success: function (response) {
                    alert("Datos actualizados correctamente");
                    setTimeout("location.reload(true);", 1000);
                }
            });
        });

        $("#fav").click(function () {
            $(".checkphoto").each(
                function () {
                    if ($(this).is(":checked"))
                        ids.push($(this).attr("laid"))
                });

            for (var i = 0; i < ids.length; i++) {
                let opt = 3;
                let fav = 1;
                $.ajax({
                    type: "POST",
                    url: "controladores/controlador_galeria.php",
                    data: {
                        ids: ids[i],
                        fav: fav,
                        opt: opt
                    }
                });

            } setTimeout(function(){location.href="index.php", 1000});

        })

        $("#desfav").click(function () {
            $(".checkphoto").each(
                function () {
                    if ($(this).is(":checked"))
                        ids.push($(this).attr("laid"))
                });

            for (var i = 0; i < ids.length; i++) {
                let opt = 3;
                let fav = 0;
                $.ajax({
                    type: "POST",
                    url: "controladores/controlador_galeria.php",
                    data: {
                        ids: ids[i],
                        fav: fav,
                        opt: opt
                    }
                });

            } setTimeout(function(){location.href="index.php", 1000})
        })

        $("#trashcan").click(function () {
            $(".checkphoto").each(
                function () {
                    if ($(this).is(":checked"))
                        ids.push($(this).attr("laid"))
                });

            for (var i = 0; i < ids.length; i++) {
                let opt = 4;
                let trash = 1;
                $.ajax({
                    type: "POST",
                    url: "controladores/controlador_galeria.php",
                    data: {
                        ids: ids[i],
                        trash: trash,
                        opt: opt
                    }
                });

            } setTimeout("location.reload(true);", 1000);


        });

        $("#restcan").click(function () {
            $(".checkphoto").each(
                function () {
                    if ($(this).is(":checked"))
                        ids.push($(this).attr("laid"))
                });

            for (var i = 0; i < ids.length; i++) {
                let opt = 4;
                let trash = 0;
                $.ajax({
                    type: "POST",
                    url: "controladores/controlador_galeria.php",
                    data: {
                        ids: ids[i],
                        trash: trash,
                        opt: opt
                    }
                });

            } setTimeout("location.reload(true);", 1000);


        });

        $(".can").hide();
        $("#buttoncan").click(
            function () {
                $(".can").toggle("slow");
            }
        )
    });
</script>

</html>