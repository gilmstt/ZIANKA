<?php

class Mpatient extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_all_valid_patients() {
        try {
            $this->db->select("*");
            $this->db->from('paciente as P');
            $this->db->join('sexo as S', 'S.ID_SEXO = P.ID_SEXO');
            $this->db->where('P.ACTIVO_PACIENTE', ACTIVO);
            $this->db->order_by('P.ID_PACIENTE', 'DESC');
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function get_all_valid_sex() {
        try {
            $this->db->select("*");
            $this->db->from('sexo');
            $this->db->order_by('ID_SEXO', 'ASC');
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function get_all_tarifas() {
        try {
            return $this->db->get('tarifa')->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    // ADD NEW PATIENT */
    function add_new_patient_on_db() {
        try {
            //Inputs name
            $tarifa = intval($this->input->post("RG_ID_TARIFA"));
            $membre = intval($this->input->post("RG_ID_MEMBRESIA"));
            $perfil = intval($this->input->post("RG_ID_PERFIL_MEMBRESIA"));
            $id_casa = intval($this->input->post("RG_ID_CASA"));
            $nombre = trim($this->input->post("RG_NOMBRE_PACIENTE"));
            $apep = trim($this->input->post("RG_APELLIDO_PATERNO_PACIENTE"));
            $fnac = convierte_fecha_valida_db($this->input->post("RG_FECHA_NAC_PACIENTE"));
//            Validate if exist
            $this->db->where('NOMBRE_PACIENTE', $nombre);
            $this->db->where('FECHA_NAC_PACIENTE', $fnac);
            $this->db->where('APELLIDO_PATERNO_PACIENTE', $apep);
            $this->db->where('ACTIVO_PACIENTE', ACTIVO);
            $exist = $this->db->get('paciente')->row();

//            Setting values if exists
            if ($tarifa) {
                $id_tarifa = $tarifa;
                $id_mempre = NULL;
                $tp_membre = NULL;
                $id_casa = NULL;
            } else {
                $id_tarifa = NULL;
                $id_mempre = $membre;
                $tp_membre = $perfil;
                $id_casa = $id_casa;
            }
            //Array info patient
            $data = array(
                'NOMBRE_PACIENTE' => $nombre,
                'APELLIDO_PATERNO_PACIENTE' => $apep,
                'APELLIDO_MATERNO_PACIENTE' => trim($this->input->post("RG_APELLIDO_MATERNO_PACIENTE")),
                'FECHA_NAC_PACIENTE' => $fnac,
                'TELEFONO_PACIENTE' => trim($this->input->post("RG_TELEFONO_PACIENTE")),
                'TELEFONO_URGENCIA' => trim($this->input->post("RG_TELEFONO_URGENCIA")),
                'EMAIL_PACIENTE' => trim($this->input->post("RG_EMAIL_PACIENTE")),
                'CALLE_PACIENTE' => trim($this->input->post("RG_CALLE_PACIENTE")),
                'NUMERO_PACIENTE' => trim($this->input->post("RG_NUMERO_PACIENTE")),
                'COLONIA_PACIENTE' => trim($this->input->post("RG_COLONIA_PACIENTE")),
                'MUNICIPIO_PACIENTE' => trim($this->input->post("RG_MUNICIPIO_PACIENTE")),
                'ESTADO_REPUBLICA' => trim($this->input->post("RG_ESTADO_REPUBLICA")),
                'LUGAR_NACIMIENTO' => trim($this->input->post("RG_LUGAR_NACIMIENTO")),
                'RESIDENCIA' => trim($this->input->post("RG_RESIDENCIA")),
                'NOMBRE_MADRE_PACIENTE' => trim($this->input->post("RG_NOMBRE_MADRE_PACIENTE")),
                'APELLIDO_MADRE_PATERNO_PACIENTE' => trim($this->input->post("RG_APELLIDO_MADRE_PATERNO_PACIENTE")),
                'APELLIDO_MADRE_MATERNO_PACIENTE' => trim($this->input->post("RG_APELLIDO_MADRE_MATERNO_PACIENTE")),
                'TELEFONO_MADRE_PACIENTE' => trim($this->input->post("RG_TELEFONO_MADRE_PACIENTE")),
                'NOMBRE_PADRE_PACIENTE' => trim($this->input->post("RG_NOMBRE_PADRE_PACIENTE")),
                'APELLIDO_PADRE_PATERNO_PACIENTE' => trim($this->input->post("RG_APELLIDO_PADRE_PATERNO_PACIENTE")),
                'APELLIDO_PADRE_MATERNO_PACIENTE' => trim($this->input->post("RG_APELLIDO_PADRE_MATERNO_PACIENTE")),
                'TELEFONO_PADRE_PACIENTE' => trim($this->input->post("RG_TELEFONO_PADRE_PACIENTE")),
                'ID_SEXO' => intval($this->input->post("RG_ID_SEXO")),
                'ID_TARIFA' => $id_tarifa, // regresar a id_tarifa
                'ID_MEMBRESIA' => $id_mempre,
                'ID_PERFIL_MEMBRESIA' => $tp_membre,
                'ID_CASA' => $id_casa,
                'ACTIVO_PACIENTE' => ACTIVO,
            );

//            If exist true
            if (count($exist) > 0) {
                return false;
            } else {
                $this->db->insert('paciente', $data);
                $id_patient = $this->db->insert_id();
                $Antecedentes = array(
                    'ID_PACIENTE' => $id_patient,
                    'PATOLOGICO' => trim($this->input->post('PATOLOGICO')),
                    'NO_PATOLOGICO' => trim($this->input->post('NO_PATOLOGICO')),
                    'HEREDO_FAMILIARES' => trim($this->input->post('HEREDO_FAMILIARES')),
                    'QUIRURGICOS' => trim($this->input->post('QUIRURGICOS')),
                    'OBSTETRICOS' => trim($this->input->post('OBSTETRICOS')),
                    'ALERGIAS' => trim($this->input->post('ALERGIAS')),
                    'MEDICAMENTOS' => trim($this->input->post('MEDICAMENTOS')),
                    'PRENATALES' => trim($this->input->post('PRENATALES')),
                    'PERINATALES' => trim($this->input->post('PERINATALES')),
                    'POSNATALES' => trim($this->input->post('POSNATALES')),
                );
                $this->db->insert('antecedentes', $Antecedentes);

                return $id_patient;
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    // ROW INFO PATIENT
    function get_patient_by_id($ID_PATIENT) {
        try {
            $this->db->select("*");
            $this->db->from('paciente');
            $this->db->where('ID_PACIENTE', $ID_PATIENT);
            $query = $this->db->get();
            return $query->row();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }
    
    function getAntecedentesByPatientdId($patient_id) {
        try {
            $antecedentes = $this->db->get_where('antecedentes', array('ID_PACIENTE' => $patient_id))->row();
            return $antecedentes;
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    // UPDATE PATIENT
    function edit_patient_on_db($row) {

        try {
            $tarifa = intval($this->input->post("RG_ID_TARIFA"));
            $membre = intval($this->input->post("RG_ID_MEMBRESIA"));
            $perfil = intval($this->input->post("RG_ID_PERFIL_MEMBRESIA"));
            
            if ($tarifa) {
                $id_tarifa = $tarifa;
                $id_mempre = NULL;
                $tp_membre = NULL;
            } else {
                $id_tarifa = NULL;
                $id_mempre = $membre;
                $tp_membre = $perfil;
            }

            $data = array(
                'ID_PACIENTE' => trim($row['ID_PACIENTE']),
                'NOMBRE_PACIENTE' => trim($row['NOMBRE_PACIENTE']),
                'APELLIDO_PATERNO_PACIENTE' => trim($row['APELLIDO_PATERNO_PACIENTE']),
                'APELLIDO_MATERNO_PACIENTE' => trim($row['APELLIDO_MATERNO_PACIENTE']),
                'TELEFONO_PACIENTE' => trim($row['TELEFONO_PACIENTE']),
                'TELEFONO_URGENCIA' => trim($row['TELEFONO_URGENCIA']),
                'EMAIL_PACIENTE' => trim($row['EMAIL_PACIENTE']),
                'CALLE_PACIENTE' => trim($row['CALLE_PACIENTE']),
                'NUMERO_PACIENTE' => trim($row['NUMERO_PACIENTE']),
                'COLONIA_PACIENTE' => trim($row['COLONIA_PACIENTE']),
                'MUNICIPIO_PACIENTE' => trim($row['MUNICIPIO_PACIENTE']),
                'ESTADO_REPUBLICA' => trim($row['ESTADO_REPUBLICA']),
                'FECHA_NAC_PACIENTE' => trim($row['FECHA_NAC_PACIENTE']),
                'LUGAR_NACIMIENTO' => trim($row['LUGAR_NACIMIENTO']),
                'RESIDENCIA' => trim($row['RESIDENCIA']),
                'NOMBRE_MADRE_PACIENTE' => trim($row['NOMBRE_MADRE_PACIENTE']),
                'APELLIDO_MADRE_PATERNO_PACIENTE' => trim($row['APELLIDO_MADRE_PATERNO_PACIENTE']),
                'APELLIDO_MADRE_MATERNO_PACIENTE' => trim($row['APELLIDO_MADRE_MATERNO_PACIENTE']),
                'TELEFONO_MADRE_PACIENTE' => trim($row['TELEFONO_MADRE_PACIENTE']),
                'NOMBRE_PADRE_PACIENTE' => trim($row['NOMBRE_PADRE_PACIENTE']),
                'APELLIDO_PADRE_PATERNO_PACIENTE' => trim($row['APELLIDO_PADRE_PATERNO_PACIENTE']),
                'APELLIDO_PADRE_MATERNO_PACIENTE' => trim($row['APELLIDO_PADRE_MATERNO_PACIENTE']),
                'TELEFONO_PADRE_PACIENTE' => trim($row['TELEFONO_PADRE_PACIENTE']),
                'ID_CASA' =>  intval($row["ID_CASA"]),
                'ID_SEXO' => trim($row['ID_SEXO']),
                'ID_TARIFA' => $tarifa,
                'ID_MEMBRESIA' => $membre,
                'ID_PERFIL_MEMBRESIA' => $perfil,
            );

            $this->db->where('ID_PACIENTE', $row['ID_PACIENTE']);
            $this->db->update('paciente', $data);  
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // DISABLED PATIENT
    function disable_patient_on_db($ID_PATIENT) {
        try {
            $data = array(
                'ACTIVO_PACIENTE' => 0
            );
            $this->db->where('ID_PACIENTE', $ID_PATIENT);
            $this->db->update('paciente', $data);
            return $this->db->affected_rows();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }
    // MODAL ADJUNTAR ARCHIVO
    function delete_file_by_id($ID_DOCUMENTO) {
        try {

            $this->db->where('ID_DOCUMENTO', $ID_DOCUMENTO);
            $this->db->delete('documento_paciente');
            return $this->db->affected_rows();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function get_files_patient_on_db($ID_PATIENT) {
        try {
            $this->db->where('D.ID_PACIENTE', $ID_PATIENT);
            $this->db->from('documento_paciente AS D');
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function insert_file_by_patient_id($ROW) {
        try {
            $data = array(
                //'ID_MEMBRESIA' => $row['ID_MEMBRESIA'],
                'ID_PACIENTE' => intval($ROW['ID_PACIENTE']),
                'TIPO_DOCUMENTO' => trim($ROW['TIPO_DOCUMENTO']),
                'NOMBRE_DOCUMENTO' => $ROW['NOMBRE_DOCUMENTO'],
                'FECHA_CREACION_DOCUMENTO' => date("Y-m-d H:i:s")
            );
            $this->db->insert('documento_paciente', $data);
            return $this->db->insert_id();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // SERVERSIDE PATIENT //
    function make_query() {
        $order_column = array("ID_PACIENTE", NULL, "NOMBRE_PACIENTE", "APELLIDO_PATERNO_PACIENTE", "APELLIDO_MATERNO_PACIENTE", "CALLE_PACIENTE", "ESTADO_REPUBLICA", NULL, "FECHA_NAC_PACIENTE", "ID_SEXO");
        
        $this->db->select("P.*");
        $this->db->from('paciente as P');
        $this->db->where('P.ACTIVO_PACIENTE', ACTIVO);
    
        if (!empty($_POST["search"]["value"])) {
            $search_value = $_POST["search"]["value"];
            
            $this->db->like("CONCAT(P.NOMBRE_PACIENTE, ' ', `P`.`APELLIDO_PATERNO_PACIENTE`, ' ', `P`.APELLIDO_MATERNO_PACIENTE)", $search_value);
            $this->db->or_like("ID_PACIENTE", $search_value);
            $this->db->or_like("CALLE_PACIENTE", $search_value);
            $this->db->or_like("NUMERO_PACIENTE", $search_value);
            $this->db->or_like("COLONIA_PACIENTE", $search_value);
            $this->db->or_like("MUNICIPIO_PACIENTE", $search_value);
            $this->db->or_like("FECHA_NAC_PACIENTE", $search_value);
        }
    
        if (isset($_POST["order"])) {
            $this->db->order_by($order_column[$_POST["order"]['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by("ID_PACIENTE", "DESC");
        }
    }
    

    function make_datatables() {
        $this->make_query();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST["length"], $_POST["start"]);
        }
        $query = $this->db->get()->result_array();
        return $query;
    }

    function get_all_data() {
        $this->db->select("*");
        $this->db->where('ACTIVO_PACIENTE', ACTIVO);
        $this->db->from("paciente");
        /* $this->db->get('urgencias')->num_rows(); */
        return $this->db->count_all_results();
    }

    function get_filtered_data() {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_patients() {
        $fetch_data = $this->mpatient->make_datatables();
        $total_patients = $this->mpatient->get_all_data();
        $filtered_patients = $this->mpatient->get_filtered_data();

        $data = array();
        foreach ($fetch_data as $row) {
            $actions = "
         <a class='btn btn-defaultx' href='" . base_url() . "Consult/nueva_consulta/" . $row['ID_PACIENTE'] . "'
            data-original-title='Crear consulta'
            data-toggle='tooltip'>															
            <i	class='fas fa-file-signature fa-x'></i>
         </a>

         <button id='btnEditPatient' class='btn btn-defaultz btn-edit-patient'
            data-original-title='Editar paciente'
            data-toggle='tooltip'
            data-id-patient='" . $row['ID_PACIENTE'] . "'><i class='fa fa-user-edit fa-x'></i>
         </button>

        <span title='Adjuntar archivo' data-toggle='tooltip' data-placement='top'>
          <button id='BTN_ADJUNTAR_ARCHIVOP' href='#modAddFiles' class='btn btn-defaultx'
            data-toggle='modal'
            data-id_patient='" . $row['ID_PACIENTE'] . "'>
            <i class='fas fa-file fa-x' aria-hidden='true'></i>
          </button>
        </span> 

         <button id='btnDeletePatient' class='btn btn-defaultz btn-delete-patient'           
            data-id-patient='" . $row['ID_PACIENTE'] . "'
            data-original-title='Eliminar paciente'
            data-toggle='tooltip'>
            <i class='fa fa-trash fa-x'></i>
         </button>";

            $sub_array = array();

            $sub_array[] = mb_strtoupper($row['ID_PACIENTE']);
            $sub_array[] = $actions;
            $sub_array[] = mb_strtoupper($row['NOMBRE_PACIENTE']." ".$row['APELLIDO_PATERNO_PACIENTE']." ".$row['APELLIDO_MATERNO_PACIENTE']);
            $sub_array[] = mb_strtoupper($row['CALLE_PACIENTE'] . " " . $row['NUMERO_PACIENTE'] . ", " . $row['COLONIA_PACIENTE']);
            $sub_array[] = mb_strtoupper($row['MUNICIPIO_PACIENTE']);
            $sub_array[] = mb_strtoupper($row['ESTADO_REPUBLICA']);
            $sub_array[] = calcula_edad($row['FECHA_NAC_PACIENTE']);
            //$sub_array[] = mb_strtoupper($row['NOMBRE_SEXO']);


            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" => $total_patients,
            "recordsFiltered" => $filtered_patients,
            "data" => $data
        );
        return $output;
    }

}
