<?php

$bd = new mysqli("localhost", "root", "", "webphp"); //Conexión a la base de datos
mysqli_query($bd, "SET NAMES 'UTF8'"); //Esto para definir el tipo de caracteres que utilizarán