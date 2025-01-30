
<?php

$vector = array( //Siempre hay que declarar los arrays

    0 => "pepe ",
    1 => ['0' => "papa", '1' => "mama"],
    2 => " pipo",
    3 => " popo",

);
/*
var_dump($vector);
echo "<br><br>";
echo $vector["padre"]['b'];
echo "<br><br>";
print_r($vector);
echo "<br><br>";
array_push($vector, "pupu");*/


//BUCLE FOR
/*
for ($i = 0; $i < count($vector); $i++) {
    print_r($vector[$i]);
    if (is_array($vector[$i])) {
        for ($j = 0; $j < count($vector[$i]); $j++) {
           echo " hola ". $vector[$i][$j]. " adios \$hola"; //Para poner $ y una palabra seguida hay que escribir el caracter de escape \
        }
        ;
    }
    ;
}*/


//BUCLE FOREACH
/*
foreach ($vector as $datos)

if (!is_array($datos)){
    echo $datos . " ";
} else 
    foreach($datos as $datos1){
        echo $datos1 . " ";
    }
*/


//BUCLE FOR ANTERIOR CONVERTIDO A WHILE
/*
$i = 0;
$j = 0;

while ($i < count($vector)) {

    if (is_array($vector[$i])) {

        while ($j < count($vector[$i])) {
            print_r($vector[$i][$j]);
            $j++;
        }
    } else {
        echo ($vector[$i]);
    }
    $i++;
}*/

//BUCLE EN DO-WHILE

$i = 0;
$j = 0;

do  {

    if (is_array($vector[$i])) {

        while ($j < count($vector[$i])) {
            print_r($vector[$i][$j]);
            $j++;
        }
    } else {
        echo ($vector[$i]);
    }
    $i++;
} while ($i < count($vector))

?>