<?php

session_start();
if (!isset($_SESSION["log"]) || ($_SESSION['log'] == false)) {
    header("location: login.php"); //Así con esto no entra aunque no logeemos.
} else if ($_SESSION["nivel"] == 1) {
    header("location: index.php");
} else if ($_SESSION["nivel"] == 0) {
    ?>

            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
                <link rel="stylesheet" href="css/tabla.css">

                <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>


            </head>

            <body>

                <button type="submit" value="BORRAR SELECCIÓN" id="botonborrar">BORRAR SELECCIÓN</button>
                <table class="tabla" style="border: 1px solid black">
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>User</th>
                        <th>Password</th>
                        <th>Name</th>
                        <th>Mail</th>
                        <th>Level</th>
                        <th>Activity</th>
                    </tr>

                <?php
                include "security/connectbd.php";

                $con = $bd->prepare("SELECT * from usuarios");
                $con->execute();
                $res = $con->get_result();

                for ($i = 0; $i < $res->num_rows; $i++) {
                    $results = $res->fetch_assoc();
                    ?>

                        <tr>
                            <td><input type="checkbox" class="checkusers" laid="<?php echo $results['id'] ?>"></td>
                            <td><?php echo $results['id'] ?></td>
                            <td><?php echo $results['user'] ?></td>
                            <td></td>
                            <td><input id="name<?php echo $results['id'] ?>" value="<?php echo $results['nombreuser'] ?>"></td>
                            <td><input id="mail<?php echo $results["id"] ?>" value="<?php echo $results["mail"] ?>"></td>
                            <td><input id="nivel<?php echo $results['id'] ?>" value="<?php echo $results['nivel'] ?>"></td>
                            <td><select id="activity<?php echo $results['id'] ?>" value="<?php echo $results['actividad'] ?>">
                                    <option value="" disabled selected> <?php echo $results['actividad'] ?> </option>
                                    <option value="active">activo</option>
                                    <option value="inactive">inactive</option>
                                </select></td>
                            <td><button class="botonactualizar" laid="<?php echo $results['id'] ?>"><img
                                        src="./iconos/cloud-upload-alt.png"></td>
                        </tr>

            <?php } ?>
                    <tr>
                        <td></td>
                        <td><?php echo ($results['id'] + 1) ?></td>
                        <td><input id="newUser"></td>
                        <td><input id="newPassword"></td>
                        <td><input id="newNombre"></td>
                        <td><input id="newMail"></td>
                        <td><input id="newNivel"></td>
                        <td><button class="botonregistrar" laid="<?php echo $results['id'] + 1 ?>"><img src="./iconos/nuevo.png">
                        </td>

                    </tr>
                </table>


            </body>

            <script>

                $(document).ready(function () {
                    let ids = [];

                    $("#botonborrar").click( //Con almohadilla llamas al id
                        function () {
                            $(".checkusers").each( //Con punto llamas a la class
                                function () {
                                    if ($(this).is(":checked"))
                                        ids.push($(this).attr("laid"))
                                });
                            let opt = 3;
                            for (var i = 0; i < ids.length; i++) {
                                $.ajax({
                                    type: "POST",
                                    url: "./controladores/controlador_user.php", //Llamaria al controlador
                                    data: {
                                        ids: ids[i],
                                        opt: opt
                                    }, //añadiria la opcion del switch
                                    success: function (response) {
                                        alert("Usuario borrado con exito." + response)
                                        setTimeout("location.reload(true);", 1025);
                                    }
                                });
                            };

                        });

                    $(".botonactualizar").click(function () { //Funcionará pinchando en CUALQUIER botón de actualizar

                        //Capturamos el valor del ID del usuario con el atributo laid
                        var userId = $(this).attr("laid");
                        let name = $("#name" + userId).val(); //Val apunta al valor
                        let mail = $("#mail" + userId).val();
                        let nivel = $("#nivel" + userId).val();
                        let actividad = $("#activity" + userId).val();
                        let opt = 2;
                        //REalizamos la llamada al ajax
                        $.ajax({
                            type: "POST",
                            url: "./controladores/controlador_user.php",
                            data: {
                                ids: userId,
                                name: name,
                                mail: mail,
                                nivel: nivel,
                                actividad: actividad,
                                opt: opt
                            },
                            success: function (response) {
                                alert("Datos actualizados correctamente: " + response);
                                setTimeout("location.reload(true);", 1000);
                            }
                        });
                    });

                    $(".botonregistrar").click(function () { //Funcionará pinchando en CUALQUIER botón de actualizar

                        //Capturamos el valor del ID del usuario con el atributo laid

                        var userId = $(this).attr("laid");
                        var name = $("#newNombre").val(); //Val apunta al valor
                        var pass = $("#newPassword").val();
                        var user = $("#newUser").val();
                        var mail = $("#newMail").val();
                        var nivel = $("#newNivel").val();
                        let opt = 1;
                        //REalizamos la llamada al ajax
                        $.ajax({
                            type: "POST",
                            url: "./controladores/controlador_user.php",
                            data: {
                                user: user,
                                name: name,
                                pass: pass,
                                mail: mail,
                                nivel: nivel,
                                opt: opt
                            },
                            success: function (response) {
                                alert(response);
                                /*setTimeout("location.reload(true);", 1000); */
                                setTimeout(function () {
                                    location.reload(true);
                                }, 1000);
                            },
                            error: function (xhr, status, error) {
                                alert("Error en el envio de datos");
                            }
                        });
                    });
                });


            </script>

            </html>
<?php } ?>