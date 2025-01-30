<?php
/* if ($_POST["opcion"]==1)
     echo"hola";
 elseif ($_POST["opcion"] == 2)
     echo"que tal";
 elseif ($_POST["opcion"] == 0)
     echo"adios";
*/

switch ($_POST["opcion"]) {
    case 0:
        echo "hola";
        break;

    case 1:
        echo "que tal";
        break;

    case 2:
        echo "adios";
        break;
}

?>