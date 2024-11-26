<div class="main-container">

    <form class="box login" action="" method="POST" autocomplete="off" >
		<h5 class="title is-5 has-text-centered is-uppercase">LOGIN</h5>

		<div class="field">
			<label class="label">Usuario</label>
			<div class="control">
			    <input class="input" type="text" name="login_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required >
			</div>
		</div>

		<div class="field">
		  	<label class="label">Clave</label>
		  	<div class="control">
		    	<input class="input" type="password" name="login_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
		  	</div>
		</div>

		<p class="has-text-centered mb-4 mt-3">
			<button type="submit" class="button is-info is-rounded">Iniciar sesion</button>
		</p>
		<p class="has-text-centered">
            <a href="<?php echo APP_URL; ?>userNew/" class="button is-link is-rounded">Registrarse</a>
        </p>
		<p class="has-text-centered mt-3">
            <a href="<?php echo APP_URL; ?>recover_password/" class="label">¿Olvidó su contraseña?</a>
        </p>

	</form>
</div>

<?php
	if(isset($_POST['login_usuario']) && isset($_POST['login_clave'])){
		$insLogin->iniciarSesionControlador();
	}
?>