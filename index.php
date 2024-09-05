<?php
//https://www.youtube.com/watch?v=EQmcvuGiayM&list=PLH_tVOsiVGzmnl7ImSmhIw5qb9Sy5KJRE&index=143
    // {./} USado para indicar que estan en el mismo nivel 
    require_once "./config/app.php";
    require_once "./autoload.php";
    require_once "./app/views/inc/session_start.php";
    //Obtenemos el nombre de la vista en un array
    if(isset($_GET["views"])){
        $url = explode("/",$_GET["views"]);
    }
    else{
        $url=["login"]; 
    }
?>    
<!DOCTYPE html>
<html lang="es">
<head>
    <?php 
        require_once "./App/Views/Inc/head.php"
    ?>
</head>
<body>
    
<?php 
    use App\Controllers\viewsController;
    $viewsController = new viewsController();
    $vista = $viewsController->obtenerVistasControlador($url[0]);
    if($vista=="login" || $vista == "404"){
        require_once "./App/Views/Content/".$vista."-view.php";
    }else{
        require_once "./App/Views/Inc/navbar.php";
        require_once $vista;
    }
    require_once "./App/Views/Inc/script.php";

?>
</body>
</html>
<?php
/** Crud
 * Create
 * Read
 * Update
 * Delete
*/
/**MVC
 * Es un patron de arquitectura de software que separa en 3 partes distintas los componentes una aplicacion.
 * {Modelo} Es la parte que se encarga de interactuar directamente con la base de datos.
 * {Vista} Es la parte donde se encuentra ña interfaz grafica de la aplicacion con la cual el usuario interactua.
 * {Controlador} Es la que parte que interactua como intermediario entre el modelo y la vista. {vista->modelo; modelo->controlador y de regreso}
 */
/** .HTACCESS {HyperText Access}
 * Es un archivo de configuración del servidor Apache, que contiene las directivas que definen el comportamiento Apache.
 * Indica en todo momento qué puede hacer y qué no el usuario que visita tu web, así como configurar el comportamiento del servidor ante errores de conexión.
 * Puedes reescribir la URL, proteger directorios con contraseñas, habilitar la protección de enlaces directos, no permitir el acceso a direcciones IP especificas, cambiar la zona horaria de tu sitio web o alterar la página de índice predeterminada.
 */
?>