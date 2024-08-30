<?php
    namespace App\Models;

    //Modelo para controlas las vistas
    class viewsModel{
        //Solo se usara en la clase y en sus clases heredadas
        protected function obtenerVistasModelo($vista){
            //Limitamos una lista de urls validas para el sistema
            $listaBlanca = ["dashboard"];
            
            if(in_array($vista,$listaBlanca)){
                
                if(is_file('./App/Views/Content/'.$vista.'-view.php')){
                    $contenido = './App/Views/Content/'.$vista.'-view.php';
                }else{
                    $contenido = "404";
                }
            }elseif($vista=="login" || $vista == "index"){
                $contenido = "login";
            }else{
                $contenido = "404";
            }
            return$contenido;
        }
    }