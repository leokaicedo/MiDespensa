<?php
	
	namespace app\models;

	class viewsModel {
	
		/*---------- Modelo obtener vista ----------*/
		protected function obtenerVistasModelo($vista) {
	
			// Define the whitelist
			$listaBlanca = ["dashboard", "userNew", "userList", "userSearch", "userUpdate", "userPhoto", "logOut", "recover_password", "despensa", "elementList", "elementSearch", "elementUpdate"];
	
			// Check if view is in the whitelist
			if (in_array($vista, $listaBlanca)) {
				$contenido = $vista;  // Just the view name without file extension
			} elseif ($vista == "login" || $vista == "index") {
				$contenido = $vista;
			} else {
				$contenido = "404";
			}
	
			return $contenido;
		}
	}
	