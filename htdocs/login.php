<!DOCTYPE html>

<?php $a = "<h1>Drakecuoya</h1>"; ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">

</head>

<body>
    <fieldset id="login">
        <form action="index.php" method="post">


            <div id="logo">
                <img src="https://i.servimg.com/u/f96/19/40/77/82/logo_t13.png">
            </div>
            <div id="login1">
                User o e-mail: <input name="user" type="text"></input>
                <br><br>
                Pass: <input name="pass" type="password"></input>
            </div>
            <br>
            <div id="boton">
                <input type="submit" , id="botonlog" , value="LOG IN"></input> <!-- Boton de logeao -->
            </div>

            <br>
            <div id="desplegable">
                <label for="Idioma">Idiomas</label>

                <select name="idiomas" id="idiomas">
                    <option value="es">ES</option>
                    <option value="en">EN</option>
                    <!-- <option value="fr">FR</option> --> <!-- Idioma adicional que no lleva a nada, fue una prueba -->
                </select>
            </div>
        </form>
        <br>
        <div id="botonreg">
            <input type="submit" , id="botonreg" , value="REGÍSTRATE"></input> <!-- Botón para ir al registro -->
        </div>


    </fieldset>

    <fieldset id="registro" >
        <form action="./controladores/controlador_user.php" method="post">
            <h1>¿NO ESTÁS REGISTRADO? ¡ÚNETE!</h1>
            <div id="info">
                Usuario: <input name="user" type="text"></input>
                <br><br>
                E-mail: <input name="mail" type="text"></input>
                <br><br>
                Nombre del usuario: <input name="name" type="text"></input>
                <br><br>
                Contraseña: <input name="pass" type="password"></input>
            </div>
            <br>
            <div id="botonreg">
                <input type="submit" , id="regi" , value="REGISTRARSE"></input>
                <input name="opt" type="hidden", value="4"></input>

            </div>
        </form>
        <br>
        <input type="submit" , id="atras" , value="ATRÁS"></input>
        
    </fieldset>
</body>

<script>
    $(document).ready(function () {
        <?php
        if (isset($_GET["tipo"]) && $_GET["tipo"] == "reg") { //Esta función (de esta linea en adelante) es solo para cambiar el menú hacia el de registro y de vuelta al de logeo
            ?>
            $("#login").hide("slow");
            $("#registro").show("slow");
            <?php
        } else {
            ?>

            $("#registro").hide();

            <?php
        }
        ?>$("#atras").click(
            function () {

                $("#registro").hide("slow");
                $("#login").show("slow");
            }
        )

        $("#botonreg").click(
            function () {
                $("#login").hide();
                $("#registro").show("slow");
            }
        );

    });
</script>

</html>