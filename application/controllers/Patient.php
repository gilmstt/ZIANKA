<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Patient extends CI_Controller {

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
            $data['ROW_PATIENTS'] = $this->mpatient->get_all_valid_patients();
            $this->load->view('Patient/v_index_patient', $data);
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
            $data['TELEFONO_PACIENTE'] = trim($this->input->post("RG_TELEFONO_PACIENTE"));
            $data['TELEFONO_URGENCIA'] = trim($this->input->post("RG_TELEFONO_URGENCIA"));
            $data['EMAIL_PACIENTE'] = trim($this->input->post("RG_EMAIL_PACIENTE"));
            $data['CALLE_PACIENTE'] = trim($this->input->post("RG_CALLE_PATIENT"));
            $data['NUMERO_PACIENTE'] = trim($this->input->post("RG_NUMERO_PATIENT"));
            $data['COLONIA_PACIENTE'] = trim($this->input->post("RG_COLONIA_PATIENT"));
            $data['MUNICIPIO_PACIENTE'] = trim($this->input->post("RG_MUNICIPIO_PATIENT"));
            $data['ESTADO_REPUBLICA'] = trim($this->input->post("RG_ESTADO_REPUBLICAP"));
            $data['FECHA_NAC_PACIENTE'] = convierte_fecha_valida_db($this->input->post("RG_FECHA_NAC_PTIENT"));
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
            $data['ID_SEXO'] = intval($this->input->post("RG_ID_SEXOP"));
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
