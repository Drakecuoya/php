<?php
$uss =filter_input(INPUT_POST , 'user', FILTER_SANITIZE_FULL_SPECIAL_CHARS); //En vez de String hay que poner FULL_SPECIAL_CHARS para que no te lance un deprecated

$bd = new mysqli("localhost", "root", "", "webphp"); //Conexión a la base de datos
mysqli_query($bd,"SET NAMES 'UTF8'"); //Esto para definir el tipo de caracteres que utilizarán
//$base = mysqli_select_db($bd,"webphp");
//Esta query es susceptible a inyeccion
//$res = $bd -> query("select * from usuarios;");


//La parte superior se crearía en un archivo único, y se usaría un include donde necesitásemos hacer consultas. Las consultas (parte inferior) se hacen donde sean necesarias.


//Usando prepare, bind_Param, execute y get_result haremos que sea más segura la consulta.
$con = $bd -> prepare("SELECT * from usuarios where user = ?"); //Preparamos la query que queremos lanzar. Si en el where ponemos interrogaciones pillará el param
$con->bind_param('s',$uss); //Para añadir parámetros. Lo de SS es que significa String, String, es la inicial del tipo de dato. El $_POST viene desde un formulario externo
$con -> execute(); //Para ejecutar la consulta
$res = $con -> get_result(); //Para volcar el resultado de la consulta en una variable

for($i = 0; $i < $res->num_rows; $i++){
    $fila = $res -> fetch_assoc(); //files_assoc convierte el resultado sql en un array de datos y te lo almacena en $files
    echo $fila["id"] . " " . $fila["user"] . " ";
}

//Sanitizar variables 
/* Cuando recibimos $_POST["id"] puede estar pervertido. Lo que podemos hacer es un $id=filter_saniticer_int($_POST).
Siempre por seguridad hay que hacerlo cuando recibamos datos de un formulario, ajas o cualquier cosa que el usuario pueda pervertir. 
*/