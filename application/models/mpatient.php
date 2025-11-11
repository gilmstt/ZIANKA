<?php

class Mpatient extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_all_valid_patients()
    {
        try {
            $this->db->select("*");
            $this->db->from('paciente as P');
            $this->db->join('sexo as S', 'S.ID_SEXO = P.ID_SEXO');
            $this->db->where('P.ACTIVO_PACIENTE', ACTIVO);
            $this->db->order_by('P.ID_PACIENTE', 'DESC');
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function get_all_valid_sex()
    {
        try {
            $this->db->select("*");
            $this->db->from('sexo');
            $this->db->order_by('ID_SEXO', 'ASC');
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function get_all_valid_sangre()
    {
        try {
            $this->db->select("*");
            $this->db->from('sangre');
            $this->db->order_by('id_sangre', 'ASC');
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function get_all_tarifas()
    {
        try {
            return $this->db->get('tarifa')->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    // ADD NEW PATIENT */
    function add_new_patient_on_db()
    {
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
                'ID_SEXO' => intval($this->input->post("RG_ID_SEXO")),
                'FECHA_NAC_PACIENTE' => $fnac,
                'ESTADO_CIVIL_PACIENTE' => trim($this->input->post("RG_ESTADO_CIVIL_PACIENTE")),
                'RELIGION_PACIENTE' => trim($this->input->post("RG_RELIGION_PACIENTE")),
                'OCUPACION_PACIENTE' => trim($this->input->post("RG_OCUPACION_PACIENTE")),
                'CALLE_PACIENTE' => trim($this->input->post("RG_CALLE_PACIENTE")),
                'NUMERO_PACIENTE' => trim($this->input->post("RG_NUMERO_PACIENTE")),
                'COLONIA_PACIENTE' => trim($this->input->post("RG_COLONIA_PACIENTE")),
                'EMAIL_PACIENTE' => trim($this->input->post("RG_EMAIL_PACIENTE")),
                'TELEFONO_PACIENTE' => trim($this->input->post("RG_TELEFONO_PACIENTE")),
                'TELEFONO_URGENCIA' => trim($this->input->post("RG_TELEFONO_URGENCIA")),
                'ID_SANGRE' => intval($this->input->post("RG_ID_TIPO_SANGRE")),
                "EXPOSICION_SOLAR" => $this->input->post('EXPOSICION_SOLAR') !== false ? (int)$this->input->post('EXPOSICION_SOLAR') : null,
                "TIEMPO_EXPOSICION_SOLAR" => $this->input->post('TIEMPO_EXPOSICION_SOLAR'),
                "USO_PROTECCION_SOLAR" => $this->input->post('USO_PROTECTOR_SOLAR') !== false ? (int)$this->input->post('USO_PROTECTOR_SOLAR') : null,
                "MARCA_PROTECTOR_SOLAR" => $this->input->post('MARCA_PROTECTOR_SOLAR'),
                "FPS_PROTECTOR_SOLAR" => $this->input->post('FPS_PROTECTOR_SOLAR'),
                'ACTIVO_PACIENTE' => ACTIVO,

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
                'ID_TARIFA' => $id_tarifa, // regresar a id_tarifa
                'ID_MEMBRESIA' => $id_mempre,
                'ID_PERFIL_MEMBRESIA' => $tp_membre,
                'ID_CASA' => $id_casa,
                'FECHA_REGISTRO' => date('Y-m-d H:i:s'),
            );

            //            If exist true
            if (count($exist) > 0) {
                return false;
            } else {
                $this->db->insert('paciente', $data);
                $id_patient = $this->db->insert_id();
                $Antecedentes = array(
                    'ID_PACIENTE' => $id_patient,
                    'DIABETES_MADRE' => $this->input->post("DIABETES_MADRE") ? 1 : null,
                    'HIPERTENSION_MADRE' => $this->input->post("HIPERTENSION_MADRE") ? 1 : null,
                    'ENF_AUTOINMUNES_MADRE' => $this->input->post("ENF_AUTOINMUNES_MADRE") ? 1 : null,
                    'CANCER_MADRE' => $this->input->post("CANCER_MADRE") ? 1 : null,
                    'DIABETES_PADRE' => $this->input->post("DIABETES_PADRE") ? 1 : null,
                    'HIPERTENSION_PADRE' => $this->input->post("HIPERTENSION_PADRE") ? 1 : null,
                    'ENF_AUTOINMUNES_PADRE' => $this->input->post("ENF_AUTOINMUNES_PADRE") ? 1 : null,
                    'CANCER_PADRE' => $this->input->post("CANCER_PADRE") ? 1 : null,
                    'DIABETES_HERMANOS' => $this->input->post("DIABETES_HERMANOS") ? 1 : null,
                    'HIPERTENSION_HERMANOS' => $this->input->post("HIPERTENSION_HERMANOS") ? 1 : null,
                    'ENF_AUTOINMUNES_HERMANOS' => $this->input->post("ENF_AUTOINMUNES_HERMANOS") ? 1 : null,
                    'CANCER_HERMANOS' => $this->input->post("CANCER_HERMANOS") ? 1 : null,
                    'OTROS_HEREDOFAMILIARES' => trim($this->input->post("OTROS_HEREDOFAMILIARES")),

                    'DIABETES_MELLITUS' => $this->input->post('DIABETES_MELLITUS') !== false ? (int)$this->input->post('DIABETES_MELLITUS') : null,
                    'TIEMPO_EVOLUCION_DIABETES' => trim($this->input->post("TIEMPO_EVOLUCION_DIABETES")),
                    'HIPERTENSION_ARTERIAL' => $this->input->post('HIPERTENSION_ARTERIAL') !== false ? (int)$this->input->post('HIPERTENSION_ARTERIAL') : null,
                    'TIEMPO_EVOLUCION_HIPERTENSION' => trim($this->input->post("TIEMPO_EVOLUCION_HIPERTENSION")),
                    'ENFERMEDADES_ENDOCRINOLOGICAS' => $this->input->post("ENFERMEDADES_ENDOCRINOLOGICAS") !== false ? (int)$this->input->post("ENFERMEDADES_ENDOCRINOLOGICAS") : null,
                    'ENFERMEDADES_PSIQUIATRICAS' => $this->input->post("ENFERMEDADES_PSIQUIATRICAS") !== false ? (int)$this->input->post("ENFERMEDADES_PSIQUIATRICAS") : null,
                    'TIEMPO_EVOLUCION_ENFERMEDADES_PSIQUIATRICAS' => trim($this->input->post("TIEMPO_EVOLUCION_ENFERMEDADES_PSIQUIATRICAS")),
                    'ENFERMEDADES_AUTOINMUNES' => $this->input->post("ENFERMEDADES_AUTOINMUNES") !== false ? (int)$this->input->post("ENFERMEDADES_AUTOINMUNES") : null,
                    'TIEMPO_EVOLUCION_ENFERMEDADES_AUTOINMUNES' => trim($this->input->post("TIEMPO_EVOLUCION_ENFERMEDADES_AUTOINMUNES")),
                    'VIH' => $this->input->post("VIH") !== false ? (int)$this->input->post("VIH") : null,
                    'TIEMPO_EVOLUCION_VIH' => trim($this->input->post("TIEMPO_EVOLUCION_VIH")),
                    'HERPES_LABIAL' => $this->input->post("HERPES_LABIAL") !== false ? (int)$this->input->post("HERPES_LABIAL") : null,
                    'TIEMPO_EVOLUCION_HERPES_LABIAL' => trim($this->input->post("TIEMPO_EVOLUCION_HERPES_LABIAL")),
                    'TRANSFUSIONES_SANGUINEAS' => $this->input->post("TRANSFUSIONES_SANGUINEAS") !== false ? (int)$this->input->post("TRANSFUSIONES_SANGUINEAS") : null,
                    'TIEMPO_EVOLUCION_TRANSFUSIONES_SANGUINEAS' => trim($this->input->post("TIEMPO_EVOLUCION_TRANSFUSIONES_SANGUINEAS")),
                    'FRACTURAS' => $this->input->post('FRACTURAS') !== false ? (int)$this->input->post('FRACTURAS') : null,
                    'TIEMPO_EVOLUCION_FRACTURAS' => trim($this->input->post('TIEMPO_EVOLUCION_FRACTURAS')),
                    'HOSPITALIZACIONES' => $this->input->post('HOSPITALIZACIONES') !== false ? (int)$this->input->post('HOSPITALIZACIONES') : null,
                    'TIEMPO_EVOLUCION_HOSPITALIZACIONES' => trim($this->input->post('TIEMPO_EVOLUCION_HOSPITALIZACIONES')),
                    'CIRUGIAS_PREVIAS' => $this->input->post('CIRUGIAS_PREVIAS') !== false ? (int)$this->input->post('CIRUGIAS_PREVIAS') : null,
                    'TIEMPO_EVOLUCION_CIRUGIAS_PREVIAS' => trim($this->input->post('TIEMPO_EVOLUCION_CIRUGIAS_PREVIAS')),
                    'HEPATITIS' => $this->input->post('HEPATITIS') !== false ? (int)$this->input->post('HEPATITIS') : null,
                    'TIEMPO_EVOLUCION_HEPATITIS' => trim($this->input->post('TIEMPO_EVOLUCION_HEPATITIS')),
                    'CANCER' => $this->input->post('CANCER') !== false ? (int)$this->input->post('CANCER') : null,
                    'TIEMPO_EVOLUCION_CANCER' => trim($this->input->post('TIEMPO_EVOLUCION_CANCER')),
                    'EPILEPSIA' => $this->input->post('EPILEPSIA') !== false ? (int)$this->input->post('EPILEPSIA') : null,
                    'TIEMPO_EVOLUCION_EPILEPSIA' => trim($this->input->post('TIEMPO_EVOLUCION_EPILEPSIA')),
                    'ALERGIAS' => $this->input->post('ALERGIAS') !== false ? (int)$this->input->post('ALERGIAS') : null,
                    'TIEMPO_EVOLUCION_ALERGIAS' => trim($this->input->post('TIEMPO_EVOLUCION_ALERGIAS')),
                    'OTROS_PATOLOGICO' => trim($this->input->post('OTROS_PATOLOGICO')),
                    'FUMA' => $this->input->post('FUMA') !== false ? (int)$this->input->post('FUMA') : null,
                    'FUMA_CUANTOS' => trim($this->input->post('FUMA_CUANTOS')),
                    'ADICCIONES' => $this->input->post('ADICCIONES') !== false ? (int)$this->input->post('ADICCIONES') : null,
                    'ESPECIFIQUE_ADICCIONES' => trim($this->input->post('ESPECIFIQUE_ADICCIONES')),
                    'BEBE_ALCOHOL' => $this->input->post('BEBE_ALCOHOL') !== false ? (int)$this->input->post('BEBE_ALCOHOL') : null,
                    'ESPECIFIQUE_ALCOHOL' => trim($this->input->post('ESPECIFIQUE_ALCOHOL')),
                    'FOBIA' => $this->input->post('FOBIA') !== false ? (int)$this->input->post('FOBIA') : null,
                    'DESMAYOS' => $this->input->post('DESMAYOS') !== false ? (int)$this->input->post('DESMAYOS') : null,
                    'ASPIRINA' => $this->input->post('ASPIRINA') !== false ?  (int)$this->input->post('ASPIRINA') : null,
                    'MORETES' => $this->input->post('MORETES') !== false ? (int)$this->input->post('MORETES') : null,
                    'BRONCEADO' => $this->input->post('BRONCEADO') !== false ? (int)$this->input->post('BRONCEADO') : null, 
                    'ANESTESIA' => $this->input->post('ANESTESIA') !== false ? (int)$this->input->post('ANESTESIA') : null,
                    'PROBLEMA_ANESTESIA' => $this->input->post('PROBLEMA_ANESTESIA') !== false ? (int)$this->input->post('PROBLEMA_ANESTESIA') : null,
                    'ESPECIFIQUE_PROBLEMA_ANESTESIA' => trim($this->input->post('ESPECIFIQUE_PROBLEMA_ANESTESIA')),
                    'INMUNIZACION' => $this->input->post('INMUNIZACION') !== false ? (int)$this->input->post('INMUNIZACION') : null,
                    'ESPECIFIQUE_INMUNIZACION' => trim($this->input->post('ESPECIFIQUE_INMUNIZACION')),
                    'INFECCION_PIEL' => $this->input->post('INFECCION_PIEL') !== false ? (int)$this->input->post('INFECCION_PIEL') : null,
                    'ESPECIFIQUE_INFECCION_PIEL' => trim($this->input->post('ESPECIFIQUE_INFECCION_PIEL')),
                    'ESTEROIDES' => $this->input->post('ESTEROIDES') !== false ? (int)$this->input->post('ESTEROIDES') : null,
                    'ESPECIFIQUE_ESTEROIDES' => trim($this->input->post('ESPECIFIQUE_ESTEROIDES')),
                    'EJERCICIO' => $this->input->post('EJERCICIO') !== false ? (int)$this->input->post('EJERCICIO') : null,
                    'ESPECIFIQUE_EJERCICIO' => trim($this->input->post('ESPECIFIQUE_EJERCICIO')),
                    'DIETA' => $this->input->post('DIETA') !== false ? (int)$this->input->post('DIETA') : null,
                    'ESPECIFIQUE_DIETA' => trim($this->input->post('ESPECIFIQUE_DIETA')),
                    'ACTUALMENTE_EMBARAZADA' => $this->input->post('ACTUALMENTE_EMBARAZADA') !== false ? (int)$this->input->post('ACTUALMENTE_EMBARAZADA') : null,

                    'MENARCA' => trim($this->input->post('MENARCA')),
                    'FUM' => trim($this->input->post('FUM')),
                    'RITMO_MENSTRUAL' => trim($this->input->post('RITMO_MENSTRUAL')),
                    'FUP_CESAREA' => trim($this->input->post('FUP_CESAREA')),
                    'G' => trim($this->input->post('G')),
                    'P' => trim($this->input->post('P')),
                    'A' => trim($this->input->post('A')),
                    'C' => trim($this->input->post('C')),
                    'METODO_ANTICONCEPTIVO' => trim($this->input->post('METODO_ANTICONCEPTIVO')),
                );
                $this->db->insert('antecedentes', $Antecedentes);

                return $id_patient;
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    // ROW INFO PATIENT
    function get_patient_by_id($ID_PATIENT)
    {
        try {
            $this->db->select("*");
            $this->db->from('paciente');
            $this->db->join('antecedentes', 'paciente.ID_PACIENTE = antecedentes.ID_PACIENTE', 'left');
            $this->db->where('paciente.ID_PACIENTE', $ID_PATIENT);
            $query = $this->db->get();
            return $query->row();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function getAntecedentesByPatientdId($patient_id)
    {
        try {
            $antecedentes = $this->db->get_where('antecedentes', array('ID_PACIENTE' => $patient_id))->row();
            return $antecedentes;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    // UPDATE PATIENT
    function edit_patient_on_db($row)
    {
        try {
            $tarifa = intval($this->input->post("RG_ID_TARIFA"));
            $perfil = intval($this->input->post("RG_ID_PERFIL_MEMBRESIA"));

            if ($tarifa) {
                $id_tarifa = $tarifa;
                $id_mempre = NULL;
                $tp_membre = NULL;
            } else {
                $id_tarifa = NULL;
                $tp_membre = $perfil;
            }

            $data = array(
                'NOMBRE_PACIENTE' => trim($row['NOMBRE_PACIENTE']),
                'APELLIDO_PATERNO_PACIENTE' => trim($row['APELLIDO_PATERNO_PACIENTE']),
                'APELLIDO_MATERNO_PACIENTE' => trim($row['APELLIDO_MATERNO_PACIENTE']),
                'ID_SEXO' => intval($row['ID_SEXO']),
                'FECHA_NAC_PACIENTE' => convierte_fecha_valida_db($row['FECHA_NAC_PACIENTE']),
                'ESTADO_CIVIL_PACIENTE' => trim($row['ESTADO_CIVIL_PACIENTE']),
                'RELIGION_PACIENTE' => trim($row['RELIGION_PACIENTE']),
                'OCUPACION_PACIENTE' => trim($row['OCUPACION_PACIENTE']),
                'CALLE_PACIENTE' => trim($row['CALLE_PACIENTE']),
                'NUMERO_PACIENTE' => trim($row['NUMERO_PACIENTE']),
                'COLONIA_PACIENTE' => trim($row['COLONIA_PACIENTE']),
                'EMAIL_PACIENTE' => trim($row['EMAIL_PACIENTE']),
                'TELEFONO_PACIENTE' => trim($row['TELEFONO_PACIENTE']),
                'TELEFONO_URGENCIA' => trim($row['TELEFONO_URGENCIA']),
                'ID_SANGRE' => intval($row['ID_SANGRE']),
                "EXPOSICION_SOLAR" => $this->input->post('EXPOSICION_SOLAR') !== false ? (int)$this->input->post('EXPOSICION_SOLAR') : null,
                "TIEMPO_EXPOSICION_SOLAR" => trim($row['TIEMPO_EXPOSICION_SOLAR']),
                "USO_PROTECCION_SOLAR" =>$this->input->post('USO_PROTECCION_SOLAR') !== false ? (int)$this->input->post('USO_PROTECCION_SOLAR') : null,
                "MARCA_PROTECTOR_SOLAR" => trim($row['MARCA_PROTECTOR_SOLAR']),
                "FPS_PROTECTOR_SOLAR" => trim($row['FPS_PROTECTOR_SOLAR']),
                'MUNICIPIO_PACIENTE' => trim($row['MUNICIPIO_PACIENTE']),
                'ESTADO_REPUBLICA' => trim($row['ESTADO_REPUBLICA']),
                'RESIDENCIA' => trim($row['RESIDENCIA']),
                'NOMBRE_MADRE_PACIENTE' => trim($row['NOMBRE_MADRE_PACIENTE']),
                'APELLIDO_MADRE_PATERNO_PACIENTE' => trim($row['APELLIDO_MADRE_PATERNO_PACIENTE']),
                'APELLIDO_MADRE_MATERNO_PACIENTE' => trim($row['APELLIDO_MADRE_MATERNO_PACIENTE']),
                'TELEFONO_MADRE_PACIENTE' => trim($row['TELEFONO_MADRE_PACIENTE']),
                'NOMBRE_PADRE_PACIENTE' => trim($row['NOMBRE_PADRE_PACIENTE']),
                'APELLIDO_PADRE_PATERNO_PACIENTE' => trim($row['APELLIDO_PADRE_PATERNO_PACIENTE']),
                'APELLIDO_PADRE_MATERNO_PACIENTE' => trim($row['APELLIDO_PADRE_MATERNO_PACIENTE']),
                'TELEFONO_PADRE_PACIENTE' => trim($row['TELEFONO_PADRE_PACIENTE']),
                'ID_TARIFA' => $id_tarifa,
                'ID_PERFIL_MEMBRESIA' => $perfil,
                'ID_CASA' =>  intval($row["ID_CASA"]),
            );var_dump($data);


            // Actualizar tabla paciente
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
    function disable_patient_on_db($ID_PATIENT)
    {
        try {
            $data = array(
                'ACTIVO_PACIENTE' => 0
            );
            $this->db->where('ID_PACIENTE', $ID_PATIENT);
            $this->db->update('paciente', $data);
            return $this->db->affected_rows();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    // MODAL ADJUNTAR ARCHIVO
    function delete_file_by_id($ID_DOCUMENTO)
    {
        try {

            $this->db->where('ID_DOCUMENTO', $ID_DOCUMENTO);
            $this->db->delete('documento_paciente');
            return $this->db->affected_rows();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function get_files_patient_on_db($ID_PATIENT)
    {
        try {
            $this->db->where('D.ID_PACIENTE', $ID_PATIENT);
            $this->db->from('documento_paciente AS D');
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function insert_file_by_patient_id($ROW)
    {
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
    function make_query()
    {
        $order_column = array("ID_PACIENTE", NULL, "NOMBRE_PACIENTE", "APELLIDO_PATERNO_PACIENTE", "APELLIDO_MATERNO_PACIENTE", "CALLE_PACIENTE",  "FECHA_NAC_PACIENTE");

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
            $this->db->or_like("FECHA_NAC_PACIENTE", $search_value);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($order_column[$_POST["order"]['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by("ID_PACIENTE", "DESC");
        }
    }


    function make_datatables()
    {
        $this->make_query();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST["length"], $_POST["start"]);
        }
        $query = $this->db->get()->result_array();
        return $query;
    }

    function get_all_data()
    {
        $this->db->select("*");
        $this->db->where('ACTIVO_PACIENTE', ACTIVO);
        $this->db->from("paciente");
        /* $this->db->get('urgencias')->num_rows(); */
        return $this->db->count_all_results();
    }

    function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_patients()
    {
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
            $sub_array[] = mb_strtoupper($row['NOMBRE_PACIENTE'] . " " . $row['APELLIDO_PATERNO_PACIENTE'] . " " . $row['APELLIDO_MATERNO_PACIENTE']);
            $sub_array[] = mb_strtoupper($row['CALLE_PACIENTE'] . " " . $row['NUMERO_PACIENTE'] . ", " . $row['COLONIA_PACIENTE']);
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
