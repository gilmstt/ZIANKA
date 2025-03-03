<?php

/*      Regresa informacion de los input post
 */
function getData() {
    $INSTANCE = get_instance();

    // IDs a relacionar guardados al dar click en "Agregar" o "Editar" Receta
    $id = $INSTANCE->session->userdata("recetaIDs");

    $data = array(
        /*  ID para relacionar  */
        "paciente" => $id["paciente"],
        "consulta" => $id["consulta"],
        "urgencia" => $id["urgencia"],

        /*  Datos del paciente  */
        "diagnostico" => $INSTANCE->input->post('DIAGNOSTICO'),

        /*  Datos de la receta, son array   */
        "nombre" => $INSTANCE->input->post("NOMBRE_MEDICAMENTO"),
        "formula" => $INSTANCE->input->post("FORMULA"),
        "comercial" => $INSTANCE->input->post("NOMBRE_COMERCIAL"),
        "indicacion" => $INSTANCE->input->post("INDICACION")
    );
    return $data;
}


/*      Busca la receta junto con todas sus indicaciones y medicamentos en la base de datos,
        después guarda toda esa informacion dentro de la sesion.
*/
function obtenerIndicacionesExistentes() {
    $INSTANCE = get_instance();

    // IDs a relacionar guardados al dar click en "Agregar" o "Editar" Receta
    $id = $INSTANCE->session->userdata("recetaIDs");

    if ($id['consulta'] != null) {
        // Esta jalara la receta por ID de consulta
        $receta = $INSTANCE->mreceta->ObtenerRecetaConsulta($id['consulta']);
    }
    else {
        // Esta jalara la receta por ID de urgencia
        $receta = $INSTANCE->mreceta->ObtenerRecetaUrgencia($id['urgencia']);
    }
    convertirInformacion($receta);
}


/*      Convertirá la información de las indicaciones existentes a la manera como se
        muestra la informacion en la tabla de la vista, agregara un prefijo al id.
 */
function convertirInformacion($array) {
    $INSTANCE = get_instance();
    $indicaciones = $INSTANCE->session->userdata("indicaciones");

    foreach ($array as $item) {
        $indicacion = array(
            "id" => "_" . $item["ID_INDICACION"],
            "idMedicamento" => $item["ID_MEDICAMENTO"],
            "nombre" => $item["NOMBRE"],
            "comercial" => $item["NOMBRE_COMERCIAL"],
            "formula" => $item["FORMULA"],
            "indicacion" => $item["INDICACION"]
        );
        array_push($indicaciones, $indicacion);
    }
    $INSTANCE->session->set_userdata("indicaciones", $indicaciones);
}


/*      Actualiza la consulta o urgencia existente, agrega el ID de la receta
 */
function actualizarConReceta($idReceta) {
    $INSTANCE = get_instance();
    $data = getData();

    $idConsulta = $data["consulta"];
    $idUrgencia = $data["urgencia"];

    if ($idConsulta != null) {
        $INSTANCE->mconsult->agregarReceta($idConsulta, $idReceta);
    }
    else {
        $INSTANCE->murgency->agregarReceta($idUrgencia, $idReceta);
    }
}


/*      Busca en la base de datos algun medicamento que tenga
        el nombre, nombre comercial y formula ingresado,
        sí se encuentra regresa el id, sino regresa zero
 */
function buscarMedicamento() {
    $INSTANCE = get_instance();
    $data = getData();

    // Lo buscamos en la base de datos
    $medicamento = $INSTANCE->mreceta->buscarMedicamento(
        $data["nombre"], $data["comercial"], $data["formula"]);

    // Si fue encontrado regresamos el id, sino zero
    if ($medicamento != null) {
        return intval($medicamento[0]["ID_MEDICAMENTO"]);
    }
    return 0;
}


/*      Regresa el ultimo input de indicacion ingresado al
        array guardado en la sesion
 */
function sesionUltimoInput() {
    $INSTANCE = get_instance();
    $indicaciones = $INSTANCE->session->userdata("indicaciones");
    $ultimoId = count($indicaciones) - 1;
    return $indicaciones[$ultimoId];
}


/*      Guarda la indicacion en un array dentro de la sesion,
        también le asigna un id para poder ser eliminado.
 */
function sesionGuardarIndicacion($idMedicamento) {
    $INSTANCE = get_instance();
    $data = getData();

    // Traemos las indicaciones guardadas y el id actual
    $indicaciones = $INSTANCE->session->userdata("indicaciones");
    $id = $INSTANCE->session->userdata("idActual");

    /*      Creamos nuestro array en base a la informacion obtenida
            del input post, junto con el id del medicamento
     */
    $indicacion = array(
        "id" => $id,
        "idMedicamento" => $idMedicamento,
        "nombre" => $data["nombre"],
        "comercial" => $data["comercial"],
        "formula" => $data["formula"],
        "indicacion" => $data["indicacion"]
    );

    // Agregamos la nueva indicacion al array
    array_push($indicaciones, $indicacion);

    // Guardamos el array y aumentamos el id en 1
    $INSTANCE->session->set_userdata("indicaciones", $indicaciones);
    $INSTANCE->session->set_userdata("idActual", $id + 1);
}


/*      Elimina algun item del array de indicaciones, en base al id
 */
function sesionEliminarIndicacion($id) {
    $INSTANCE = get_instance();

    // Traemos las indicaciones guardadas
    $indicaciones = $INSTANCE->session->userdata("indicaciones");
    $nuevasIndicaciones = array();

    // Loopeamos entre todas ellas
    for ($index = 0; $index < count($indicaciones); $index++) {
        $idActual = $indicaciones[$index]["id"];


        // Sí el id coincide con el que buscamos
        if (($idActual == $id) && (sinPrefijo($idActual))) {

            // Borramos el item, reiniciamos los index y guardamos en sesion
            unset($indicaciones[$index]);
            $indicaciones = array_values($indicaciones);
            $INSTANCE->session->set_userdata("indicaciones", $indicaciones);
            return;
        }
        elseif ($idActual != $id) {
            /*  Por alguna razón, la función "unset" (como arriba) no sirve cuando el id tiene un prefijo,
                solo Dios sabe la razón, entonces tengo que crear otro array para pushear
                todos los items existentes de uno por uno y saltarme el que quiero borrar.  */
            array_push($nuevasIndicaciones, $indicaciones[$index]);
        }
        else {
            paraBorrar($idActual);
        }
    }
    // Finalmente actualizamos el array de la sesion
    $INSTANCE->session->set_userdata("indicaciones", $nuevasIndicaciones);
}


function sinPrefijo($id) {
    return substr_count($id, "_") == 0;
}


/*      Esta función se encarga de guardar en un array los ID de las indicaciones
        Ya existentes en la base de datos, para ser desactivadas
 */
function paraBorrar($id) {
    $INSTANCE = get_instance();
    $id = str_replace("_", "", $id);
    $array = $INSTANCE->session->userdata("borrar");
    array_push($array, $id);
    $INSTANCE->session->set_userdata("borrar", $array);
}

/*      Borra las indicaciones en la base de datos (solo para las indicaciones ya guardadas)
 */
function borrarIndicaciones() {
    $INSTANCE = get_instance();
    $array = $INSTANCE->session->userdata("borrar");
    foreach ($array as $idIndicacion) {
        $INSTANCE->mreceta->borrarIndicacion($idIndicacion);
    }
}


/*      Guarda la receta en base a la informacion de los input post
 */
function guardarReceta() {
    $INSTANCE = get_instance();

    // Sí ya existe (como al editar) entonces regresa el ID
    $idReceta = $INSTANCE->session->userdata("recetaIDs")["receta"];
    if ($idReceta != null)
        return $idReceta;

    // Sino, la vamos a crear
    $INSTANCE->load->model("mreceta");
    $data = getData();

    $receta = array(
        "ID_CONSULTA" => $data["consulta"],
        "ID_URGENCIA" => $data["urgencia"],
        "ID_PACIENTE" => $data["paciente"],
        "FECHA" => date("Y/m/d"),
        "DIAGNOSTICO" => $data["diagnostico"]
    );
    return $INSTANCE->mreceta->guardarReceta($receta);
}


/*      Guarda un medicamento, requiere el index ya que la sesion es un array
 */
function guardarMedicamento($index) {
    $INSTANCE = get_instance();
    $INSTANCE->load->model("mreceta");

    // Traemos la indicación específica
    $indicacion = $INSTANCE->session->userdata("indicaciones")[$index];

    // Creamos nuestro array en base a esa información
    $medicamento = array(
        "FORMULA" => $indicacion["formula"],
        "NOMBRE" => $indicacion["nombre"],
        "NOMBRE_COMERCIAL" => $indicacion["comercial"]
    );
    // Finalmente lo guardamos
    return $INSTANCE->mreceta->guardarMedicamento($medicamento);
}


/*      Guarda la indicación, requiere el index ya que la sesion es un array
 */
function guardarIndicacion($index, $idReceta, $idMedicamento) {
    $INSTANCE = get_instance();
    $INSTANCE->load->model("mreceta");

    // Traemos la indicación específica
    $indicacion = $INSTANCE->session->userdata("indicaciones")[$index];

    // Creamos nuestro array en base a esa información
    $indicacion = array(
        "ID_RECETA" => $idReceta,
        "ID_MEDICAMENTO" => $idMedicamento,
        "INDICACION" => $indicacion["indicacion"]
    );
    // Finalmente lo guardamos
    return $INSTANCE->mreceta->guardarIndicacion($indicacion);
}


/*      Esta función va a loopear entre el array de indicaciones que
        guardamos en la sesión, guardará indicaciones y medicamentos (inexistentes)
 */
function guardarIndicaciones($idReceta) {
    $INSTANCE = get_instance();

    // Traemos todas las indicaciónes guardadas
    $indicaciones = $INSTANCE->session->userdata("indicaciones");

    // Loopearemos entre todas ellas
    for ($index = 0; $index < count($indicaciones); $index++) {

        /* Sí encuentra el prefijo de guión bajo en el ID se saltará el loop actual,
           ya que los ID con prefijo son aquellas indicaciones ya existentes     */
        $id = $indicaciones[$index]["id"];
        if (!sinPrefijo($id))
            continue;

        /*  Este valor originalmente fue obtenido de la funcion `buscarMedicamento`,
            sí en su momento lo encontro entonces tendrá asignado el id,
            caso contrario entonces vale zero   */
        $idMedicamento = $indicaciones[$index]["idMedicamento"];

        // Si el medicamento no fue encontrado, entonces lo guaradamos
        if ($idMedicamento == 0) {
            $idMedicamento = guardarMedicamento($index);
        }
        // Después guardamos la indicación con su receta y medicamento
        guardarIndicacion($index, $idReceta, $idMedicamento);
    }
}