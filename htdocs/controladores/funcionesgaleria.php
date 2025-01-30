<?php
class gallery
{
    function uploads($files)
    {
        if ((file_exists("../fotos/fotos_{$_SESSION["id"]}")) == false) {

            mkdir("../fotos/fotos_{$_SESSION["id"]}");

        }

        for ($i = 0; $i < count($files['uploads']['name']); $i++) {
            $tmpFilePath = $files['uploads']['tmp_name'][$i];
            $fileName = $files['uploads']['name'][$i];
            $extension = pathinfo($fileName, PATHINFO_EXTENSION);
            /* $contar = count(scandir("../fotos/fotos_{$_SESSION["id"]}")) - 2; */   //Con el -1 nos está haciendo que empiece en el archivo numero 1
            include "../security/connectbd.php"; //Se incluye la conexión a la base de datos
            $tabla = "fotos_" . $_SESSION["id"];
            $filt = $bd->prepare("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'webphp' AND TABLE_NAME = '$tabla';");
            $filt->execute();
            $res = $filt->get_result();
            $fila = $res->fetch_assoc();
            $contar = $fila["AUTO_INCREMENT"];

            if ($tmpFilePath != "") {
                // Ruta donde quieres guardar la imagen
                $newFilePath = "../fotos/fotos_{$_SESSION["id"]}/" . "USR_" . $_SESSION['id'] . "_for_" . $contar . "." . $extension;
                $photo = "USR_" . $_SESSION['id'] . "_for_" . $contar . "." . $extension;
                // Mover el archivo a la carpeta de destino
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    include "../security/connectbd.php";

                    $con = $bd->prepare("CREATE TABLE IF NOT EXISTS FOTOS_" . $_SESSION['id'] . "(
                        id_foto int primary key not null auto_increment,
                        nombre_foto varchar (255) not null,
                        nombre_disco varchar (255) not null,
                        descripcion varchar (255),
                        fav int(1),
                        trash int(1)
                        )");
                    $con->execute();

                    $desc = " ";
                    $con = $bd->prepare("INSERT INTO FOTOS_" . $_SESSION['id'] . " (nombre_foto, nombre_disco, descripcion) VALUES (?, ?, ?)");
                    $con->bind_param('sss', $fileName, $photo, $desc);
                    $con->execute();
                    $con->close();
                    ?>
                    <script>
                        alert("Archivo " + "<?php echo $files['uploads']['name'][$i] ?>" + " subido exitosamente.");
                        window.location.href = "../index.php"
                    </script><?php
                
            }
        } else {
            ?>
            <script>
                alert("No puede enviarse sin archivos");
                window.location.href = "../index.php";
            </script>
            <?php
        }
    }
}

    function erasePhoto($id)
    {
        include "../security/connectbd.php";

        $con = $bd->prepare("SELECT nombre_disco FROM FOTOS_" . $_SESSION['id'] . " WHERE id_foto = ?");
        $con->bind_param('i', $id);
        $con->execute();
        $res = $con->get_result();
        $fila = $res->fetch_assoc();
        unlink("../fotos/fotos_" . $_SESSION["id"] . "/{$fila['nombre_disco']}");

        $con = $bd->prepare("DELETE FROM FOTOS_" . $_SESSION['id'] . " WHERE id_foto = ?");
        $con->bind_param('i', $id);
        $con->execute();
    }

    function updatePhoto($names, $id, $descripcion)
    {
        include "../security/connectbd.php";
        $con = $bd->prepare("UPDATE FOTOS_" . $_SESSION['id'] . " SET nombre_foto = ? WHERE id_foto = ?");
        $con->bind_param('si', $names, $id);
        $con->execute();
        $con = $bd->prepare("UPDATE FOTOS_" . $_SESSION['id'] . " SET descripcion = ? WHERE id_foto = ?");
        $con->bind_param('si', $descripcion, $id);
        $con->execute();
    }

    function favPhoto($fav, $id){
        include "../security/connectbd.php";
        $con = $bd->prepare("UPDATE FOTOS_" . $_SESSION['id'] . " SET fav = ? WHERE id_foto = ? ");
        $con->bind_param('ii', $fav, $id); 
        $con->execute();
    } 

    function trashCan($trash, $id){
        include "../security/connectbd.php";
        $con = $bd->prepare("UPDATE FOTOS_" . $_SESSION['id'] . " SET trash = ? WHERE id_foto = ? ");
        $con->bind_param('ii', $trash, $id); 
        $con->execute();
    }
    }