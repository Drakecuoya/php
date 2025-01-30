<?php
$user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$language = filter_input(INPUT_POST, 'idiomas', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


if (login($user, $pass, $language)) {
    $_SESSION["log"] = true;
    $_SESSION["estado"] = 1;
    
    include "connectbd.php";
    $con = $bd->prepare("UPDATE usuarios SET estado = ? WHERE id = ?");
    $con->bind_param('ii', $_SESSION['estado'], $_SESSION['id']);
    $con->execute();

}  else if($results['actividad'] == "inactive"){
    ?><script>alert("Su usuario se encuentra inactivo. Contacte con administración");
    header(".location: ../login.php");
    <?php
} else {
    $_SESSION["log"] = false;
    echo "Login false";
    header("location: ../login.php");
    exit;
}

//Función para control de login. Usaremos un while hasta llegar al end of file
function login($user, $pass, $language)
{
    //Esto hay que cambiarlo por una consulta SQL
    include "connectbd.php";

    $con = $bd->prepare("SELECT * FROM usuarios where (user = ? or mail = ?) and password = ?");
    $con->bind_param('sss', $user, $user, $pass); 
    $con->execute();

    $res = $con->get_result(); //Pilla los datos como SQL
    $results = $res->fetch_assoc(); //Convierte los datos de SQL a un array

    if (!is_array($results)) {
        return false;
    }
    
  

    $_SESSION["id"] = $results['id'];
    $_SESSION["user"] = $results['user'];
    $_SESSION["mail"] = $results['mail'];
    $_SESSION["name"] = $results['nombreuser'];
    $_SESSION["nivel"] = $results['nivel'];
    $_SESSION["idiomas"] = $language;
    $_SESSION["time"] = time();

    return true;

    //LO SIGUIENTE ES ANTIGUO
    /* $fp = fopen("./security/login.txt", 'r');
    while ($line = fgets($fp)) {   //$line llama a un bucle de linea a linea donde pille la función $fp para comprobar
        $vec = explode("#", $line); //Considera y separa los delimitadores '#' de la información del txt (para más info en documentación de explode)
        if ($user == $vec['1'] && $pass == $vec['2']) { //Esto comprueba los apartados 1 y 2 (usuario y contraseña) del txt, si está bien da un true y si está mal un false
            $_SESSION["id"] = $vec['0'];
            $_SESSION["name"] = $vec['3'];
            $_SESSION["nivel"] = $vec['4'];
            $_SESSION["idiomas"] = $_POST["idiomas"];
            return true;
        }
    }
    fclose($fp); */
}
?>