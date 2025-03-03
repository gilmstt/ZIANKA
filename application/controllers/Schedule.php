<?php

if (!defined('BASEPATH')) {
   exit('No direct script access allowed');
}

class Schedule extends CI_Controller
{

   public function __construct()
   {
      parent::__construct();

      $this->load->model('mschedule');
      $this->load->helper('functions');
      $this->load->helper('general');
   }

   public function index()
   {
      if ((!empty($this->session->userdata('CAREYES_ID_USUARIO')))) {
         $data = getActive("classSch");
         $this->load->view('esqueleton/header', $data);
         $this->load->view('Schedule/v_index_schedule');
         $this->load->view('esqueleton/footer');
      } else {
         redirect('login/salir');
      }
   }

   public function ajax_render_calendar_from_db()
   {
      if (!empty($this->session->userdata('CAREYES_ID_USUARIO')) && $this->input->is_ajax_request()) {
         $ROW_SCHEDULE = $this->mschedule->get_schedule();
         if (count($ROW_SCHEDULE)):
            $events = array();
            $e = array();
            foreach ($ROW_SCHEDULE as $SCHEDULE):
               $e['id'] = $SCHEDULE['ID_CITA'];
               $e['title'] = $SCHEDULE['APELLIDO_PATERNO_PACIENTE'] . " " . $SCHEDULE['APELLIDO_MATERNO_PACIENTE'] . " " . $SCHEDULE['NOMBRE_PACIENTE'];
               $e['start'] = $SCHEDULE['FECHA_CITA'] . 'T' . $SCHEDULE['HORA_INICIO_CITA'];
               //$e['color'] = $SCHEDULE['CODIGO_CATALOGO_COLORES'];
               $e['end'] = $SCHEDULE['FECHA_CITA'] . 'T' . $SCHEDULE['HORA_FINAL_CITA'];
               $e['allDay'] = false;
               $e['editable'] = false;
               array_push($events, $e);
            endforeach;
            $this->output->set_content_type("application/json")->set_output(json_encode($events));
         endif;
      } else {
         redirect('login/salir');
      }
   }

   public function ajax_obtener_apellidos_paternos_pac()
   {
      if ($this->input->is_ajax_request()) {
         $resultado = $this->mschedule->obtenerApePatPac();
         $this->output->set_content_type("application/json")->set_output(json_encode($resultado));
      } else {
         redirect('login');
      }
   }

   public function ajax_obtener_apellidos_maternos_pac()
   {
      if ($this->input->is_ajax_request()) {
         $APP = $this->input->post('apellido_paterno');
         $resultado = $this->mschedule->obtenerApeMatPac($APP);
         $this->output->set_content_type("application/json")->set_output(json_encode($resultado));
      } else {
         redirect('login');
      }
   }

   public function ajax_obtener_nombres_pac()
   {
      if ($this->input->is_ajax_request()) {
         $APP = $this->input->post('apellido_paterno');
         $APM = $this->input->post('apellido_materno');
         $resultado = $this->mschedule->obtenerNombrePac($APP, $APM);
         $this->output->set_content_type("application/json")->set_output(json_encode($resultado));
      } else {
         redirect('login');
      }
   }

   public function ajax_obtener_paciente()
   {
      if ($this->input->is_ajax_request()) {
         $APP = $this->input->post('apellido_paterno');
         $APM = $this->input->post('apellido_materno');
         $NOMBRE = $this->input->post('nombre');
         $resultado = $this->mschedule->obtenerPaciente($APP, $APM, $NOMBRE);
         $this->output->set_content_type("application/json")->set_output(json_encode($resultado));
      } else {
         redirect('login');
      }
   }

   public function ajax_obtener_nombres_pac_by_app()
   {
      if ($this->input->is_ajax_request()) {
         $APP = $this->input->post('apellido_paterno');
         $resultado = $this->mschedule->obtenerNombrePacByAPP($APP);
         $this->output->set_content_type("application/json")->set_output(json_encode($resultado));
      } else {
         redirect('login');
      }
   }

   public function ajax_obtener_paciente_by_nom_app()
   {
      if ($this->input->is_ajax_request()) {
         $APP = $this->input->post('apellido_paterno');
         $NOMBRE = $this->input->post('nombre');
         $resultado = $this->mschedule->obtenerPacienteByNomApp($APP, $NOMBRE);
         $this->output->set_content_type("application/json")->set_output(json_encode($resultado));
      } else {
         redirect('login');
      }
   }

   public function ajax_obtener_apellidos_med()
   {
      if ($this->input->is_ajax_request()) {
         $resultado = $this->mschedule->obtenerApesMed();
         $this->output->set_content_type("application/json")->set_output(json_encode($resultado));
      } else {
         redirect('login');
      }
   }

   public function ajax_obtener_nombres_med()
   {
      if ($this->input->is_ajax_request()) {
         $AP = $this->input->post('apellido');
         $resultado = $this->mschedule->obtenerNombreMed($AP);
         $this->output->set_content_type("application/json")->set_output(json_encode($resultado));
      } else {
         redirect('login');
      }
   }

   public function ajax_obtener_medico()
   {
      if ($this->input->is_ajax_request()) {
         $AP = $this->input->post('apellido');
         $NOMBRE = $this->input->post('nombre');
         $resultado = $this->mschedule->obtenerMedico($AP, $NOMBRE);
         $this->output->set_content_type("application/json")->set_output(json_encode($resultado));
      } else {
         redirect('login');
      }
   }

   public function ajax_add_schedule()
   {
      if ($this->input->is_ajax_request() && !empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
         $data['ID_PACIENTE'] = $this->input->post("ID_PACIENTE");
         $data['ID_MEDICO'] = $this->input->post("ID_USUARIO");
         $data['FECHA_CITA'] = convierte_fecha($this->input->post("RG_FECHA_CITA"));
         $data['HORA_INICIO_CITA'] = $this->input->post("RG_HORA_INICIO_CITA");
         $data['HORA_FINAL_CITA'] = $this->input->post("RG_HORA_FINAL_CITA");
         $data['MOTIVO_CITA'] = $this->input->post("RG_MOTIVO_CITA");

         $ID_CITA = $this->mschedule->add_new_schedule_on_db($data);
         if ($ID_CITA > NULO) {
            echo $ID_CITA;
         } else {
            echo -1;
         }

      } else {
         redirect('login/salir');
      }
   }

   public function ajax_get_data_event_schedule_by_id()
   {
      if ($this->input->is_ajax_request()) {
         $ID_CITA = $this->input->post('ID_CITA');
         $ROW_SCHEDULE = $this->mschedule->get_event_schedule_by_id($ID_CITA);
         if (count($ROW_SCHEDULE) > NULO) {
            $this->output->set_content_type("application/json")->set_output(json_encode($ROW_SCHEDULE));
         }

      } else {
         show_404();
      }
   }

   public function ajax_disable_schedule()
   {
      if ($this->input->is_ajax_request()) {
         $ID_CITA = $this->input->post('ID_CITA');
         $AFFECTED_ROWS = $this->mschedule->disable_schedule_on_db($ID_CITA);
         echo $AFFECTED_ROWS;
      } else {
         redirect('Schedule');
      }
   }

}
