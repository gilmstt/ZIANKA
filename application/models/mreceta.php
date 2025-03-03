<?php

class Mreceta extends CI_Model {

    function __construct() {
        parent::__construct();
        define("TABLA_RECETA", 'receta');
        define("TABLA_MEDICAMENTO", 'medicamento');
        define("TABLA_INDICACION", 'indicacion');
        define("TABLA_CONSULTA", 'consulta');
        define("TABLA_URGENCIA", 'urgencia');
        define("TABLA_PACIENTE", 'paciente');
        define("TABLA_PRODUCTO", 'producto');
    }

    function ObtenerRecetaConsulta($idConsulta) {
        try {
            $this->db->select("*");
            $this->db->from(TABLA_RECETA . ' as r');
            $this->db->join(TABLA_INDICACION . ' as i', 'i.ID_RECETA = r.ID_RECETA');
            $this->db->join(TABLA_MEDICAMENTO . ' as m', 'm.ID_MEDICAMENTO = i.ID_MEDICAMENTO');
            $this->db->where('r.ID_CONSULTA', $idConsulta);
            $this->db->where('r.VIGENCIA_RECETA', ACTIVO);
            return $this->db->get()->result_array();
        } 
        catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    function ObtenerRecetaUrgencia($idUrgencia) {
        try {
            $this->db->select("*");
            $this->db->from(TABLA_RECETA . ' as r');
            $this->db->join(TABLA_INDICACION . ' as i', 'i.ID_RECETA = r.ID_RECETA');
            $this->db->join(TABLA_MEDICAMENTO . ' as m', 'm.ID_MEDICAMENTO = i.ID_MEDICAMENTO');
            $this->db->where('r.ID_URGENCIA', $idUrgencia);
            $this->db->where('r.VIGENCIA_RECETA', ACTIVO);
            return $this->db->get()->result_array();
        } 
        catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    /*  Obtener un registro     */

    function obtenerReceta($id) {
        try {
            $this->db->select("*");
            $this->db->from(TABLA_RECETA . " as R");
            $this->db->join(TABLA_INDICACION . ' as I', 'I.ID_RECETA = R.ID_RECETA');
            $this->db->join(TABLA_MEDICAMENTO . ' as M', 'M.ID_MEDICAMENTO = I.ID_MEDICAMENTO');
            $this->db->where('R.VIGENCIA_RECETA', ACTIVO);
            $this->db->where('R.ID_RECETA', $id);

            return $this->db->get()->result_array();
        }
        catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    function obtenerMedicamento($id) {
        try {
            $this->db->select("*");
            $this->db->from(TABLA_MEDICAMENTO . " as M");
            $this->db->where('M.VIGENCIA_MEDICAMENTO', ACTIVO);
            $this->db->where('M.ID_MEDICAMENTO', $id);

            return $this->db->get()->result_array();
        }
        catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    function obtenerIndicacion($id) {
        try {
            $this->db->select("*");
            $this->db->from(TABLA_INDICACION . " as I");
            $this->db->join(TABLA_RECETA . ' as R', 'R.ID_RECETA = I.ID_RECETA');
            $this->db->join(TABLA_MEDICAMENTO . ' as M', 'M.ID_MEDICAMENTO = I.ID_MEDICAMENTO');
            $this->db->where('I.VIGENCIA_INDICACION', ACTIVO);
            $this->db->where('I.ID_INDICACION', $id);

            return $this->db->get()->result_array();
        }
        catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    /*  Obtener todos los registros   */

    function obtenerRecetas() {
        try {
            $this->db->select("*");
            $this->db->from(TABLA_RECETA . " as R");
            $this->db->join(TABLA_INDICACION . ' as I', 'I.ID_RECETA = R.ID_RECETA');
            $this->db->join(TABLA_MEDICAMENTO . ' as M', 'M.ID_MEDICAMENTO = I.ID_MEDICAMENTO');
            $this->db->where('R.VIGENCIA_RECETA', ACTIVO);
            $this->db->order_by('R.ID_RECETA', 'DESC');

            return $this->db->get()->result_array();
        }
        catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    function obtenerMedicamentos() {
        try {
            $this->db->select("*");
            $this->db->from(TABLA_MEDICAMENTO . " as M");
            $this->db->where('M.VIGENCIA_MEDICAMENTO', ACTIVO);
            $this->db->order_by('M.ID_MEDICAMENTO', 'DESC');

            return $this->db->get()->result_array();
        }
        catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    function obtenerIndicaciones() {
        try {
            $this->db->select("*");
            $this->db->from(TABLA_INDICACION . " as I");
            $this->db->join(TABLA_RECETA . ' as R', 'R.ID_RECETA = I.ID_RECETA');
            $this->db->join(TABLA_MEDICAMENTO . ' as M', 'M.ID_MEDICAMENTO = I.ID_MEDICAMENTO');
            $this->db->where('I.VIGENCIA_INDICACION', ACTIVO);
            $this->db->order_by('I.ID_INDICACION', 'DESC');

            return $this->db->get()->result_array();
        }
        catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    /*  Guardar     */

    function guardarReceta($receta) {
        try {
            $this->db->insert(TABLA_RECETA, $receta);
            return $this->db->insert_id();
        }
        catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    function guardarMedicamento($medicamento) {
        try {
            $this->db->insert(TABLA_MEDICAMENTO, $medicamento);
            return $this->db->insert_id();
        }
        catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    function guardarIndicacion($indicacion) {
        try {
            $this->db->insert(TABLA_INDICACION, $indicacion);
            return $this->db->insert_id();
        }
        catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    /*  Editar      */
    
  function editarReceta($receta) {
        try {
            $this->db->where('ID_RECETA', $receta['ID_RECETA']);
            $this->db->update(TABLA_RECETA, $receta);
            return ($this->db->affected_rows() > 0);
        }
        catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    function editarMedicamento($medicamento) {
        try {
            $this->db->where('ID_MEDICAMENTO', $medicamento['ID_MEDICAMENTO']);
            $this->db->update(TABLA_MEDICAMENTO, $medicamento);
            return ($this->db->affected_rows() > 0);
        }
        catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    function editarIndicacion($indicacion) {
        try {
            $this->db->where('ID_INDICACION', $indicacion['ID_INDICACION']);
            $this->db->update(TABLA_INDICACION, $indicacion);
            return ($this->db->affected_rows() > 0);
        }
        catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    /*  Borrar (desactivar)     */

    function borrarReceta($receta) {
        try {
            $this->db->set("VIGENCIA_RECETA", 0);
            $this->db->where('ID_RECETA', $receta['ID_RECETA']);
            $this->db->update(TABLA_RECETA, $receta);
            return ($this->db->affected_rows() > 0);
        }
        catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    function borrarMedicamento($medicamento) {
        try {
            $this->db->set("VIGENCIA_MEDICAMENTO", 0);
            $this->db->where('ID_MEDICAMENTO', $medicamento['ID_MEDICAMENTO']);
            $this->db->update(TABLA_MEDICAMENTO, $medicamento);
            return ($this->db->affected_rows() > 0);
        }
        catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    function borrarIndicacion($id) {
        try {
            $this->db->where('ID_INDICACION', $id);
            $this->db->delete(TABLA_INDICACION);
            return ($this->db->affected_rows() > 0);
        }
        catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    /*  Funciones para autocompletar    */

    function obtenerNombres() {
        try {
            $this->db->distinct();
            $this->db->select("NOMBRE");
            $this->db->from(TABLA_MEDICAMENTO);
            $this->db->where("VIGENCIA_MEDICAMENTO", ACTIVO);

            return $this->db->get()->result_array();
        }
        catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    function obtenerNombresComerciales($nombre) {
        try {
            $this->db->distinct();
            $this->db->select("NOMBRE_COMERCIAL");
            $this->db->from(TABLA_MEDICAMENTO);
            $this->db->where("NOMBRE", $nombre);
            $this->db->where("VIGENCIA_MEDICAMENTO", ACTIVO);

            return $this->db->get()->result_array();
        }
        catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    function obtenerFormulas($nombre, $nombreComercial) {
        try {
            $this->db->distinct();
            $this->db->select("FORMULA");
            $this->db->from(TABLA_MEDICAMENTO);
            $this->db->where("NOMBRE", $nombre);
            $this->db->where("NOMBRE_COMERCIAL", $nombreComercial);
            $this->db->where("VIGENCIA_MEDICAMENTO", ACTIVO);

            return $this->db->get()->result_array();
        }
        catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    function buscarMedicamento($nombre, $comercial, $formula) {
        try {
            $this->db->select("ID_MEDICAMENTO");
            $this->db->from(TABLA_MEDICAMENTO);
            $this->db->where("NOMBRE", $nombre);
            $this->db->where("NOMBRE_COMERCIAL", $comercial);
            $this->db->where("FORMULA", $formula);
            $this->db->where("VIGENCIA_MEDICAMENTO", ACTIVO);

            return $this->db->get()->result_array();
        }
        catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
    
    function get_receta_by_id_consult($ID_RECETA) {
        try {
            $this->db->select("*");
            $this->db->from('receta as r');
            $this->db->join('consulta as c', 'c.ID_CONSULTA=r.ID_CONSULTA');
            $this->db->join('usuario as u', 'c.ID_USER=u.ID_USUARIO');
            $this->db->join('indicacion as i', 'r.ID_RECETA=i.ID_RECETA');
            $this->db->join('medicamento as m', 'i.ID_MEDICAMENTO=m.ID_MEDICAMENTO');
            $this->db->join('paciente as p', 'r.ID_PACIENTE=p.ID_PACIENTE');
            $this->db->where('r.ID_RECETA', $ID_RECETA);

            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }
    
}
