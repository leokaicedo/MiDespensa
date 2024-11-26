<?php

require_once "./config/app.php";
require_once "./autoload.php";

/*---------- Iniciando sesión ----------*/
require_once "./app/views/inc/session_start.php";

if (isset($_GET['views'])) {
    $url = explode("/", $_GET['views']);
} else {
    $url = ["login"];
}

// Aquí se establece el valor por defecto si $url[0] está vacío
if (empty($url[0])) {
    $url[0] = "login"; // Por defecto a 'login' si no se especifica una vista
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once "./app/views/inc/head.php"; ?>
</head>
<body>
<?php


if ($url[0] !== "login" && $url[0] !== "userNew") {
    // Incluir la barra de navegación solo si no estás en login
    require_once "./app/views/inc/navbar.php"; 
}

        use app\controllers\viewsController;
        use app\controllers\loginController;
        use app\controllers\userController;

        $insLogin = new loginController();
        $insuserNew = new userController();

        $viewsController = new viewsController();
        $vista = $viewsController->obtenerVistasControlador($url[0]);

        // Construir la ruta correcta al archivo de vista
        $path = "./app/views/content/{$vista}-view.php";

        // Verificar si el archivo de vista existe
        if (file_exists($path)) {
            require_once $path;
        } else {
            
             // Si la vista no existe, cargar la vista 404
            require_once "./app/views/content/404-view.php";
        }
        require_once "./app/views/inc/script.php"; 
    ?>

</body>
<footer>
<?php require_once "./app/views/inc/footer.php"; ?>
</footer>
</html>