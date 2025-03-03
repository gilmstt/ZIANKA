<?php

class Mschedule extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_schedule() {
        try {
            $this->db->select("*");
            $this->db->from("cita as c");
            $this->db->join('paciente as p','c.ID_PACIENTE= p.ID_PACIENTE');
            $this->db->join('usuario as u','c.ID_MEDICO= u.ID_USUARIO');
            $this->db->where('VIGENCIA_CITA', VIGENTE);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }
    
    function obtenerApePatPac() {
        try {
            $this->db->distinct();
            $this->db->select("APELLIDO_PATERNO_PACIENTE");
            $this->db->from('paciente');
            $this->db->where('ACTIVO_PACIENTE', ACTIVO);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }
    
    function obtenerApeMatPac($APP) {
        try {
            $this->db->distinct();
            $this->db->select("APELLIDO_MATERNO_PACIENTE");
            $this->db->from('paciente');
            $this->db->where('ACTIVO_PACIENTE', ACTIVO);
            $this->db->where('APELLIDO_PATERNO_PACIENTE', $APP);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }
    
    function obtenerNombrePac($APP,$APM) {
        try {
            $this->db->distinct();
            $this->db->select("NOMBRE_PACIENTE");
            $this->db->from('paciente');
            $this->db->where('ACTIVO_PACIENTE', ACTIVO);
            $this->db->where('APELLIDO_PATERNO_PACIENTE', $APP);
            $this->db->where('APELLIDO_MATERNO_PACIENTE', $APM);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }
    
    function obtenerPaciente($APP,$APM,$NOMBRE) {
        try {
            $this->db->distinct();
            $this->db->select("*");
            $this->db->from('paciente');
            $this->db->where('ACTIVO_PACIENTE', ACTIVO);
            $this->db->where('APELLIDO_PATERNO_PACIENTE', $APP);
            $this->db->where('APELLIDO_MATERNO_PACIENTE', $APM);
            $this->db->where('NOMBRE_PACIENTE', $NOMBRE);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }
    
    function obtenerNombrePacByAPP($APP) {
        try {
            $this->db->distinct();
            $this->db->select("NOMBRE_PACIENTE");
            $this->db->from('paciente');
            $this->db->where('ACTIVO_PACIENTE', ACTIVO);
            $this->db->where('APELLIDO_PATERNO_PACIENTE', $APP);
            $this->db->where('APELLIDO_MATERNO_PACIENTE', "");
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }
    
    function obtenerPacienteByNomApp($APP, $NOMBRE){
        try {
            $this->db->distinct();
            $this->db->select("*");
            $this->db->from('paciente');
            $this->db->where('ACTIVO_PACIENTE', ACTIVO);
            $this->db->where('APELLIDO_PATERNO_PACIENTE', $APP);
            $this->db->where('APELLIDO_MATERNO_PACIENTE', "");
            $this->db->where('NOMBRE_PACIENTE', $NOMBRE);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }
    
    function obtenerApesMed(){
        try {
            $this->db->distinct();
            $this->db->select("APELLIDO_USUARIO");
            $this->db->from('usuario');
            $this->db->where('VIGENCIA_USUARIO', VIGENTE);
            $this->db->where('ID_ROL', MEDICO);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }
    
    function obtenerNombreMed($AP){
        try {
            $this->db->distinct();
            $this->db->select("NOMBRE_USUARIO");
            $this->db->from('usuario');
            $this->db->where('VIGENCIA_USUARIO', VIGENTE);
            $this->db->where('ID_ROL', MEDICO);
            $this->db->where('APELLIDO_USUARIO', $AP);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }
    
    function obtenerMedico($AP, $NOMBRE){
        try {
            $this->db->distinct();
            $this->db->select("*");
            $this->db->from('usuario');
            $this->db->where('VIGENCIA_USUARIO', VIGENTE);
            $this->db->where('ID_ROL', MEDICO);
            $this->db->where('APELLIDO_USUARIO', $AP);
            $this->db->where('NOMBRE_USUARIO', $NOMBRE);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }
    
    function add_new_schedule_on_db($data){
        try {
            $this->db->insert('cita', $data);
            return $this->db->insert_id();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    function get_event_schedule_by_id($ID_CITA){
        try{
            $this->db->select("*");
            $this->db->from('cita AS C');
            $this->db->join('paciente AS P','P.ID_PACIENTE=C.ID_PACIENTE');
            $this->db->join('usuario AS U','U.ID_USUARIO=C.ID_MEDICO');
            $this->db->where('C.ID_CITA',$ID_CITA);
            $query = $this->db->get();
            return $query->result_array();
            
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }
    
    function disable_schedule_on_db($ID_CITA){
        try {
            $data = array(
                'VIGENCIA_CITA' => NULO
            );
            $this->db->where('ID_CITA', $ID_CITA);
            $this->db->update('cita', $data);
            return $this->db->affected_rows();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }
 
}
