<?php

require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\searchController;

if (isset($_POST['modulo_buscador'])) {

    $insBuscador = new searchController();

    // Verificamos si se trata de una búsqueda o de eliminar el término de búsqueda
    if ($_POST['modulo_buscador'] == "buscar") {
        // Iniciar búsqueda
        echo $insBuscador->iniciarBuscadorControlador($_POST['modulo_url']);
    }

    if ($_POST['modulo_buscador'] == "eliminar") {
        // Eliminar término de búsqueda
        echo $insBuscador->eliminarBuscadorControlador($_POST['modulo_url']);
    }

} else {
    session_destroy();
    header("Location: " . APP_URL . "login/");
}
