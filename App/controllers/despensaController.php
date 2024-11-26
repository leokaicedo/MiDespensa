 /*----------  Controlador registrar elemento  ----------*/
    public function registrarElementoControlador()
    {
        # Almacenando datos#
        $nombre = $this->limpiarCadena($_POST['elemento_nombre']);
        $descripcion = $this->limpiarCadena($_POST['elemento_descripcion']);
        $cantidad = $this->limpiarCadena($_POST['elemento_cantidad']);
        $unidad = $this->limpiarCadena($_POST['elemento_unidad']);
        $categoria = $this->limpiarCadena($_POST['categoria_id']);

        # Obtener el ID del usuario de la sesión
        $usuario_id = $_SESSION['usuario_id'];  // Asegúrate de que el usuario esté autenticado

        # Verificando campos obligatorios #
        if ($nombre == "" || $descripcion == "" || $cantidad == "" || $unidad == "" || $categoria == "") {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        # Verificando elemento #
        $check_usuario = $this->ejecutarConsulta("SELECT elemento_nombre FROM elemento WHERE elemento_nombre='$nombre' AND usuario_id='$usuario_id'");
        if ($check_usuario->rowCount() > 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "Ya ha ingresado este elemento, por favor elija otro",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        # Directorio de imagenes #
        $img_dir = "../views/fotos/";

        # Comprobar si se selecciono una imagen #
        if ($_FILES['elemento_foto']['name'] != "" && $_FILES['elemento_foto']['size'] > 0) {
            # Creando directorio #
            if (!file_exists($img_dir)) {
                if (!mkdir($img_dir, 0777)) {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrió un error inesperado",
                        "texto" => "Error al crear el directorio",
                        "icono" => "error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            }

            # Verificando formato de imagenes #
            if (mime_content_type($_FILES['elemento_foto']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['elemento_foto']['tmp_name']) != "image/png") {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "La imagen que ha seleccionado es de un formato no permitido",
                    "icono" => "error"
                ];
                return json_encode($alerta);
                exit();
            }

            # Verificando peso de imagen #
            if (($_FILES['elemento_foto']['size'] / 1024) > 5120) {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "La imagen que ha seleccionado supera el peso permitido",
                    "icono" => "error"
                ];
                return json_encode($alerta);
                exit();
            }

            # Nombre de la foto #
            $foto = str_ireplace(" ", "_", $nombre);
            $foto = $foto . "_" . rand(0, 100);

            # Extension de la imagen #
            switch (mime_content_type($_FILES['elemento_foto']['tmp_name'])) {
                case 'image/jpeg':
                    $foto = $foto . ".jpg";
                    break;
                case 'image/png':
                    $foto = $foto . ".png";
                    break;
            }

            chmod($img_dir, 0777);

            # Moviendo imagen al directorio #
            if (!move_uploaded_file($_FILES['elemento_foto']['tmp_name'], $img_dir . $foto)) {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "No podemos subir la imagen al sistema en este momento",
                    "icono" => "error"
                ];
                return json_encode($alerta);
                exit();
            }
        } else {
            $foto = "";
        }

        $elemento_datos_reg = [
            [
                "campo_nombre" => "elemento_nombre",
                "campo_marcador" => ":Nombre",
                "campo_valor" => $nombre
            ],
            [
                "campo_nombre" => "elemento_descripcion",
                "campo_marcador" => ":Descripcion",
                "campo_valor" => $descripcion
            ],
            [
                "campo_nombre" => "elemento_cantidad",
                "campo_marcador" => ":Cantidad",
                "campo_valor" => $cantidad
            ],
            [
                "campo_nombre" => "elemento_unidad",
                "campo_marcador" => ":Unidad",
                "campo_valor" => $unidad
            ],
            [
                "campo_nombre" => "categoria_id",
                "campo_marcador" => ":Categoria",
                "campo_valor" => $categoria
            ],
            [
                "campo_nombre" => "elemento_foto",
                "campo_marcador" => ":Foto",
                "campo_valor" => $foto
            ],
            // Añadir el campo usuario_id para guardar el ID del usuario
            [
                "campo_nombre" => "usuario_id",
                "campo_marcador" => ":Usuario",
                "campo_valor" => $usuario_id
            ],
        ];

        // Asegúrate de que la función guardarDatos también acepte el usuario_id
        $registrar_elemento = $this->guardarDatos("elemento", $elemento_datos_reg);

        if ($registrar_elemento->rowCount() == 1) {
            $alerta = [
                "tipo" => "limpiar",
                "titulo" => "Elemento agregado",
                "texto" => "El elemento " . $nombre . "  se agregó con éxito",
                "icono" => "success"
            ];
        } else {
            if (is_file($img_dir . $foto)) {
                chmod($img_dir . $foto, 0777);
                unlink($img_dir . $foto);
            }

            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No se pudo registrar el elemento, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }



    /*----------  Controlador listar categorías  ----------*/
    public function listarCategoriasControlador($busqueda = "")
    {

        $busqueda = $this->limpiarCadena($busqueda);

        // Consulta SQL para obtener las categorías
        if (isset($busqueda) && $busqueda != "") {
            $consulta_datos = "SELECT * FROM categoria WHERE categoria_nombre LIKE '%$busqueda%' ORDER BY categoria_nombre ASC";
        } else {
            $consulta_datos = "SELECT * FROM categoria ORDER BY categoria_nombre ASC";
        }



        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();

        // Ejecutar la consulta
        $datos = $this->ejecutarConsulta($consulta_datos);
        $categorias = $datos->fetchAll();  // Obtener todos los resultados

        // Generar las opciones para el select
        $opciones = "";
        if (count($categorias) > 0) {
            foreach ($categorias as $categoria) {
                $opciones .= '<option value="' . $categoria['categoria_id'] . '">' . $categoria['categoria_nombre'] . '</option>';
            }
        } else {
            // Si no hay categorías, mostrar una opción vacía
            $opciones = '<option value="">No hay categorías disponibles</option>';
        }


        return $opciones;  // Retornar las opciones para mostrarlas en el select
    }

    public function listarElementoControlador($pagina, $registros, $url, $busqueda)
    {
        $pagina = $this->limpiarCadena($pagina);
        $registros = $this->limpiarCadena($registros);

        $url = $this->limpiarCadena($url);
        $url = APP_URL . $url . "/";

        $busqueda = $this->limpiarCadena($busqueda);
        $tabla = "";

        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        if (isset($busqueda) && $busqueda != "") {
            // Consulta para buscar elementos por nombre, descripción o categoría
            $consulta_datos = "SELECT e.*, c.categoria_nombre 
                               FROM elemento e
                               JOIN categoria c ON e.categoria_id = c.categoria_id
                               WHERE (e.elemento_nombre LIKE '%$busqueda%' OR e.elemento_descripcion LIKE '%$busqueda%' OR c.categoria_nombre LIKE '%$busqueda%')
                               ORDER BY e.elemento_nombre ASC 
                               LIMIT $inicio, $registros";

            $consulta_total = "SELECT COUNT(e.elemento_id) 
                               FROM elemento e
                               JOIN categoria c ON e.categoria_id = c.categoria_id
                               WHERE (e.elemento_nombre LIKE '%$busqueda%' OR e.elemento_descripcion LIKE '%$busqueda%' OR c.categoria_nombre LIKE '%$busqueda%')";
        } else {
            // Consulta para listar todos los elementos sin filtro de búsqueda
            $consulta_datos = "SELECT e.*, c.categoria_nombre 
                               FROM elemento e
                               JOIN categoria c ON e.categoria_id = c.categoria_id
                               ORDER BY e.elemento_nombre ASC 
                               LIMIT $inicio, $registros";

            $consulta_total = "SELECT COUNT(e.elemento_id) 
                               FROM elemento e";
        }

        // Ejecutamos las consultas
        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();

        $total = $this->ejecutarConsulta($consulta_total);
        $total = (int) $total->fetchColumn();

        $numeroPaginas = ceil($total / $registros);

        // Construcción de la tabla HTML
        $tabla .= '
        <div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th class="has-text-centered">#</th>
                    <th class="has-text-centered">Nombre</th>
                    <th class="has-text-centered">Descripción</th>
                    <th class="has-text-centered">Cantidad</th>
                    <th class="has-text-centered">Unidad</th>
                    <th class="has-text-centered">Categoría</th>
                    <th class="has-text-centered">Creado</th>
		            <th class="has-text-centered">Actualizado</th>
		            <th class="has-text-centered" colspan="3">Opciones</th>
                </tr>
            </thead>
            <tbody>';

        if ($total >= 1 && $pagina <= $numeroPaginas) {
            $contador = $inicio + 1;
            $pag_inicio = $inicio + 1;
            foreach ($datos as $rows) {
                $tabla .= '
                <tr class="has-text-centered">
                    <td>' . $contador . '</td>
                    <td>' . $rows['elemento_nombre'] . '</td>
                    <td>' . $rows['elemento_descripcion'] . '</td>
                    <td>' . $rows['elemento_cantidad'] . '</td>
                    <td>' . $rows['elemento_unidad'] . '</td>
                    <td>' . $rows['categoria_id'] . '</td>
                    <td>' . date("d-m-Y  h:i:s A", strtotime($rows['elemento_creado'])) . '</td>
					<td>' . date("d-m-Y  h:i:s A", strtotime($rows['elemento_actualizado'])) . '</td>
                    <td>
                        <a href="' . APP_URL . 'elementoFoto/' . $rows['elemento_id'] . '/" class="button is-info is-rounded is-small">Foto</a>
                    </td>
                    <td>
                        <a href="' . APP_URL . 'elementUpdate/' . $rows['elemento_id'] . '/" class="button is-success is-rounded is-small">Actualizar</a>
                    </td>
                    <td>
                        <form class="FormularioAjax" action="' . APP_URL . 'app/ajax/despensaAjax.php" method="POST" autocomplete="off">
                            <input type="hidden" name="modulo_elemento" value="eliminar">
                            <input type="hidden" name="elemento_id" value="' . $rows['elemento_id'] . '">
                            <button type="submit" class="button is-danger is-rounded is-small">Eliminar</button>
                        </form>
                    </td>
                </tr>
            ';
                $contador++;
            }
            $pag_final = $contador - 1;
        } else {
            if ($total >= 1) {
                $tabla .= '
                <tr class="has-text-centered">
                    <td colspan="7">
                        <a href="' . $url . '1/" class="button is-link is-rounded is-small mt-4 mb-4">
                            Haga clic acá para recargar el listado
                        </a>
                    </td>
                </tr>
            ';
            } else {
                $tabla .= '
                <tr class="has-text-centered">
                    <td colspan="7">No hay registros en el sistema</td>
                </tr>
            ';
            }
        }

        $tabla .= '</tbody></table></div>';

        ### Paginación ###
        if ($total > 0 && $pagina <= $numeroPaginas) {
            $tabla .= '<p class="has-text-right">Mostrando elementos <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';
            $tabla .= $this->paginadorTablas($pagina, $numeroPaginas, $url, 7);
        }

        return $tabla;
    }

    /*----------  Controlador eliminar elemento  ----------*/
    public function eliminarElementoControlador()
    {

        // Limpiar y obtener el ID del elemento
        $id = $this->limpiarCadena($_POST['elemento_id']);

        // Verificando si existe el elemento en la base de datos
        $datos = $this->ejecutarConsulta("SELECT * FROM elemento WHERE id_elemento='$id'");

        if ($datos->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos encontrado el elemento en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        } else {
            // Obtener los datos del elemento
            $datos = $datos->fetch();
        }

        // Intentar eliminar el registro del elemento
        $eliminarElemento = $this->eliminarRegistro("elemento", "id_elemento", $id);

        // Verificar si la eliminación fue exitosa
        if ($eliminarElemento->rowCount() == 1) {

            // Verificar si el archivo de foto del elemento existe y eliminarlo
            if (is_file("../views/fotos/" . $datos['elemento_foto'])) {
                chmod("../views/fotos/" . $datos['elemento_foto'], 0777);
                unlink("../views/fotos/" . $datos['elemento_foto']);
            }

            // Enviar alerta de éxito
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Elemento eliminado",
                "texto" => "El elemento " . $datos['nombre'] . " ha sido eliminado del sistema correctamente",
                "icono" => "success"
            ];
        } else {
            // Enviar alerta de error en caso de que la eliminación no se haya podido realizar
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos podido eliminar el elemento " . $datos['nombre'] . " del sistema, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        // Retornar la alerta en formato JSON
        return json_encode($alerta);
    }

    /*----------  Controlador actualizar elemento  ----------*/
    public function actualizarElementoControlador()
    {
        $id = $this->limpiarCadena($_POST['elemento_id']);

        # Verificando elemento #
        $datos = $this->ejecutarConsulta("SELECT * FROM elemento WHERE elemento_id='$id'");
        if ($datos->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos encontrado el elemento en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        } else {
            $datos = $datos->fetch();
        }

        # Almacenando datos#
        $nombre = $this->limpiarCadena($_POST['elemento_nombre']);
        $descripcion = $this->limpiarCadena($_POST['elemento_descripcion']);
        $cantidad = $this->limpiarCadena($_POST['elemento_cantidad']);
        $unidad = $this->limpiarCadena($_POST['elemento_unidad']);
        $foto = isset($_FILES['elemento_foto']) ? $_FILES['elemento_foto'] : null;

        # Verificando campos obligatorios #
        if ($nombre == "" || $cantidad == "" || $unidad == "") {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        # Verificando integridad de los datos #
        if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,100}", $nombre)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El NOMBRE del elemento no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        # Verificando cantidad #
        if (!is_numeric($cantidad) || $cantidad < 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "La CANTIDAD debe ser un número válido",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        # Si hay foto nueva, procesarla #
        if ($foto && $foto['error'] == 0) {
            $ruta_foto = "../views/fotos/" . $foto['name'];
            if (move_uploaded_file($foto['tmp_name'], $ruta_foto)) {
                # Eliminar la foto anterior si existe
                if (is_file("../views/fotos/" . $datos['elemento_foto'])) {
                    chmod("../views/fotos/" . $datos['elemento_foto'], 0777);
                    unlink("../views/fotos/" . $datos['elemento_foto']);
                }
                $elemento_foto = $foto['name'];
            } else {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "No se pudo subir la foto del elemento, por favor intente nuevamente",
                    "icono" => "error"
                ];
                return json_encode($alerta);
                exit();
            }
        } else {
            $elemento_foto = $datos['elemento_foto']; // Mantener la foto existente
        }

        # Preparando datos para actualizar #
        $elemento_datos_up = [
            [
                "campo_nombre" => "elemento_nombre",
                "campo_marcador" => ":Nombre",
                "campo_valor" => $nombre
            ],
            [
                "campo_nombre" => "elemento_descripcion",
                "campo_marcador" => ":Descripcion",
                "campo_valor" => $descripcion
            ],
            [
                "campo_nombre" => "elemento_cantidad",
                "campo_marcador" => ":Cantidad",
                "campo_valor" => $cantidad
            ],
            [
                "campo_nombre" => "elemento_unidad",
                "campo_marcador" => ":Unidad",
                "campo_valor" => $unidad
            ],
            [
                "campo_nombre" => "elemento_foto",
                "campo_marcador" => ":Foto",
                "campo_valor" => $elemento_foto
            ],
            [
                "campo_nombre" => "elemento_actualizado",
                "campo_marcador" => ":Actualizado",
                "campo_valor" => date("Y-m-d H:i:s")
            ]
        ];

        $condicion = [
            "condicion_campo" => "elemento_id",
            "condicion_marcador" => ":ID",
            "condicion_valor" => $id
        ];

        if ($this->actualizarDatos("elemento", $elemento_datos_up, $condicion)) {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Elemento actualizado",
                "texto" => "Los datos del elemento " . $datos['elemento_nombre'] . " se actualizaron correctamente",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos podido actualizar los datos del elemento " . $datos['elemento_nombre'] . ", por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }
}
