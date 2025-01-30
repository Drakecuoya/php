<?php


class user
{
    function createuser($user, $mail, $pass, $name) //Opción 1 del switch
    {
        include("../security/connectbd.php"); //Entrando en controlador_user, esto peta en vez de redireccionar
        $con = $bd->prepare("SELECT * FROM usuarios WHERE (user = ? or mail=?)"); //Preparamos la query que queremos lanzar. Si en el where ponemos interrogaciones pillará el param
        $con->bind_param('ss', $user, $mail);
        $con->execute();
        $result = $con->get_result();


        if ($result->num_rows > 0) {
            return false;
        } else {

            $con = $bd->prepare("INSERT INTO usuarios(user, mail, password, nombreuser) VALUES (?, ?, ?, ?)"); //Preparamos la query que queremos lanzar. Si en el where ponemos interrogaciones pillará el param
            $con->bind_param('ssss', $user, $mail, $pass, $nombre); //Para añadir parámetros. Lo de SS es que significa String, String, es la inicial del tipo de dato. El $_POST viene desde un formulario externo
            $con->execute(); //Para ejecutar la consulta
            return true;
        }
    }


    function updateuser($name, $mail, $level, $activity, $id)
    { //Opción 2 del switch
        include("../security/connectbd.php");
        $con = $bd->prepare("UPDATE usuarios SET nombreuser=? , mail=? , nivel=? , actividad=? WHERE id=?"); //Preparamos la query que queremos lanzar. Si en el where ponemos interrogaciones pillará el param
        $con->bind_param('ssisi', $name, $mail, $level, $activity, $id); //Para añadir parámetros. Lo de SS es que significa String, String, es la inicial del tipo de dato. El $_POST viene desde un formulario externo
        $con->execute();

    }

    function eraseuser($id)
    { //Opción 3 del switch

        function recurseRmdir($dir)
        {
            if (!is_dir($dir)) {
                return false;
            }
            $files = array_diff(scandir($dir), array('.', '..'));
            foreach ($files as $file) {
                $path = "$dir/$file";
                if (is_dir($path) && !is_link($path)) {
                    recurseRmdir($path);
                } else {
                    unlink($path);
                }
            }
            return rmdir($dir);
        }

        $direction = "../fotos/fotos_$id";
        recurseRmdir($direction);

        include("../security/connectbd.php");
        //Sentencia DELETE
        /* $con = $bd->prepare("DELETE FROM usuarios WHERE id = ?"); 
        $con->bind_param('i', $id); 
        $con->execute();
        $con = $bd->prepare("DROP TABLE IF EXISTS fotos_" . $id . "");
        $con->execute(); */

        //Sentencia INACTIVIDAD. Hay que editar en tablaAdmin también.
        $con = $bd->prepare("UPDATE usuarios SET actividad = 'inactive' WHERE id= ?");
        $con->bind_param('i', $id); 
        $con->execute();
        //No sería realmente necesario romper las imagenes si puede recuperarla. Hacerlo en caso de aliviar carga en la base de datos
        /* $con = $bd->prepare("DROP TABLE IF EXISTS fotos_" . $id . "");
        $con->execute(); */
    }


    function autologin($user, $mail, $pass, $name) //Opción 4 del switch
    {
        include("../security/connectbd.php"); //Entrando en controlador_user, esto peta en vez de redireccionar

        $con = $bd->prepare("SELECT * FROM usuarios WHERE user = ?");
        $con->bind_param('s', $user);
        $con->execute();
        $result = $con->get_result();


        if ($result->num_rows > 0) {
            // Si el usuario ya existe, mostrar un mensaje de alerta y redirigir
            ?>
            <script>
                alert("El usuario ya existe. Por favor, elija otro nombre de usuario.");
                window.location.href = "../index.php";
            </script>
            <?php
        } else {
            $con = $bd->prepare("INSERT INTO usuarios(user, mail, password, nombreuser) VALUES (?, ?, ?, ?)"); //Preparamos la query que queremos lanzar. Si en el where ponemos interrogaciones pillará el param
            $con->bind_param('ssss', $user, $mail, $pass, $name); //Para añadir parámetros. Lo de SS es que significa String, String, es la inicial del tipo de dato. El $_POST viene desde un formulario externo
            $con->execute(); //Para ejecutar la consulta
            ?>
            <script>
                alert("Usuario creado con exito");
                window.location.href = "../index.php";
            </script>
            <?php

            $this->login($user, $mail, $pass);

        }
    }

    function login($user, $mail, $pass)
    {
        include "../security/connectbd.php";

        if (session_status() == PHP_SESSION_NONE) {
            session_start();

        }

        $con = $bd->prepare("SELECT * FROM usuarios where (user = ? or mail=?) and password = ?");
        $con->bind_param('sss', $user, $mail, $pass);
        $con->execute();

        $res = $con->get_result();
        $results = $res->fetch_assoc();

        if (!is_array($results)) {
            echo '<script>
                alert("Credenciales incorrectas. Por favor, intente de nuevo.");
                window.location.href = "../login.php";
            </script>';
            exit;
        }

        $_SESSION["id"] = $results['id'];
        $_SESSION["user"] = $results['user'];
        $_SESSION["name"] = $results['nombreuser'];
        $_SESSION["nivel"] = $results['nivel'];
        $_SESSION["log"] = true;

        $con = $bd->prepare("UPDATE usuarios SET estado = '1' WHERE id = ?");
        $con->bind_param('i', $_SESSION['id']);
        $con->execute();
        
    }

    function addfriend($id)
    {
        include "../security/connectbd.php";
        $con = $bd->prepare("UPDATE usuarios SET amigos = CONCAT(amigos,  ? , ',') WHERE id =" . $_SESSION['id']);
        $con->bind_param('i', $id);
        $con->execute();
        $con = $bd->prepare("UPDATE usuarios SET amigos = CONCAT(amigos,  ? , ',') WHERE id = ?");
        $con->bind_param('ii', $_SESSION['id'], $id);
        $con->execute();
    }

    function removefriend($id)
    {
        include "../security/connectbd.php";

        $con = $bd->prepare("SELECT amigos FROM usuarios WHERE id = " . $_SESSION['id']);
        $con->execute();
        $res = $con->get_result();
        $resultados = $res->fetch_assoc();
        $friends = explode(",", $resultados['amigos']);

        $array = array_search($id, $friends);
        unset($friends[$array]);
        $final = implode(",", $friends);

        $con = $bd->prepare("UPDATE usuarios SET amigos = ? WHERE id= " . $_SESSION['id']);
        $con->bind_param('s', $final);
        $con->execute();


        $con = $bd->prepare("SELECT amigos FROM usuarios WHERE id = " . $_SESSION['id']);
        $con->execute();
        $res = $con->get_result();
        $resultados = $res->fetch_assoc();
        $friends = explode(",", $resultados['amigos']);

        $array = array_search($id, $friends);
        unset($friends[$array]);
        $final = implode(",", $friends);

        $con = $bd->prepare("UPDATE usuarios SET amigos = ? WHERE id= ?");
        $con->bind_param('si', $final, $id);
        $con->execute();
    }
}
