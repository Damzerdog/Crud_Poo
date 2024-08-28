<?php
    //Obtener el nombre de la clase que se esta utilizando
    spl_autoload_register(function($clase){
        //{__DIR__} Obtiene la ubicacion del archivo que se esta ejecutando
        $archivo = __DIR__."/".$clase.".php";
        $archivo = str_replace("\\","/",$archivo);
        if(is_file($archivo)){
            require_once $archivo;
        }
    });