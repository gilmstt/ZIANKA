<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Patient extends CI_Controller {

    /**
     * @var mpatient
     * @var mconfig
     */
    public $mpatient;
    public $mconfig;

    public function __construct() {
        parent::__construct();

        $this->load->model('mpatient');
        $this->load->model('mconfig');
        $this->load->helper('functions');
        $this->load->helper('general');
    }

    public function index() {
        if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
            $data = getActive("classPat");
            $this->load->view('esqueleton/header', $data);
            $this->load->view('Patient/v_index_patient');
            $this->load->view('esqueleton/footer');
        } else {
            redirect('login/salir');
        }
    }

    public function ajax_get_patients() {
        if ($this->input->is_ajax_request()) {
            $Patients = $this->mpatient->get_patients();

            echo json_encode($Patients);
        } else {
            redirect('index');
        }
    }

    public function form_add_patient() {
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

    public function ajax_add_patient() {
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

    public function ficha_consumo($id) {
        $data = getActive("classPat");
        $this->load->view('esqueleton/header', $data);
        $data['row_user'] = $this->mpatient->get_patient_by_id($id);
        $this->load->view('Patient/v_new_ficha', $data);
        $this->load->view('esqueleton/footer');
    }

    /*     * ****EDIT COMPANY****** */

    public function form_edit_patient($PARAM) {
        if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
            $ID_PATIENT = intval($PARAM);
            if ($ID_PATIENT > NULO) {
                $ROW_PATIENT = $this->mpatient->get_patient_by_id($ID_PATIENT);
                if (count($ROW_PATIENT) > NULO) {
                    //CARGAR LA VISTA..
                    $data = getActive("classPat");
                    $this->load->view('esqueleton/header', $data);
                    $data['ROW_SEX'] = $this->mpatient->get_all_valid_sex();
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

    public function ajax_edit_patient() {
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
            $data['ID_SANGRE'] = trim($this->input->post("RG_ID_TIPO_SANGRE"));
            $data['DIABETES_MADRE'] = $this->input->post("DIABETES_MADRE") ? 1 : 0;
            $data['HIPERTENSION_MADRE'] = $this->input->post("HIPERTENSION_MADRE") ? 1 : 0;
            $data['ENF_AUTOINMUNES_MADRE'] = $this->input->post("ENF_AUTOINMUNES_MADRE") ? 1 : 0;
            $data['CANCER_MADRE'] = $this->input->post("CANCER_MADRE") ? 1 : 0;
            $data['DIABETES_PADRE'] = $this->input->post("DIABETES_PADRE") ? 1 : 0;
            $data['HIPERTENSION_PADRE'] = $this->input->post("HIPERTENSION_PADRE") ? 1 : 0;
            $data['ENF_AUTOINMUNES_PADRE'] = $this->input->post("ENF_AUTOINMUNES_PADRE") ? 1 : 0;
            $data['CANCER_PADRE'] = $this->input->post("CANCER_PADRE") ? 1 : 0;
            $data['DIABETES_HERMANOS'] = $this->input->post("DIABETES_HERMANOS") ? 1 : 0;
            $data['HIPERTENSION_HERMANOS'] = $this->input->post("HIPERTENSION_HERMANOS") ? 1 : 0;
            $data['ENF_AUTOINMUNES_HERMANOS'] = $this->input->post("ENF_AUTOINMUNES_HERMANOS") ? 1 : 0;
            $data['CANCER_HERMANOS'] = $this->input->post("CANCER_HERMANOS") ? 1 : 0;
            $data['OTROS_HEREDOFAMILIARES'] = trim($this->input->post("OTROS_HEREDOFAMILIARES"));
            $data['DIABETES_MELLITUS'] = $this->input->post('DIABETES_MELLITUS') ? 1 : 0;
            $data['TIEMPO_EVOLUCION_DIABETES'] = trim($this->input->post('TIEMPO_EVOLUCION_DIABETES'));
            $data['HIPERTENSION_ARTERIAL'] = $this->input->post('HIPERTENSION_ARTERIAL') ? 1 : 0;
            $data['TIEMPO_EVOLUCION_HIPERTENSION'] = trim($this->input->post('TIEMPO_EVOLUCION_HIPERTENSION'));
            $data['ENFERMEDADES_ENDOCRINOLOGICAS'] = $this->input->post('ENFERMEDADES_ENDOCRINOLOGICAS') ? 1 : 0;
            $data['TIEMPO_EVOLUCION_ENFERMEDADES_ENDOCRINOLOGICAS'] = trim($this->input->post('TIEMPO_EVOLUCION_ENFERMEDADES_ENDOCRINOLOGICAS'));
            $data['ENFERMEDADES_PSIQUIATRICAS'] = $this->input->post('ENFERMEDADES_PSIQUIATRICAS') ? 1 : 0;
            $data['TIEMPO_EVOLUCION_ENFERMEDADES_PSIQUIATRICAS'] = trim($this->input->post('TIEMPO_EVOLUCION_ENFERMEDADES_PSIQUIATRICAS'));
            $data['ENFERMEDADES_AUTOINMUNES'] = $this->input->post('ENFERMEDADES_AUTOINMUNES') ? 1 : 0;
            $data['TIEMPO_EVOLUCION_ENFERMEDADES_AUTOINMUNES'] = trim($this->input->post('TIEMPO_EVOLUCION_ENFERMEDADES_AUTOINMUNES'));
            $data['VIH'] = $this->input->post('VIH') ? 1 : 0;
            $data['TIEMPO_EVOLUCION_VIH'] = trim($this->input->post('TIEMPO_EVOLUCION_VIH'));
            $data['HERPES_LABIAL'] = $this->input->post('HERPES_LABIAL') ? 1 : 0;
            $data['TIEMPO_EVOLUCION_HERPES_LABIAL'] = trim($this->input->post('TIEMPO_EVOLUCION_HERPES_LABIAL'));
            $data['TRANSFUSIONES_SANGUINEAS'] = $this->input->post('TRANSFUSIONES_SANGUINEAS') ? 1 : 0;
            $data['TIEMPO_EVOLUCION_TRANSFUSIONES_SANGUINEAS'] = trim($this->input->post('TIEMPO_EVOLUCION_TRANSFUSIONES_SANGUINEAS'));
            $data['FRACTURAS'] = $this->input->post('FRACTURAS') ? 1 : 0;
            $data['TIEMPO_EVOLUCION_FRACTURAS'] = trim($this->input->post('TIEMPO_EVOLUCION_FRACTURAS'));
            $data['HOSPITALIZACIONES'] = $this->input->post('HOSPITALIZACIONES') ? 1 : 0;
            $data['TIEMPO_EVOLUCION_HOSPITALIZACIONES'] = trim($this->input->post('TIEMPO_EVOLUCION_HOSPITALIZACIONES'));
            $data['CIRUGIAS_PREVIAS'] = $this->input->post('CIRUGIAS_PREVIAS') ? 1 : 0;
            $data['TIEMPO_EVOLUCION_CIRUGIAS_PREVIAS'] = trim($this->input->post('TIEMPO_EVOLUCION_CIRUGIAS_PREVIAS'));
            $data['HEPATITIS'] = $this->input->post('HEPATITIS') ? 1 : 0;
            $data['TIEMPO_EVOLUCION_HEPATITIS'] = trim($this->input->post('TIEMPO_EVOLUCION_HEPATITIS'));
            $data['CANCER'] = $this->input->post('CANCER') ? 1 : 0;
            $data['TIEMPO_EVOLUCION_CANCER'] = trim($this->input->post('TIEMPO_EVOLUCION_CANCER'));
            $data['EPILEPSIA'] = $this->input->post('EPILEPSIA') ? 1 : 0;
            $data['TIEMPO_EVOLUCION_EPILEPSIA'] = trim($this->input->post('TIEMPO_EVOLUCION_EPILEPSIA'));
            $data['ALERGIAS'] = $this->input->post('ALERGIAS') ? 1 : 0;
            $data['TIEMPO_EVOLUCION_ALERGIAS'] = trim($this->input->post('TIEMPO_EVOLUCION_ALERGIAS'));
            $data['OTROS_PATOLOGICO'] = trim($this->input->post('OTROS_PATOLOGICO'));
            $data['FUMA'] = $this->input->post('FUMA') ? 1 : 0;
            $data['FUMA_CUANTOS'] = trim($this->input->post('FUMA_CUANTOS'));
            $data['ADICCIONES'] = $this->input->post('ADICCIONES') ? 1 : 0;
            $data['ESPECIFIQUE_ADICCIONES'] = trim($this->input->post('ESPECIFIQUE_ADICCIONES'));
            $data['BEBE_ALCOHOL'] = $this->input->post('BEBE_ALCOHOL') ? 1 : 0;
            $data['ESPECIFIQUE_ALCOHOL'] = trim($this->input->post('ESPECIFIQUE_ALCOHOL'));
            $data['FOBIA'] = $this->input->post('FOBIA') ? 1 : 0;
            $data['DESMAYOS'] = $this->input->post('DESMAYOS') ? 1 : 0;
            $data['ASPIRINA'] = $this->input->post('ASPIRINA') ? 1 : 0;
            $data['MORETES'] = $this->input->post('MORETES') ? 1 : 0;
            $data['BRONCEADO'] = $this->input->post('BRONCEADO') ? 1 : 0;
            $data['ANESTESIA'] = $this->input->post('ANESTESIA') ? 1 : 0;
            $data['PROBLEMA_ANESTESIA'] = $this->input->post('PROBLEMA_ANESTESIA') ? 1 : 0;
            $data['ESPECIFIQUE_PROBLEMA_ANESTESIA'] = trim($this->input->post('ESPECIFIQUE_PROBLEMA_AN Gif ESIA'));
            $data['INMUNIZACION'] = $this->input->post('INMUNIZACION') ? 1 : 0;
            $data['ESPECIFIQUE_INMUNIZACION'] = trim($this->input->post('ESPECIFIQUE_INMUNIZACION'));
            $data['INFECCION_PIEL'] = $this->input->post('INFECCION_PIEL') ? 1 : 0;
            $data['ESPECIFIQUE_INFECCION_PIEL'] = trim($this->input->post('ESPECIFIQUE_INFECCION_PIEL'));
            $data['ESTEROIDES'] = $this->input->post('ESTEROIDES') ? 1 : 0;
            $data['ESPECIFIQUE_ESTEROIDES'] = trim($this->input->post('ESPECIFIQUE_ESTEROIDES'));
            $data['EJERCICIO'] = $this->input->post('EJERCICIO') ? 1 : 0;
            $data['ESPECIFIQUE_EJERCICIO'] = trim($this->input->post('ESPECIFIQUE_EJERCICIO'));
            $data['DIETA'] = $this->input->post('DIETA') ? 1 : 0;
            $data['ESPECIFIQUE_DIETA'] = trim($this->input->post('ESPECIFIQUE_DIETA'));
            $data['ACTUALMENTE_EMBARAZADA'] = $this->input->post('ACTUALMENTE_EMBARAZADA') ? 1 : 0;

            $data['MENARCA'] = trim($this->input->post('MENARCA'));
            $data['FUM'] = trim($this->input->post('FUM'));
            $data['RITMO_MENSTRUAL'] = trim($this->input->post('RITMO_MENSTRUAL'));
            $data['FUP_CESAREA'] = trim($this->input->post('FUP_CESAREA'));
            $data['G'] = trim($this->input->post('G'));
            $data['P'] = trim($this->input->post('P'));
            $data['A'] = trim($this->input->post('A'));
            $data['C'] = trim($this->input->post('C'));
            $data['METODO_ANTICONCEPTIVO'] = trim($this->input->post('METODO_ANTICONCEPTIVO'));



            
            $data['MUNICIPIO_PACIENTE'] = trim($this->input->post("RG_MUNICIPIO_PATIENT"));
            $data['ESTADO_REPUBLICA'] = trim($this->input->post("RG_ESTADO_REPUBLICAP"));
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

    function ajax_disable_patient() {
        if ($this->input->is_ajax_request()) {
            $ID_PATIENT = $this->input->post('ID_PATIENT');
            $AFFECTED_ROWS = $this->mpatient->disable_patient_on_db($ID_PATIENT);
            echo $AFFECTED_ROWS;
        } else {
            redirect('patient');
        }
    }

    // MODAL ADJUNTAR ARCHIVO
    public function ajax_get_files_patient() {
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

    public function ajax_delete_file_by_id() {
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

    public function ajax_subir_archivo() {
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
