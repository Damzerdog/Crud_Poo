<?php

    namespace App\Controllers;
    //Para cada controlador pertenece un modelo
    use App\Models\ViewsModel;
    class viewsController extends ViewsModel{
        //Permitir acceder desde fuera de la clase 
        public function obtenerVistasControlador($vista){
            if($vista!=""){
                //Al heredad de views model, podemos usar los metodos definidos en la clase padre
                $respuesta = $this->obtenerVistasModelo($vista);
            }else{
                $respuesta = "login";
            }
            return $respuesta;
        }
    }



