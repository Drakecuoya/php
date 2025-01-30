<?php
session_start();

if ($_SESSION["log"] == false) {
    include("./security/sec.php");
}

if ((file_exists("./fotos/fotos_{$_SESSION["id"]}")) == false) {

    mkdir("./fotos/fotos_{$_SESSION["id"]}");

}

for ($i = 0; $i < count($_FILES['uploads']['name']); $i++) {
    $tmpFilePath = $_FILES['uploads']['tmp_name'][$i];
    $fileName = $_FILES['uploads']['name'][$i];
    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
    $contar = count(scandir("fotos/fotos_{$_SESSION["id"]}")) - 1;
    if ($tmpFilePath != "") {
        // Ruta donde quieres guardar la imagen
        $newFilePath = "fotos/fotos_{$_SESSION["id"]}/" . "USR_" . $_SESSION['id'] . "_for_" . $contar . "." . $extension;
        // Mover el archivo a la carpeta de destino
        if (move_uploaded_file($tmpFilePath, $newFilePath)) {
            ?>
            <script>
                alert("Archivo " + "<?php echo $_FILES['uploads']['name'][$i] ?>" + " subido exitosamente.");
                location.href = "index.php";
            </script>
            <?php
        } else {
            ?>
            <script>
                alert("Error al subir el archivo " + "<?php $_FILES['uploads']['name'][$i] ?>");
                location.href = "index.php";
            </script>
            <?php
        }
    }
}