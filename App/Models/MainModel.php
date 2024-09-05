<?php
    namespace App\Models;
    //Si ocupo namespace debo incluir de donde mando llamar otras clases
    //En el caso de PDO, basta con indicar la raiz del proyecto
    use \PDO;
    if(file_exists(__DIR__."/../../Config/server.php")){
        require_once __DIR__."/../../Config/server.php";
    }
    class MainModel{
        private $server = DB_SERVER;
        private $db = DB_NAME;
        private $user = DB_USER;
        private $pass = DB_PASS;
        //Acceso unico en esta clase y en sus cases heredadas
        protected function conectar(){
            $conexion = new PDO("mysql:host=".$this->server.";dbname=".$this->db, $this->user, $this->pass);
            //Indicamos que se usaran caracteres UTF-8
            $conexion->exec("SET CHARACTER SET utf8");
            return $conexion;
        }

        //Funcion que nos va permitir ejecutar consultas
        protected function ejecutarConsulta($consulta){
            $sql = $this->conectar()->prepare($consulta);
            $sql->execute();
            return $sql;
        }
        //Funcion para evitar inyeccion de SQL
        public function limpiarCadena($cadena){
            $palabras = ["<script>","</script>","<script src","<script type=","SELECT * FROM","SELECT "," SELECT ","DELETE FROM","INSERT INTO","DROP TABLE","DROP DATABASE","TRUNCATE TABLE","SHOW TABLES","SHOW DATABASES","<?php","?>","--","^","<",">","==","=",";","::"];
            //Quita espacios
            $cadena = trim($cadena);
            //Quita barras invertidas
            $cadena = stripslashes($cadena);
            foreach ($palabras as $palabra) {
                //No importa mayusc o minusc, si coincide, quita la palabra
                $cadena = str_ireplace($palabra,"",$cadena);
            }
            $cadena = trim($cadena);
            $cadena = stripslashes($cadena);
            return $cadena;
        }

        protected function verificarDatos($filtro,$cadena){
            //{}Permite generar una comparacion mediante una expresion regular
            if(preg_match("/^".$filtro."$/",$cadena)){
                return false;
            }else{
                return true;
            }
        }
        protected function guardarDatos($tabla,$datos){
            $query="INSERT INTO $tabla (";
            $contador = 0;
            foreach ($datos as $dato) {
                if(){}
                else{}
            }
        }
    }