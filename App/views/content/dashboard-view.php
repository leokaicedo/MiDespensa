<div class="container is-fluid">
  <h1 class="title">Bienvenido a tu Despensa</h1>
  <div class="columns is-flex is-justify-content-center">
    <figure class="image is-128x128">
      <?php
      if (is_file("./app/views/fotos/" . $_SESSION['foto'])) {
        echo '<img class="is-rounded" src="' . APP_URL . 'app/views/fotos/' . $_SESSION['foto'] . '">';
      } else {
        echo '<img class="is-rounded" src="' . APP_URL . 'app/views/fotos/default.png">';
      }
      ?>
    </figure>
  </div>
  <div class="columns is-flex is-justify-content-center">
    <h2 class="subtitle">¡Bienvenido <?php echo $_SESSION['nombre'] . " " . $_SESSION['apellido']; ?>!</h2>
  </div>
  <section class="section">
  <p class="level-item has-text-centered">
        <img src="<?php echo APP_URL; ?>app/views/img/logo2.png" alt="Bulma" width="112" height="28">
      </p>
    <h3 class="is-size-6">
      A un solo paso genera tu despensa, escoga los elementos que mercaste y programa tu aliminetacion sin desperdicirar alimentos <strong>Inicia ahora</strong>.
    </h3>
   
  </section>
</div>