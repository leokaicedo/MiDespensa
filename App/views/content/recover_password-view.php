<body>
    <div class="main-container">
        <form class="box login" action="recover_password.php" method="POST" autocomplete="off">
            <h5 class="title is-5 has-text-centered is-uppercase">Recuperar Contraseña</h5>

            <div class="field">
                <label class="label">Correo Electrónico</label>
                <div class="control">
                    <input class="input" type="email" name="recover_email" required>
                </div>
            </div>

            <p class="has-text-centered mb-4 mt-3">
                <button type="submit" class="button is-info is-rounded">Enviar Enlace de Recuperación</button>
            </p>
        </form>
    </div>