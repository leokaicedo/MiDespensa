<div class="container is-fluid mb-6">
    <?php
    // Obtener el ID del elemento a actualizar de la URL
    $id = $insLogin->limpiarCadena($url[1]);
    ?>
    <h1 class="title">Elementos de la Despensa</h1>
    <h2 class="subtitle">Actualizar Elemento</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
    // Botón para regresar
    include "./app/views/inc/btn_back.php";

    // Seleccionar los datos del elemento a través del ID
    $datos = $insLogin->seleccionarDatos("Unico", "elemento", "elemento_id", $id);

    // Verificar si el elemento existe
    if ($datos && $datos->rowCount() == 1) {
        $datos = $datos->fetch();
    ?>

        <h2 class="title has-text-centered"><?php echo htmlspecialchars($datos['elemento_nombre']); ?></h2>

        <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/despensaAjax.php" method="POST" autocomplete="off">

            <input type="hidden" name="modulo_elemento" value="actualizar">
            <input type="hidden" name="elemento_id" value="<?php echo htmlspecialchars($datos['elemento_id']); ?>">

            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label for="elemento_nombre">Nombre del elemento</label>
                        <input class="input" type="text" id="elemento_nombre" name="elemento_nombre" maxlength="100" value="<?php echo htmlspecialchars($datos['elemento_nombre']); ?>" required>
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label for="elemento_descripcion">Descripción</label>
                        <textarea class="textarea" id="elemento_descripcion" name="elemento_descripcion" maxlength="500"><?php echo htmlspecialchars($datos['elemento_descripcion']); ?></textarea>
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label for="elemento_cantidad">Cantidad</label>
                        <input class="input" type="number" id="elemento_cantidad" name="elemento_cantidad" value="<?php echo htmlspecialchars($datos['elemento_cantidad']); ?>" min="1" required>
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label for="elemento_unidad">Unidad</label>
                        <input class="input" type="text" id="elemento_unidad" name="elemento_unidad" maxlength="20" value="<?php echo htmlspecialchars($datos['elemento_unidad']); ?>" required>
                    </div>
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label for="elemento_categoria">Categoría</label>
                    <select class="input" id="elemento_categoria" name="elemento_categoria" required>
                        <?php
                        // Obtener todas las categorías
                        $categorias = $insLogin->seleccionarDatos("Todos", "categoria", null, null);

                        if ($categorias && $categorias->rowCount() > 0) {
                            while ($categoria = $categorias->fetch()) {
                                // Determinar si la categoría actual es la que corresponde al elemento
                                $selected = ($categoria['categoria_id'] == $datos['categoria_id']) ? "selected" : "";
                                echo "<option value='" . htmlspecialchars($categoria['categoria_id']) . "' $selected>" . htmlspecialchars($categoria['categoria_nombre']) . "</option>";
                            }
                        } else {
                            echo "<option value='' disabled>No hay categorías disponibles</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <br><br>
           
            <p class="has-text-centered">
                <button type="submit" class="button is-success is-rounded">Actualizar</button>
            </p>

        </form>

    <?php
    } else {
        // Mostrar mensaje de error si el elemento no se encuentra
        include "./app/views/inc/error_alert.php";
    }
    ?>
</div>
