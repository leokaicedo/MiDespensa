<nav class="navbar">
    <div class="navbar-brand">
        <a class="navbar-item" href="<?php echo APP_URL; ?>dashboard/">
            <img src="<?php echo APP_URL; ?>app/views/img/logo.png" alt="Bulma" width="112" height="28">
        </a>
        <div class="navbar-burger" data-target="navbarExampleTransparentExample">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div id="navbarExampleTransparentExample" class="navbar-menu">

        <div class="navbar-start">
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link" href="#">
                    Mi Despensa
                </a>
                <div class="navbar-dropdown is-boxed">

                
                    <a class="navbar-item" href="<?php echo APP_URL; ?>despensa/">
                        Agregar Productos
                    </a>
                    <a class="navbar-item" href="#">
                       Informacion Nutricional
                    </a>


                    <a class="navbar-item" href="<?php echo APP_URL; ?>elementList/">
                        Lista
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL; ?>elementSearch/">
                        Buscar
                    </a>

                </div>
            </div>
        </div>

        <div class="navbar-end">
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    ** <?php echo $_SESSION['usuario']; ?> **
                </a>
                <div class="navbar-dropdown is-boxed">

                    <a class="navbar-item" href="<?php echo APP_URL."userUpdate/".$_SESSION['id']."/"; ?>">
                        Mi cuenta
                    </a>
                    <a class="navbar-item" href="<?php echo APP_URL."userPhoto/".$_SESSION['id']."/"; ?>">
                        Mi foto
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item" href="<?php echo APP_URL."logOut/"; ?>" id="btn_exit" >
                        Salir
                    </a>

                </div>
            </div>
        </div>

    </div>
</nav>

