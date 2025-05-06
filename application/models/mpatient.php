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
            return $e->getMessage();
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
            return $e->getMessage();
        }
    }

    function get_all_tarifas()
    {
        try {
            return $this->db->get('tarifa')->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
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
                'DIABETES_MADRE' => $this->input->post("DIABETES_MADRE") ? 1 : 0,
                'HIPERTENSION_MADRE' => $this->input->post("HIPERTENSION_MADRE") ? 1 : 0,
                'ENF_AUTOINMUNES_MADRE' => $this->input->post("ENF_AUTOINMUNES_MADRE") ? 1 : 0,
                'CANCER_MADRE' => $this->input->post("CANCER_MADRE") ? 1 : 0,
                'DIABETES_PADRE' => $this->input->post("DIABETES_PADRE") ? 1 : 0,
                'HIPERTENSION_PADRE' => $this->input->post("HIPERTENSION_PADRE") ? 1 : 0,
                'ENF_AUTOINMUNES_PADRE' => $this->input->post("ENF_AUTOINMUNES_PADRE") ? 1 : 0,
                'CANCER_PADRE' => $this->input->post("CANCER_PADRE") ? 1 : 0,
                'DIABETES_HERMANOS' => $this->input->post("DIABETES_HERMANOS") ? 1 : 0,
                'HIPERTENSION_HERMANOS' => $this->input->post("HIPERTENSION_HERMANOS") ? 1 : 0,
                'ENF_AUTOINMUNES_HERMANOS' => $this->input->post("ENF_AUTOINMUNES_HERMANOS") ? 1 : 0,
                'CANCER_HERMANOS' => $this->input->post("CANCER_HERMANOS") ? 1 : 0,
                'OTROS_HEREDOFAMILIARES' => trim($this->input->post("OTROS_HEREDOFAMILIARES")),
                'DIABETES_MELLITUS_SI' => $this->input->post("DIABETES_MELLITUS_SI") ? 1 : 0,
                'DIABETES_MELLITUS_NO' => $this->input->post("DIABETES_MELLITUS_NO") ? 1 : 0,
                'TIEMPO_EVOLUCION_DIABETES' => trim($this->input->post("TIEMPO_EVOLUCION_DIABETES")),
                'HIPERTENSION_ARTERIAL_SI' => $this->input->post("HIPERTENSION_ARTERIAL_SI") ? 1 : 0,
                'HIPERTENSION_ARTERIAL_NO' => $this->input->post("HIPERTENSION_ARTERIAL_NO") ? 1 : 0,
                'TIEMPO_EVOLUCION_HIPERTENSION' => trim($this->input->post("TIEMPO_EVOLUCION_HIPERTENSION")),
                'ENFERMEDADES_ENDOCRINOLOGICAS_SI' => $this->input->post("ENFERMEDADES_ENDOCRINOLOGICAS_SI") ? 1 : 0,
                'ENFERMEDADES_ENDOCRINOLOGICAS_NO' => $this->input->post("ENFERMEDADES_ENDOCRINOLOGICAS_NO") ? 1 : 0,
                'TIEMPO_EVOLUCION_ENFERMEDADES_ENDOCRINOLOGICAS' => trim($this->input->post("TIEMPO_EVOLUCION_ENFERMEDADES_ENDOCRINOLOGICAS")),
                'ENFERMEDADES_PSIQUIATRICAS_SI' => $this->input->post("ENFERMEDADES_PSIQUIATRICAS_SI") ? 1 : 0,
                'ENFERMEDADES_PSIQUIATRICAS_NO' => $this->input->post("ENFERMEDADES_PSIQUIATRICAS_NO") ? 1 : 0,
                'TIEMPO_EVOLUCION_ENFERMEDADES_PSIQUIATRICAS' => trim($this->input->post("TIEMPO_EVOLUCION_ENFERMEDADES_PSIQUIATRICAS")),
                'ENFERMEDADES_AUTOINMUNES_SI' => $this->input->post("ENFERMEDADES_AUTOINMUNES_SI") ? 1 : 0,
                'ENFERMEDADES_AUTOINMUNES_NO' => $this->input->post("ENFERMEDADES_AUTOINMUNES_NO") ? 1 : 0,
                'TIEMPO_EVOLUCION_ENFERMEDADES_AUTOINMUNES' => trim($this->input->post("TIEMPO_EVOLUCION_ENFERMEDADES_AUTOINMUNES")),
                'VIH_SI' => $this->input->post("VIH_SI") ? 1 : 0,
                'VIH_NO' => $this->input->post("VIH_NO") ? 1 : 0,
                'TIEMPO_EVOLUCION_VIH' => trim($this->input->post("TIEMPO_EVOLUCION_VIH")),
                'HERPES_LABIAL_SI' => $this->input->post("HERPES_LABIAL_SI") ? 1 : 0,
                'HERPES_LABIAL_NO' => $this->input->post("HERPES_LABIAL_NO") ? 1 : 0,
                'TIEMPO_EVOLUCION_HERPES_LABIAL' => trim($this->input->post("TIEMPO_EVOLUCION_HERPES_LABIAL")),
                'TRANSFUSIONES_SANGUINEAS_SI' => $this->input->post("TRANSFUSIONES_SANGUINEAS_SI") ? 1 : 0,
                'TRANSFUSIONES_SANGUINEAS_NO' => $this->input->post("TRANSFUSIONES_SANGUINEAS_NO") ? 1 : 0,
                'TIEMPO_EVOLUCION_TRANSFUSIONES_SANGUINEAS' => trim($this->input->post("TIEMPO_EVOLUCION_TRANSFUSIONES_SANGUINEAS")),
                'FRACTURAS_SI' => $this->input->post('FRACTURAS_SI') ? 1 : 0,
                'FRACTURAS_NO' => $this->input->post('FRACTURAS_NO') ? 1 : 0,
                'TIEMPO_EVOLUCION_FRACTURAS' => trim($this->input->post('TIEMPO_EVOLUCION_FRACTURAS')),
                'HOSPITALIZACIONES_SI' => $this->input->post('HOSPITALIZACIONES_SI') ? 1 : 0,
                'HOSPITALIZACIONES_NO' => $this->input->post('HOSPITALIZACIONES_NO') ? 1 : 0,
                'TIEMPO_EVOLUCION_HOSPITALIZACIONES' => trim($this->input->post('TIEMPO_EVOLUCION_HOSPITALIZACIONES')),
                'CIRUGIAS_PREVIAS_SI' => $this->input->post('CIRUGIAS_PREVIAS_SI') ? 1 : 0,
                'CIRUGIAS_PREVIAS_NO' => $this->input->post('CIRUGIAS_PREVIAS_NO') ? 1 : 0,
                'TIEMPO_EVOLUCION_CIRUGIAS_PREVIAS' => trim($this->input->post('TIEMPO_EVOLUCION_CIRUGIAS_PREVIAS')),
                'HEPATITIS_SI' => $this->input->post('HEPATITIS_SI') ? 1 : 0,
                'HEPATITIS_NO' => $this->input->post('HEPATITIS_NO') ? 1 : 0,
                'TIEMPO_EVOLUCION_HEPATITIS' => trim($this->input->post('TIEMPO_EVOLUCION_HEPATITIS')),
                'CANCER_SI' => $this->input->post('CANCER_SI') ? 1 : 0,
                'CANCER_NO' => $this->input->post('CANCER_NO') ? 1 : 0,
                'TIEMPO_EVOLUCION_CANCER' => trim($this->input->post('TIEMPO_EVOLUCION_CANCER')),
                'EPILEPSIA_SI' => $this->input->post('EPILEPSIA_SI') ? 1 : 0,
                'EPILEPSIA_NO' => $this->input->post('EPILEPSIA_NO') ? 1 : 0,
                'TIEMPO_EVOLUCION_EPILEPSIA' => trim($this->input->post('TIEMPO_EVOLUCION_EPILEPSIA')),
                'ALERGIAS_SI' => $this->input->post('ALERGIAS_SI') ? 1 : 0,
                'ALERGIAS_NO' => $this->input->post('ALERGIAS_NO') ? 1 : 0,
                'TIEMPO_EVOLUCION_ALERGIAS' => trim($this->input->post('TIEMPO_EVOLUCION_ALERGIAS')),
                'OTROS_PATOLOGICO' => trim($this->input->post('OTROS_PATOLOGICO')),
                'FUMA_SI' => $this->input->post('FUMA_SI') ? 1 : 0,
                'FUMA_NO' => $this->input->post('FUMA_NO') ? 1 : 0,
                'FUMA_CUANTOS' => trim($this->input->post('FUMA_CUANTOS')),
                'ADICCIONES_SI' => $this->input->post('ADICCIONES_SI') ? 1 : 0,
                'ADICCIONES_NO' => $this->input->post('ADICCIONES_NO') ? 1 : 0,
                'ESPECIFIQUE_ADICCIONES' => trim($this->input->post('ESPECIFIQUE_ADICCIONES')),
                'BEBE_ALCOHOL_SI' => $this->input->post('BEBE_ALCOHOL_SI') ? 1 : 0,
                'BEBE_ALCOHOL_NO' => $this->input->post('BEBE_ALCOHOL_NO') ? 1 : 0,
                'ESPECIFIQUE_ALCOHOL' => trim($this->input->post('ESPECIFIQUE_ALCOHOL')),
                'FOBIA_SI' => $this->input->post('FOBIA_SI') ? 1 : 0,
                'FOBIA_NO' => $this->input->post('FOBIA_NO') ? 1 : 0,
                'DESMAYOS_SI' => $this->input->post('DESMAYOS_SI') ? 1 : 0,
                'DESMAYOS_NO' => $this->input->post('DESMAYOS_NO') ? 1 : 0,
                'ASPIRINA_SI' => $this->input->post('ASPIRINA_SI') ? 1 : 0,
                'ASPIRINA_NO' => $this->input->post('ASPIRINA_NO') ? 1 : 0,
                'MORETES_SI' => $this->input->post('MORETES_SI') ? 1 : 0,
                'MORETES_NO' => $this->input->post('MORETES_NO') ? 1 : 0,
                'BRONCEADO_SI' => $this->input->post('BRONCEADO_SI') ? 1 : 0,
                'BRONCEADO_NO' => $this->input->post('BRONCEADO_NO') ? 1 : 0,
                'ANESTESIA_SI' => $this->input->post('ANESTESIA_SI') ? 1 : 0,
                'ANESTESIA_NO' => $this->input->post('ANESTESIA_NO') ? 1 : 0,
                'PROBLEMA_ANESTESIA_SI' => $this->input->post('PROBLEMA_ANESTESIA_SI') ? 1 : 0,
                'PROBLEMA_ANESTESIA_NO' => $this->input->post('PROBLEMA_ANESTESIA_NO') ? 1 : 0,
                'ESPECIFIQUE_PROBLEMA_ANESTESIA' => trim($this->input->post('ESPECIFIQUE_PROBLEMA_ANESTESIA')),
                'INMUNIZACION_SI' => $this->input->post('INMUNIZACION_SI') ? 1 : 0,
                'INMUNIZACION_NO' => $this->input->post('INMUNIZACION_NO') ? 1 : 0,
                'ESPECIFIQUE_INMUNIZACION' => trim($this->input->post('ESPECIFIQUE_INMUNIZACION')),
                'INFECCION_PIEL_SI' => $this->input->post('INFECCION_PIEL_SI') ? 1 : 0,
                'INFECCION_PIEL_NO' => $this->input->post('INFECCION_PIEL_NO') ? 1 : 0,
                'ESPECIFIQUE_INFECCION_PIEL' => trim($this->input->post('ESPECIFIQUE_INFECCION_PIEL')),
                'ESTEROIDES_SI' => $this->input->post('ESTEROIDES_SI') ? 1 : 0,
                'ESTEROIDES_NO' => $this->input->post('ESTEROIDES_NO') ? 1 : 0,
                'ESPECIFIQUE_ESTEROIDES' => trim($this->input->post('ESPECIFIQUE_ESTEROIDES')),
                'EJERCICIO_SI' => $this->input->post('EJERCICIO_SI') ? 1 : 0,
                'EJERCICIO_NO' => $this->input->post('EJERCICIO_NO') ? 1 : 0,
                'ESPECIFIQUE_EJERCICIO' => trim($this->input->post('ESPECIFIQUE_EJERCICIO')),
                'DIETA_SI' => $this->input->post('DIETA_SI') ? 1 : 0,
                'DIETA_NO' => $this->input->post('DIETA_NO') ? 1 : 0,
                'ESPECIFIQUE_DIETA' => trim($this->input->post('ESPECIFIQUE_DIETA')),
                'ACTUALMENTE_EMBARAZADA_SI' => $this->input->post('ACTUALMENTE_EMBARAZADA_SI') ? 1 : 0,
                'ACTUALMENTE_EMBARAZADA_NO' => $this->input->post('ACTUALMENTE_EMBARAZADA_NO') ? 1 : 0,
                'MENARCA' => trim($this->input->post('MENARCA')),
                'FUM' => trim($this->input->post('FUM')),
                'RITMO_MENSTRUAL' => trim($this->input->post('RITMO_MENSTRUAL')),
                'FUP_CESAREA' => trim($this->input->post('FUP_CESAREA')),
                'G' => trim($this->input->post('G')),
                'P' => trim($this->input->post('P')),
                'A' => trim($this->input->post('A')),
                'C' => trim($this->input->post('C')),
                'METODO_ANTICONCEPTIVO' => trim($this->input->post('METODO_ANTICONCEPTIVO')),
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
    function get_patient_by_id($ID_PATIENT)
    {
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

    function getAntecedentesByPatientdId($patient_id)
    {
        try {
            $antecedentes = $this->db->get_where('antecedentes', array('ID_PACIENTE' => $patient_id))->row();
            return $antecedentes;
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    // UPDATE PATIENT
    function edit_patient_on_db($row)
    {

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
            return $e->getMessage();
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
            return $e->getMessage();
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
            return $e->getMessage();
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
