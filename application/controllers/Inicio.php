<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inicio extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('minicio');
        $this->load->helper('general');
    }

    public function index() {
        if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
            $data['classIni'] = 'class="dropdown active"';
            $data['classSch'] = '';
            $data['classPat'] = '';
            $data['classInv'] = '';
            $data['classCon'] = '';
            $data['classUrg'] = '';
            $data['classCfg'] = '';
            $data['classRep'] = '';
            $data['classSch'] = '';
            $data = getActive("classIni");
            $data["countPaciente"] = $this->minicio->getCount("paciente", "ACTIVO_PACIENTE");
            $data["countInventario"] = $this->minicio->getCount("producto", "ACTIVO_PRODUCTO");
            $data["countConsulta"] = $this->minicio->getCount("consulta", "VIGENCIA_CONSULTA");
            $data["countReporte"] = $this->minicio->getCount("paciente", "ACTIVO_PACIENTE");
            $data["countUrgencia"] = $this->minicio->getCount("urgencia", "VIGENCIA_URGENCIA");

            $this->load->view('esqueleton/header', $data);
            $this->load->view('Inicio/v_index', $data);
            $this->load->view('esqueleton/footer');
        } else {
            redirect('login/salir');
        }
    }
    
}
