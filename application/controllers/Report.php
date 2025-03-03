<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper('functions');
        $this->load->helper('currency');
        $this->load->helper('general');
        $this->load->model('mconsult');
        $this->load->model('mconfig');
        $this->load->model('mreport');
        $this->load->helper('general');
    }

    // public function consultas() {
    //     $fechas = array(
    //         'inicio' => date("Y-m-d", strtotime("01/01/2019")),
    //         'final' => date("Y-m-d", strtotime(
    //             str_replace("/", "-", "27/12/2019"))));
    //     $tarifa = '';
    //     $resultado = $this->mreport->todasConsultas($fechas, $tarifa);
    //     print_r($resultado);
    //     // print_r($fechas);
    // }

    public function consultas() {
        if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
            $data = getActive("classRep");

            $data['TARFIAS'] = $this->mconfig->get_all_valid_tarifas();
            $data['MEMBRESIAS'] = $this->mconfig->get_all_valid_membresias();
            $data['entries'] = $this->all_consultas();

            $this->load->view('esqueleton/header', $data);
            $this->load->view('Reportes/v_paciente', $data);
            $this->load->view('esqueleton/footer');
        } else {
            redirect('login/salir');
        }
    }
    
    public function casas() {
        if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
            $data = getActive("classRep");

            if (!empty($this->input->post('RG_FECHA_INICIAL')) && !empty($this->input->post('RG_FECHA_FINAL'))):
                $data['FECHA_INICIO'] = convierte_fecha_valida_db($this->input->post('RG_FECHA_INICIAL'));
                $data['FECHA_FIN'] = convierte_fecha_valida_db($this->input->post('RG_FECHA_FINAL'));
            else: 
                $data['FECHA_INICIO'] = '';
                $data['FECHA_FIN'] = '';
            endif;
            
            $data['FECHA_FORMAT_INICIO'] = convierte_fecha_db_to_show($data['FECHA_INICIO']);
            $data['FECHA_FORMAT_FIN'] = convierte_fecha_db_to_show($data['FECHA_FIN']);
            
            $this->load->view('esqueleton/header', $data);
            $this->load->view('Reportes/v_casas', $data);
            $this->load->view('esqueleton/footer');
        } else {
            redirect('login/salir');
        }
    }
    
    function ajax_search_houses() {
        if ($this->input->is_ajax_request() && !empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
            $dates['FECHAINI'] = convierte_fecha($this->input->post("fecha_ini")) . " 00:00:00";
            $dates['FECHAFIN'] = convierte_fecha($this->input->post("fecha_fin")) . " 23:59:59";
            $consultas = $this->mreport->get_consults_houses_by_dates($dates);
            $urgencias = $this->mreport->get_urgencies_houses_by_dates($dates);
            $resultado=array();
            foreach ($consultas as $row){
                $resultado[$row['ID_CASA']]['NOMBRE']=$row['NOMBRE_CASA'];
                $resultado[$row['ID_CASA']]['CONSULTAS']=$row['suma'];
                if(!isset($resultado[$row['ID_CASA']]['URGENCIAS'])){
                    $resultado[$row['ID_CASA']]['URGENCIAS']=0;
                }
            }
            foreach ($urgencias as $row){
                $resultado[$row['ID_CASA']]['NOMBRE']=$row['NOMBRE_CASA'];
                $resultado[$row['ID_CASA']]['URGENCIAS']=$row['suma'];
                if(!isset($resultado[$row['ID_CASA']]['CONSULTAS'])){
                    $resultado[$row['ID_CASA']]['CONSULTAS']=0;
                }
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($resultado));
        } else {
            redirect('login/salir');
        }
    }

    public function myform() {
        if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
            $data = getActive("classRep");

            $data['TARFIAS'] = $this->mconfig->get_all_valid_tarifas();
            $data['MEMBRESIAS'] = $this->mconfig->get_all_valid_membresias();
            $data['entries'] = $this->all_consultas();

            $this->load->view('esqueleton/header', $data);
            $this->load->view('Reportes/v_my', $data);
            $this->load->view('esqueleton/footer');
        } else {
            redirect('login/salir');
        }
    }

    public function paciente() {
        if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
            $data = getActive("classRep");

            $data['TARFIAS'] = $this->mconfig->get_all_valid_tarifas();
            $data['MEMBRESIAS'] = $this->mconfig->get_all_valid_membresias();

            $this->load->view('esqueleton/header', $data);
            $this->load->view('Reportes/v_paciente', $data);
            $this->load->view('esqueleton/footer');
        } else {
            redirect('login/salir');
        }
    }

    public function grafica() {
        if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
            $data = getActive("classRep");
            $this->load->view('esqueleton/header', $data);
            if ($this->input->post('ID_MEMBRESIA_S') > 0)
                $data['ID_MEMBRESIA'] = $this->input->post('ID_MEMBRESIA_S');
            else
                $data['ID_MEMBRESIA'] = 1;
            if ($this->input->post('ID_MEMBRESIA_U') > 0)
                $data['ID_MEMBRESIAU'] = $this->input->post('ID_MEMBRESIA_U');
            else
                $data['ID_MEMBRESIAU'] = 1;
            $this->load->view('Reportes/v_reports', $data);
            $this->load->view('esqueleton/footer');
        } else {
            redirect('login/salir');
        }
    }

    public function ajax_obtener_consultas_meses() {
        if ($this->input->is_ajax_request()) {
            $anioactual = date("Y");
            $aniopasado = $anioactual - 1;

            $datosPasado = array();
            for ($x = 1; $x <= 12; $x++) {
                $dias = cal_days_in_month(CAL_GREGORIAN, $x, $aniopasado);
                if ($x < 10) {
                    $mes = "0" . $x;
                } else {
                    $mes = $x;
                }
                $fechainipast = $aniopasado . '-' . $mes . '-01';
                $fechafinpast = $aniopasado . '-' . $mes . '-' . $dias;
                $resultado = $this->mreport->consultameses($fechainipast, $fechafinpast);
                $datosPasado[$x] = $resultado[0]['TOTAL'];
            }
            $datosPresente = array();
            for ($x = 1; $x <= 12; $x++) {
                $dias = cal_days_in_month(CAL_GREGORIAN, $x, $anioactual);
                if ($x < 10) {
                    $mes = "0" . $x;
                } else {
                    $mes = $x;
                }
                $fechainipast = $anioactual . '-' . $mes . '-01';
                $fechafinpast = $anioactual . '-' . $mes . '-' . $dias;
                $resultado = $this->mreport->consultameses($fechainipast, $fechafinpast);
                $datosPresente[$x] = $resultado[0]['TOTAL'];
            }
            $data["pasado"] = $datosPasado;
            $data["presente"] = $datosPresente;
            echo json_encode($data);
        }
    }

    public function ajax_obtener_consultas_tarifas() {
        if ($this->input->is_ajax_request()) {
            $anioactual = date("Y");
            $fecha_ini = $anioactual . "-01-01";
            $fecha_fin = $anioactual . "-12-31";
            $resultado = $this->mreport->consulta_x_tarifas($fecha_ini, $fecha_fin);
            echo json_encode($resultado);
        }
    }

    public function ajax_obtener_consultas_membresias() {
        if ($this->input->is_ajax_request()) {
            $anioactual = date("Y");
            $fecha_ini = $anioactual . "-01-01";
            $fecha_fin = $anioactual . "-12-31";
            $resultado = $this->mreport->consulta_x_membresias($fecha_ini, $fecha_fin);
            echo json_encode($resultado);
        }
    }
    
    public function ajax_obtener_consultas_casas() {
        if ($this->input->is_ajax_request()) {
            $anioactual = date("Y");
            $fecha_ini = $anioactual . "-01-01";
            $fecha_fin = $anioactual . "-12-31";
            $resultado = $this->mreport->consulta_x_membresias_casa($fecha_ini, $fecha_fin, $this->input->post('ID_MEMBRESIA'));
            echo json_encode($resultado);
        }
    }

    public function ajax_obtener_urgencias_meses() {
        if ($this->input->is_ajax_request()) {
            $anioactual = date("Y");
            $aniopasado = $anioactual - 1;

            $datosPasado = array();
            for ($x = 1; $x <= 12; $x++) {
                $dias = cal_days_in_month(CAL_GREGORIAN, $x, $aniopasado);
                if ($x < 10) {
                    $mes = "0" . $x;
                } else {
                    $mes = $x;
                }
                $fechainipast = $aniopasado . '-' . $mes . '-01';
                $fechafinpast = $aniopasado . '-' . $mes . '-' . $dias;
                $resultado = $this->mreport->urgenciameses($fechainipast, $fechafinpast);
                $datosPasado[$x] = $resultado[0]['TOTAL'];
            }
            $datosPresente = array();
            for ($x = 1; $x <= 12; $x++) {
                $dias = cal_days_in_month(CAL_GREGORIAN, $x, $anioactual);
                if ($x < 10) {
                    $mes = "0" . $x;
                } else {
                    $mes = $x;
                }
                $fechainipast = $anioactual . '-' . $mes . '-01';
                $fechafinpast = $anioactual . '-' . $mes . '-' . $dias;
                $resultado = $this->mreport->urgenciameses($fechainipast, $fechafinpast);
                $datosPresente[$x] = $resultado[0]['TOTAL'];
            }
            $data["pasado"] = $datosPasado;
            $data["presente"] = $datosPresente;
            echo json_encode($data);
        }
    }

    public function ajax_obtener_urgencias_tarifas() {
        if ($this->input->is_ajax_request()) {
            $anioactual = date("Y");
            $fecha_ini = $anioactual . "-01-01";
            $fecha_fin = $anioactual . "-12-31";
            $resultado = $this->mreport->urgencia_x_tarifas($fecha_ini, $fecha_fin);
            echo json_encode($resultado);
        }
    }

    public function ajax_obtener_urgencias_membresias() {
        if ($this->input->is_ajax_request()) {
            $anioactual = date("Y");
            $fecha_ini = $anioactual . "-01-01";
            $fecha_fin = $anioactual . "-12-31";
            $resultado = $this->mreport->urgencia_x_membresias($fecha_ini, $fecha_fin);
            echo json_encode($resultado);
        }
    }

    public function ajax_obtener_urgencias_casas() {
        if ($this->input->is_ajax_request()) {
            $anioactual = date("Y");
            $fecha_ini = $anioactual . "-01-01";
            $fecha_fin = $anioactual . "-12-31";
            $resultado = $this->mreport->urgencia_x_membresias_casa($fecha_ini, $fecha_fin, $this->input->post('ID_MEMBRESIA'));
            echo json_encode($resultado);
        }
    }

    public function urgencias() {
        if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {

            $data = getActive("classRep");

            $data['TARFIAS'] = $this->mconfig->get_all_valid_tarifas();
            $data['MEMBRESIAS'] = $this->mconfig->get_all_valid_membresias();
            $data['entries'] = $this->all_urgencias();

            $this->load->view('esqueleton/header', $data);
            $this->load->view('Reportes/v_urgencias', $data);
            $this->load->view('esqueleton/footer');
        } else {
            redirect('login/salir');
        }
    }

    public function procedimientos() {
        if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
            $data = getActive("classRep");

            $data['entries'] = $this->all_procedimientos();

            $this->load->view('esqueleton/header', $data);
            $this->load->view('Reportes/v_procedimientos');
            $this->load->view('esqueleton/footer');
        } else {
            redirect('login/salir');
        }
    }

    public function productos() {
        if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
            $data = getActive("classRep");

            $data['entries'] = $this->all_productos();

            $this->load->view('esqueleton/header', $data);
            $this->load->view('Reportes/v_productos');
            $this->load->view('esqueleton/footer');
        } else {
            redirect('login/salir');
        }
    }

    /*  Funciones utilizadas durante la primera carga de la pagina,
      muestra solo los resultados respecto a hace un mes hasta
      el día de hoy
     */

    public function all_consultas() {
        $fechas = array(
            'inicio' => date("Y/m/d", strtotime('-1 month')),
            'final' => date("Y/m/d")
        );
        return $this->mreport->todasConsultas($fechas, 1, 0, 0);
    }

    public function all_urgencias() {
        $fechas = array(
            'inicio' => date("Y/m/d", strtotime('-1 month')),
            'final' => date("Y/m/d")
        );
        return $this->mreport->todasUrgencias($fechas, "");
    }

    public function all_procedimientos() {
        $fechas = array(
            'inicio' => date("Y/m/d", strtotime("-1 month")),
            'final' => date("Y/m/d")
        );
        $fichaId = $this->mreport->obtenerFichas($fechas);
        return $this->mreport->informacionProcedimientos($fichaId);
    }

    public function all_productos() {
        $fechas = array(
            'inicio' => date("Y/m/d", strtotime("-1 month")),
            'final' => date("Y/m/d")
        );
        $fichaId = $this->mreport->obtenerFichas($fechas);
        return $this->mreport->informacionProductos($fichaId);
    }

    /*  Funciones utilizadas para el auto-complete en la pagina de reportes del medico,
     *  primero obtiene ambos apellidos y finalmente el nombre
     */

    public function ajax_obtener_medico_ap() {
        if ($this->input->is_ajax_request()) {
            $resultado = $this->mreport->obtenerApMedico();
            echo json_encode($resultado);
        }
    }

    public function ajax_obtener_medico_nombre() {
        if ($this->input->is_ajax_request()) {
            $ap = $this->input->post('apellidos_medico');
            $resultado = $this->mreport->obtenerNomMedico($ap);
            echo json_encode($resultado);
        }
    }

    /*  Funciones utilizadas para el auto-complete en la pagina de reportes del paciente,
     *  primero obtiene el apellido paterno, luego el materno y finalmente el nombre
     */

    public function ajax_obtener_paciente_app() {
        if ($this->input->is_ajax_request()) {
            $resultado = $this->mreport->obtenerAppPaciente();
            echo json_encode($resultado);
        }
    }

    public function ajax_obtener_paciente_apm() {
        if ($this->input->is_ajax_request()) {
            $app = $this->input->post('apellido_paterno');
            $resultado = $this->mreport->obtenerApmPaciente($app);
            echo json_encode($resultado);
        }
    }

    public function ajax_obtener_paciente_nombre() {
        if ($this->input->is_ajax_request()) {
            $app = $this->input->post('apellido_paterno');
            $apm = $this->input->post('apellido_materno');
            $resultado = $this->mreport->obtenerNomPaciente($app, $apm);
            echo json_encode($resultado);
        }
    }

    /*  Obtiene la informacion del paciente / medico, junto con el filtro de fecha y hora.
     *  
     *  Primero busca el ID por sus apellidos y nombres, funciona incluso
     *  si algun campo falta, simplemente no lo utiliza en la busqueda dentro del modelo.
     */


    /*      Busqueda de consultas por paciente, medico y ambos
     */

    public function ajax_consulta_paciente() {
        if ($this->input->is_ajax_request()) {
            $paciente = array(
                'app' => $this->input->post('SEARCH_APP_PACIENTE'),
                'apm' => $this->input->post('SEARCH_APM_PACIENTE'),
                'nom' => $this->input->post('SEARCH_NOMBRE_PACIENTE')
            );

            $fechas = array(
                'inicio' => date("Y-m-d", strtotime(
                                str_replace("/", "-", $this->input->post('RG_FECHA_INICIAL')))),
                'final' => date("Y-m-d", strtotime(
                                str_replace("/", "-", $this->input->post('RG_FECHA_FINAL'))))
            );

            $pacienteId = $this->mreport->obtenerPacientes($paciente);
            $consultaId = $this->mreport->obtenerRegistros($pacienteId, "ID_CONSULTA", "consulta", "ID_PACIENTE");
            $tipo_descuento = $this->input->post('TIPO_DESCUENTO');
            $tarifa = $this->input->post('BUSCAR_TARIFA');
            $membresia = $this->input->post('BUSCAR_MEMBRESIA');

            $resultado = $this->mreport->InformacionConsultas($consultaId, $fechas, $tipo_descuento, $tarifa, $membresia);
            echo json_encode($resultado);
        }
    }

    public function ajax_consulta_por_paciente() {
        if ($this->input->is_ajax_request()) {
            $paciente = array(
                'app' => $this->input->post('SEARCH_APP_PAC'),
                'apm' => $this->input->post('SEARCH_APM_PAC'),
                'nom' => $this->input->post('SEARCH_NOMBRE_PAC')
            );

            $consultas = $this->mreport->InformacionConsultaPaciente($paciente);
            $urgencias = $this->mreport->InformacionUrgenciaPaciente($paciente);
            $resultado = array_merge($consultas, $urgencias);
            echo json_encode($resultado);
        }
    }

    public function ajax_consulta_medico() {
        if ($this->input->is_ajax_request()) {
            $medico = array(
                'ap' => $this->input->post('SEARCH_AP_MEDICO'),
                'nom' => $this->input->post('SEARCH_NOMBRE_MEDICO')
            );

            $fechas = array(
                'inicio' => date("Y-m-d", strtotime(
                                str_replace("/", "-", $this->input->post('RG_FECHA_INICIAL')))),
                'final' => date("Y-m-d", strtotime(
                                str_replace("/", "-", $this->input->post('RG_FECHA_FINAL'))))
            );

            $tarifa = $this->input->post('BUSCAR_TARIFA');

            $medicoId = $this->mreport->obtenerMedicos($medico);
            $consultaId = $this->mreport->obtenerRegistros($medicoId, "ID_CONSULTA", "consulta", "ID_MEDICO");
            $resultado = $this->mreport->InformacionConsultas($consultaId, $fechas, $tarifa);
            echo json_encode($resultado);
        }
    }

    public function ajax_consulta_todos() {
        if ($this->input->is_ajax_request()) {
            $fechas = array(
                'inicio' => date("Y-m-d", strtotime(
                                str_replace("/", "-", $this->input->post('RG_FECHA_INICIAL')))),
                'final' => date("Y-m-d", strtotime(
                                str_replace("/", "-", $this->input->post('RG_FECHA_FINAL'))))
            );
            $tipo_descuento = $this->input->post('TIPO_DESCUENTO');
            $tarifa = $this->input->post('BUSCAR_TARIFA');
            $membresia = $this->input->post('BUSCAR_MEMBRESIA');

            $resultado = $this->mreport->todasConsultas($fechas, $tipo_descuento, $tarifa, $membresia);
            echo json_encode($resultado);
        }
    }

    /*      Busqueda de urgencias por paciente y medico
     */

    public function ajax_urgencia_paciente() {
        if ($this->input->is_ajax_request()) {
            $paciente = array(
                'app' => $this->input->post('SEARCH_APP_PACIENTE'),
                'apm' => $this->input->post('SEARCH_APM_PACIENTE'),
                'nom' => $this->input->post('SEARCH_NOMBRE_PACIENTE')
            );

            $fechas = array(
                'inicio' => date("Y-m-d", strtotime(
                                str_replace("/", "-", $this->input->post('RG_FECHA_INICIAL')))),
                'final' => date("Y-m-d", strtotime(
                                str_replace("/", "-", $this->input->post('RG_FECHA_FINAL'))))
            );

            $tarifa = $this->input->post('BUSCAR_TARIFA');

            $pacienteId = $this->mreport->obtenerPacientes($paciente);
            $urgenciaId = $this->mreport->obtenerRegistros($pacienteId, "ID_URGENCIA", "urgencia", "ID_PACIENTE");
            $resultado = $this->mreport->InformacionUrgencias($urgenciaId, $fechas, $tarifa);
            echo json_encode($resultado);
        }
    }

    public function ajax_urgencia_medico() {
        if ($this->input->is_ajax_request()) {
            $medico = array(
                'ap' => $this->input->post('SEARCH_AP_MEDICO'),
                'nom' => $this->input->post('SEARCH_NOMBRE_MEDICO')
            );

            $fechas = array(
                'inicio' => date("Y-m-d", strtotime(
                                str_replace("/", "-", $this->input->post('RG_FECHA_INICIAL')))),
                'final' => date("Y-m-d", strtotime(
                                str_replace("/", "-", $this->input->post('RG_FECHA_FINAL'))))
            );

            $tarifa = $this->input->post('BUSCAR_TARIFA');

            $medicoId = $this->mreport->obtenerMedicos($medico);
            $urgenciaId = $this->mreport->obtenerRegistros($medicoId, "ID_URGENCIA", "urgencia", "ID_MEDICO");
            $resultado = $this->mreport->InformacionUrgencias($urgenciaId, $fechas, $tarifa);
            echo json_encode($resultado);
        }
    }

    public function ajax_urgencia_todos() {
        $fechas = array(
            'inicio' => date("Y-m-d", strtotime(
                            str_replace("/", "-", $this->input->post('RG_FECHA_INICIAL')))),
            'final' => date("Y-m-d", strtotime(
                            str_replace("/", "-", $this->input->post('RG_FECHA_FINAL'))))
        );

        $tipo_descuento = $this->input->post('TIPO_DESCUENTO');
        $tarifa = $this->input->post('BUSCAR_TARIFA');
        $membresia = $this->input->post('BUSCAR_MEMBRESIA');

        $resultado = $this->mreport->todasUrgencias($fechas, $tipo_descuento, $tarifa, $membresia);
        echo json_encode($resultado);
    }

    /*  Busca los procedimientos entre las fechas seleccionadas, suma los resultados
     */

    public function ajax_ficha_procedimiento() {
        if ($this->input->is_ajax_request()) {
            $fechas = array(
                'inicio' => date("Y-m-d", strtotime(
                                str_replace("/", "-", $this->input->post('RG_FECHA_INICIAL')))),
                'final' => date("Y-m-d", strtotime(
                                str_replace("/", "-", $this->input->post('RG_FECHA_FINAL'))))
            );

            $fichaId = $this->mreport->obtenerFichas($fechas);
            $resultado = $this->mreport->informacionProcedimientos($fichaId);
            echo json_encode($resultado);
        }
    }

    /*  Busca los productos entre las fechas seleccionadas, suma los resultados
     */

    public function ajax_ficha_producto() {
        if ($this->input->is_ajax_request()) {
            $fechas = array(
                'inicio' => date("Y-m-d", strtotime(
                                str_replace("/", "-", $this->input->post('RG_FECHA_INICIAL')))),
                'final' => date("Y-m-d", strtotime(
                                str_replace("/", "-", $this->input->post('RG_FECHA_FINAL'))))
            );

            $fichaId = $this->mreport->obtenerFichas($fechas);
            $resultado = $this->mreport->informacionProductos($fichaId);
            echo json_encode($resultado);
        }
    }

    public function pdfPaciente($ID_PACIENTE) {
        if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {

            if ($ID_PACIENTE > NULO) {
                $ROW_PACIENT = $this->mreport->get_pacient_by_id($ID_PACIENTE);
                $CONSULTAS = $this->mreport->InformacionConsultaPacienteId($ID_PACIENTE);
                $URGENCIAS = $this->mreport->InformacionUrgenciaPacienteId($ID_PACIENTE);

                $this->load->library('PDF');
                //Carpeta imágenes está un directorio arriba
                $directorioPadre = base_url() . "assets/img/";

                // $this->pdf->Image($directorioPadre."logo.jpg",10,10,10,28);

                $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                $this->pdf->SetFont('Arial', 'B', 8); //Arial, negrita, 12 puntos
                $this->pdf->designUp();

                $this->pdf->image(base_url() . "assets/img/encabezado.png", 76, 8, 70);

                $this->pdf->setXY(25, 37);
                $this->pdf->SetFont('Arial', 'B', 11);
                $this->pdf->Text(66, 37, utf8_decode('Historia Clínica de' . ' ' . $ROW_PACIENT[0]['NOMBRE_PACIENTE'] . ' ' . $ROW_PACIENT[0]['APELLIDO_PATERNO_PACIENTE'] . ' ' . $ROW_PACIENT[0]['APELLIDO_MATERNO_PACIENTE']), 0, 0, 'C');
                $this->pdf->Ln(4);

                $this->pdf->setXY(25, 45);
                $this->pdf->Cell(170, 5, utf8_decode('Información General'), 1, 1, 'L');

                $this->pdf->setXY(26, 55);
                $this->pdf->Cell(170, 5, utf8_decode('Datos Personales'), 0, 0, 'L');

                $this->pdf->setXY(25, 37);
                $this->pdf->Text(27, 65, utf8_decode('Nombre:'), 0, 0, 'L');

                $this->pdf->SetFont('Arial', '', 11);
                $this->pdf->Text(55, 65, utf8_decode($ROW_PACIENT[0]['NOMBRE_PACIENTE'] . ' ' . $ROW_PACIENT[0]['APELLIDO_PATERNO_PACIENTE'] . ' ' . $ROW_PACIENT[0]['APELLIDO_MATERNO_PACIENTE']), 0, 0, 'L');

                $this->pdf->SetFont('Arial', 'B', 11);
                $this->pdf->Text(27, 70, utf8_decode('Sexo:'), 0, 0, 'L');

                $this->pdf->SetFont('Arial', '', 11);
                $this->pdf->Text(55, 70, utf8_decode($ROW_PACIENT[0]['NOMBRE_SEXO']), 0, 0, 'L');

                $this->pdf->SetFont('Arial', 'B', 11);
                $this->pdf->Text(27, 75, utf8_decode('Nacimiento:'), 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 11);
                $this->pdf->Text(55, 75, ($ROW_PACIENT[0]['FECHA_NAC_PACIENTE']));

                $this->pdf->SetFont('Arial', 'B', 11);
                $this->pdf->Text(27, 80, utf8_decode('Edad:'), 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 11);

                $age = calcula_edad_2($ROW_PACIENT[0]['FECHA_NAC_PACIENTE'], date('Y-m-d'));
                $this->pdf->Text(55, 80, $age);

                $this->pdf->SetFont('Arial', 'B', 11);
                $this->pdf->Text(27, 88, utf8_decode('Teléfonos'), 0, 0, 'L');

                $this->pdf->SetFont('Arial', 'B', 11);
                $this->pdf->Text(27, 93, utf8_decode('Tel. Móvil:'), 0, 0, 'L');

                $this->pdf->SetFont('Arial', '', 11);
                $this->pdf->Text(55, 93, ($ROW_PACIENT[0]['TELEFONO_PACIENTE']));

                //PEDIATRICOS
                $this->pdf->SetFont('Arial', 'B', 11);
                $this->pdf->Text(27, 101, utf8_decode('Otros Datos'), 0, 0, 'L');

                /* $this->pdf->Text(27, 106, utf8_decode('País:'), 0, 0, 'L');

                  $this->pdf->SetFont('Arial', '', 11);
                  $this->pdf->Text(55, 106, utf8_decode($ROW_PACIENT[0]['RESIDENCIA'])); */

                $this->pdf->SetFont('Arial', 'B', 11);
                $this->pdf->Text(27, 106, utf8_decode('Dirección:'), 0, 0, 'L');

                $this->pdf->SetFont('Arial', '', 11);
                $this->pdf->Text(55, 106, utf8_decode($ROW_PACIENT[0]['CALLE_PACIENTE'] . ' ' . $ROW_PACIENT[0]['NUMERO_PACIENTE'] . ' ' . $ROW_PACIENT[0]['COLONIA_PACIENTE']));

                $this->pdf->SetFont('Arial', 'B', 11);
                $this->pdf->Text(27, 114, utf8_decode('Madre o Encargada'), 0, 0, 'L');

                $this->pdf->Text(27, 119, utf8_decode('Nombre:'), 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 11);
                $this->pdf->Text(55, 119, utf8_decode(($ROW_PACIENT[0]['NOMBRE_MADRE_PACIENTE'] . ' ' . $ROW_PACIENT[0]['APELLIDO_MADRE_PATERNO_PACIENTE'] . ' ' . $ROW_PACIENT[0]['APELLIDO_MADRE_MATERNO_PACIENTE'])));


                $this->pdf->SetFont('Arial', 'B', 11);
                $this->pdf->Text(27, 124, utf8_decode('Teléfono:'), 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 11);
                $this->pdf->Text(55, 124, ($ROW_PACIENT[0]['TELEFONO_MADRE_PACIENTE']));

                $this->pdf->SetFont('Arial', 'B', 11);
                $this->pdf->Text(27, 130, utf8_decode('Padre o Encargado'), 0, 0, 'L');

                $this->pdf->Text(27, 137, utf8_decode('Nombre:'), 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 11);
                $this->pdf->Text(55, 137, ($ROW_PACIENT[0]['NOMBRE_PADRE_PACIENTE'] . ' ' . $ROW_PACIENT[0]['APELLIDO_PADRE_PATERNO_PACIENTE'] . ' ' . $ROW_PACIENT[0]['APELLIDO_PADRE_MATERNO_PACIENTE']));

                $this->pdf->SetFont('Arial', 'B', 11);
                $this->pdf->Text(27, 142, utf8_decode('Teléfono:'), 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 11);
                $this->pdf->Text(55, 142, ($ROW_PACIENT[0]['TELEFONO_MADRE_PACIENTE']));

                $this->pdf->SetFont('Arial', 'B', 11);
                $this->pdf->setXY(25, 150);
                $this->pdf->Cell(170, 5, utf8_decode('Antecedentes'), 1, 1, 'L');

                $this->pdf->Text(27, 160, utf8_decode('Antecedentes Generales'), 0, 0, 'L');

                $this->pdf->Text(27, 166, utf8_decode('Patológicos:'), 0, 0, 'L');

                $this->pdf->SetFont('Arial', '', 11);
                $y = $this->pdf->GetY();
                $this->pdf->setXY(55, $y + 7);
                $this->pdf->Multicell(140, 5.5, utf8_decode($ROW_PACIENT[0]['PATOLOGICO']));
                $this->pdf->Ln(2);

                $this->pdf->SetFont('Arial', 'B', 11);
                $y = $this->pdf->GetY();
                $this->pdf->Text(27, $y + 4, utf8_decode('Quirúrgicos:'), 0, 0, 'L');

                $this->pdf->SetFont('Arial', '', 11);
                $y = $this->pdf->GetY();
                $this->pdf->setXY(55, $y);
                $this->pdf->Multicell(170, 5.5, utf8_decode($ROW_PACIENT[0]['QUIRURGICOS']));
                $this->pdf->Ln(2);

                $this->pdf->SetFont('Arial', 'B', 11);
                $y = $this->pdf->GetY();
                $this->pdf->Text(27, $y + 4, utf8_decode('Alergias:'), 0, 0, 'L');

                $this->pdf->SetFont('Arial', '', 11);
                $y = $this->pdf->GetY();
                $this->pdf->setXY(55, $y);
                $this->pdf->Multicell(170, 5.5, utf8_decode($ROW_PACIENT[0]['ALERGIAS']));
                $this->pdf->Ln(2);

                $this->pdf->SetFont('Arial', 'B', 11);
                $y = $this->pdf->GetY();
                $this->pdf->Text(27, $y + 4, utf8_decode('Medicamentos:'), 0, 0, 'L');

                $this->pdf->SetFont('Arial', '', 11);
                $y = $this->pdf->GetY();
                $this->pdf->setXY(55, $y);
                $this->pdf->Multicell(170, 5.5, utf8_decode($ROW_PACIENT[0]['MEDICAMENTOS']));
                //$this->pdf->Ln(3);

                $this->pdf->SetFont('Arial', 'B', 11);
                $y = $this->pdf->GetY();
                $this->pdf->setXY(55, $y);
                $this->pdf->Text(27, $y + 4, utf8_decode('Antecedentes prenatales:'), 0, 0, 'L');
                $this->pdf->Ln(3);

                if ($age < 18) {
                    $this->pdf->SetFont('Arial', '', 11);
                    $y = $this->pdf->GetY();
                    $this->pdf->setXY(27, $y + 8);
                    $this->pdf->Multicell(168, 5.5, utf8_decode($ROW_PACIENT[0]['PRENATALES']));
                    $this->pdf->Ln(2);
                }
                $this->pdf->SetFont('Arial', 'B', 11);
                $y = $this->pdf->GetY();
                $this->pdf->Text(27, $y + 8, utf8_decode('Antecedentes perinatales:'), 0, 0, 'L');
                $this->pdf->Ln(5);

                if ($age < 18) {
                    $this->pdf->SetFont('Arial', '', 11);
                    $y = $this->pdf->GetY();
                    $this->pdf->setXY(25, $y + 8);
                    $this->pdf->multicell(168, 5.5, utf8_decode($ROW_PACIENT[0]['PERINATALES']));
                    $this->pdf->Ln(4);
                }

                $this->pdf->SetFont('Arial', 'B', 11);
                $y = $this->pdf->GetY();
                $this->pdf->Text(27, $y + 9, utf8_decode('Antecedentes posnatales:'), 0, 0, 'L');
                $this->pdf->Ln(5);

                if ($age < 18) {
                    $this->pdf->SetFont('Arial', '', 11);
                    $y = $this->pdf->GetY();
                    $this->pdf->setXY(25, $y + 8);
                    $this->pdf->multicell(168, 5.5, utf8_decode($ROW_PACIENT[0]['POSNATALES']));
                    $this->pdf->Ln(4);
                }
                /* $this->pdf->SetFont('Arial', 'B', 8);
                  $this->pdf->Text(27, 198, utf8_decode('Control Prenatal:') , 0, 0, 'L');

                  $this->pdf->SetFont('Arial', 'B', 8);
                  $this->pdf->Text(27, 203, utf8_decode('Tipo de parto:') , 0, 0, 'L');

                  $this->pdf->SetFont('Arial', 'B', 8);
                  $this->pdf->Text(27, 208, utf8_decode('Clasificación:') , 0, 0, 'L');

                  $this->pdf->SetFont('Arial', 'B', 8);
                  $this->pdf->Text(27, 213, utf8_decode('Embarazo de:') , 0, 0, 'L');

                  $this->pdf->SetFont('Arial', 'B', 8);
                  $this->pdf->Text(27, 218, utf8_decode('Lugar de Nacimiento:') , 0, 0, 'L');

                  $this->pdf->SetFont('Arial', 'B', 8);
                  $this->pdf->Text(27, 223, utf8_decode('Peso:') , 0, 0, 'L');

                  $this->pdf->SetFont('Arial', 'B', 8);
                  $this->pdf->Text(27, 228, utf8_decode('Talla:') , 0, 0, 'L');

                  $this->pdf->SetFont('Arial', 'B', 8);
                  $this->pdf->Text(27, 233, utf8_decode('Circ. Cefálica:') , 0, 0, 'L');

                  $this->pdf->SetFont('Arial', 'B', 8);
                  $this->pdf->Text(27, 238, utf8_decode('Apgar 1:') , 0, 0, 'L');

                  $this->pdf->SetFont('Arial', 'B', 8);
                  $this->pdf->Text(27, 243, utf8_decode('Apgar 5:') , 0, 0, 'L');

                  $this->pdf->SetFont('Arial', 'B', 8);
                  $this->pdf->Text(27, 248, utf8_decode('Reanimación:') , 0, 0, 'L');

                  $this->pdf->SetFont('Arial', 'B', 8);
                  $this->pdf->Text(27, 253, utf8_decode('Complicaciones:') , 0, 0, 'L');

                  $this->pdf->SetFont('Arial', 'B', 8);
                  $this->pdf->Text(27, 258, utf8_decode('Observaciones:') , 0, 0, 'L'); */

                /* $y= $this->pdf->GetY();
                  $this->pdf->setXY(25, $y);
                  $this->pdf->Cell(170, 5, utf8_decode('Vacunas'), 1, 1, 'L');

                  $y= $this->pdf->GetY();
                  $this->pdf->setXY(25, $y+ 10);
                  $this->pdf->Cell(170, 5, utf8_decode('Consultas'), 1, 1, 'L'); */

                $y = $this->pdf->GetY();
                if (count($CONSULTAS) > 0) {
                    if ($CONSULTAS [0]['ID_CONSULTA'] > NULO) {
                        $this->pdf->setXY(25, $y);
                        foreach ($CONSULTAS as $ROW) {
                            $this->pdf->setXY(25, $y + 11);
                            $this->pdf->SetFillColor(230, 230, 230);
                            $this->pdf->SetFont('Arial', 'B', 11);
                            $this->pdf->Cell(170, 5, 'Fecha:', 0, 0, 'L', 1);


                            $this->pdf->setX(38);
                            $this->pdf->SetFont('Arial', '', 11);
                            $this->pdf->Cell(20, 5, $ROW['FECHA_CONSULTA'], 0, 1, 'L');

                            $this->pdf->SetFont('Arial', 'B', 11);
                            $y = $this->pdf->GetY();
                            $this->pdf->setXY(25, $y);
                            $this->pdf->SetFillColor(230, 230, 230);
                            $this->pdf->Cell(170, 5, 'Tipo:', 0, 0, 'L', 1);

                            $y = $this->pdf->GetY();
                            $this->pdf->setXY(25, $y + 5);
                            $this->pdf->SetFont('Arial', 'B', 11);
                            $this->pdf->Cell(26, 5, 'Motivo consulta:', 0, 0, 'L');

                            $y = $this->pdf->GetY();
                            $this->pdf->setXY(25, $y + 3);
                            $this->pdf->SetFont('Arial', '', 11);
                            $this->pdf->multicell(168, 6.6, utf8_decode($ROW['MOTIVO_CONSULTA']));

                            $y = $this->pdf->GetY();
                            $this->pdf->setXY(25, $y);
                            $this->pdf->SetFont('Arial', 'B', 10);
                            $this->pdf->Cell(26, 5, utf8_decode('Inicio y Evolución:'), 0, 0, 'L');

                            $y = $this->pdf->GetY();
                            $this->pdf->setXY(25, $y + 3);
                            $this->pdf->SetFont('Arial', '', 10);
                            $this->pdf->Multicell(168, 5.5, utf8_decode($ROW['INICIOEVOLUCION_CONSULTA']));

                            $y = $this->pdf->GetY();
                            $this->pdf->SetFont('Arial', 'B', 10);
                            $this->pdf->text(26, $y + 3, utf8_decode('Signos Vitales:'));
                            $this->pdf->Ln(4);

                            $y = $this->pdf->GetY();
                            $this->pdf->text(26, $y + 3, utf8_decode('TA:'));
                            $this->pdf->SetFont('Arial', '', 10);
                            $this->pdf->Text(33, $y + 3, utf8_decode($ROW['SIGNOS_VITALES']));

                            $this->pdf->SetFont('Arial', 'B', 10);
                            $this->pdf->text(63, $y + 3, utf8_decode('FC:'));
                            $this->pdf->SetFont('Arial', '', 10);
                            $this->pdf->Text(68, $y + 3, utf8_decode($ROW['FC_CONSULTA']));

                            $this->pdf->SetFont('Arial', 'B', 10);
                            $this->pdf->text(86, $y + 3, utf8_decode('RITMO CARDIACO:'));
                            $this->pdf->SetFont('Arial', '', 10);
                            $this->pdf->Text(120, $y + 3, utf8_decode($ROW['RITMO_CARDIACO_CONSULTA']));

                            $this->pdf->SetFont('Arial', 'B', 10);
                            $this->pdf->text(140, $y + 3, utf8_decode('TEMP.:'));
                            $this->pdf->SetFont('Arial', '', 10);
                            $this->pdf->Text(154, $y + 3, utf8_decode($ROW['TEMP_CONSULTA']));

                            $y = $this->pdf->GetY();
                            $this->pdf->SetFont('Arial', 'B', 10);
                            $this->pdf->text(26, $y + 6, utf8_decode('SAT:'));
                            $this->pdf->SetFont('Arial', '', 10);
                            $this->pdf->Text(36, $y + 6, $ROW['SAT_CONSULTA']);

                            $this->pdf->SetFont('Arial', 'B', 10);
                            $this->pdf->text(50, $y + 6, utf8_decode('GLICEMA CAPILAR:'));
                            $this->pdf->SetFont('Arial', '', 10);
                            $this->pdf->Text(89, $y + 6, $ROW['GLICEMIA_CAPILAR_CONSULTA']);
                            $this->pdf->Ln(6);

                            $this->pdf->SetFont('Arial', 'B', 10);
                            $this->pdf->text(169, $y + 3, utf8_decode('FR:'));
                            $this->pdf->SetFont('Arial', '', 10);
                            $this->pdf->Text(177, $y + 3, $ROW['FR_CONSULTA']);

                            $this->pdf->SetFont('Arial', 'B', 11);
                            $y = $this->pdf->GetY();
                            $this->pdf->setXY(25, $y + 3);
                            $this->pdf->Cell(26, 5, utf8_decode('Examen Físico o Exploración Física:'), 0, 0, 'L');

                            $this->pdf->SetFont('Arial', '', 11);
                            $y = $this->pdf->GetY();
                            $this->pdf->setXY(25, $y + 4);
                            $this->pdf->multicell(168, 5.5, utf8_decode($ROW['EXPLORACION_FISICA']));

                            $this->pdf->SetFont('Arial', 'B', 11);
                            $y = $this->pdf->GetY();
                            $this->pdf->setXY(25, $y);
                            $this->pdf->Cell(26, 5, utf8_decode('Diagnóstico Presuntivo:'), 0, 0, 'L');
                            $this->pdf->Ln(1);

                            $y = $this->pdf->GetY();
                            $this->pdf->SetFont('Arial', '', 11);
                            $this->pdf->setXY(25, $y + 3);
                            $this->pdf->multicell(168, 5.5, utf8_decode($ROW['DIAGNOSTICO']));

                            $this->pdf->SetFont('Arial', 'B', 11);
                            $y = $this->pdf->GetY();
                            $this->pdf->setXY(25, $y);
                            $this->pdf->Cell(26, 5, utf8_decode('Manejo Intrahospitalario:'), 0, 0, 'L');
                            $this->pdf->Ln(2);

                            $this->pdf->SetFont('Arial', 'B', 11);
                            $y = $this->pdf->GetY();
                            $this->pdf->setXY(25, $y + 3);
                            $this->pdf->Cell(26, 5, utf8_decode('Tratamiento:'), 0, 0, 'L');
                            $this->pdf->Ln(1);

                            $this->pdf->SetFont('Arial', '', 11);
                            $y = $this->pdf->GetY();
                            $this->pdf->setXY(25, $y + 3);
                            $this->pdf->multicell(168, 5.5, utf8_decode($ROW['TRATAMIENTO_CONSULTA']));

                            $y = $this->pdf->GetY();
                            $this->pdf->SetFont('Arial', 'B', 11);
                            $this->pdf->setXY(25, $y + 3);
                            $this->pdf->Cell(26, 5, utf8_decode('Observaciones:'), 0, 0, 'L');
                            $this->pdf->Ln(1);

                            $y = $this->pdf->GetY();
                            $this->pdf->setXY(25, $y + 2);
                            $this->pdf->SetFont('Arial', '', 11);
                            $this->pdf->multicell(168, 6.6, utf8_decode($ROW['OBSERVACIONES_CONSULTA']));

                            $y = $this->pdf->GetY();
                        }
                    }
                }

                if (count($URGENCIAS) > 0) {
                    if ($ID_PACIENTE > 0) {
                        $y+=10;
                        $this->pdf->SetFont('Arial', 'B', 15);
                        $this->pdf->text(96, $y, utf8_decode('URGENCIAS'), 0, 0, 'C');


                        foreach ($URGENCIAS as $ROW) {
                            $y= $this->pdf->GetY();
                            $this->pdf->setXY(25, $y+10);
                            $this->pdf->SetFillColor(230, 230, 230);
                            $this->pdf->SetFont('Arial', 'B', 11);
                            $this->pdf->Cell(170, 5, 'Fecha:', 0, 0, 'L', 1);

                            $this->pdf->setX(38);
                            $this->pdf->SetFont('Arial', '', 11);
                            $this->pdf->Cell(20, 5, $ROW['FECHA_URGENCIA'], 0, 1, 'L');
                            
                            $y= $this->pdf->GetY();
                            $this->pdf->SetFont('Arial', 'B', 11);
                            $this->pdf->text(26, $y+3, 'Motivo de urgencia:', 0, 0, 'L');


                            $this->pdf->SetFont('Arial', '', 11);
                            $this->pdf->setXY(25, $y+3);
                            $this->pdf->multicell(168, 6.6, utf8_decode($ROW['MOTIVO_URGENCIA']));
                            $this->pdf->Ln(3);

                            $this->pdf->SetFont('Arial', 'B', 11);
                            $y = $this->pdf->GetY();
                            $this->pdf->text(26, $y, utf8_decode('Inicio y Evolución:'), 0, 0, 'L');

                            $y = $this->pdf->GetY();
                            $this->pdf->setXY(25, $y + 5);
                            $this->pdf->SetFont('Arial', '', 10);
                            $this->pdf->multicell(168, 5.5, utf8_decode($ROW['INICIOEVOLUCION_URGENCIA']));
                            $this->pdf->Ln(3);

                            $y = $this->pdf->GetY();
                            $this->pdf->SetFont('Arial', 'B', 10);
                            $this->pdf->text(26, $y, utf8_decode('Signos Vitales:'));
                            $this->pdf->Ln(3);

                            $y = $this->pdf->GetY();
                            $this->pdf->text(26, $y + 2, utf8_decode('TA:'));
                            $this->pdf->SetFont('Arial', '', 10);
                            $this->pdf->Text(33, $y + 2, utf8_decode($ROW['SIGNOS_VITALES']));

                            $this->pdf->SetFont('Arial', 'B', 10);
                            $this->pdf->text(58, $y + 2, utf8_decode('FC:'));
                            $this->pdf->SetFont('Arial', '', 10);
                            $this->pdf->Text(65, $y + 2, utf8_decode($ROW['FC_URGENCIA']));

                            $this->pdf->SetFont('Arial', 'B', 10);
                            $this->pdf->text(86, $y + 2, utf8_decode('RITMO CARDIACO:'));
                            $this->pdf->SetFont('Arial', '', 10);
                            $this->pdf->Text(120, $y + 2, utf8_decode($ROW['RITMO_CARDIACO_URGENCIA']));

                            $this->pdf->SetFont('Arial', 'B', 10);
                            $this->pdf->text(140, $y + 2, utf8_decode('TEMP.:'));
                            $this->pdf->SetFont('Arial', '', 10);
                            $this->pdf->Text(154, $y + 2, utf8_decode($ROW['TEMP_URGENCIA']));

                            $this->pdf->SetFont('Arial', 'B', 10);
                            $this->pdf->text(169, $y + 2, utf8_decode('FR:'));
                            $this->pdf->SetFont('Arial', '', 10);
                            $this->pdf->Text(177, $y + 2, $ROW['FR_URGENCIA']);

                            $y = $this->pdf->GetY();
                            $this->pdf->SetFont('Arial', 'B', 10);
                            $this->pdf->text(26, $y + 6, utf8_decode('SAT:'));
                            $this->pdf->SetFont('Arial', '', 10);
                            $this->pdf->Text(36, $y + 6, $ROW['SAT_URGENCIA']);
                            $this->pdf->ln(3);

                            $this->pdf->SetFont('Arial', 'B', 10);
                            $this->pdf->text(50, $y + 6, utf8_decode('GLICEMA CAPILAR:'));
                            $this->pdf->SetFont('Arial', '', 10);
                            $this->pdf->Text(89, $y + 6, $ROW['GLICEMIA_CAPILAR_URGENCIA']);

                            $this->pdf->SetFont('Arial', 'B', 11);
                            $y = $this->pdf->GetY();
                            $this->pdf->setXY(25, $y + 5);
                            $this->pdf->Cell(26, 5, utf8_decode('Examen Físico o Exploración Física:'), 0, 0, 'L');

                            $this->pdf->SetFont('Arial', '', 11);
                            $y = $this->pdf->GetY();
                            $this->pdf->setXY(25, $y + 4);
                            $this->pdf->multicell(168, 5.5, utf8_decode($ROW['EXPLORACION_FISICA']));

                            $this->pdf->SetFont('Arial', 'B', 11);
                            $y = $this->pdf->GetY();
                            $this->pdf->setXY(25, $y);
                            $this->pdf->Cell(26, 5, utf8_decode('Diagnóstico Presuntivo:'), 0, 0, 'L');
                            $this->pdf->Ln(1);

                            $y = $this->pdf->GetY();
                            $this->pdf->SetFont('Arial', '', 11);
                            $this->pdf->setXY(25, $y + 3);
                            $this->pdf->multicell(168, 5.5, utf8_decode($ROW['DIAGNOSTICO']));

                            $this->pdf->SetFont('Arial', 'B', 11);
                            $y = $this->pdf->GetY();
                            $this->pdf->setXY(25, $y);
                            $this->pdf->Cell(26, 5, utf8_decode('Manejo Intrahospitalario:'), 0, 0, 'L');

                            $y = $this->pdf->GetY();
                            $this->pdf->setXY(25, $y + 5);
                            $this->pdf->SetFont('Arial', '', 10);
                            $this->pdf->multicell(168, 5.5, utf8_decode($ROW['MANEJO_INTRAHOSPITALARIO_URGENCIA']));

                            $this->pdf->SetFont('Arial', 'B', 11);
                            $y = $this->pdf->GetY();
                            $this->pdf->setXY(25, $y + 3);
                            $this->pdf->Cell(26, 5, utf8_decode('Tratamiento:'), 0, 0, 'L');
                            $this->pdf->Ln(1);

                            $this->pdf->SetFont('Arial', '', 11);
                            $y = $this->pdf->GetY();
                            $this->pdf->setXY(25, $y + 3);
                            $this->pdf->multicell(168, 5.5, utf8_decode($ROW['TRATAMIENTO_URGENCIA']));

                            $y = $this->pdf->GetY();
                            $this->pdf->SetFont('Arial', 'B', 11);
                            $this->pdf->setXY(25, $y + 3);
                            $this->pdf->Cell(26, 5, utf8_decode('Observaciones:'), 0, 0, 'L');
                            $this->pdf->Ln(2);

                            $y = $this->pdf->GetY();
                            $this->pdf->setXY(25, $y + 2);
                            $this->pdf->SetFont('Arial', '', 11);
                            $this->pdf->multicell(168, 6.6, utf8_decode($ROW['OBSERVACION_URGENCIA']));
                        }
                    }
                } else {
                    $this->pdf->SetFont('Arial', 'B', 11);
                    $this->pdf->text(26, $y + 5, 'Este cliente no cuenta con urgencias', 0, 0, 'L');
                }





                $this->pdf->Output(); //Salida al navegador del pdf
            } else {
                redirect('Report/paciente');
            }
        } else {
            redirect('Login/salir');
        }
    }

}
