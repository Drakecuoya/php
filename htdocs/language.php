<?php
try {

    if (empty($_SESSION['idiomas'])){
          
        throw new Exception("No se ha detectado idioma, por defecto ES", 1);
 
    }
    if (($idioma = simplexml_load_file("locals/".$_SESSION['idiomas'].".xml")) == null){
        throw new Exception("No exite el idioma seleccionado, por defecto ES", 1);    
    }
    if ((!file_exists("locals/".$_SESSION['idiomas'].".xml"))){   
        throw new Exception("No exite el idioma seleccionado, por defecto ES", 1);      
    }
} catch (Exception $e) { 
    $idioma = simplexml_load_file("locals/es.xml");
}
