<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <title>Login</title>
</head>

<body>
    <fieldset style="width: 500px; margin: auto; margin-top: auto; background-color: #DAA6F7">

        <form action="regform.php" method="post">

            <div id="logo">
                <img src="https://i.servimg.com/u/f96/19/40/77/82/logo_t13.png">
            </div>
            <div id="info">
                Usuario: <input name="user" type="text"></input>
                <br><br>
                Nombre del usuario: <input name="name" type="text"></input>
                <br><br>
                Contraseña: <input name="pass" type="password"></input>
            </div>
            <br>
            <div id="botonreg">
                <input type="submit" , id="boton" , value="REGISTRARSE"></input>
            </div>

        </form>
    </fieldset>
</body>

</html>