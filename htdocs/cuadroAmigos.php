<?php
session_start();
$_SESSION["id"];

if ($_SESSION["log"] == false) {
    include("./security/sec.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div id="listamigos">
        <table class="friendslist">
            <?php
            include "security/connectbd.php";

            $con = $bd->prepare("SELECT amigos from usuarios where id=" . $_SESSION['id']);
            $con->execute();
            $res = $con->get_result();
            $results = $res->fetch_assoc();
            $amigos = explode(",", $results["amigos"]);
            ?>
            <?php
            for ($i = 0; $i < count($amigos); $i++) {
                if ($amigos[$i] != "") {
                    $con = $bd->prepare("SELECT nombreuser, id, estado from usuarios where id =" . $amigos[$i]);
                    $con->execute();
                    $res = $con->get_result();
                    $results = $res->fetch_assoc();
                    ?>
                    <tr>
                        <td><?php if ($results['estado'] == 1) { ?>
                                <img src="./iconos/on.png" alt="conectado" /><?php
                        } else {
                            ?><img src="./iconos/off.png" alt="conectado" /><?php
                        } ?>
                        </td>
                        <td><?php echo $results['nombreuser'] ?></td>
                        <td><img src="./iconos/remove-friend.png" class="erasefriend" laidName="<?php echo $results['id'] ?>">
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
        <div id="imgadd"><img src="./iconos/add-friend.png" alt="addfriend" id="addfriend"></div>
    </div>

    <div id="sugerenciasamigos">
        <table class="friendssuggestions">
            <?php
            for ($i = 0; $i < count($amigos); $i++) {
                if ($amigos[$i] != $_SESSION['id']) {
                    $con = $bd->prepare("SELECT id, nombreuser from usuarios where  id != " . $_SESSION['id']);
                    $con->execute();
                    $res = $con->get_result();

                    for ($i = 0; $i < $res->num_rows; $i++) {
                        $results = $res->fetch_assoc();
                        if (!in_array($results['id'], $amigos)) {
                            ?>
                            <tr>
                                <td><?php echo $results['nombreuser'] ?></td>
                                <td><img src="./iconos/add.png" class="add" alt="addfriends" laid="<?php echo $results['id'] ?>">
                                </td>
                            </tr>
                            <?php
                        }
                    }
                }
            }
            ?>
        </table>
        <div id="imgremove"><img src="./iconos/return.png" id="returnfriends" alt="return"></div>
    </div>
    </div>
    </div>

</body>
<script>
    $(document).ready(function () {

        $("#addfriend").click( 
            function () {
                $("#listamigos").hide("slow");
                $("#sugerenciasamigos").toggle("slow")
            });
        $("#returnfriends").click( 
            function () {
                $("#sugerenciasamigos").hide("slow");
                $("#listamigos").toggle("slow")
            })

        let ids = [];

        $("#sugerenciasamigos").hide();

        $(".add").click( 
            function () {
                asd = $(this).attr("laid");
                opt = 5;
                $.ajax({
                    type: "post",
                    url: "controladores/controlador_user.php",
                    data: {
                        ids: asd,
                        opt: opt
                    },
                    success: function (data) {
                        alert("Amigo agregado");
                        setTimeout("location.reload(true)", 1000);
                    }
                })
            });
        $(".erasefriend").click(
            function () {
                asd = $(this).attr("laidName");
                opt = 6;
                $.ajax({
                    type: "post",
                    url: "controladores/controlador_user.php",
                    data: {
                        ids: asd,
                        opt: opt
                    },
                    success: function (data) {
                        alert("Amigo eliminado");
                        setTimeout("location.reload(true)", 1000);
                    }
                })
            });
    });
</script>

</html>