<?php

require_once "../../config/app.php";
require_once "../views/inc/session_start.php";
require_once "../../autoload.php";

use app\controllers\despensaController;

if (isset($_POST['modulo_elemento'])) {

    $insElemento = new despensaController();

    if ($_POST['modulo_elemento'] == "registrar") {
        echo  $insElemento->registrarElementoControlador();
    }

    if ($_POST['modulo_elemento'] == "eliminar") {
        echo $insElemento->eliminarElementoControlador();
    }

    if($_POST['modulo_elemento']=="actualizar"){
        echo $insElemento->actualizarElementoControlador();
    }

} else {
    session_destroy();
    header("Location: " . APP_URL . "login/");
}
