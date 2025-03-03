<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Config extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('mconfig');
        $this->load->helper('general');
    }

    public function index($area = "usuarios") {
        if ((!empty($this->session->userdata('CAREYES_ID_USUARIO')))) {
            $data = getActive('classCfg');
            $this->load->view('esqueleton/header', $data);
            $data['ROW_USERS'] = $this->mconfig->get_all_valid_users();
            $data['ROW_TARIFA'] = $this->mconfig->get_all_valid_tarifas();
            $data['ROW_MEMBRESIA'] = $this->mconfig->get_all_valid_membresias();
            $data['ROW_PERFIL'] = $this->mconfig->get_all_valid_perfiles();
            $data['ROW_CASAS'] = $this->mconfig->get_all_valid_casas();

            //Cargar la sección correspondiente
            $data['user_active'] = "";
            $data['user_hidex'] = "hidex";
            $data['user_in_active'] = "";
            $data['tar_active'] = "";
            $data['tar_hidex'] = "hidex";
            $data['tar_in_active'] = "";
            $data['mem_active'] = "";
            $data['mem_hidex'] = "hidex";
            $data['mem_in_active'] = "";
            $data['per_active'] = "";
            $data['per_hidex'] = "hidex";
            $data['per_in_active'] = "";
            $data['cas_active'] = "";
            $data['cas_hidex'] = "hidex";
            $data['cas_in_active'] = "";

            if ($area == "usuarios") {
                $data['user_active'] = 'class="active"';
                $data['user_hidex'] = "";
                $data['user_in_active'] = "in active";
            }
            if ($area == "tarifas") {
                $data['tar_active'] = 'class="active"';
                $data['tar_hidex'] = "";
                $data['tar_in_active'] = "in active";
            }
            if ($area == "membresias") {
                $data['mem_active'] = 'class="active"';
                $data['mem_hidex'] = "";
                $data['mem_in_active'] = "in active";
            }
            if ($area == "perfiles") {
                $data['per_active'] = 'class="active"';
                $data['per_hidex'] = "";
                $data['per_in_active'] = "in active";
            }
            if ($area == "casas") {
                $data['$cas_active'] = 'class="active"';
                $data['cas_hidex'] = "";
                $data['cas_in_active'] = "in active";
            }

            $this->load->view('Config/v_principal_config', $data);
            $this->load->view('esqueleton/footer');
        } else {
            redirect('Login/salir');
        }
    }

    //Usuarios
    public function config_user() {
        if ((!empty($this->session->userdata('CAREYES_ID_USUARIO')))) {
            $data = getActive('classCfg');
            $this->load->view('esqueleton/header', $data);
            $data['ROW_USERS'] = $this->mconfig->get_all_valid_users();
            $this->load->view('Config/v_config_user', $data);
            $this->load->view('esqueleton/footer');
        } else {
            redirect('Login/salir');
        }
    }

    public function form_config_add_user() {
        if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
            $data = getActive("classCfg");
            $data['ROW_AUTORIDAD'] = $this->mconfig->get_all_valid_roles();
            $data['ROW_USERS'] = $this->mconfig->get_all_valid_users();
            $this->load->view('esqueleton/header', $data);
            $this->load->view('Config/v_config_add_user');
            $this->load->view('esqueleton/footer');
        } else {
            redirect('Login/salir');
        }
    }

    public function ajax_add_user() {
        if ($this->input->is_ajax_request()) {
            if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
                $data['NOMBRE_USUARIO'] = $this->input->post("RG_NOMBRE_USUARIO");
                $data['APELLIDO_USUARIO'] = $this->input->post("RG_APELLIDO_USUARIO");
                // $data['EMAIL_USUARIO'] = $this->input->post("RG_EMAIL_USUARIO");
                $data['ID_ROL'] = $this->input->post("RG_ID_AUTORIDAD");
                $data['USERNAME_USUARIO'] = $this->input->post("RG_USERNAME_USUARIO");
                $data['PASSWD_USUARIO'] = $this->input->post("RG_PASSWD_USUARIO");
                $data['VIGENCIA_USUARIO'] = 1;
                $ID_USER = $this->mconfig->add_new_user_on_db($data);
                if ($ID_USER > NULO) {
                    echo $ID_USER;
                } else {
                    echo -1;
                }
            } else {
                //operacion no permitida..
                redirect('Login/salir');
            }
        } else {
            redirect('Login/salir');
        }
    }

    function ajax_disable_user() {
        if ($this->input->is_ajax_request()) {
            $ID_USUARIO = $this->input->post('ID_USUARIO');
            $AFFECTED_ROWS = $this->mconfig->disable_user_on_db($ID_USUARIO);
            echo $AFFECTED_ROWS;
        } else {
            redirect('Config');
        }
    }

    public function form_config_edit_user($PARAM) {
        if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
            $ID_USUARIO = intval($PARAM);
            if ($ID_USUARIO > NULO) {
                $ROW_USUARIO = $this->mconfig->get_user_by_id($ID_USUARIO);

                if (count($ROW_USUARIO) > NULO) {
                    $data = getActive("classCfg");
                    //CARGAR LA VISTA..
                    $data['ROW_AUTORIDAD'] = $this->mconfig->get_all_valid_roles();
                    $data['ROW_DATA_USUARIO'] = $ROW_USUARIO;

                    $this->load->view('esqueleton/header', $data);
                    $this->load->view('Config/v_edit_user');
                    $this->load->view('esqueleton/footer');
                } else {
                    redirect('Config/v_config_user');
                }
            } else {
                redirect('Config/v_config_user');
            }
        } else {
            redirect('Login/salir');
        }
    }

    public function ajax_edit_user() {
        if ($this->input->is_ajax_request()) {
            if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {

                $data['ID_USUARIO'] = $this->input->post("RG_ID_USUARIO");
                $data['NOMBRE_USUARIO'] = $this->input->post("RG_NOMBRE_USUARIO");
                $data['APELLIDO_USUARIO'] = $this->input->post("RG_APELLIDO_USUARIO");
                // $data['EMAIL_USUARIO'] = $this->input->post("RG_EMAIL_USUARIO");
                $data['ID_ROL'] = $this->input->post("RG_ID_AUTORIDAD");
                $data['USERNAME_USUARIO'] = $this->input->post("RG_USERNAME_USUARIO");
                $data['PASSWD_USUARIO'] = $this->input->post("RG_PASSWD_USUARIO");

                $id_usuario = $this->input->post("RG_ID_USUARIO");
                $ID_USER = $this->mconfig->edit_user_on_db($data, $id_usuario);
                if ($ID_USER > NULO) {
                    echo $ID_USER;
                } else {
                    echo -1;
                }
            } else {
                //operacion no permitida..
                redirect('Login/salir');
            }
        } else {
            redirect('Login/salir');
        }
    }

    //Tarifas
    public function config_tarifa() {
        if ((!empty($this->session->userdata('CAREYES_ID_USUARIO')))) {
            $data = getActive('classCfg');
            $this->load->view('esqueleton/header', $data);
            $data['ROW_TARIFA'] = $this->mconfig->get_all_valid_tarifas();
            $this->load->view('Config/v_index_tarifa', $data);
            $this->load->view('esqueleton/footer');
        } else {
            redirect('Login/salir');
        }
    }

    public function ajax_add_tarifa() {
        if ($this->input->is_ajax_request()) {
            if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
                $tarifa = $this->input->post("RG_NOMBRE_TARIFA");
                $data['NOMBRE_TARIFA'] = $this->input->post("RG_NOMBRE_TARIFA");
                $data['PORCENTAJE_TARIFA'] = $this->input->post("RG_PORCENTAJE_TARIFA");
                $data['CONSULTA_TARIFA'] = $this->input->post("RG_ADD_CONSULTA_TARIFA");
                $data['URGENCIA_TARIFA'] = $this->input->post("RG_ADD_URGENCIA_TARIFA");
                $data['VIGENCIA_TARIFA'] = 1;

                $check = $this->mconfig->check_tarifa($tarifa);
                if ($check == NULL) {
                    $ID_TARIFA = $this->mconfig->add_new_tarifa_on_db($data);
                    if ($ID_TARIFA > NULO) {
                        echo $ID_TARIFA;
                    } else {
                        echo -1;
                    }
                }
            } else {
                //operacion no permitida..
                redirect('Login/salir');
            }
        } else {
            redirect('Login/salir');
        }
    }

    public function ajax_edit_tarifa() {
        if ($this->input->is_ajax_request()) {
            if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
                $id_tarifa = $this->input->post("RG_ID_TARIFA");
                $data['NOMBRE_TARIFA'] = $this->input->post("RG_NOMBRE_TARIFA");
                $data['PORCENTAJE_TARIFA'] = $this->input->post("RG_PORCENTAJE_TARIFA");
                $data['CONSULTA_TARIFA'] = $this->input->post("RG_CONSULTA_TARIFA");
                $data['URGENCIA_TARIFA'] = $this->input->post("RG_URGENCIA_TARIFA");
                $ID_TARIFA = $this->mconfig->edit_tarifa_on_db($data, $id_tarifa);
                if ($ID_TARIFA > NULO) {
                    echo $ID_TARIFA;
                } else {
                    echo -1;
                }
            } else {
                //operacion no permitida..
                redirect('Login/salir');
            }
        } else {
            redirect('Login/salir');
        }
    }

    function ajax_delete_tarifa() {
        if ($this->input->is_ajax_request()) {
            $ID_TARIFA = $this->input->post('ID_TARIFA');
            $AFFECTED_ROWS = $this->mconfig->delete_tarifa_on_db($ID_TARIFA);
            echo $AFFECTED_ROWS;
        } else {
            redirect('Config');
        }
    }

    //Membresias
    public function ajax_add_membresia() {
        if ($this->input->is_ajax_request()) {
            if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
                $membresia = $this->input->post("RG_NOMBRE_MEMBRESIA");
                $data['NOMBRE_MEMBRESIA'] = $this->input->post("RG_NOMBRE_MEMBRESIA");
                $data['VIGENCIA_MEMBRESIA'] = VIGENTE;

                $check = $this->mconfig->check_membresia($membresia);
                if ($check == NULL) {
                    $ID_MEMBRESIA = $this->mconfig->add_new_membresia_on_db($data);
                    if ($ID_MEMBRESIA > NULO) {
                        echo $ID_MEMBRESIA;
                    } else {
                        echo -1;
                    }
                }
            } else {
                //operacion no permitida..
                redirect('Login/salir');
            }
        } else {
            redirect('Login/salir');
        }
    }

    public function ajax_edit_membresia() {
        if ($this->input->is_ajax_request()) {
            if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
                $id_membresia = $this->input->post("RG_ID_MEMBRESIA");
                $membresia = $this->input->post('RG_NOMBRE_MEMBRESIA');
                $data['NOMBRE_MEMBRESIA'] = $this->input->post("RG_NOMBRE_MEMBRESIA");

                $check = $this->mconfig->check_membresia($membresia);

                if ($check == NULL) {
                    $ID_MEMBRESIA = $this->mconfig->edit_membresia_on_db($data, $id_membresia);
                    if ($ID_MEMBRESIA > NULO) {
                        echo $ID_MEMBRESIA;
                    } else {
                        echo -1;
                    }
                } else {
                    echo implode($check[0]);
                }
            } else {
                //operacion no permitida..
                redirect('Login/salir');
            }
        } else {
            redirect('Login/salir');
        }
    }

    function ajax_delete_membresia() {
        if ($this->input->is_ajax_request()) {
            $ID_MEMBRESIA = $this->input->post('ID_MEMBRESIA');
            $AFFECTED_ROWS = $this->mconfig->delete_membresia_on_db($ID_MEMBRESIA);
            echo $AFFECTED_ROWS;
        } else {
            redirect('Config');
        }
    }

    //Perfiles
    public function ajax_add_perfil() {
        if ($this->input->is_ajax_request()) {
            if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
                $perfil = $this->input->post("RG_NOMBRE_PERFIL");
                $data['NOMBRE_PERFIL'] = $this->input->post("RG_NOMBRE_PERFIL");
                $data['VIGENCIA_PERFIL'] = VIGENTE;

                $check = $this->mconfig->check_perfil($perfil);
                if ($check == NULL) {
                    $ID_PERFIL = $this->mconfig->add_new_perfil_on_db($data);
                    if ($ID_PERFIL > NULO) {
                        echo $ID_PERFIL;
                    } else {
                        echo -1;
                    }
                }
            } else {
                //operacion no permitida..
                redirect('Login/salir');
            }
        } else {
            redirect('Login/salir');
        }
    }

    public function ajax_edit_perfil() {
        if ($this->input->is_ajax_request()) {
            if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
                $id_perfil = $this->input->post("RG_ID_PERFIL");
                $perfil = $this->input->post('RG_NOMBRE_PERFIL');
                $data['NOMBRE_PERFIL'] = $this->input->post("RG_NOMBRE_PERFIL");

                $check = $this->mconfig->check_perfil($perfil);

                if ($check == NULL) {
                    $ID_PERFIL = $this->mconfig->edit_perfil_on_db($data, $id_perfil);
                    if ($ID_PERFIL > NULO) {
                        echo $ID_PERFIL;
                    } else {
                        echo -1;
                    }
                } else {
                    echo implode($check[0]);
                }
            } else {
                //operacion no permitida..
                redirect('Login/salir');
            }
        } else {
            redirect('Login/salir');
        }
    }

    function ajax_delete_perfil() {
        if ($this->input->is_ajax_request()) {
            $ID_PERFIL = $this->input->post('ID_PERFIL');
            $AFFECTED_ROWS = $this->mconfig->delete_perfil_on_db($ID_PERFIL);
            echo $AFFECTED_ROWS;
        } else {
            redirect('Config');
        }
    }

    public function ajax_add_house() {
        if ($this->input->is_ajax_request()) {
            if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
                $casa = $this->input->post("RG_NOMBRE_CASA");
                $data['NOMBRE_CASA'] = $casa;
                $data['ID_MEMBRESIA'] = $this->input->post("RG_ID_MEMBRESIA");
                $data['VIGENCIA_CASA'] = VIGENTE;

                $check = $this->mconfig->check_house($casa);
                if ($check == NULL) {
                    $ID_CASA = $this->mconfig->add_new_house_on_db($data);
                    if ($ID_CASA > NULO) {
                        echo $ID_CASA;
                    } else {
                        echo -1;
                    }
                }
            } else {
                //operacion no permitida..
                redirect('Login/salir');
            }
        } else {
            redirect('Login/salir');
        }
    }

    public function ajax_edit_house() {
        if ($this->input->is_ajax_request()) {
            if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
                $id_casa = $this->input->post("RG_ID_CASA");
                $casa = $this->input->post('RG_NOMBRE_CASA');
                $data['NOMBRE_CASA'] = $casa;
                $data['ID_MEMBRESIA'] = $this->input->post('RG_ID_MEMBRESIA_E');
                
                $ID_CASA = $this->mconfig->edit_house_on_db($data, $id_casa);
                if ($ID_CASA > NULO) {
                    echo $ID_CASA;
                } else {
                    echo -1;
                }
            } else {
                redirect('Login/salir');
            }
        }
    }

    function ajax_delete_house() {
        if ($this->input->is_ajax_request()) {
            $ID_CASA = $this->input->post('ID_CASA');
            $AFFECTED_ROWS = $this->mconfig->delete_casa_on_db($ID_CASA);
            echo $AFFECTED_ROWS;
        } else {
            redirect('Config');
        }
    }

}
