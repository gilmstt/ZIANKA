<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Consult extends CI_Controller
{

    // CONSTRUCT

    public function __construct()
    {
        parent::__construct();
        $this->load->model('mpatient');
        $this->load->model('mconsult');
        $this->load->model('mconfig');
        $this->load->model('Murgency');
        $this->load->helper('functions');
        $this->load->helper('currency');
        $this->load->helper('general');
        $this->load->model('Minventary');
        $this->ID_SESSION = $this->session->userdata('CAREYES_ID_USUARIO');
    }

    // INDEX
    public function index()
    {
        $data = getActive("classCon");
        $data['PRODUCTOS'] = $this->Murgency->get_productos_();
        $this->load->view('esqueleton/header', $data);
        $this->load->view('Consult/v_index_consult');
        $this->load->view('esqueleton/footer');
    }

    public function ajax_get_all_consults()
    {
        if ($this->input->is_ajax_request()) {
            $data = $this->mconsult->get_consults();
            echo json_encode($data, true);
        } else {
            show_404();
        }
    }

    // CONSULTA
    public function nueva_consulta($id)
    {
        $data['row_user'] = $this->mpatient->get_patient_by_id($id);

        $this->load->view('esqueleton/header', getActive("classCon"));
        $data['tratamientos'] = [
            'TOXINA_BOTULINICA' => 'Toxina Botulínica',
            'ACIDO_HIALURONICO' => 'Relleno Ácido Hialurónico',
            'BIOESTIMULADORES' => 'Bioestimuladores',
            'DERMAPEN' => 'Dermapen',
            'PEELING' => 'Peeling Químico',
            'PLASMA' => 'Plasma Rico en Plaquetas',
            'HILOS' => 'Hilos de Sustentación',
            'MESOTERAPIA' => 'Mesoterapia',
            'APARATOLOGIA_CORPORAL' => 'Aparatología Corporal'
        ];
        $this->load->view('Consult/v_new_consult', $data);
        $this->load->view('esqueleton/footer');
        $this->mconsult->clear_temps($this->ID_SESSION);
    }

    public function ajax_nueva_consulta()
    {
        if ($this->input->is_ajax_request()) {
            $this->mconsult->nueva_consulta();
        } else {
            redirect('index');
        }
    }

    public function get_tarifas()
    {
        if ($this->input->is_ajax_request()) {
            $tarifas = $this->mconfig->get_all_valid_tarifas();
            echo json_encode($tarifas);
        }
    }

    public function change_tarifa()
    {
        if ($this->input->is_ajax_request()) {

            $ficha = $this->input->post('ficha');
            $id = $this->input->post('id_tarifa');

            $this->db->where('ID_FICHA', $ficha);
            $this->db->update('consulta', array('ID_TARIFA' => $id));
            if ($this->db->affected_rows() > 0) {
                echo "success";
            }
        }
    }

    public function ajax_get_consulta_by_id()
    {
        if ($this->input->is_ajax_request()) {
            $Consult = $this->mconsult->get_consult_by_id();
            echo json_encode($Consult);
        } else {
            redirect('index');
        }
    }

    /* public function ajax_delete_consult() {
        if ($this->input->is_ajax_request()) {
            ($this->mconsult->delete_consult()) ? 'success' : 'error';
        } else {
            redirect('index');
        }
    }*/

    public function ajax_costo_total()
    { //index
        if ($this->input->is_ajax_request()) {
            $total = $this->mconsult->costo_total();
            echo json_encode($total);
        } else {
            redirect('index');
        }
    }

    public function ajax_total_final()
    { //form
        if ($this->input->is_ajax_request()) {
            $data = $this->mconsult->total_final();
            echo json_encode($data);
        } else {
            redirect('index');
        }
    }

    public function ajax_edit_desc_tarifa()
    {
        if ($this->input->is_ajax_request()) {
            $edit = $this->mconsult->edit_desc_tarifa();
            if ($edit == "bien") {
                echo "success";
            } else {
                if ($edit == "no ficha") {
                    echo 'no ficha';
                } else {
                    echo 'repetido';
                }
            }
        } else {
            redirect('index');
        }
    }

    public function ajax_close_consult()
    {
        if ($this->input->is_ajax_request()) {

            if ($this->mconsult->close_consult()) {
                echo "success";
            }
        } else {
            redirect('index');
        }
    }

    // FICHA CONSUMO
    public function ajax_insert_ficha()
    {
        if ($this->input->is_ajax_request()) {
            $this->mconsult->insertFicha();
        } else {
            redirect('index');
        }
    }

    // PROCEDIMIENTOS & PRODUCTOS
    public function ajax_obtener_procedimiento()
    {
        if ($this->input->is_ajax_request()) {
            $var = $this->input->post('var');
            $this->mconsult->obtenerProcedimiento($var);
        } else {
            redirect('index');
        }
    }

    public function ajax_get_procedimientos_por_tipo()
    {
        if ($this->input->is_ajax_request()) {
            $id_tipo_consulta = $this->input->post('id_tipo_consulta');
            $data = $this->mconsult->getProcedimientosPorTipo($id_tipo_consulta);
            echo json_encode($data);
        } else {
            show_404();
        }
    }

    public function ajax_temp_procedimiento()
    {
        if ($this->input->is_ajax_request()) {
            $this->mconsult->tempProcedimiento();
        } else {
            redirect('index');
        }
    }

    public function ajax_show_tempProcedimientos()
    {
        if ($this->input->is_ajax_request()) {
            $data = $this->mconsult->get_tempProcedimientos();
            echo json_encode($data);
        } else {
            redirect('index');
        }
    }

    public function ajax_delete_temProcedimiento()
    {
        if ($this->input->is_ajax_request()) {
            $this->mconsult->delete_temProcedimiento();
        } else {
            redirect('index');
        }
    }

    // MATERIALES
    public function ajax_obtener_producto()
    {
        if ($this->input->is_ajax_request()) {
            $var = $this->input->post('var');
            $this->mconsult->obtenerProducto($var);
        } else {
            redirect('index');
        }
    }

    public function ajax_temp_producto()
    {
        if ($this->input->is_ajax_request()) {
            $this->mconsult->tempProducto();
        } else {
            redirect('index');
        }
    }

    public function ajax_show_tempProductos()
    {
        if ($this->input->is_ajax_request()) {
            $data = $this->mconsult->get_tempProductos();
            echo json_encode($data);
        } else {
            redirect('index');
        }
    }

    public function ajax_delete_temProducto()
    {
        if ($this->input->is_ajax_request()) {
            $this->mconsult->delete_temProducto();
        } else {
            redirect('index');
        }
    }

    // MODAL FICHA CONSUMO
    public function ajax_get_procedimientos()
    {
        if ($this->input->is_ajax_request()) {
            $data = $this->mconsult->get_procedimientos();
            echo json_encode($data);
        } else {
            redirect('index');
        }
    }

    public function ajax_get_productos()
    {
        if ($this->input->is_ajax_request()) {
            $data = $this->mconsult->get_productos();
            echo json_encode($data);
        } else {
            redirect('index');
        }
    }

    public function ajax_insert_relProcedimiento()
    {
        if ($this->input->is_ajax_request()) {
            $id_ficha = $this->mconsult->insert_relProcedimiento();
            echo $id_ficha;
        } else {
            redirect('index');
        }
    }

    public function ajax_delete_relProcedimiento()
    {
        if ($this->input->is_ajax_request()) {
            $this->mconsult->delete_relProcedimiento();
        } else {
            redirect('index');
        }
    }

    public function ajax_insert_relProducto()
    {
        if ($this->input->is_ajax_request()) {
            $id_ficha = $this->mconsult->insert_relProducto();
            echo $id_ficha;
        } else {
            redirect('index');
        }
    }

    public function ajax_delete_relProducto()
    {
        if ($this->input->is_ajax_request()) {
            $this->mconsult->delete_relProducto();
        } else {
            redirect('index');
        }
    }

    // MODAL FICHA DIAGNOSTICO
    public function ajax_update_consulta()
    {
        if ($this->input->is_ajax_request()) {
            $this->mconsult->update_consulta();
        } else {
        }
    }

    // MODAL ADJUNTAR ARCHIVO
    public function ajax_get_files_consult()
    {
        if ($this->input->is_ajax_request() && !empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
            $ID_CONSULTA = $this->input->post('ID_CONSULTA');
            $FILES_CONSULT = $this->mconsult->get_files_consult_on_db($ID_CONSULTA);
            if (count($FILES_CONSULT) > NULO):
                $this->output->set_content_type("application/json")->set_output(json_encode($FILES_CONSULT));
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
            $ID_CONSULTA = $this->input->post('ID_CONSULTA');
            $ID_DOCUMENTO = $this->input->post('ID_DOCUMENTO');
            $NOMBRE_DOCUMENTO = $this->input->post('NOMBRE_DOCUMENTO');

            $affected = $this->mconsult->delete_file_by_id($ID_DOCUMENTO);
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

            $ID_CONSULTA = $_POST['ID_CONSULTA'];

            if (strlen(trim($_FILES['userfile']['name'])) > NULO) {
                $tmpNombreDir = $ID_CONSULTA . '_FILES' . '/';
                // var_dump(is_dir(PATH_TO_UPLOAD_FILES . '/' . $tmpNombreDir));
                if (!is_dir(PATH_TO_UPLOAD_FILES . '/' . $tmpNombreDir)) {
                    mkdir(PATH_TO_UPLOAD_FILES . '/' . $tmpNombreDir);
                }
                $config['upload_path'] = './' . PATH_TO_UPLOAD_FILES . '/' . $tmpNombreDir;
                $config['allowed_types'] = '*';
                $config['max_size'] = '6000000';
                $config['max_width'] = '8000';
                $config['max_height'] = '5000';
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    echo -2; //no se pudo adjuntar el video..
                    // uploading failed. $error will holds the errors.
                } else {
                    $data = $this->upload->data();
                    $data_aux['NOMBRE_DOCUMENTO'] = $tmpNombreDir . $data['file_name'];
                    $data_aux['TIPO_DOCUMENTO'] = $_FILES['userfile']['type'];
                    $data_aux['ID_CONSULTA'] = $ID_CONSULTA;
                    $INSERT_FILE_CONSULTA = $this->mconsult->insert_file_by_consult_id($data_aux);
                    echo $INSERT_FILE_CONSULTA;

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
    public function ajax_delete_consult()
    {
        if ($this->input->is_ajax_request()) {
            $ID_CONSULTA = $this->input->post('id_consulta');

            $ROW_ITEMS = $this->mconsult->get_producto_by_consult_id($ID_CONSULTA);
            foreach ($ROW_ITEMS as $ROW) {

                $ID_PRODUCTO = $ROW['ID_PRODUCTO'];
                $ITEM_ON_DB = $this->Minventary->get_product_by_id($ID_PRODUCTO);
                $data['STOCK_PRODUCTO'] = $ITEM_ON_DB[0]['STOCK_PRODUCTO'] + $ROW['CANT_PRODUCTO'];
                $UPDATE = $this->Minventary->edit_product_on_db($data, $ID_PRODUCTO);
            }
            if ($this->mconsult->delete_consult()) {
                echo "success";
            } else {
                echo "error";
            }
        } else {
            redirect('index', 'refresh');
        }
    }

    // PDF FORMATTOS IMPRESION
    // FICHA DE CONSULTA
    function creaPdfFichaDiagnostic($ID_CONSULT)
    {
        if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {

            $ROW_CONSULT = $this->mconsult->get_consult_by_id_consult($ID_CONSULT);
            if (count($ROW_CONSULT) > NULO) {
                $this->load->library('PDF');
                //Carpeta imágenes está un directorio arriba
                $directorioPadre = base_url() . "assets/img/";

                $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                $this->pdf->SetFont('Arial', 'B', 8); //Arial, negrita, 12 puntos
                $this->pdf->image(base_url() . "assets/img/encabezado.png", 76, 8, 100);
                $this->pdf->designUp();

                //$this->pdf->image(base_url() . "assets/img/", 76, 8, 70);

                /* if ($ROW_CONSULT[0]['TARIFA2'] > NULO) {
                    $ROW_TARIFA = $this->mconfig->get_tarifa_by_id(mb_strtoupper($ROW_CONSULT[0]['TARIFA2']));
                    $this->pdf->SetFont('Arial', 'B', 11);
                    $this->pdf->text(172, 32, 'Tarifa:', 0, 0, 'L');
                    $this->pdf->SetFont('Arial', '', 11);
                    $this->pdf->Text(186, 32, $ROW_TARIFA[0]['NOMBRE_TARIFA']);
                    //$this->pdf->line(182, 32.5, 193, 32.5);
                }
                if ($ROW_CONSULT[0]['ID_MEMBRESIA'] > NULO) {
                    $ROW_MEMBRESIA = $this->mconfig->get_membresia_by_id($ROW_CONSULT[0]['ID_MEMBRESIA']);
                    $this->pdf->SetFont('Arial', 'B', 11);
                    $this->pdf->text(127, 34, 'Membresia:', 0, 0, 'L');
                    $this->pdf->SetFont('Arial', '', 11);
                    $this->pdf->Text(149, 34, $ROW_MEMBRESIA[0]['NOMBRE_MEMBRESIA']);
                    //$this->pdf->line(142, 32.5, 156, 32.5);
                    $ROW_PERFIL = $this->mconfig->get_perfil_by_id($ROW_CONSULT[0]['ID_PERFIL_MEMBRESIA']);
                    $this->pdf->SetFont('Arial', 'B', 11);
                    $this->pdf->text(159, 34, 'Perfil:', 0, 0, 'L');
                    $this->pdf->SetFont('Arial', '', 11);
                    $this->pdf->Text(171, 34, $ROW_PERFIL[0]['NOMBRE_PERFIL']);
                }*/

                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, 40, 'Nombre:', 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(42, 40, utf8_decode($ROW_CONSULT[0]['NOMBRE_PACIENTE']) . ' ' . utf8_decode($ROW_CONSULT[0]['APELLIDO_PATERNO_PACIENTE']) . ' ' . utf8_decode($ROW_CONSULT[0]['APELLIDO_MATERNO_PACIENTE']));

                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(150, 40, 'Edad:', 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(160, 40, utf8_decode(calcula_edad_2($ROW_CONSULT[0]['FECHA_NAC_PACIENTE'], $ROW_CONSULT[0]['FECHA_CONSULTA'])));

                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, 47, 'Domicilio:', 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(46, 47, utf8_decode($ROW_CONSULT[0]['CALLE_PACIENTE']) . ' ' . utf8_decode($ROW_CONSULT[0]['NUMERO_PACIENTE']) . ' ' . utf8_decode($ROW_CONSULT[0]['COLONIA_PACIENTE']));

                /* $this->pdf->SetFont('Arial', 'B', 11);
                $this->pdf->text(26, 53, 'Lugar Nacimiento:', 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 11);
                $this->pdf->Text(62, 53, utf8_decode($ROW_CONSULT[0]['LUGAR_NACIMIENTO']));

                $this->pdf->SetFont('Arial', 'B', 11);
                $this->pdf->text(146, 47, 'Residencia:', 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 11);
                $this->pdf->Text(168, 47, utf8_decode($ROW_CONSULT[0]['RESIDENCIA']));*/

                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, 58, 'Ingreso:', 0, 0, 'L');

                $this->pdf->text(62, 58, 'Fecha:', 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(76, 58, $ROW_CONSULT[0]['FECHA_CONSULTA']);

                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(99, 58, 'Hora:', 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(109, 58, $ROW_CONSULT[0]['HORA_CONSULTA']);

                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(129, 58, utf8_decode('Condición:'), 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(139, 58, utf8_decode($ROW_CONSULT[0]['CONDICION_CONSULTA']));

                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(159, 58, utf8_decode('Origen:'), 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(174, 58, utf8_decode($ROW_CONSULT[0]['ORIGEN_CONSULTA']));

                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, 65, 'Motivo de Consulta:', 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(64, 65, utf8_decode($ROW_CONSULT[0]['MOTIVO_CONSULTA']));

                $this->pdf->setXY(25, 65);
                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, 70, utf8_decode('Inicio y Evolución:'), 0, 0, 'L');


                $y = $this->pdf->GetY();
                $this->pdf->setXY(25, $y + 5);
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Multicell(168, 5.5, utf8_decode($ROW_CONSULT[0]['INICIOEVOLUCION_CONSULTA']));
                $this->pdf->Ln(3);

                $y = $this->pdf->GetY();
                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, $y, utf8_decode('Signos Vitales:'));
                $this->pdf->Ln(3);

                $y = $this->pdf->GetY();
                $this->pdf->text(26, $y + 2, utf8_decode('TA:'));
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(33, $y + 2, $ROW_CONSULT[0]['SIGNOS_VITALES']);

                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(58, $y + 2, utf8_decode('FC:'));
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(65, $y + 2, $ROW_CONSULT[0]['FC_CONSULTA']);


                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(86, $y + 2, utf8_decode('RITMO CARDIACO:'));
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(120, $y + 2, $ROW_CONSULT[0]['RITMO_CARDIACO_CONSULTA']);


                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(140, $y + 2, utf8_decode('TEMP.:'));
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(154, $y + 2, utf8_decode($ROW_CONSULT[0]['TEMP_CONSULTA']));


                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(169, $y + 2, utf8_decode('FR:'));
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(177, $y + 2, $ROW_CONSULT[0]['FR_CONSULTA']);


                $y = $this->pdf->GetY();
                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, $y + 6, utf8_decode('SAT:'));
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(36, $y + 6, $ROW_CONSULT[0]['SAT_CONSULTA']);


                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(50, $y + 6, utf8_decode('GLICEMA CAPILAR:'));
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(89, $y + 6, $ROW_CONSULT[0]['GLICEMIA_CAPILAR_CONSULTA']);
                $this->pdf->Ln(6);

                $y = $this->pdf->GetY();
                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, $y + 4, utf8_decode('Diágnostico Presuntivo:'), 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(71, $y + 4, utf8_decode($ROW_CONSULT[0]['DIAGNOSTICO']));
                $this->pdf->Ln(8);

                $y = $this->pdf->GetY();
                $this->pdf->setXY(25, $y);
                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, $y, utf8_decode('Exploración Física:'), 0, 0, 'L');

                $y = $this->pdf->GetY();
                $this->pdf->setXY(25, $y);
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Multicell(168, 5.5, utf8_decode($ROW_CONSULT[0]['EXPLORACION_FISICA']));
                $this->pdf->Ln(4);

                $y = $this->pdf->GetY();
                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, $y, utf8_decode('Manejo Intrahospitalario:'), 0, 0, 'L');

                $y = $this->pdf->GetY();
                $this->pdf->setXY(25, $y);
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Multicell(168, 5.5, utf8_decode($ROW_CONSULT[0]['MANEJO_INTRAHOSPITALARIO_CONSULTA']));
                $this->pdf->Ln(4);

                $y = $this->pdf->GetY();
                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, $y, utf8_decode('Tratamiento:'), 0, 0, 'L');

                $y = $this->pdf->GetY();
                $this->pdf->setXY(25, $y);
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Multicell(168, 5.5, utf8_decode($ROW_CONSULT[0]['TRATAMIENTO_CONSULTA']));
                $this->pdf->Ln(4);

                $y = $this->pdf->GetY();

                $this->pdf->setXY(25, $y);
                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->Text(26, $y, utf8_decode('Evolución:'), 0, 0, 'L');

                $y = $this->pdf->GetY();

                $this->pdf->setXY(25, $y);
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Multicell(168, 6.5, utf8_decode($ROW_CONSULT[0]['EVOLUCION_CONSULTA']));
                $this->pdf->Ln(3);

                $y = $this->pdf->GetY();

                $this->pdf->setXY(25, $y);
                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, $y, utf8_decode('Observaciones:'), 0, 0, 'L');

                $y = $this->pdf->GetY();
                $this->pdf->setXY(25, $y);
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Multicell(168, 6.5, utf8_decode($ROW_CONSULT[0]['OBSERVACIONES_CONSULTA']));


                $y = $this->pdf->GetY();

                $this->pdf->setXY(25, $y);
                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->Cell(26, 5, utf8_decode('Egreso:'), 0, 0, 'L');
                $this->pdf->Ln(2);


                $y = $this->pdf->GetY();

                $this->pdf->setXY(25, $y + 4);
                $this->pdf->Cell(26, 5, utf8_decode('DX:'), 0, 0, 'L');

                $this->pdf->setXY(25, $y + 7);
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Multicell(170, 4.4, $ROW_CONSULT[0]['DIAGNOSTICO_EGRESO_CONSULTA']);

                $y = $this->pdf->GetY();
                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, $y + 3, utf8_decode('Fecha:'), 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(38, $y + 3, $ROW_CONSULT[0]['FECHAEGRESO_CONSULTA']);
                //$this->pdf->line(80, 229.5, 110, 229.5);

                $y = $this->pdf->GetY();

                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(65, $y + 3, utf8_decode('Hora:'), 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(74, $y + 3, $ROW_CONSULT[0]['HREGRESO_CONSULTA']);
                //$this->pdf->line(118, 229.5, 145, 229.5);

                $y = $this->pdf->GetY();

                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(96, $y + 3, utf8_decode('Destino:'), 0, 0, 'L');

                $y = $this->pdf->GetY();

                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, $y + 9, utf8_decode('Médico:'), 0, 0, 'L');

                $y = $this->pdf->GetY();
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(41, $y + 9, utf8_decode($ROW_CONSULT[0]['NOMBRE_USUARIO'] . ' ' . $ROW_CONSULT[0]['APELLIDO_USUARIO']));
                //$this->pdf->line(36, 243.5, 193, 243.5);

                $this->pdf->SetFont('Arial', 'B', 8); //Arial, negrita, 12 puntos
                $this->pdf->setXY(13, 255);
                $this->pdf->Cell(0, 0, utf8_decode('Km. 53.5 CARRETERA MELAQUE-PUERTO VALLARTA TELS:(315) 351 0170 Y 351 0169 FAX:(315) 351 0043 CAREYITOS,JALISCO. C.P.48890'), 0, 0, 'C');
                $y = $this->pdf->GetY();
                $this->pdf->line(12, $y + 2, 205, $y + 2);

                $this->pdf->Output(); //Salida al navegador del pdf
            } else {
                redirect('Consult/index');
            }
        } else {
            redirect('Login/salir');
        }
    }

    //FICHA DE CONSUMO
    public function creaPdf($ID_CONSULT)
    {
        if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {

            if ($ID_CONSULT > NULO) {
                $ROW_CONSULT = $this->mconsult->get_consult_by_id_consult($ID_CONSULT);
                $ROW_PROC = $this->mconsult->get_procedimiento_by_consult_id($ID_CONSULT);
                $ROW_MAT = $this->mconsult->get_producto_by_consult_id($ID_CONSULT);
                $SUM_PROC = $this->mconsult->get_sum($ROW_CONSULT[0]['ID_FICHA']);
                $SUM_FICHA = $this->mconsult->get_sum_ficha($ROW_CONSULT[0]['ID_FICHA']);

                if (count($ROW_CONSULT) > NULO) {
                    $this->load->library('PDF');
                    //Carpeta imágenes está un directorio arriba
                    $directorioPadre = base_url() . "assets/img/";

                    // $this->pdf->Image($directorioPadre."logo.jpg",10,10,10,28);

                    $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                    $this->pdf->SetFont('Arial', 'B', 10); //Arial, negrita, 12 puntos
                    $this->pdf->designUp();

                    $this->pdf->image(base_url() . "assets/img/encabezado.png", 76, 6, 90);

                    $this->pdf->setXY(11, 29);
                    $this->pdf->Cell(66, 5, 'FECHA:', 1, 1, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(37, 32.5, $ROW_CONSULT[0]['FECHA_CONSULTA']);

                    $this->pdf->setXY(77, 29);
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->Cell(66, 5, 'HORA DE INGRESO:', 1, 1, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(118, 32.5, $ROW_CONSULT[0]['HORA_CONSULTA']);

                    $this->pdf->setXY(143, 29);
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->Cell(62, 5, 'HORA DE EGRESO:', 1, 1, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(183, 32.5, $ROW_CONSULT[0]['HREGRESO_CONSULTA']);

                    $this->pdf->setXY(11, 34);
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->Cell(138, 5, 'NOMBRE DEL PACIENTE:', 1, 1, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(60, 37, utf8_decode(mb_strtoupper($ROW_CONSULT[0]['NOMBRE_PACIENTE'])) . ' ' . utf8_decode(mb_strtoupper($ROW_CONSULT[0]['APELLIDO_PATERNO_PACIENTE'])) . ' ' . utf8_decode(mb_strtoupper($ROW_CONSULT[0]['APELLIDO_MATERNO_PACIENTE'])));

                    $this->pdf->setXY(149, 34);
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->Cell(30, 5, 'EDAD:', 1, 1, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(166, 37, utf8_decode(calcula_edad_2($ROW_CONSULT[0]['FECHA_NAC_PACIENTE'], $ROW_CONSULT[0]['FECHA_CONSULTA'])));

                    $this->pdf->setXY(179, 34);
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->Cell(26, 5, 'SEXO:', 1, 1, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(196, 37, $ROW_CONSULT[0]['ABREV_SEXO']);

                    $this->pdf->setXY(164, 132);
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->Cell(41, 5, 'TOTAL PAGADO', 1, 1, 'C');
                    $this->pdf->setXY(164, 137);
                    $this->pdf->Cell(41, 5, ' ', 1, 1, 'C');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(179, 141, to_currency($ROW_CONSULT[0]['TOTAL_PAGADO_CONSULTA']));

                    if ($ROW_CONSULT[0]['TARIFA2'] > NULO) {
                        $ROW_TARIFA = $this->mconfig->get_tarifa_by_id($ROW_CONSULT[0]['TARIFA2']);
                        $suma = $SUM_PROC[0]['suma'] + $SUM_FICHA[0]['sumaficha'] + $ROW_TARIFA[0]['CONSULTA_TARIFA'];
                        $NOMBRE_TARIFA = $ROW_TARIFA[0]['NOMBRE_TARIFA'];
                        $porcentaje = $ROW_CONSULT[0]['DESC_TARIFA'];
                        $descuento = $suma * ($porcentaje / 100);
                        $total = $suma - $descuento;

                        $this->pdf->setXY(11, 39);
                        $this->pdf->SetFont('Arial', 'B', 10);
                        $this->pdf->Cell(194, 5, 'TIPO DE TARIFA:', 1, 1, 'L');
                        $this->pdf->SetFont('Arial', '', 10);
                        $this->pdf->Text(60, 43, $NOMBRE_TARIFA);
                    }
                    if ($ROW_CONSULT[0]['MEMBRECIA2'] > NULO) {
                        $ROW_MEMBRESIA = $this->mconfig->get_membresia_by_id($ROW_CONSULT[0]['MEMBRECIA2']);
                        $this->pdf->setXY(11, 39);
                        $this->pdf->Cell(194, 5, 'MEMBRESIA:', 1, 1, 'L');
                        $this->pdf->Text(55, 43, $ROW_MEMBRESIA[0]['NOMBRE_MEMBRESIA']);
                        $ROW_PERFIL = $this->mconfig->get_perfil_by_id($ROW_CONSULT[0]['ID_PERFIL_MEMBRESIA']);
                        $this->pdf->setXY(77, 39);
                        $this->pdf->Cell(128, 5, 'PERFIL:', 1, 1, 'L');
                        $this->pdf->Text(100, 43, $ROW_PERFIL[0]['NOMBRE_PERFIL']);
                    }

                    $this->pdf->setXY(11, 44);
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->Cell(194, 5, utf8_decode('DIAGNÓSTICO:'), 1, 1, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(60, 48, utf8_decode(mb_strtoupper($ROW_CONSULT[0]['MOTIVO_CONSULTA'])));

                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->Text(26, 56, 'PROCEDIMIENTOS');
                    $this->pdf->Text(113, 56, 'MATERIAL Y MEDICAMENTOS UTILIZADOS');

                    $this->pdf->setXY(11, 57);
                    $this->pdf->Cell(55, 5, 'NOMBRE', 1, 1, 'C');

                    $this->pdf->setXY(66, 57);
                    $this->pdf->Cell(20, 5, 'CANT.', 1, 1, 'C');

                    $this->pdf->setXY(86, 57);
                    $this->pdf->Cell(23, 5, 'COSTO', 1, 1, 'C');

                    $this->pdf->setXY(109, 57);
                    $this->pdf->Cell(55, 5, 'NOMBRE', 1, 1, 'C');

                    $this->pdf->setXY(164, 57);
                    $this->pdf->Cell(20, 5, 'CANT.', 1, 1, 'C');

                    $this->pdf->setXY(184, 57);
                    $this->pdf->Cell(21, 5, 'COSTO', 1, 1, 'C');

                    $posicionY = 62;
                    $this->pdf->SetFont('Arial', 'B', 8);

                    for ($x = 0; $x < 14; $x++) {
                        $NOMBRE_PROCEDIMIENTO = isset($ROW_PROC[$x]['NOMBRE_PROCEDIMIENTO']) ? $ROW_PROC[$x]['NOMBRE_PROCEDIMIENTO'] : '';
                        $CANT_PROCEDIMIENTO = isset($ROW_PROC[$x]['CANT_PROCEDIMIENTO']) ? $ROW_PROC[$x]['CANT_PROCEDIMIENTO'] : '';
                        $PRECIO_PROCEDIMIENTO = isset($ROW_PROC[$x]['PRECIO_PROCEDIMIENTO']) ? $ROW_PROC[$x]['PRECIO_PROCEDIMIENTO'] : '';

                        $NOMBRE_PRODUCTO = isset($ROW_MAT[$x]['NOMBRE_PRODUCTO']) ? $ROW_MAT[$x]['NOMBRE_PRODUCTO'] : '';
                        $CANT_PRODUCTO = isset($ROW_MAT[$x]['CANT_PRODUCTO']) ? $ROW_MAT[$x]['CANT_PRODUCTO'] : '';
                        $PRECIO_PRODUCTO = isset($ROW_MAT[$x]['PRECIO_PRODUCTO']) ? $ROW_MAT[$x]['PRECIO_PRODUCTO'] : '';

                        $this->pdf->setXY(11, $posicionY);
                        $this->pdf->SetFont('Arial', '', 8);
                        $limit = strlen($NOMBRE_PROCEDIMIENTO);
                        $nom_Procedim = '';

                        if ($limit > 29) {
                            $nom_Procedim = substr(utf8_decode($NOMBRE_PROCEDIMIENTO), 0, 28) . '...';
                        } else {
                            $nom_Procedim = $NOMBRE_PROCEDIMIENTO;
                        }

                        $this->pdf->Cell(55, 5, utf8_decode($nom_Procedim), 1, 1, 'L');

                        $this->pdf->setXY(66, $posicionY);
                        $this->pdf->Cell(20, 5, $CANT_PROCEDIMIENTO, 1, 1, 'C');

                        $this->pdf->setXY(86, $posicionY);
                        $this->pdf->Cell(23, 5, floatval($PRECIO_PROCEDIMIENTO) > 0 ? to_currency(floatval($PRECIO_PROCEDIMIENTO)) : "", 1, 1, 'R');

                        $this->pdf->setXY(109, $posicionY);
                        $limit = strlen($NOMBRE_PRODUCTO);
                        $nom_Producto = '';
                        if ($limit > 30) {
                            $nom_Producto = substr(utf8_decode($NOMBRE_PRODUCTO), 0, 29) . '...';
                        } else {
                            $nom_Producto = $NOMBRE_PRODUCTO;
                        }
                        $this->pdf->Cell(55, 5, utf8_decode($nom_Producto), 1, 1, 'L');

                        $this->pdf->setXY(164, $posicionY);
                        $this->pdf->Cell(20, 5, $CANT_PRODUCTO, 1, 1, 'C');

                        $this->pdf->setXY(184, $posicionY);
                        $this->pdf->Cell(21, 5, floatval($PRECIO_PRODUCTO) > 0 ? to_currency(floatval($PRECIO_PRODUCTO)) : "", 1, 1, 'R');

                        $posicionY += 5;
                    }
                    $this->pdf->setXY(11, 120);
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->Cell(55, 20, 'TOTAL', 0, 0, 'C');

                    if ($ROW_CONSULT[0]['MEMBRECIA2'] > NULL) {

                        $this->pdf->setXY(86, 127);
                        $this->pdf->SetFont('Arial', '', 10);
                        $this->pdf->Cell(23, 5, '$0.00', 1, 1, 'R');
                    } else {
                        $this->pdf->setXY(86, 127);
                        $this->pdf->SetFont('Arial', '', 10);
                        $this->pdf->Cell(23, 5, to_currency($SUM_PROC[0]['suma']), 1, 1, 'R');
                    }

                    $this->pdf->setXY(110, 120);
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->Cell(55, 20, 'TOTAL', 0, 0, 'C');

                    $this->pdf->setXY(186, 127);
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Cell(19, 5, to_currency($SUM_FICHA[0]['sumaficha']), 0, 0, 'R');



                    if ($ROW_CONSULT[0]['TARIFA2'] > NULO) {

                        $this->pdf->setXY(11, 132);
                        $this->pdf->SetFont('Arial', 'B', 10);
                        $this->pdf->Cell(55, 5, 'PRECIO CONSULTA', 1, 1, 'C');

                        $this->pdf->setXY(11, 137);
                        $this->pdf->Cell(55, 5, ' ', 1, 1, 'C');
                        $this->pdf->SetFont('Arial', '', 10);
                        $this->pdf->Text(35, 141, to_currency($ROW_TARIFA[0]['CONSULTA_TARIFA']));

                        $this->pdf->setXY(87, 132);
                        $this->pdf->SetFont('Arial', 'B', 10);
                        $this->pdf->Cell(22, 5, 'SUBTOTAL', 1, 1, 'C');
                        $this->pdf->SetFont('Arial', '', 10);
                        $this->pdf->Text(94, 141, to_currency($suma));

                        $this->pdf->setXY(109, 132);
                        $this->pdf->SetFont('Arial', 'B', 10);
                        $this->pdf->Cell(22, 5, 'DESCUENTO', 1, 1, 'C');
                        $this->pdf->SetFont('Arial', '', 10);
                        $this->pdf->Text(115, 141, to_currency($descuento));

                        $this->pdf->setXY(131, 132);
                        $this->pdf->SetFont('Arial', 'B', 10);
                        $this->pdf->Cell(33, 5, 'TOTAL A PAGAR', 1, 1, 'C');
                        $this->pdf->SetFont('Arial', '', 10);
                        $this->pdf->Text(142, 141, to_currency($total));
                        $this->pdf->SetFont('Arial', 'B', 9);
                        $this->pdf->setXY(66, 132);
                        $this->pdf->Cell(21, 5, 'DESC. TARIFA', 1, 1, 'C');
                        $this->pdf->SetFont('Arial', '', 10);
                        $this->pdf->Text(72, 141, utf8_decode('%' . $porcentaje));

                        $this->pdf->setXY(66, 137);
                        $this->pdf->Cell(21, 5, ' ', 1, 1, 'C');



                        $this->pdf->setXY(87, 137);
                        $this->pdf->Cell(22, 5, ' ', 1, 1, 'C');



                        $this->pdf->setXY(109, 137);
                        $this->pdf->Cell(22, 5, ' ', 1, 1, 'C');



                        $this->pdf->setXY(131, 137);
                        $this->pdf->Cell(33, 5, '  ', 1, 1, 'C');
                    }

                    $this->pdf->SetFont('Arial', 'B', 8); //Arial, negrita, 12 puntos
                    $this->pdf->setXY(13, 255);
                    $this->pdf->Cell(0, 0, utf8_decode('Km. 53.5 CARRETERA MELAQUE-PUERTO VALLARTA TELS:(315) 351 0170 Y 351 0169 FAX:(315) 351 0043 CAREYITOS,JALISCO. C.P.48890'), 0, 0, 'C');
                    $this->pdf->line(12, $y + 257, 205, $y + 257);
                    //Posición 0 || 1 || 2 || 3

                    $this->pdf->Output(); //Salida al navegador del pdf
                } else {
                    echo "redirect('Consult/index')";
                }
            } else {
                redirect('Consult/index');
            }
        }
    }

    //FICHA DE URGENCIA
    public function creaPdfUrgency($ID_URGENCY)
    {
        if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {

            if ($ID_URGENCY > NULO) {
                $ROW_URGENCY = $this->mconsult->get_urgency_by_id($ID_URGENCY);
                $ROW_PROC = $this->mconsult->get_procedimiento_by_urgency_id($ID_URGENCY);
                $ROW_MAT = $this->mconsult->get_producto_by_urgency_id($ID_URGENCY);
                $SUM_PROC = $this->mconsult->get_sum($ROW_URGENCY[0]['ID_FICHA']);
                $SUM_FICHA = $this->mconsult->get_sum_ficha($ROW_URGENCY[0]['ID_FICHA']);
                if (count($ROW_URGENCY) > NULO) {
                    $this->load->library('PDF');
                    //Carpeta imágenes está un directorio arriba
                    $directorioPadre = base_url() . "assets/img/";

                    // $this->pdf->Image($directorioPadre."logo.jpg",10,10,10,28);

                    $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                    $this->pdf->SetFont('Arial', 'B', 10); //Arial, negrita, 12 puntos
                    $this->pdf->designUp();

                    $this->pdf->image(base_url() . "assets/img/encabezado.png", 76, 6, 100);

                    $this->pdf->setXY(11, 29);
                    $this->pdf->Cell(66, 5, 'FECHA:', 1, 1, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(37, 32.5, $ROW_URGENCY[0]['FECHA_URGENCIA']);

                    $this->pdf->setXY(77, 29);
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->Cell(66, 5, 'HORA DE INGRESO:', 1, 1, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(118, 32.5, $ROW_URGENCY[0]['HORA_URGENCIA']);

                    $this->pdf->setXY(143, 29);
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->Cell(62, 5, 'HORA DE EGRESO:', 1, 1, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(183, 32.5, $ROW_URGENCY[0]['HREGRESO_URGENCIA']);

                    $this->pdf->setXY(11, 34);
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->Cell(138, 5, 'NOMBRE DEL PACIENTE:', 1, 1, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(60, 37, utf8_decode(mb_strtoupper($ROW_URGENCY[0]['NOMBRE_PACIENTE'])) . ' ' . utf8_decode(mb_strtoupper($ROW_URGENCY[0]['APELLIDO_PATERNO_PACIENTE'])) . ' ' . utf8_decode(mb_strtoupper($ROW_URGENCY[0]['APELLIDO_MATERNO_PACIENTE'])));

                    $this->pdf->setXY(149, 34);
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->Cell(30, 5, 'EDAD:', 1, 1, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(166, 37, calcula_edad_2($ROW_URGENCY[0]['FECHA_NAC_PACIENTE'], $ROW_URGENCY[0]['FECHA_URGENCIA']));

                    $this->pdf->setXY(179, 34);
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->Cell(26, 5, 'SEXO:', 1, 1, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(196, 37, $ROW_URGENCY[0]['ABREV_SEXO']);

                    $this->pdf->setXY(164, 132);
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->Cell(41, 5, 'TOTAL PAGADO', 1, 1, 'C');
                    $this->pdf->setXY(164, 137);
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Cell(41, 5, ' ', 1, 1, 'C');
                    $this->pdf->Text(179, 141, to_currency($ROW_URGENCY[0]['TOTAL_PAGADO_URGENCIA']));


                    if ($ROW_URGENCY[0]['TARIFA2'] > NULO) {
                        $ROW_TARIFA = $this->mconfig->get_tarifa_by_id($ROW_URGENCY[0]['TARIFA2']);
                        $suma = $SUM_PROC[0]['suma'] + $SUM_FICHA[0]['sumaficha'] + $ROW_TARIFA[0]['URGENCIA_TARIFA'];
                        $NOMBRE_TARIFA = $ROW_TARIFA[0]['NOMBRE_TARIFA'];
                        $porcentaje = $ROW_URGENCY[0]['DESC_TARIFA'];
                        $descuento = $suma * ($porcentaje / 100);
                        $total = $suma - $descuento;
                        $this->pdf->setXY(11, 39);
                        $this->pdf->SetFont('Arial', 'B', 10);
                        $this->pdf->Cell(194, 5, 'TIPO DE TARIFA:', 1, 1, 'L');
                        $this->pdf->SetFont('Arial', '', 10);
                        $this->pdf->Text(60, 43, $ROW_TARIFA[0]['NOMBRE_TARIFA']);
                    }
                    if ($ROW_URGENCY[0]['MEMBRESIA2'] > NULO) {
                        $ROW_MEMBRESIA = $this->mconfig->get_membresia_by_id($ROW_URGENCY[0]['MEMBRESIA2']);
                        $this->pdf->setXY(11, 39);
                        $this->pdf->SetFont('Arial', 'B', 10);
                        $this->pdf->Cell(194, 5, 'MEMBRESIA:', 1, 1, 'L');
                        $this->pdf->SetFont('Arial', '', 10);
                        $this->pdf->Text(55, 43, $ROW_MEMBRESIA[0]['NOMBRE_MEMBRESIA']);
                        $ROW_PERFIL = $this->mconfig->get_perfil_by_id($ROW_URGENCY[0]['ID_PERFIL_MEMBRESIA']);
                        $this->pdf->setXY(77, 39);
                        $this->pdf->SetFont('Arial', 'B', 10);
                        $this->pdf->Cell(128, 5, 'PERFIL:', 1, 1, 'L');
                        $this->pdf->SetFont('Arial', '', 10);
                        if (count($ROW_PERFIL) <= 0) {
                            $this->pdf->Text(100, 43, 'Sin asignar', 1, 1, 'L');
                        } else {
                            $this->pdf->Text(100, 43, $ROW_PERFIL[0]['NOMBRE_PERFIL']);
                        }
                    }

                    $this->pdf->setXY(11, 44);
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->Cell(194, 5, utf8_decode('DIAGNÓSTICO:'), 1, 1, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(60, 48, utf8_decode(mb_strtoupper($ROW_URGENCY[0]['DIAGNOSTICO'])));

                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->Text(26, 56, 'PROCEDIMIENTOS');
                    $this->pdf->Text(113, 56, 'MATERIAL Y MEDICAMENTOS UTILIZADOS');

                    $this->pdf->setXY(11, 57);
                    $this->pdf->Cell(55, 5, 'NOMBRE', 1, 1, 'C');

                    $this->pdf->setXY(66, 57);
                    $this->pdf->Cell(20, 5, 'CANT.', 1, 1, 'C');

                    $this->pdf->setXY(86, 57);
                    $this->pdf->Cell(23, 5, 'COSTO', 1, 1, 'C');

                    $this->pdf->setXY(109, 57);
                    $this->pdf->Cell(55, 5, 'NOMBRE', 1, 1, 'C');

                    $this->pdf->setXY(164, 57);
                    $this->pdf->Cell(20, 5, 'CANT.', 1, 1, 'C');

                    $this->pdf->setXY(184, 57);
                    $this->pdf->Cell(21, 5, 'COSTO', 1, 1, 'C');

                    $posicionY = 62;
                    $this->pdf->SetFont('Arial', 'B', 8);

                    for ($x = 0; $x < 14; $x++) {
                        $NOMBRE_PROCEDIMIENTO = isset($ROW_PROC[$x]['NOMBRE_PROCEDIMIENTO']) ? $ROW_PROC[$x]['NOMBRE_PROCEDIMIENTO'] : '';
                        $CANT_PROCEDIMIENTO = isset($ROW_PROC[$x]['CANT_PROCEDIMIENTO']) ? $ROW_PROC[$x]['CANT_PROCEDIMIENTO'] : '';
                        $PRECIO_PROCEDIMIENTO = isset($ROW_PROC[$x]['PRECIO_PROCEDIMIENTO']) ? $ROW_PROC[$x]['PRECIO_PROCEDIMIENTO'] : '';

                        $NOMBRE_PRODUCTO = isset($ROW_MAT[$x]['NOMBRE_PRODUCTO']) ? $ROW_MAT[$x]['NOMBRE_PRODUCTO'] : '';
                        $CANT_PRODUCTO = isset($ROW_MAT[$x]['CANT_PRODUCTO']) ? $ROW_MAT[$x]['CANT_PRODUCTO'] : '';
                        $PRECIO_PRODUCTO = isset($ROW_MAT[$x]['PRECIO_PRODUCTO']) ? $ROW_MAT[$x]['PRECIO_PRODUCTO'] : '';

                        $this->pdf->setXY(11, $posicionY);
                        $limit = strlen($NOMBRE_PROCEDIMIENTO);
                        $nom_Procedim = '';

                        if ($limit > 29) {
                            $nom_Procedim = substr(utf8_decode($NOMBRE_PROCEDIMIENTO), 0, 28) . '...';
                        } else {
                            $nom_Procedim = $NOMBRE_PROCEDIMIENTO;
                        }
                        $this->pdf->SetFont('Arial', '', 10);
                        $this->pdf->Cell(55, 5, utf8_decode($nom_Procedim), 1, 1, 'L');

                        $this->pdf->setXY(66, $posicionY);
                        $this->pdf->Cell(20, 5, $CANT_PROCEDIMIENTO, 1, 1, 'C');

                        $this->pdf->setXY(86, $posicionY);
                        $this->pdf->Cell(23, 5, floatval($PRECIO_PROCEDIMIENTO) > 0 ? to_currency(floatval($PRECIO_PROCEDIMIENTO)) : "", 1, 1, 'R');

                        $this->pdf->setXY(109, $posicionY);
                        $limit = strlen($NOMBRE_PRODUCTO);
                        $nom_Producto = '';

                        if ($limit > 30) {
                            $nom_Producto = substr(utf8_decode($NOMBRE_PRODUCTO), 0, 29) . '...';
                        } else {
                            $nom_Producto = $NOMBRE_PRODUCTO;
                        }

                        $this->pdf->Cell(55, 5, utf8_decode($nom_Producto), 1, 1, 'L');
                        //$this->pdf->Cell(55, 5, $NOMBRE_PRODUCTO, 1, 1, 'L');

                        $this->pdf->setXY(164, $posicionY);
                        $this->pdf->Cell(20, 5, $CANT_PRODUCTO, 1, 1, 'C');

                        $this->pdf->setXY(184, $posicionY);
                        $this->pdf->Cell(21, 5, floatval($PRECIO_PRODUCTO) > 0 ? to_currency(floatval($PRECIO_PRODUCTO)) : "", 1, 1, 'R');

                        $posicionY += 5;
                    }
                    $this->pdf->setXY(11, 120);
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->Cell(55, 20, 'TOTAL', 0, 0, 'C');

                    $this->pdf->setXY(88, 127);
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Cell(21, 5, to_currency($SUM_PROC[0]['suma']), 0, 0, 'R');

                    $this->pdf->setXY(110, 120);
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->Cell(55, 20, 'TOTAL', 0, 0, 'C');

                    $this->pdf->setXY(186, 127);
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Cell(19, 5, to_currency($SUM_FICHA[0]['sumaficha']), 0, 0, 'R');

                    if ($ROW_URGENCY[0]['TARIFA2'] > NULO) {

                        $this->pdf->setXY(11, 132);
                        $this->pdf->SetFont('Arial', 'B', 10);
                        $this->pdf->Cell(55, 5, 'PRECIO CONSULTA', 1, 1, 'C');

                        $this->pdf->setXY(11, 137);
                        $this->pdf->SetFont('Arial', '', 10);
                        $this->pdf->Cell(55, 5, ' ', 1, 1, 'C');
                        $this->pdf->Text(35, 141, to_currency($ROW_TARIFA[0]['URGENCIA_TARIFA']));

                        $this->pdf->setXY(66, 132);
                        $this->pdf->SetFont('Arial', 'B', 8);
                        $this->pdf->Cell(21, 5, 'DESC. TARIFA', 1, 1, 'C');
                        $this->pdf->Text(72, 141, utf8_decode('%' . $porcentaje));

                        $this->pdf->setXY(66, 137);
                        $this->pdf->Cell(21, 5, ' ', 1, 1, 'C');

                        $this->pdf->setXY(87, 132);
                        $this->pdf->SetFont('Arial', 'B', 10);
                        $this->pdf->Cell(22, 5, 'SUBTOTAL', 1, 1, 'C');
                        $this->pdf->SetFont('Arial', '', 10);
                        $this->pdf->Text(94, 141, to_currency($suma));

                        $this->pdf->setXY(87, 137);
                        $this->pdf->Cell(22, 5, ' ', 1, 1, 'C');

                        $this->pdf->setXY(109, 132);
                        $this->pdf->SetFont('Arial', 'B', 10);
                        $this->pdf->Cell(22, 5, 'DESCUENTO', 1, 1, 'C');
                        $this->pdf->SetFont('Arial', '', 10);
                        $this->pdf->Text(115, 141, to_currency($descuento));

                        $this->pdf->setXY(109, 137);
                        $this->pdf->Cell(22, 5, ' ', 1, 1, 'C');

                        $this->pdf->setXY(131, 132);
                        $this->pdf->SetFont('Arial', 'B', 10);
                        $this->pdf->Cell(33, 5, 'TOTAL A PAGAR', 1, 1, 'C');
                        $this->pdf->SetFont('Arial', '', 10);
                        $this->pdf->Text(142, 141, to_currency($total));

                        $this->pdf->setXY(131, 137);
                        $this->pdf->Cell(33, 5, '  ', 1, 1, 'C');
                    }

                    $this->pdf->SetFont('Arial', 'B', 8); //Arial, negrita, 12 puntos
                    $this->pdf->setXY(13, 255);
                    $this->pdf->Cell(0, 0, utf8_decode('Km. 53.5 CARRETERA MELAQUE-PUERTO VALLARTA TELS:(315) 351 0170 Y 351 0169 FAX:(315) 351 0043 CAREYITOS,JALISCO. C.P.48890'), 0, 0, 'C');
                    $this->pdf->line(12, $y + 257, 205, $y + 257);

                    //Nos ayuda a saber qué posición está haciendo
                    //Posición 0 || 1 || 2 || 3

                    $this->pdf->Output(); //Salida al navegador del pdf
                } else {
                    redirect('Urgency/index');
                }
            }
        }
    }

    //FORMATO DE URGENCIA
    public function creaPdfFichaUrgency($ID_URGENCY)
    {
        if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {

            if ($ID_URGENCY > NULO) {
                $ROW_URGENCY = $this->mconsult->get_urgency_by_id($ID_URGENCY);
                if (count($ROW_URGENCY) > NULO) {
                    $this->load->library('PDF');
                    //Carpeta imágenes está un directorio arriba
                    $directorioPadre = base_url() . "assets/img/";

                    $this->pdf->AddPage('P', 'letter', 0); //Vertical, Carta
                    $this->pdf->SetFont('Arial', 'B', 10); //Arial, negrita, 12 puntos
                    $this->pdf->designUp();
                    $this->pdf->image(base_url() . "assets/img/encabezado.png", 76, 8, 100);

                    /*if ($ROW_URGENCY[0]['TARIFA2'] > NULO) {
                        $ROW_TARIFA = $this->mconfig->get_tarifa_by_id($ROW_URGENCY[0]['TARIFA2']);
                        $this->pdf->text(163, 32, 'Tarifa:', 0, 0, 'L');
                        $this->pdf->SetFont('Arial', '', 10);
                        $this->pdf->Text(180, 32, $ROW_TARIFA[0]['NOMBRE_TARIFA']);
                    }
                    if ($ROW_URGENCY[0]['MEMBRESIA2'] > NULO) {
                        $ROW_MEMBRESIA = $this->mconfig->get_membresia_by_id($ROW_URGENCY[0]['MEMBRESIA2']);
                        $this->pdf->setXY(125, 31);
                        $this->pdf->text(163, 32, 'Membresia:', 0, 0, 'L');
                        $this->pdf->SetFont('Arial', '', 10);
                        $this->pdf->Text(143, 34, $ROW_MEMBRESIA[0]['NOMBRE_MEMBRESIA']);

                        $ROW_PERFIL = $this->mconfig->get_perfil_by_id($ROW_URGENCY[0]['ID_PERFIL_MEMBRESIA']);
                        $this->pdf->setXY(160, 31);
                        $this->pdf->SetFont('Arial', 'B', 10);
                        $this->pdf->Cell(26, 5, 'Perfil', 0, 0, 'L');
                        $this->pdf->SetFont('Arial', '', 10);
                        $this->pdf->Text(171, 34, $ROW_PERFIL[0]['NOMBRE_PERFIL']);
                    }*/
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(26, 40, 'Nombre:', 0, 0, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->SetXY(40, 36);
                    $this->pdf->Multicell(50, 4.5, utf8_decode($ROW_URGENCY[0]['NOMBRE_PACIENTE']) . ' ' . utf8_decode($ROW_URGENCY[0]['APELLIDO_PATERNO_PACIENTE']) . ' ' . utf8_decode($ROW_URGENCY[0]['APELLIDO_MATERNO_PACIENTE']), 0, 1);

                    $this->pdf->SetXY(90, 36);

                    /*$this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->multicell(40, 5.5, 'Lugar Nacimiento:',0,1);
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(115, 40, strtoupper(utf8_decode($ROW_URGENCY[0]['LUGAR_NACIMIENTO'])));*/

                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(163, 40, 'Edad:', 0, 0, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(173, 40, calcula_edad_2($ROW_URGENCY[0]['FECHA_NAC_PACIENTE'], $ROW_URGENCY[0]['FECHA_URGENCIA']));

                    /*$this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(152, 47, 'Residencia:', 0, 0, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(172, 47, utf8_decode($ROW_URGENCY[0]['RESIDENCIA']));*/

                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(26, 47, 'Domicilio:', 0, 0, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(43, 47, utf8_decode($ROW_URGENCY[0]['CALLE_PACIENTE']) . ' ' . utf8_decode($ROW_URGENCY[0]['NUMERO_PACIENTE']) . ' ' . utf8_decode($ROW_URGENCY[0]['COLONIA_PACIENTE']));

                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(26, 54, 'Ingreso:', 0, 0, 'L');

                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(50, 54, 'Fecha:', 0, 0, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(62, 54, $ROW_URGENCY[0]['FECHA_URGENCIA']);

                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(90, 54, 'Hora:', 0, 0, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(99, 54, $ROW_URGENCY[0]['HORA_URGENCIA']);

                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(120, 54, utf8_decode('Condición:'), 0, 0, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(139, 54, $ROW_URGENCY[0]['CONDICION_URGENCIA']);

                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(155, 54, utf8_decode('Origen:'), 0, 0, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(176, 54, $ROW_URGENCY[0]['ORIGEN_URGENCIA']);

                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(26, 61, 'Motivo de urgencia:', 0, 0, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(61, 61, utf8_decode($ROW_URGENCY[0]['MOTIVO_URGENCIA']));

                    $this->pdf->SetXY(26, 68);
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(26, 68, utf8_decode('Inicio y Evolución:'), 0, 0, 'L');


                    $y = $this->pdf->GetY();

                    $this->pdf->SetXY(26, $y);
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Multicell(168, 5.5, utf8_decode($ROW_URGENCY[0]['INICIOEVOLUCION_URGENCIA']));
                    $this->pdf->Ln(2);
                    $y = $this->pdf->GetY();

                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(26, $y + 2, utf8_decode('Signos Vitales:'), 0, 0, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Ln(5);

                    $y = $this->pdf->GetY();
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(26, $y + 2, utf8_decode('TA:'));
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(33, $y + 2, $ROW_URGENCY[0]['SIGNOS_VITALES']);


                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(57, $y + 2, utf8_decode('FC:'));
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(64, $y + 2, $ROW_URGENCY[0]['FC_URGENCIA']);

                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(79, $y + 2, utf8_decode('RITMO CARDIACO:'));
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(115, $y + 2, $ROW_URGENCY[0]['RITMO_CARDIACO_URGENCIA']);

                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(140, $y + 2, utf8_decode('TEMP.:'));
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(154, $y + 2, utf8_decode($ROW_URGENCY[0]['TEMP_URGENCIA']));


                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(169, $y + 2, utf8_decode('FR:'));
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(177, $y + 2, $ROW_URGENCY[0]['FR_URGENCIA']);

                    $y = $this->pdf->GetY();
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(26, $y + 6, utf8_decode('SAT:'));
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(36, $y + 6, $ROW_URGENCY[0]['SAT_URGENCIA']);


                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(50, $y + 6, utf8_decode('GLICEMA CAPILAR:'));
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(89, $y + 6, $ROW_URGENCY[0]['GLICEMIA_CAPILAR_URGENCIA']);
                    $this->pdf->Ln(6);

                    $y = $this->pdf->GetY();

                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(26, $y + 4, utf8_decode('Diágnostico Ingreso:'), 0, 0, 'L');
                    $this->pdf->SetFont('Arial', '', 10);

                    $y = $this->pdf->GetY();
                    $this->pdf->SetXY(26, $y + 4);
                    $this->pdf->Multicell(170, 4.4, utf8_decode($ROW_URGENCY[0]['DIAGNOSTICO']));
                    $this->pdf->Ln(6);

                    $y = $this->pdf->GetY();

                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(26, $y, utf8_decode('Exploración Física:'), 0, 0, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->setXY(25, $y);
                    $this->pdf->Multicell(160, 5.5, utf8_decode($ROW_URGENCY[0]['EXPLORACION_FISICA']));
                    $this->pdf->Ln(2);

                    $y = $this->pdf->GetY();
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(26, $y, utf8_decode('Manejo intrahospitalario:'), 0, 0, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->setXY(25, $y);
                    $this->pdf->Multicell(168, 5.5, utf8_decode($ROW_URGENCY[0]['MANEJO_INTRAHOSPITALARIO_URGENCIA']));
                    $this->pdf->Ln(2);

                    $y = $this->pdf->GetY();
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(26, $y, utf8_decode('Tratamiento:'), 0, 0, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->setXY(25, $y);
                    $this->pdf->Multicell(168, 5.5, utf8_decode($ROW_URGENCY[0]['TRATAMIENTO_URGENCIA']));
                    $this->pdf->Ln(2);

                    $y = $this->pdf->GetY();
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(26, $y, utf8_decode('Evolución:'), 0, 0, 'L');

                    $this->pdf->setXY(25, $y);
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Multicell(168, 6.5, utf8_decode($ROW_URGENCY[0]['EVOLUCION_URGENCIA']));
                    $this->pdf->Ln(2);

                    $y = $this->pdf->GetY();
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(26, $y, utf8_decode('Observaciones:'), 0, 0, 'L');

                    $y = $this->pdf->GetY();
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->setXY(26, $y);
                    $this->pdf->Multicell(168, 5.5, utf8_decode($ROW_URGENCY[0]['OBSERVACION_URGENCIA']));
                    $this->pdf->Ln(5);

                    $y = $this->pdf->GetY();
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(26, $y, utf8_decode('Egreso:'), 0, 0, 'L');
                    $this->pdf->Ln(5);
                    $y = $this->pdf->GetY();

                    $this->pdf->text(26, $y, utf8_decode('DX egreso:'), 0, 0, 'L');

                    $this->pdf->setXY(25, $y + 3);
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Multicell(163, 4.5, utf8_decode($ROW_URGENCY[0]['DIAGNOSTICO_EGRESO']));

                    $y = $this->pdf->GetY();

                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(26, $y + 3, utf8_decode('Fecha:'), 0, 0, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(38, $y + 3, $ROW_URGENCY[0]['FECHAEGRESO_URGENCIA']);

                    $y = $this->pdf->GetY();
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(61, $y + 3, utf8_decode('Hora:'), 0, 0, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(72, $y + 3, $ROW_URGENCY[0]['HREGRESO_URGENCIA']);

                    $y = $this->pdf->GetY();
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(87, $y + 3, utf8_decode('Destino:'), 0, 0, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(102, $y + 3, utf8_decode($ROW_URGENCY[0]['DESTINO']));

                    // Verificar si el contenido anterior alcanza el límite inferior
                    if ($y + 10 > $this->pdf->GetPageHeight() - $footerHeight) {
                        $this->pdf->AddPage();  // Añadir una nueva página si no hay espacio suficiente
                    }

                    $y = $this->pdf->GetY();
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->text(26, $y + 10, utf8_decode('Médico:'), 0, 0, 'L');
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(40, $y + 10, utf8_decode($ROW_URGENCY[0]['NOMBRE_USUARIO'] . ' ' . $ROW_URGENCY[0]['APELLIDO_USUARIO']));

                    $this->pdf->SetFont('Arial', 'B', 8); //Arial, negrita, 12 puntos
                    //$this->pdf->setXY(13, 258);

                    $footerHeight = 10; // Altura del pie de página
                    $this->pdf->SetAutoPageBreak(true, $footerHeight);
                    $this->pdf->SetY(-$footerHeight);

                    $this->pdf->Cell(0, 0, utf8_decode('Km. 53.5 CARRETERA MELAQUE-PUERTO VALLARTA TELS:(315) 351 0170 Y 351 0169 FAX:(315) 351 0043 CAREYITOS,JALISCO. C.P.48890'), 0, 1, 'C');
                    $y = $this->pdf->GetY();
                    $this->pdf->line(12, $y + 2, 205, $y + 2);

                    $this->pdf->Output(); //Salida al navegador del pdf
                    $this->pdf->close();
                } else {
                    redirect('Urgency/index');
                }
            } else {
                redirect('Urgency/index');
            }
        } else {
            redirect('Login/salir');
        }
    }

    //RECETA
    public function creaPdfReceta($ID_CONSULT)
    {
        if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {

            if ($ID_CONSULT > NULO) {
                $ROW_CONSULT = $this->mconsult->get_consult_by_id_consult($ID_CONSULT);

                if (count($ROW_CONSULT) > NULO) {
                    $this->load->library('PDF');
                    //Carpeta imágenes está un directorio arriba
                    $directorioPadre = base_url() . "assets/img/";

                    // $this->pdf->Image($directorioPadre."logo.jpg",10,10,10,28);

                    $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                    $this->pdf->SetFont('Arial', 'B', 10); //Arial, negrita, 12 puntos
                    $this->pdf->designUp();

                    $this->pdf->image(base_url() . "assets/img/encabezado.png", 76, 8, 100);

                    $this->pdf->setXY(11, 29);
                    $this->pdf->SetFont('Arial', '', 9);
                    $this->pdf->line(153, 43, 199, 43);
                    $this->pdf->text(140, 43, utf8_decode('Fecha:'), 0, 0, 'L');
                    $this->pdf->Text(160, 42, $ROW_CONSULT[0]['FECHA_CONSULTA']);

                    $this->pdf->text(16, 43, utf8_decode('Paciente:'), 0, 0, 'L');

                    $this->pdf->setXY(11, 34);
                    $this->pdf->line(40, 43, 140, 43);
                    $this->pdf->Text(41, 42, utf8_decode(mb_strtoupper($ROW_CONSULT[0]['NOMBRE_PACIENTE'])) . ' ' . utf8_decode(mb_strtoupper($ROW_CONSULT[0]['APELLIDO_PATERNO_PACIENTE'])) . ' ' . utf8_decode(mb_strtoupper($ROW_CONSULT[0]['APELLIDO_MATERNO_PACIENTE'])));

                    $this->pdf->text(16, 53, utf8_decode('Diagnóstico:'), 0, 0, 'L');
                    $this->pdf->Text(41, 53, utf8_decode($ROW_CONSULT[0]['DIAGNOSTICO_EGRESO_CONSULTA']));
                    $this->pdf->line(40, 54, 140, 54);

                    $this->pdf->text(141, 53, 'Edad:', 0, 0, 'L');
                    $this->pdf->Text(167, 52, calcula_edad_2($ROW_CONSULT[0]['FECHA_NAC_PACIENTE'], $ROW_CONSULT[0]['FECHA_CONSULTA']));
                    $this->pdf->line(153, 53, 199, 53);

                    $this->pdf->setXY(15, 56);
                    $this->pdf->Multicell(163, 5.5, utf8_decode($ROW_CONSULT[0]['TRATAMIENTO_CONSULTA']));

                    $this->pdf->setXY(25, 145);
                    $y = $this->pdf->GetY();

                    $this->pdf->Text(25, $y + 5, utf8_decode('DR.:'), 0, 0, 'L');
                    $this->pdf->Text(35, $y + 5, utf8_decode($ROW_CONSULT[0]['NOMBRE_USUARIO'] . ' ' . $ROW_CONSULT[0]['APELLIDO_USUARIO']));
                    $this->pdf->line(34, $y + 6, 139, $y + 6);
                    $this->pdf->Text(140, $y + 5, utf8_decode('CEDULA:'), 0, 0, 'L');
                    $this->pdf->Text(167, $y + 5, $ROW_CONSULT[0]['CEDULA_USUARIO']);
                    $this->pdf->line(159, $y + 6, 199, $y + 6);

                    $this->pdf->SetFont('Arial', 'B', 8); //Arial, negrita, 12 puntos
                    $this->pdf->setXY(10, 157);
                    $this->pdf->Cell(0, 0, utf8_decode('Km. 53.5 CARRETERA MELAQUE-PUERTO VALLARTA TELS:(315) 351 0170 Y 351 0169 FAX:(315) 351 0043 CAREYITOS,JALISCO. C.P.48890'), 0, 0, 'C');
                    $this->pdf->line(12, $y + 17, 205, $y + 17);
                    //$this->SetFont('Arial', 'B', 8); //Arial, negrita, 12 puntos
                    // $this->pdf->setXY(13, 255);
                    //$this->Cell(0, 5, utf8_decode('Km. 53.5 CARRETERA MELAQUE-PUERTO VALLARTA TELS:(315) 351 0170 Y 351 0169 FAX:(315) 351 0043 CAREYITOS,JALISCO. C.P.48890'), 0, 0, 'C');
                    //$y = $this->GetY();
                    // $this->line(12, $y+7, 205, $y+7);

                    $this->pdf->Output(); //Salida al navegador del pdf
                } else {
                    echo "redirect('Consult/index')";
                }
            } else {
                redirect('Consult/index');
            }
        }
    }
}
