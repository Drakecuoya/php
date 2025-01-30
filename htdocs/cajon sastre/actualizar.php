<?php

$fp = fopen("./security/login.txt", 'r+');
while ($line = fgets($fp)) {
    $vec = explode("#", $line);
    if ($vec[0] == $_POST["id"]) {

        $name = $_POST["nombre"];
        $level = $_POST["nivel"];
        $datos = $vec[0] . '#' . $vec[1] . '#' . $vec[2] . '#' . $name . '#' . $level . '#' . PHP_EOL;


        $searchString = $line; // el fragmento de texto a borrar o actualizar (en nuestro caso el fgets o la cadena entera que hemos enviado por la red)

        $string = file_get_contents("./security/login.txt"); // volvamos sobre la variable el archivo completo

        $offset = strpos($string, $searchString); // pillamos la posicion de lo que vamos a borrar o actualizar


        $part1 = substr($string, 0, $offset); //pillamos la parte previa a donde empieza lo que queremos borrar (es decir hasta donde empieza)

        $part2 = substr($string, $offset + strlen($searchString)); //pillamos la parte posterior a lo que queremos borrar (osea desde donde acaba)


        file_put_contents("./security/login.txt", $part1 . $datos . $part2); //pegamos ambas partes en el archivo

    }
}
;