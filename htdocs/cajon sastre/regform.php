<?php
$user = $_POST["user"];
$pass = $_POST["pass"];
$name = $_POST["name"];
function registro($user, $pass, $name)
{
    $fp = fopen("./security/login.txt", 'r');
    while ($line = fgets($fp)) {
        $vec = explode("#", $line);
        if ($vec['1'] == $user) {
            if ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')) { //Distingue si vienes del ajax o de un form
                echo "El usuario ya existe"; //Aquí viene del ajax
                exit();
            } else {
                ?>
                <script>
                alert("El usuario ya existe") //Aquí viene del formulario
                location.href = "login.php?tipo=reg";//Envia un $_GET a login para que se active una función
                </script>
                <?php
                exit();
            }
        }
        $id = $vec['0'];
        $type = $vec['4'];
    }
    fclose($fp);

    $id++;
    $type = 1;

    $datos = $id . '#' . $user . '#' . $pass . '#' . $name . '#' . $type . '#' . PHP_EOL;
    $fp = fopen("./security/login.txt", 'a+');
    //Aquí ahora debe captar e introducir las cosas que mandamos por el registro
    fwrite($fp, $datos);
}

registro($user, $pass, $name);

header("location: index.php");