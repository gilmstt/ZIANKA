<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Patient extends CI_Controller
{

    /**
     * @var mpatient
     * @var mconfig
     */
    public $mpatient;
    public $mconfig;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('mpatient');
        $this->load->model('mconfig');
        $this->load->helper('functions');
        $this->load->helper('general');
    }

    public function index()
    {
        if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
            $data = getActive("classPat");
            $this->load->view('esqueleton/header', $data);
            $this->load->view('Patient/v_index_patient');
            $this->load->view('esqueleton/footer');
        } else {
            redirect('login/salir');
        }
    }
    public function cargar_tipos_consentimiento()
    {
        $this->db->select('id_tipo_consulta AS id, nombre_tipo_consulta');
        $this->db->from('tipo_consulta');
        $this->db->where('vigencia_tipo_consulta', 1);

        $query = $this->db->get();

        echo json_encode($query->result_array());
    }

    // En application/controllers/Patient.php (o donde tengas cargar_tipos_consentimiento)
    public function cargar_medicos()
    {
        $this->db->select('ID_USUARIO, NOMBRE_USUARIO, APELLIDO_USUARIO');
        $this->db->where('ID_ROL', 4); // ajusta según tu campo de rol
        $this->db->where('VIGENCIA_USUARIO', 1);     // solo activos
        $this->db->order_by('NOMBRE_USUARIO', 'ASC');

        $medicos = $this->db->get('usuario')->result_array();

        // Formato simple para JS
        $response = [];
        foreach ($medicos as $m) {
            $response[] = [
                'id'     => $m['ID_USUARIO'],
                'nombre' => trim($m['NOMBRE_USUARIO'] . ' ' . $m['APELLIDO_USUARIO'])
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function ajax_get_patients()
    {
        if ($this->input->is_ajax_request()) {
            $Patients = $this->mpatient->get_patients();

            echo json_encode($Patients);
        } else {
            redirect('index');
        }
    }

    public function form_add_patient()
    {
        if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
            $data = getActive("classPat");
            $this->load->view('esqueleton/header', $data);
            $data['ROW_SEX'] = $this->mpatient->get_all_valid_sex();
            $data['casas'] = $this->mconfig->get_all_valid_casas();
            $data['tipo_sangre'] = $this->mconfig->get_all_valid_sangre();
            $this->load->view('Patient/v_add_patient', $data);
            $this->load->view('esqueleton/footer');
        } else {
            redirect('login/salir');
        }
    }

    public function ajax_add_patient()
    {
        if ($this->input->is_ajax_request()) {

            $ID_PATIENT = $this->mpatient->add_new_patient_on_db();

            if ($ID_PATIENT > NULO) {
                echo $ID_PATIENT;
            } else {
                echo -1;
            }
        } else {
            redirect('patient');
        }
    }

    public function ficha_consumo($id)
    {
        $data = getActive("classPat");
        $this->load->view('esqueleton/header', $data);
        $data['row_user'] = $this->mpatient->get_patient_by_id($id);
        $this->load->view('Patient/v_new_ficha', $data);
        $this->load->view('esqueleton/footer');
    }

    /*     * ****EDIT COMPANY****** */

    public function form_edit_patient($PARAM)
    {
        if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
            $ID_PATIENT = intval($PARAM);
            if ($ID_PATIENT > NULO) {
                $ROW_PATIENT = $this->mpatient->get_patient_by_id($ID_PATIENT);
                if (!empty($ROW_PATIENT)) {
                    //CARGAR LA VISTA..
                    $data = getActive("classPat");
                    $this->load->view('esqueleton/header', $data);
                    $data['ROW_SEX'] = $this->mpatient->get_all_valid_sex();
                    $data['ROW_SANGRE'] = $this->mpatient->get_all_valid_sangre();
                    $data['casas'] = $this->mconfig->get_all_valid_casas();
                    $data['ROW_DATA_PATIENT'] = $ROW_PATIENT;
                    $data['Antecedentes'] = $this->mpatient->getAntecedentesByPatientdId($ID_PATIENT);
                    $this->load->view('Patient/v_edit_patient', $data);
                    $this->load->view('esqueleton/footer');
                } else {
                    redirect('Patient/v_index_patient');
                }
            } else {
                redirect('Company/v_index_patient');
            }
        } else {
            redirect('login/salir');
        }
    }

    public function ajax_edit_patient()
    {
        if ($this->input->is_ajax_request()) {
            $Antecedentes = array(
                'ID_PACIENTE' => trim($this->input->post('RG_ID_PATIENT')),
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
                'DIABETES_MELLITUS' => $this->input->post("DIABETES_MELLITUS") !== false ? ($this->input->post("DIABETES_MELLITUS") ? 1 : 0) : null,
                'TIEMPO_EVOLUCION_DIABETES' => trim($this->input->post("TIEMPO_EVOLUCION_DIABETES")),
                'HIPERTENSION_ARTERIAL' => $this->input->post("HIPERTENSION_ARTERIAL") !== false ? ($this->input->post("HIPERTENSION_ARTERIAL") ? 1 : 0) : null,
                'TIEMPO_EVOLUCION_HIPERTENSION' => trim($this->input->post("TIEMPO_EVOLUCION_HIPERTENSION")),
                'ENFERMEDADES_ENDOCRINOLOGICAS' => $this->input->post("ENFERMEDADES_ENDOCRINOLOGICAS") !== false ? ($this->input->post("ENFERMEDADES_ENDOCRINOLOGICAS") ? 1 : 0) : null,
                'TIEMPO_EVOLUCION_ENFERMEDADES_ENDOCRINOLOGICAS' => trim($this->input->post("TIEMPO_EVOLUCION_ENFERMEDADES_ENDOCRINOLOGICAS")),
                'ENFERMEDADES_PSIQUIATRICAS' => $this->input->post("ENFERMEDADES_PSIQUIATRICAS") !== false ? ($this->input->post("ENFERMEDADES_PSIQUIATRICAS") ? 1 : 0) : null,
                'TIEMPO_EVOLUCION_ENFERMEDADES_PSIQUIATRICAS' => trim($this->input->post("TIEMPO_EVOLUCION_ENFERMEDADES_PSIQUIATRICAS")),
                'ENFERMEDADES_AUTOINMUNES' => $this->input->post("ENFERMEDADES_AUTOINMUNES") !== false ? ($this->input->post("ENFERMEDADES_AUTOINMUNES") ? 1 : 0) : null,
                'TIEMPO_EVOLUCION_ENFERMEDADES_AUTOINMUNES' => trim($this->input->post("TIEMPO_EVOLUCION_ENFERMEDADES_AUTOINMUNES")),
                'VIH' => $this->input->post("VIH") !== false ? ($this->input->post("VIH") ? 1 : 0) : null,
                'TIEMPO_EVOLUCION_VIH' => trim($this->input->post("TIEMPO_EVOLUCION_VIH")),
                'HERPES_LABIAL' => $this->input->post("HERPES_LABIAL") !== false ? ($this->input->post("HERPES_LABIAL") ? 1 : 0) : null,
                'TIEMPO_EVOLUCION_HERPES_LABIAL' => trim($this->input->post("TIEMPO_EVOLUCION_HERPES_LABIAL")),
                'TRANSFUSIONES_SANGUINEAS' => $this->input->post("TRANSFUSIONES_SANGUINEAS") !== false ? ($this->input->post("TRANSFUSIONES_SANGUINEAS") ? 1 : 0) : null,
                'TIEMPO_EVOLUCION_TRANSFUSIONES_SANGUINEAS' => trim($this->input->post("TIEMPO_EVOLUCION_TRANSFUSIONES_SANGUINEAS")),
                'FRACTURAS' => $this->input->post("FRACTURAS") !== false ? ($this->input->post("FRACTURAS") ? 1 : 0) : null,
                'TIEMPO_EVOLUCION_FRACTURAS' => trim($this->input->post("TIEMPO_EVOLUCION_FRACTURAS")),
                'HOSPITALIZACIONES' => $this->input->post("HOSPITALIZACIONES") !== false ? ($this->input->post("HOSPITALIZACIONES") ? 1 : 0) : null,
                'TIEMPO_EVOLUCION_HOSPITALIZACIONES' => trim($this->input->post("TIEMPO_EVOLUCION_HOSPITALIZACIONES")),
                'CIRUGIAS_PREVIAS' => $this->input->post("CIRUGIAS_PREVIAS") !== false ? ($this->input->post("CIRUGIAS_PREVIAS") ? 1 : 0) : null,
                'TIEMPO_EVOLUCION_CIRUGIAS_PREVIAS' => trim($this->input->post("TIEMPO_EVOLUCION_CIRUGIAS_PREVIAS")),
                'HEPATITIS' => $this->input->post("HEPATITIS") !== false ? ($this->input->post("HEPATITIS") ? 1 : 0) : null,
                'TIEMPO_EVOLUCION_HEPATITIS' => trim($this->input->post("TIEMPO_EVOLUCION_HEPATITIS")),
                'CANCER' => $this->input->post("CANCER") !== false ? ($this->input->post("CANCER") ? 1 : 0) : null,
                'TIEMPO_EVOLUCION_CANCER' => trim($this->input->post("TIEMPO_EVOLUCION_CANCER")),
                'EPILEPSIA' => $this->input->post("EPILEPSIA") !== false ? ($this->input->post("EPILEPSIA") ? 1 : 0) : null,
                'TIEMPO_EVOLUCION_EPILEPSIA' => trim($this->input->post("TIEMPO_EVOLUCION_EPILEPSIA")),
                'ALERGIAS' => $this->input->post("ALERGIAS") !== false ? ($this->input->post("ALERGIAS") ? 1 : 0) : null,
                'TIEMPO_EVOLUCION_ALERGIAS' => trim($this->input->post("TIEMPO_EVOLUCION_ALERGIAS")),
                'OTROS_PATOLOGICO' => trim($this->input->post("OTROS_PATOLOGICO")),
                'FUMA' => $this->input->post("FUMA") !== false ? ($this->input->post("FUMA") ? 1 : 0) : null,
                'FUMA_CUANTOS' => trim($this->input->post("FUMA_CUANTOS")),
                'ADICCIONES' => $this->input->post("ADICCIONES") !== false ? ($this->input->post("ADICCIONES") ? 1 : 0) : null,
                'ESPECIFIQUE_ADICCIONES' => trim($this->input->post("ESPECIFIQUE_ADICCIONES")),
                'BEBE_ALCOHOL' => $this->input->post("BEBE_ALCOHOL") !== false ? ($this->input->post("BEBE_ALCOHOL") ? 1 : 0) : null,
                'ESPECIFIQUE_ALCOHOL' => trim($this->input->post("ESPECIFIQUE_ALCOHOL")),
                'FOBIA' => $this->input->post("FOBIA") !== false ? ($this->input->post("FOBIA") ? 1 : 0) : null,
                'DESMAYOS' => $this->input->post("DESMAYOS") !== false ? ($this->input->post("DESMAYOS") ? 1 : 0) : null,
                'ASPIRINA' => $this->input->post("ASPIRINA") !== false ? ($this->input->post("ASPIRINA") ? 1 : 0) : null,
                'MORETES' => $this->input->post("MORETES") !== false ? ($this->input->post("MORETES") ? 1 : 0) : null,
                'BRONCEADO' => $this->input->post("BRONCEADO") !== false ? ($this->input->post("BRONCEADO") ? 1 : 0) : null,
                'ANESTESIA' => $this->input->post("ANESTESIA") !== false ? ($this->input->post("ANESTESIA") ? 1 : 0) : null,
                'PROBLEMA_ANESTESIA' => $this->input->post("PROBLEMA_ANESTESIA") !== false ? ($this->input->post("PROBLEMA_ANESTESIA") ? 1 : 0) : null,
                'ESPECIFIQUE_PROBLEMA_ANESTESIA' => trim($this->input->post("ESPECIFIQUE_PROBLEMA_ANESTESIA")),
                'INMUNIZACION' => $this->input->post("INMUNIZACION") !== false ? ($this->input->post("INMUNIZACION") ? 1 : 0) : null,
                'ESPECIFIQUE_INMUNIZACION' => trim($this->input->post("ESPECIFIQUE_INMUNIZACION")),
                'INFECCION_PIEL' => $this->input->post("INFECCION_PIEL") !== false ? ($this->input->post("INFECCION_PIEL") ? 1 : 0) : null,
                'ESPECIFIQUE_INFECCION_PIEL' => trim($this->input->post("ESPECIFIQUE_INFECCION_PIEL")),
                'ESTEROIDES' => $this->input->post("ESTEROIDES") !== false ? ($this->input->post("ESTEROIDES") ? 1 : 0) : null,
                'ESPECIFIQUE_ESTEROIDES' => trim($this->input->post("ESPECIFIQUE_ESTEROIDES")),
                'EJERCICIO' => $this->input->post("EJERCICIO") !== false ? ($this->input->post("EJERCICIO") ? 1 : 0) : null,
                'ESPECIFIQUE_EJERCICIO' => trim($this->input->post("ESPECIFIQUE_EJERCICIO")),
                'DIETA' => $this->input->post("DIETA") !== false ? ($this->input->post("DIETA") ? 1 : 0) : null,
                'ESPECIFIQUE_DIETA' => trim($this->input->post("ESPECIFIQUE_DIETA")),
                'ACTUALMENTE_EMBARAZADA' => $this->input->post("ACTUALMENTE_EMBARAZADA") !== false ? ($this->input->post("ACTUALMENTE_EMBARAZADA") ? 1 : 0) : null,
                'MENARCA' => trim($this->input->post("MENARCA")),
                'FUM' => trim($this->input->post("FUM")),
                'RITMO_MENSTRUAL' => trim($this->input->post("RITMO_MENSTRUAL")),
                'FUP_CESAREA' => trim($this->input->post("FUP_CESAREA")),
                'G' => trim($this->input->post("G")),
                'P' => trim($this->input->post("P")),
                'A' => trim($this->input->post("A")),
                'C' => trim($this->input->post("C")),
                'METODO_ANTICONCEPTIVO' => trim($this->input->post("METODO_ANTICONCEPTIVO")),
            );


            $this->db->where('ID_PACIENTE', $this->input->post('RG_ID_PATIENT'));
            $this->db->update('antecedentes', $Antecedentes);

            $data['ID_PACIENTE'] = $this->input->post("RG_ID_PATIENT");
            $data['NOMBRE_PACIENTE'] = trim($this->input->post("RG_NOMBRE_PATIENT"));
            $data['APELLIDO_PATERNO_PACIENTE'] = trim($this->input->post("RG_APELLIDO_PATERNO_PATIENT"));
            $data['APELLIDO_MATERNO_PACIENTE'] = trim($this->input->post("RG_APELLIDO_MATERNO_PATIENT"));
            $data['ID_SEXO'] = intval($this->input->post("RG_ID_SEXOP"));
            $data['FECHA_NAC_PACIENTE'] = convierte_fecha_valida_db($this->input->post("RG_FECHA_NAC_PTIENT"));
            $data['ESTADO_CIVIL_PACIENTE'] = trim($this->input->post("RG_ESTADO_CIVIL_PACIENTE"));
            $data['RELIGION_PACIENTE'] = trim($this->input->post("RG_RELIGION_PACIENTE"));
            $data['OCUPACION_PACIENTE'] = trim($this->input->post("RG_OCUPACION_PACIENTE"));
            $data['CALLE_PACIENTE'] = trim($this->input->post("RG_CALLE_PACIENTE"));
            $data['NUMERO_PACIENTE'] = trim($this->input->post("RG_NUMERO_PACIENTE"));
            $data['COLONIA_PACIENTE'] = trim($this->input->post("RG_COLONIA_PACIENTE"));
            $data['EMAIL_PACIENTE'] = trim($this->input->post("RG_EMAIL_PACIENTE"));
            $data['TELEFONO_PACIENTE'] = trim($this->input->post("RG_TELEFONO_PACIENTE"));
            $data['TELEFONO_URGENCIA'] = trim($this->input->post("RG_TELEFONO_URGENCIA"));
            $data['ID_SANGRE'] = intval($this->input->post("RG_ID_TIPO_SANGRE"));
            $data['EXPOSICION_SOLAR'] = $this->input->post('EXPOSICION_SOLAR') ? 1 : null;
            $data['TIEMPO_EXPOSICION_SOLAR'] = $this->input->post('TIEMPO_EXPOSICION_SOLAR');
            $data['USO_PROTECCION_SOLAR'] = $this->input->post('USO_PROTECTOR_SOLAR') ? 1 : null;
            $data['MARCA_PROTECTOR_SOLAR'] = $this->input->post('MARCA_PROTECTOR_SOLAR');
            $data['FPS_PROTECTOR_SOLAR'] = $this->input->post('FPS_PROTECTOR_SOLAR');

            $data['MUNICIPIO_PACIENTE'] = trim($this->input->post("RG_MUNICIPIO_PACIENTE"));
            $data['ESTADO_REPUBLICA'] = trim($this->input->post("RG_ESTADO_REPUBLICA"));
            $data['RESIDENCIA'] = trim($this->input->post("RG_RESIDENCIA"));
            $data['NOMBRE_MADRE_PACIENTE'] = trim($this->input->post("RG_NOMBRE_MADRE_PACIENTE"));
            $data['APELLIDO_MADRE_PATERNO_PACIENTE'] = trim($this->input->post("RG_APELLIDO_MADRE_PATERNO_PACIENTE"));
            $data['APELLIDO_MADRE_MATERNO_PACIENTE'] = trim($this->input->post("RG_APELLIDO_MADRE_MATERNO_PACIENTE"));
            $data['TELEFONO_MADRE_PACIENTE'] = trim($this->input->post("RG_TELEFONO_MADRE_PACIENTE"));
            $data['NOMBRE_PADRE_PACIENTE'] = trim($this->input->post("RG_NOMBRE_PADRE_PACIENTE"));
            $data['APELLIDO_PADRE_PATERNO_PACIENTE'] = trim($this->input->post("RG_APELLIDO_PADRE_PATERNO_PACIENTE"));
            $data['APELLIDO_PADRE_MATERNO_PACIENTE'] = trim($this->input->post("RG_APELLIDO_PADRE_MATERNO_PACIENTE"));
            $data['TELEFONO_PADRE_PACIENTE'] = trim($this->input->post("RG_TELEFONO_PADRE_PACIENTE"));
            $data['ID_CASA'] = trim($this->input->post("RG_ID_CASA"));
            $data['LUGAR_NACIMIENTO'] = trim($this->input->post("RG_LUGAR_NACIMIENTO"));
            $data['ID_TARIFA'] = intval($this->input->post("RG_ID_TARIFA"));
            $data['ID_MEMBRESIA'] = intval($this->input->post("RG_ID_MEMBRESIA"));

            $this->mpatient->edit_patient_on_db($data);
            echo "success";
        } else {
            redirect('patient');
        }
    }

    function ajax_disable_patient()
    {
        if ($this->input->is_ajax_request()) {
            $ID_PATIENT = $this->input->post('ID_PATIENT');
            $AFFECTED_ROWS = $this->mpatient->disable_patient_on_db($ID_PATIENT);
            echo $AFFECTED_ROWS;
        } else {
            redirect('patient');
        }
    }

    // MODAL ADJUNTAR ARCHIVO
    public function ajax_get_files_patient()
    {
        if ($this->input->is_ajax_request() && !empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
            $ID_PACIENTE = $this->input->post('ID_PACIENTE');
            $FILES_PATIENT = $this->mpatient->get_files_patient_on_db($ID_PACIENTE);
            if (count($FILES_PATIENT) > NULO):
                $this->output->set_content_type("application/json")->set_output(json_encode($FILES_PATIENT));
            else:
                echo null;
            endif;
        } else {
            redirect('login/salir');
        }
    }

    public function ajax_delete_file_by_id()
    {
        if ($this->input->is_ajax_request() && !empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
            $ID_PACIENTE = $this->input->post('ID_PACIENTE');
            $ID_DOCUMENTO = $this->input->post('ID_DOCUMENTO');
            $NOMBRE_DOCUMENTO = $this->input->post('NOMBRE_DOCUMENTO');

            $affected = $this->mpatient->delete_file_by_id($ID_DOCUMENTO);
            if ($affected > NULO):
                //borrar ruta..
                $FULL_PATH = './' . PATH_TO_UPLOAD_FILES . '/' . $NOMBRE_DOCUMENTO;
                unlink($FULL_PATH);
                echo $affected;
            else:
                echo null;
            endif;
        } else {
            show_404();
        }
    }

    public function ajax_subir_archivo()
    {
        if ($this->input->is_ajax_request()) {

            $ID_PACIENTE = $_POST['ID_PACIENTE'];

            if (strlen(trim($_FILES['userfile']['name'])) > NULO) {
                $tmpNombreDir = $ID_PACIENTE . '_FILES' . '/';
                // var_dump(is_dir(PATH_TO_UPLOAD_FILES . '/' . $tmpNombreDir));
                if (!is_dir(PATH_TO_UPLOAD_FILES . '/' . $tmpNombreDir)) {
                    mkdir(PATH_TO_UPLOAD_FILES . '/' . $tmpNombreDir);
                }
                $config['upload_path'] = './' . PATH_TO_UPLOAD_FILES . '/' . $tmpNombreDir;
                $config['allowed_types'] = '*';
                $config['max_size'] = '4000000';
                $config['max_width'] = '6000';
                $config['max_height'] = '3000';
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();

                    echo -2; //no se pudo adjuntar el video..
                    // uploading failed. $error will holds the errors.
                } else {
                    $data = $this->upload->data();
                    $data_aux['NOMBRE_DOCUMENTO'] = $tmpNombreDir . $data['file_name'];
                    $data_aux['TIPO_DOCUMENTO'] = $_FILES['userfile']['type'];
                    $data_aux['ID_PACIENTE'] = $ID_PACIENTE;
                    $INSERT_FILE_PATIENT = $this->mpatient->insert_file_by_patient_id($data_aux);
                    echo $INSERT_FILE_PATIENT;

                    // uploading successfull, now do your further actions
                }
                //} else {
                //  echo -3; //directorio no se pudo crear..
                // }
            } else {
                var_dump('No');
            }
        } else {
            show_404();
        }
    }
}
