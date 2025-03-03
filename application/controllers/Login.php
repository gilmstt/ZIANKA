<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('mlogin');
    }

    public function register() {
        if (empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
            // echo "alo";
            $this->load->view('Login/v_register');
        } else {
            redirect('Inicio/index');
        }
    }

    public function ajax_validate_user() {
        if ($this->input->is_ajax_request()):
            if (!empty($this->input->post('USR_USUARIO')) && !empty($this->input->post('PSWD_USUARIO'))):
                $data['USR_USUARIO'] = $this->input->post('USR_USUARIO');
                $data['PSWD_USUARIO'] = $this->input->post('PSWD_USUARIO');
                $result = $this->mlogin->login($data);
                if (count($result)):

                    $datosSesion = array(
                        'CAREYES_ID_USUARIO' => $result[0]["ID_USUARIO"],
                        'CAREYES_NOMBRE_USUARIO' => $result[0]["USERNAME_USUARIO"],
                        'CAREYES_ID_ROL' => $result[0]["ID_ROL"]
                    );

                    //var_dump($result);
                    $this->session->set_userdata($datosSesion);
                    $this->mlogin->update_last_login($result[0]["ID_USUARIO"]);
                    echo 'Ok';

                else:
                    echo '<b>¡ Datos de acceso incorrectos !</b>';
                endif;
            else:
                echo '<b>* Debe introducir usuario y contraseña</b>';
            //redirect('login/salir');
            endif;
        else:
            redirect('Login/salir');
        endif;
    }

    public function salir() {
        $this->session->sess_destroy();
        redirect(base_url());
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */