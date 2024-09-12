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
        //Funcion para verificar la sintaxis de los datos
        protected function verificarDatos($filtro,$cadena){
            //{}Permite generar una comparacion mediante una expresion regular
            if(preg_match("/^".$filtro."$/",$cadena)){
                return false;
            }else{
                return true;
            }
        }
        //Funcion para realizar el guardado de datos
        protected function guardarDatos($tabla,$datos){
            $query="INSERT INTO $tabla (";
            $contador = 0;
            foreach ($datos as $dato) {
                if($contador>=1){
                    $query .=",";
                }
                $query .=$dato["campo_nombre"];
                $contador++;
            }
            $query.= ") VALUES (";
            $contador = 0;
            foreach ($datos as $dato) {
                if($contador>=1){
                    $query .=",";
                }
                $query .=$dato["campo_marcador"];
                $contador++;
            }
            $query.=")";
            $sql=$this->conectar()->prepare($query);
            //{binParam}Vincula una variable de PHP a un parámetro de sustitución con nombre o de signo de interrogación correspondiente de la sentencia SQL que fue usada para preparar la sentencia
            foreach ($datos as $dato) {
                $sql->bindParam($dato["campo_marcador"],$dato["campo_valor"]);
            }
            $sql->execute();
            return $sql;
        }
        //Funcion para seleccionar registros
        public function seleccionarDatos($tipo,$tabla,$campo,$id){
            $tipo=$this->limpiarCadena($tipo);
            $tabla=$this->limpiarCadena($tabla);
            $campo=$this->limpiarCadena($campo);
            $id=$this->limpiarCadena($id);

            if($tipo == "Unico"){
                $sql=$this->conectar()->prepare("SELECT * FROM $tabla WHERE $campo = :ID");
                $sql->bindParam(":ID",$id);
            }
            elseif($tipo == "Normal"){
                $sql=$this->conectar()->prepare("SELECT $campo FROM $tabla");
            }
            $sql->execute();
            return $sql;
        }
        //Funcion para actualizar registros
        protected function actualizarDatos($tabla,$datos,$condicion){
            $query="UPDATE  $tabla SET ";
            $contador = 0;
            foreach ($datos as $dato) {
                if($contador>=1){
                    $query .=",";
                }
                $query .=$dato["campo_marcador"]."=".$dato["campo_marcador"];
                $contador++;
            }
            $query.=" WHERE ".$condicion["condicion_campo"]." = ".$condicion["condicion_marcador"];
            $sql=$this->conectar()->prepare($query);
            foreach ($datos as $dato) {
                $sql->bindParam($dato["campo_marcador"],$dato["campo_valor"]);
            }
            $sql->bindParam($dato["campo_marcador"],$dato["campo_valor"]);
            $sql->execute();
            return $sql;

        }
        //Funcion para eliminar registros
        protected function eliminarRegistro($tabla,$campo,$id){
            
            $sql =$this->conectar()->prepare("DELETE FROM $tabla Where $campo = :id");
            //Binds a parameter 
            $sql->bindParam(":id",$id);
            $sql->execute();
            return $sql;            
        }

        protected function paginadorTablas($pagina,$numeroPaginas,$url,$botones){
            $tabla = '<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">';
            if($pagina<=1){

            }else{

            }
            

	<a class="pagination-previous is-disabled" disabled >Anterior</a>
	<a class="pagination-previous" href="#">Anterior</a>

	<ul class="pagination-list">
		
		<li><a class="pagination-link" href="#">1</a></li>

		<li><span class="pagination-ellipsis">&hellip;</span></li>

		<li><a class="pagination-link is-current" href="#">2</a></li>

	</ul>

	<a class="pagination-next" href="#">Siguiente</a>
	<a class="pagination-next is-disabled" disabled >Siguiente</a>

</nav>

        }

    }