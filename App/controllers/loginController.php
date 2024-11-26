<?php

namespace app\controllers;

use app\models\mainModel;

class loginController extends mainModel
{
	protected $db;
	protected $redirect_url;


	// Método público para obtener el valor de $redirect_url
	public function getRedirectUrl()
	{
		return $this->redirect_url;
	}

	/*----------  Controlador iniciar sesion  ----------*/

	/*public function iniciarSesionControlador()
	{
		$usuario = $this->limpiarCadena($_POST['login_usuario']);
		$clave = $this->limpiarCadena($_POST['login_clave']);

		$responseArray = []; // Inicializa el array de respuesta

		# Verificando campos obligatorios #
		if ($usuario == "" || $clave == "") {
			$responseArray = [
				'tipo' => 'error',
				'mensaje' => 'No has llenado todos los campos que son obligatorios'
			];
		} else {
			# Verificando integridad de los datos #
			if ($this->verificarDatos("[a-zA-Z0-9]{4,20}", $usuario)) {
				$responseArray = [
					'tipo' => 'error',
					'mensaje' => 'El USUARIO no coincide con el formato solicitado'
				];
			} else {
				# Verificando integridad de los datos #
				if ($this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $clave)) {
					$responseArray = [
						'tipo' => 'error',
						'mensaje' => 'La CLAVE no coincide con el formato solicitado'
					];
				} else {
					# Verificando usuario #
					$check_usuario = $this->ejecutarConsulta("SELECT * FROM usuario WHERE usuario_usuario='$usuario'");

					if ($check_usuario->rowCount() == 1) {
						$check_usuario = $check_usuario->fetch();

						if ($check_usuario['usuario_usuario'] == $usuario && password_verify($clave, $check_usuario['usuario_clave'])) {
							$_SESSION['id'] = $check_usuario['usuario_id'];
							$_SESSION['nombre'] = $check_usuario['usuario_nombre'];
							$_SESSION['apellido'] = $check_usuario['usuario_apellido'];
							$_SESSION['usuario'] = $check_usuario['usuario_usuario'];
							$_SESSION['foto'] = $check_usuario['usuario_foto'];

							$responseArray = [
								'tipo' => 'redireccionar',
								'url' => 'http://localhost/MiDespensa/dashboard/'
							];
						} else {
							$responseArray = [
								'tipo' => 'error',
								'mensaje' => 'Usuario o clave incorrectos'
							];
						}
					} else {
						$responseArray = [
							'tipo' => 'error',
							'mensaje' => 'Usuario o clave incorrectos'
						];
					}
				}
			}
		}

		// Devuelve la respuesta JSON
		echo json_encode($responseArray);
	}*/

	/*----------  Controlador iniciar sesion  ----------*/
	public function iniciarSesionControlador()
	{

		$usuario = $this->limpiarCadena($_POST['login_usuario']);
		$clave = $this->limpiarCadena($_POST['login_clave']);

		# Verificando campos obligatorios #
		if ($usuario == "" || $clave == "") {

			echo "<script>
			        Swal.fire({
					  icon: 'error',
					  title: 'Ocurrió un error inesperado',
					  text: 'No has llenado todos los campos que son obligatorios'
					});
				</script>";
		} else {

			# Verificando integridad de los datos #
			if ($this->verificarDatos("[a-zA-Z0-9]{4,20}", $usuario)) {

				echo "<script>
				        Swal.fire({
						  icon: 'error',
						  title: 'Ocurrió un error inesperado',
						  text: 'El USUARIO no coincide con el formato solicitado'
						});
					</script>";
			} else {

				# Verificando integridad de los datos #
				if ($this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}", $clave)) {

					echo "<script>
					        Swal.fire({
							  icon: 'error',
							  title: 'Ocurrió un error inesperado',
							  text: 'La CLAVE no coincide con el formato solicitado'
							});
						</script>";
				} else {

					# Verificando usuario #
					$check_usuario = $this->ejecutarConsulta("SELECT * FROM usuario WHERE usuario_usuario='$usuario'");

					if ($check_usuario->rowCount() == 1) {

						$check_usuario = $check_usuario->fetch();

						if ($check_usuario['usuario_usuario'] == $usuario && password_verify($clave, $check_usuario['usuario_clave'])) {

							$_SESSION['id'] = $check_usuario['usuario_id'];
							$_SESSION['nombre'] = $check_usuario['usuario_nombre'];
							$_SESSION['apellido'] = $check_usuario['usuario_apellido'];
							$_SESSION['usuario'] = $check_usuario['usuario_usuario'];
							$_SESSION['foto'] = $check_usuario['usuario_foto'];

							$this->redirect_url = "dashboard"; 



							if (headers_sent()) {
								echo "<script> window.location.href='" . APP_URL . "dashboard/'; </script>";
							} else {
								header("Location: " . APP_URL . "dashboard/");
							}
						} else {

							echo "<script>
							        Swal.fire({
									  icon: 'error',
									  title: 'Ocurrió un error inesperado',
									  text: 'Usuario o clave incorrectos'
									});
								</script>";
						}
					} else {

						echo "<script>
						        Swal.fire({
								  icon: 'error',
								  title: 'Ocurrió un error inesperado',
								  text: 'Usuario o clave incorrectos'
								});
							</script>";
					}
				}
			}
		}
	}


	/*----------  Controlador cerrar sesion  ----------*/
	public function cerrarSesionControlador()
	{

		session_destroy();

		if (headers_sent()) {
			echo "<script> window.location.href='" . APP_URL . "login/'; </script>";
		} else {
			header("Location: " . APP_URL . "login/");
		}
	}
}
