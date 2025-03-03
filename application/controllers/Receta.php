<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Receta extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mreceta');
        $this->load->model('mconsult');
        $this->load->model('murgency');
        $this->load->model('minventary');
        $this->load->helper('functions');
        $this->load->helper('general');
        $this->load->helper('receta');

        if (empty($this->session->userdata('CAREYES_ID_USUARIO')))
            redirect("login/salir");
    }

    public function index() {
        $this->session->set_userdata("indicaciones", array());
        $this->session->set_userdata("idActual", 1);
        $data = getActive("classPat");
        $data["URL"] = $this->session->userdata("recetaIDs")["url"];
        loadView("Receta/v_add_receta", $data);
    }

    public function editar() {
        $this->session->set_userdata("borrar", array());
        $this->session->set_userdata("indicaciones", array());
        $this->session->set_userdata("idActual", 1);
        obtenerIndicacionesExistentes();
        $data = getActive("classPat");
        $data["URL"] = $this->session->userdata("recetaIDs")["url"];
        loadView("Receta/v_edit_receta", $data);
    }

    /*      Guarda los ID correspondientes en la sesion para relacionar tablas
     */
    public function ajax_guardar_ids_sesion() {
        if ($this->input->is_ajax_request()) {
            $ids = array(
                "url" => $this->input->post("LAST_URL"),
                "receta" => $this->input->post("ID_RECETA"),
                "paciente" => $this->input->post("ID_PACIENTE"),
                "consulta" => $this->input->post("ID_CONSULTA"),
                "urgencia" => $this->input->post("ID_URGENCIA")
            );
            $this->session->set_userdata("recetaIDs", $ids);
            echo 1;
        }
    }

    /*      Simplemente regresa las indicaciones guardadas
      actualmente en la sesion.
     */

    public function ajax_obtener_indicaciones() {
        if ($this->input->is_ajax_request()) {
            $array = $this->session->userdata("indicaciones");
            echo json_encode($array);
        }
    }

    /*      Se ejecuta al guardar una indicacion, almacena los inputs
      en un array dentro de la session
     */

    public function ajax_guardar_indicacion() {
        if ($this->input->is_ajax_request()) {

            /*  Busca el medicamento en la base de datos,
              regresa el número de id o zero */
            $idMedicamento = buscarMedicamento();

            /*  Guardamos en la sesion (dentro de un array)
              los datos del medicamento e indicacion */
            sesionGuardarIndicacion($idMedicamento);

            /*  Finalmente regresa el ultimo item ingresado */
            echo json_encode(sesionUltimoInput());
        }
    }

    /*      Elimina la indicacion de el array encontrado
      dentro de la sesion.
     */

    public function ajax_borrar_indicacion() {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post("id");
            sesionEliminarIndicacion($id);
            echo 1;
        }
    }

    /*      Guarda la receta junto con sus indicaciones y medicamentos
     */

    public function ajax_guardar_receta() {
        if ($this->input->is_ajax_request()) {

            /*  Primero guardamos la receta     */
            $idReceta = guardarReceta();

            /* Sí la receta fue guardada continuamos   */
            if ($idReceta > 0) {

                /*  Por último en está función accedemos a los valores
                  que guardamos en la sesion, guardaremos los medicamentos
                  inexistentes y las indicaciones */
                guardarIndicaciones($idReceta);

                /*  Borra las indicaciones elegidas pero que ya estaban guardadas
                  en la base de datos */
                borrarIndicaciones();

                /*  Actualizamos la consulta o urgencia agregando el id de la receta */
                actualizarConReceta($idReceta);

                /*  Limpiar la sesion  */
                $this->session->set_userdata("indicaciones", array());
                $this->session->set_userdata("idActual", 1);
                echo $idReceta;
            } else
                echo 0;
        }
    }

    /*  OTROS   */

    public function ajax_obtener_nombres() {
        if ($this->input->is_ajax_request()) {
            $productos = $this->minventary->obtenerNombres();
            $medicamentos = $this->mreceta->obtenerNombres();

            $productos = grabValue($productos, "NOMBRE_PRODUCTO");
            $medicamentos = grabValue($medicamentos, "NOMBRE");

            $nombres = array_merge($productos, $medicamentos);
            echo json_encode(array_unique($nombres));
        }
    }

    public function ajax_obtener_nombres_comerciales() {
        if ($this->input->is_ajax_request()) {
            $nombre = $this->input->post('nombre');

            $nombresComerciales = $this->mreceta->obtenerNombresComerciales($nombre);
            $nombresComerciales = grabValue($nombresComerciales, "NOMBRE_COMERCIAL");

            echo json_encode($nombresComerciales);
        }
    }

    public function ajax_obtener_formulas() {
        if ($this->input->is_ajax_request()) {
            $nombre = $this->input->post('nombre');
            $nombreComercial = $this->input->post('nombreComercial');

            $formulas = $this->mreceta->obtenerFormulas($nombre, $nombreComercial);
            $formulas = grabValue($formulas, "FORMULA");

            echo json_encode($formulas);
        }
    }
    
    function pdfReceta($ID_RECETA) {
        if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
        
            $ROW_RECETA = $this->mreceta->get_receta_by_id_consult($ID_RECETA);
            //$INDICACION = $this->mreceta->get_indicacion_by_id_consult($ID_RECETA);
            
            if (count($ROW_RECETA) > NULO) {
                $this->load->library('PDF');
                //Carpeta imágenes está un directorio arriba
                $directorioPadre = base_url() . "assets/img/";

                $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                $this->pdf->SetFont('Arial', 'B', 8); //Arial, negrita, 12 puntos
                $this->pdf->image(base_url() . "assets/img/encabezado.png", 76, 8, 70);
                $this->pdf->designUp();

                //$this->pdf->image(base_url() . "assets/img/", 76, 8, 70);

                $this->pdf->SetFont('Arial', 'B', 11);
                $this->pdf->text(26, 40, 'Nombre:', 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 11);
                $this->pdf->Text(44, 40, utf8_decode($ROW_RECETA[0]['NOMBRE_PACIENTE']) . ' ' . utf8_decode($ROW_RECETA[0]['APELLIDO_PATERNO_PACIENTE']) . ' ' . utf8_decode($ROW_RECETA[0]['APELLIDO_MATERNO_PACIENTE']));
                
                $this->pdf->SetFont('Arial', 'B', 11);
                $this->pdf->text(150, 40, 'Fecha:', 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 11);
                $this->pdf->Text(163, 40, utf8_decode($ROW_RECETA[0]['FECHA']));
                
                $this->pdf->SetFont('Arial', 'B', 11);
                $this->pdf->text(26, 45, 'Diagnostico:', 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 11);
                $this->pdf->Text(52, 45, utf8_decode($ROW_RECETA[0]['DIAGNOSTICO']));

                $this->pdf->SetXY(26,50);
                $y = $this->pdf->GetY();
                    
                if ($ROW_RECETA [0]['ID_RECETA'] > NULO) {
                    foreach ($ROW_RECETA as $ROW) {
                        $this->pdf->SetFont('Arial', '', 11);
                        $this->pdf->Text(26, $y, utf8_decode($ROW['NOMBRE'].' ('.$ROW['FORMULA'].' '.$ROW['NOMBRE_COMERCIAL'].')'));
                        $y+=5;
                        $this->pdf->Text(26, $y, utf8_decode($ROW['INDICACION']));
                        $y+=5;
                    }
                }
                
                $this->pdf->SetFont('Arial', 'B', 11);
                $this->pdf->text(26, 120, 'DR:', 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 11);
                $this->pdf->Text(34, 120, utf8_decode($ROW_RECETA[0]['NOMBRE_USUARIO'].' '.$ROW_RECETA[0]['APELLIDO_USUARIO']));
                
                $this->pdf->SetFont('Arial', 'B', 11);
                $this->pdf->text(100, 120, 'FIRMA:', 0, 0, 'L');
                
                $this->pdf->SetFont('Arial', 'B', 11);
                $this->pdf->text(150, 120, 'CEDULA:', 0, 0, 'L');
                
                $this->pdf->Output(); //Salida al navegador del pdf
            } else {
                redirect('Consult/index');
            }
        } else {
            redirect('Login/salir');
        }
    }

}
