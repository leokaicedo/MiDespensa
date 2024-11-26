<?php
// ...

?>
<div class="container is-fluid mb-6">
    <h1 class="title">Agregar Categoría y Elemento</h1>
</div>

<div class="container pb-6 pt-6">

    <?php
    include "./app/views/inc/btn_back.php";  // Incluir el botón de atrás
    ?>

    <hr>

    <!-- Formulario para Agregar Elemento -->

    <form class="FormularioAjax" action="<?php echo APP_URL; ?>app/ajax/despensaAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">

        <input type="hidden" name="modulo_elemento" value="registrar">

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Nombre del Elemento</label>
                    <input class="input" type="text" name="elemento_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{3,100}" maxlength="100" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Descripción</label>
                    <textarea class="textarea" name="elemento_descripcion" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{3,100}" maxlength="255"></textarea>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Cantidad</label>
                    <input class="input" type="number" name="elemento_cantidad" min="0">
                </div>
            </div>

<!-- Unidad del Elemento -->
            <div class="column">
                <div class="control">
                <label class="label">Unidad</label>
                <div class="select is-fullwidth">
                        <select name="elemento_unidad" required>
                            <option value="">Seleccione una unidad</option>
                            <option value="gramos">Gramos</option>
                            <option value="kilogramos">Kilogramos</option>
                            <option value="litros">Litros</option>
                            <option value="mililitros">Mililitros</option>
                            <option value="unidades">Unidades</option>
                            <option value="tazas">Tazas</option>
                            <option value="cucharadas">Cucharadas</option>
                            <option value="cucharaditas">Cucharaditas</option>
                            <option value="onzas">Onzas</option>
                            <option value="libras">Libras</option>
                            <option value="piezas">Piezas</option>
                            <option value="botellas">Botellas</option>
                        </select>
                    </div>
                </div>
            </div>
<!-- Categoría del Elemento -->
            <div class="column">
                <div class="control">
                <label class="label">Categoría</label>
                <div class="select is-fullwidth">
                        <select name="categoria_id" id="categoria" required>
                            <?php

                            use app\controllers\despensaController;

                            $insCategoria = new despensaController();

                            echo $insCategoria->listarCategoriasControlador();


                            if (!empty($categorias)) {
                                foreach ($categorias as $categoria) {
                                    echo '<option value="' . $categoria['categoria_id'] . '">' . $categoria['categoria_nombre'] . '</option>';
                                }
                            } else {
                                echo '<option value="">No hay categorías disponibles</option>';
                            }
                            ?>

                        </select>
                    </div>
                </div>
            </div>
            <!-- Foto del Elemento -->
            <div class="column">
                <div class="file has-name is-boxed">
                    <label class="file-label">
                        <input class="file-input" type="file" name="elemento_foto" accept=".jpg, .png, .jpeg">
                        <span class="file-cta">
                            <span class="file-label">
                                Seleccione una foto
                            </span>
                        </span>
                        <span class="file-name">JPG, JPEG, PNG. (MAX 5MB)</span>
                    </label>
                </div>
            </div>
        </div>
        <!-- Botones -->
        <p class="has-text-centered">
            <button type="reset" class="button is-link is-light is-rounded">Limpiar</button>
            <button type="submit" class="button is-info is-rounded">Guardar Elemento</button>
        </p>
    </form>
</div>