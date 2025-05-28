<?php

class Mconfig extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    //Terifas
    function get_all_valid_tarifas() {
        try {     
            $this->db->select("*");
            $this->db->from("tarifa");
            $this->db->where('VIGENCIA_TARIFA', VIGENTE);     
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function add_new_tarifa_on_db($row){
        try {
            $this->db->insert('tarifa', $row);
            return $this->db->insert_id();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    function get_tarifa_by_id($id_tarifa) {
        try {     
            $this->db->select("*");
            $this->db->from("tarifa");
            $this->db->where('ID_TARIFA', $id_tarifa);     
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function edit_tarifa_on_db($row, $id_tarifa) {
        try {
            // Iniciar la transacción para garantizar consistencia en ambas operaciones
            $this->db->trans_begin();
    
            // Marcar la tarifa existente como no vigente
            $this->db->where('ID_TARIFA', $id_tarifa);
            $this->db->update('tarifa', ['VIGENCIA_TARIFA' => 0]);
    
            // Verificar si la actualización fue exitosa
            if ($this->db->affected_rows() <= 0) {
                $this->db->trans_rollback(); // Deshacer los cambios
                return "Error: No se pudo actualizar la vigencia de la tarifa existente.";
            }
    
            // Agregar la nueva tarifa con VIGENCIA_TARIFA = 1
            $row['VIGENCIA_TARIFA'] = 1; // Asegurarse de que esté activa
            $this->db->insert('tarifa', $row);
    
            // Verificar si se insertó correctamente
            $idTarifa = $this->db->insert_id();
            if ($idTarifa > 0) {
                $this->db->trans_commit(); // Confirmar la transacción
                return $idTarifa; // Retornar el ID del nuevo registro
            } else {
                $this->db->trans_rollback(); // Deshacer los cambios si algo falla
                return "Error: No se pudo insertar la nueva tarifa.";
            }
        } catch (Exception $e) {
            $this->db->trans_rollback(); // Deshacer cambios en caso de error
            return $e->getMessage();
        }
    }
    

    function delete_tarifa_on_db($ID_TARIFA){
        try {
            $row['VIGENCIA_TARIFA'] = NULO;
            $this->db->where('ID_TARIFA', $ID_TARIFA);
            $this->db->update('tarifa', $row);
            return $this->db->affected_rows();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function check_tarifa($name){
        try {
            $this->db->select("*");
            $this->db->from('tarifa');
            $this->db->where('NOMBRE_TARIFA', $name);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    
    //Usuarios
    function get_all_valid_users() {
        try {
            $this->db->select("*");
            $this->db->from("usuario as u");
            $this->db->join('rol as r','u.id_rol= r.id_rol');
            $this->db->where('VIGENCIA_USUARIO', VIGENTE);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    function get_all_valid_roles() {
        try {
            $this->db->select("*");
            $this->db->from('rol');
            $this->db->where('VIGENCIA_ROL', VIGENTE);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    function add_new_user_on_db($row) {
        try {
            $this->db->insert('usuario', $row);
            return $this->db->insert_id();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    function disable_user_on_db($ID_USUARIO) {
        try {
            $data['VIGENCIA_USUARIO'] = NULO;
            $this->db->where('ID_USUARIO', $ID_USUARIO);
            $this->db->update('usuario', $data);
            return $this->db->affected_rows();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    function get_user_by_id($ID_USUARIO) {
        try {
            $this->db->select("*");
            $this->db->from('usuario');
            $this->db->where('ID_USUARIO', $ID_USUARIO);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    function edit_user_on_db($row,$id_usuario) {
        try {
            $this->db->where('ID_USUARIO',$id_usuario);
            $this->db->update('usuario', $row);
            return $this->db->affected_rows();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    //Membresias
    function get_all_valid_membresias() {
        try {     
            $this->db->select("*");
            $this->db->from("membresia");
            $this->db->where('VIGENCIA_MEMBRESIA', VIGENTE);     
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    function check_membresia($name){
        try {
            $this->db->select("*");
            $this->db->from('membresia');
            $this->db->where('NOMBRE_MEMBRESIA', $name);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    function add_new_membresia_on_db($row){
        try {
            $this->db->insert('membresia', $row);
            return $this->db->insert_id();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    function get_membresia_by_id($id_membresia) {
        try {     
            $this->db->select("*");
            $this->db->from("membresia");
            $this->db->where('ID_MEMBRESIA', $id_membresia);     
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    function edit_membresia_on_db($row,$id_membresia) {
        try {
            $this->db->where('ID_MEMBRESIA',$id_membresia);
            $this->db->update('membresia', $row);
            return $this->db->affected_rows();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    function delete_membresia_on_db($ID_MEMBRESIA){
        try {
            $data['VIGENCIA_MEMBRESIA'] = NULO;
            $this->db->where('ID_MEMBRESIA', $ID_MEMBRESIA);
            $this->db->update('membresia', $data);
            return $this->db->affected_rows();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    //Perfiles
    function get_all_valid_perfiles() {
        try {     
            $this->db->select("*");
            $this->db->from("perfil");
            $this->db->where('VIGENCIA_PERFIL', VIGENTE);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    function get_all_valid_casas() {
        try {     
            $this->db->select("*");
            $this->db->from("casas as c");
            $this->db->join("membresia as m", "m.ID_MEMBRESIA=c.ID_MEMBRESIA");
            $this->db->order_by("NOMBRE_CASA",'ASC');
            $this->db->where('c.VIGENCIA_CASA', VIGENTE);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function get_all_valid_sangre() {
        try {     
            $this->db->select("*");
            $this->db->from("sangre");
            $this->db->where('vigencia_sangre', VIGENTE);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    function check_perfil($name){
        try {
            $this->db->select("*");
            $this->db->from('perfil');
            $this->db->where('NOMBRE_PERFIL', $name);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    function add_new_perfil_on_db($row){
        try {
            $this->db->insert('perfil', $row);
            return $this->db->insert_id();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    function get_perfil_by_id($id_perfil) {
        try {     
            $this->db->select("*");
            $this->db->from("perfil");
            $this->db->where('ID_PERFIL', $id_perfil);     
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    function edit_perfil_on_db($row,$id_perfil) {
        try {
            $this->db->where('ID_PERFIL',$id_perfil);
            $this->db->update('perfil', $row);
            return $this->db->affected_rows();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    function delete_perfil_on_db($ID_PERFIL){
        try {
            $data['VIGENCIA_PERFIL'] = NULO;
            $this->db->where('ID_PERFIL', $ID_PERFIL);
            $this->db->update('perfil', $data);
            return $this->db->affected_rows();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    function check_house($name){
        try {
            $this->db->select("*");
            $this->db->from('casas');
            $this->db->where('NOMBRE_CASA', $name);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    function add_new_house_on_db($row){
        try {
            $this->db->insert('casas', $row);
            return $this->db->insert_id();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    function edit_house_on_db($row, $house_id){
        try {
            $this->db->where('ID_CASA',$house_id);
            $this->db->update('casas', $row);
            return $this->db->affected_rows();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function delete_casa_on_db($ID_CASA){
        try {
            $row['VIGENCIA_CASA'] = NULO;
            $this->db->where('ID_CASA', $ID_CASA);
            $this->db->update('casas', $row);
            return $this->db->affected_rows();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
