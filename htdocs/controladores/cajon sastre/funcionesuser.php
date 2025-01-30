<?php

class user
{  //Para declarar clases se llama a la función class y se pone el nombre de la clase separada por un espacio, después se abren y cierran las llaves, dentro de ellas irían los atributos.

    function createuser($user, $pass, $name) //Opción 0 del switch
    {

        $fp = fopen("../security/login.txt", 'r');
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
                        location.href = "../login.php?tipo=reg";//Envia un $_GET a login para que se active una función
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
        $fp = fopen("../security/login.txt", 'a+');
        //Aquí ahora debe captar e introducir las cosas que mandamos por el registro
        fwrite($fp, $datos);
        header("location: ../index.php");
    }

    function updateuser($name, $level){ //Opción 1 del switch
        if ($_SESSION["nivel"] == 0){
        $fp = fopen("../security/login.txt", 'r+');
        while ($line = fgets($fp)) {
            $vec = explode("#", $line);
            if ($vec[0] == $_POST["id"]) {

                $name = $_POST["name"];
                $level = $_POST["nivel"];
                $datos = $vec[0] . '#' . $vec[1] . '#' . $vec[2] . '#' . $name . '#' . $level . '#' . PHP_EOL;


                $searchString = $line; // el fragmento de texto a borrar o actualizar (en nuestro caso el fgets o la cadena entera que hemos enviado por la red)

                $string = file_get_contents("../security/login.txt"); // volvamos sobre la variable el archivo completo

                $offset = strpos($string, $searchString); // pillamos la posicion de lo que vamos a borrar o actualizar


                $part1 = substr($string, 0, $offset); //pillamos la parte previa a donde empieza lo que queremos borrar (es decir hasta donde empieza)

                $part2 = substr($string, $offset + strlen($searchString)); //pillamos la parte posterior a lo que queremos borrar (osea desde donde acaba)


                file_put_contents("../security/login.txt", $part1 . $datos . $part2); //pegamos ambas partes en el archivo

            }
        }
        ;}
    }

    function eraseuser($id){ //Opción 2 del switch
        if ($_SESSION["nivel"] == 0){

        $fp = fopen("../security/login.txt", 'r+');
        while ($line = fgets($fp)) {
            $vec = explode("#", $line);
            if ($vec[0] == $id) {
                echo "Usuario borrado con éxito";

                $searchString = $line; // el fragmento de texto a borrar o actualizar (en nuestro caso el fgets o la cadena entera que hemos enviado por la red)

                $string = file_get_contents("../security/login.txt");// volvamos sobre la variable el archivo completo

                $offset = strpos($string, $searchString);// pillamos la posicion de lo que vamos a borrar o actualizar

                $part1 = substr($string, 0, $offset);//pillamos la parte previa a donde empieza lo que queremos borrar( es decir hasta donde empieza)

                $part2 = substr($string, $offset + strlen($searchString));//pillamos la parte posterior a lo que queremos borrar( osea desde donde acaba)

                file_put_contents("../security/login.txt", $part1 . $part2); //pegamos ambas partes en el archivo
            }
        }
        ;
    }
}
}
