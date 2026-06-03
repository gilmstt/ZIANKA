<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Consult extends CI_Controller
{
    /**
     * @var mconsult
     * @var Murgency
     * @var mpatient
     * @var mconfig
     * @var Minventary
     * @var pdf
     */
    public $mconsult;
    public $Murgency;
    public $mpatient;
    public $mconfig;
    public $Minventary;
    public $pdf;
    private $ID_SESSION;
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
    /*public function ajax_insert_ficha()
    {
        if ($this->input->is_ajax_request()) {
            $this->mconsult->insertFicha();
        } else {
            redirect('index');
        }
    }*/

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

            $id_tipos = $this->input->post('id_tipo_consulta');

            // Convertir a array si solo viene un valor
            if (!is_array($id_tipos)) {
                $id_tipos = [$id_tipos];
            }

            // Filtrar valores vacíos o inválidos
            $id_tipos = array_filter($id_tipos, function ($id) {
                return !empty($id) && is_numeric($id);
            });

            if (empty($id_tipos)) {
                echo json_encode([]);
                return;
            }

            // Llamamos al modelo (esta es la forma correcta)
            $data = $this->mconsult->getProcedimientosPorTipo($id_tipos);

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
                $this->pdf->Image(FCPATH . "assets/img/encabezado.png", 76, 8, 100);
                $this->pdf->designUp();

                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, 40, 'Nombre:', 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(42, 40, mb_convert_encoding($ROW_CONSULT[0]['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($ROW_CONSULT[0]['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($ROW_CONSULT[0]['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));

                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(150, 40, 'Edad:', 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(160, 40, mb_convert_encoding(calcula_edad_2($ROW_CONSULT[0]['FECHA_NAC_PACIENTE'], $ROW_CONSULT[0]['FECHA_CONSULTA']), 'ISO-8859-1', 'UTF-8'));

                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, 47, 'Domicilio:', 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(46, 47, mb_convert_encoding($ROW_CONSULT[0]['CALLE_PACIENTE'], 'ISO-8859-1', 'UTF-8')  . ' ' . mb_convert_encoding($ROW_CONSULT[0]['NUMERO_PACIENTE'], 'ISO-8859-1', 'UTF-8')  . ' ' . mb_convert_encoding($ROW_CONSULT[0]['COLONIA_PACIENTE'], 'ISO-8859-1', 'UTF-8'));

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
                $this->pdf->text(129, 58, mb_convert_encoding('Condición:', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(139, 58, mb_convert_encoding($ROW_CONSULT[0]['CONDICION_CONSULTA'], 'ISO-8859-1', 'UTF-8'));

                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(159, 58, mb_convert_encoding('Origen:', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(174, 58, mb_convert_encoding($ROW_CONSULT[0]['ORIGEN_CONSULTA'], 'ISO-8859-1', 'UTF-8'));

                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, 65, 'Motivo de Consulta:', 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(64, 65, mb_convert_encoding($ROW_CONSULT[0]['MOTIVO_CONSULTA'], 'ISO-8859-1', 'UTF-8'));

                $this->pdf->setXY(25, 65);
                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, 70, mb_convert_encoding('Inicio y Evolución:', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');


                $y = $this->pdf->GetY();
                $this->pdf->setXY(25, $y + 5);
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Multicell(168, 5.5, mb_convert_encoding($ROW_CONSULT[0]['INICIOEVOLUCION_CONSULTA'], 'ISO-8859-1', 'UTF-8'));
                $this->pdf->Ln(3);

                $y = $this->pdf->GetY();
                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, $y, mb_convert_encoding('Signos Vitales:', 'ISO-8859-1', 'UTF-8'));
                $this->pdf->Ln(3);

                $y = $this->pdf->GetY();
                $this->pdf->text(26, $y + 2, mb_convert_encoding('TA:', 'ISO-8859-1', 'UTF-8'));
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(33, $y + 2, $ROW_CONSULT[0]['SIGNOS_VITALES']);

                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(58, $y + 2, mb_convert_encoding('FC:', 'ISO-8859-1', 'UTF-8'));
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(65, $y + 2, $ROW_CONSULT[0]['FC_CONSULTA']);


                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(86, $y + 2, mb_convert_encoding('RITMO CARDIACO:', 'ISO-8859-1', 'UTF-8'));
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(120, $y + 2, $ROW_CONSULT[0]['RITMO_CARDIACO_CONSULTA']);


                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(140, $y + 2, mb_convert_encoding('TEMP.:', 'ISO-8859-1', 'UTF-8'));
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(154, $y + 2, mb_convert_encoding($ROW_CONSULT[0]['TEMP_CONSULTA'], 'ISO-8859-1', 'UTF-8'));


                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(169, $y + 2, mb_convert_encoding('FR:', 'ISO-8859-1', 'UTF-8'));
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(177, $y + 2, $ROW_CONSULT[0]['FR_CONSULTA']);


                $y = $this->pdf->GetY();
                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, $y + 6, mb_convert_encoding('SAT:', 'ISO-8859-1', 'UTF-8'));
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(36, $y + 6, $ROW_CONSULT[0]['SAT_CONSULTA']);


                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(50, $y + 6, mb_convert_encoding('GLICEMA CAPILAR:', 'ISO-8859-1', 'UTF-8'));
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(89, $y + 6, $ROW_CONSULT[0]['GLICEMIA_CAPILAR_CONSULTA']);
                $this->pdf->Ln(6);

                $y = $this->pdf->GetY();
                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, $y + 4, mb_convert_encoding('Diágnostico Presuntivo:', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(71, $y + 4, mb_convert_encoding($ROW_CONSULT[0]['DIAGNOSTICO'], 'ISO-8859-1', 'UTF-8'));
                $this->pdf->Ln(8);

                $y = $this->pdf->GetY();
                $this->pdf->setXY(25, $y);
                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, $y, mb_convert_encoding('Exploración Física:', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');

                $y = $this->pdf->GetY();
                $this->pdf->setXY(25, $y);
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Multicell(168, 5.5, mb_convert_encoding($ROW_CONSULT[0]['EXPLORACION_FISICA'], 'ISO-8859-1', 'UTF-8'));
                $this->pdf->Ln(4);

                $y = $this->pdf->GetY();
                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, $y, mb_convert_encoding('Manejo Intrahospitalario:', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');

                $y = $this->pdf->GetY();
                $this->pdf->setXY(25, $y);
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Multicell(168, 5.5, mb_convert_encoding($ROW_CONSULT[0]['MANEJO_INTRAHOSPITALARIO_CONSULTA'], 'ISO-8859-1', 'UTF-8'));
                $this->pdf->Ln(4);

                $y = $this->pdf->GetY();
                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, $y, mb_convert_encoding('Tratamiento:', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');

                $y = $this->pdf->GetY();
                $this->pdf->setXY(25, $y);
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Multicell(168, 5.5, mb_convert_encoding($ROW_CONSULT[0]['TRATAMIENTO_CONSULTA'], 'ISO-8859-1', 'UTF-8'));
                $this->pdf->Ln(4);

                $y = $this->pdf->GetY();

                $this->pdf->setXY(25, $y);
                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->Text(26, $y, mb_convert_encoding('Evolución:', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');

                $y = $this->pdf->GetY();

                $this->pdf->setXY(25, $y);
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Multicell(168, 6.5, mb_convert_encoding($ROW_CONSULT[0]['EVOLUCION_CONSULTA'], 'ISO-8859-1', 'UTF-8'));
                $this->pdf->Ln(3);

                $y = $this->pdf->GetY();

                $this->pdf->setXY(25, $y);
                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, $y, mb_convert_encoding('Observaciones:', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');

                $y = $this->pdf->GetY();
                $this->pdf->setXY(25, $y);
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Multicell(168, 6.5, mb_convert_encoding($ROW_CONSULT[0]['OBSERVACIONES_CONSULTA'], 'ISO-8859-1', 'UTF-8'));


                $y = $this->pdf->GetY();

                $this->pdf->setXY(25, $y);
                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->Cell(26, 5, mb_convert_encoding('Egreso:', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');
                $this->pdf->Ln(2);


                $y = $this->pdf->GetY();

                $this->pdf->setXY(25, $y + 4);
                $this->pdf->Cell(26, 5, mb_convert_encoding('DX:', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');

                $this->pdf->setXY(25, $y + 7);
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Multicell(170, 4.4, $ROW_CONSULT[0]['DIAGNOSTICO_EGRESO_CONSULTA']);

                $y = $this->pdf->GetY();
                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, $y + 3, mb_convert_encoding('Fecha:', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(38, $y + 3, $ROW_CONSULT[0]['FECHAEGRESO_CONSULTA']);
                //$this->pdf->line(80, 229.5, 110, 229.5);

                $y = $this->pdf->GetY();

                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(65, $y + 3, mb_convert_encoding('Hora:', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(74, $y + 3, $ROW_CONSULT[0]['HREGRESO_CONSULTA']);
                //$this->pdf->line(118, 229.5, 145, 229.5);

                $y = $this->pdf->GetY();

                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(96, $y + 3, mb_convert_encoding('Destino:', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');

                $y = $this->pdf->GetY();

                $this->pdf->SetFont('Arial', 'B', 10);
                $this->pdf->text(26, $y + 9, mb_convert_encoding('Médico:', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');

                $y = $this->pdf->GetY();
                $this->pdf->SetFont('Arial', '', 10);
                $this->pdf->Text(41, $y + 9, mb_convert_encoding($ROW_CONSULT[0]['NOMBRE_USUARIO'], 'ISO-8859-1', 'UTF-8' . ' ' . $ROW_CONSULT[0]['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));
                //$this->pdf->line(36, 243.5, 193, 243.5);

                $this->pdf->SetFont('Arial', 'B', 8); //Arial, negrita, 12 puntos
                $this->pdf->setXY(13, 255);
                $this->pdf->Cell(0, 0, mb_convert_encoding('Km. 53.5 CARRETERA MELAQUE-PUERTO VALLARTA TELS:(315) 351 0170 Y 351 0169 FAX:(315) 351 0043 CAREYITOS,JALISCO. C.P.48890', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
                $y = $this->pdf->GetY();
                $this->pdf->line(12, $y + 2, 205, $y + 2);

                $this->pdf->Output(); //Salida al navegador del pdf
            } else {
                redirect('consult/index');
            }
        } else {
            redirect('login/salir');
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

                    $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                    $this->pdf->SetFont('Arial', 'B', 10); //Arial, negrita, 12 puntos
                    $this->pdf->designUp();

                    $this->pdf->Image(FCPATH . "assets/img/FichaConsumo/1.png", 0, 0, 215.9, 279.4);

                    $this->pdf->setXY(11, 29);
                    $this->pdf->SetFont('Arial', '', 12);
                    $this->pdf->Text(160, 56, $ROW_CONSULT[0]['FECHA_CONSULTA']);

                    $this->pdf->setXY(77, 29);
                    $this->pdf->SetFont('Arial', 'B', 10);

                    $this->pdf->setXY(143, 29);
                    $this->pdf->SetFont('Arial', 'B', 10);
                    $this->pdf->SetFont('Arial', '', 10);
                    $this->pdf->Text(183, 32.5, $ROW_CONSULT[0]['HREGRESO_CONSULTA']);

                    $this->pdf->setXY(11, 34);
                    $this->pdf->SetFont('Arial', '', 12);
                    $this->pdf->Text(30, 90, mb_convert_encoding(mb_strtoupper($ROW_CONSULT[0]['NOMBRE_PACIENTE']), 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding(mb_strtoupper($ROW_CONSULT[0]['APELLIDO_PATERNO_PACIENTE']), 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding(mb_strtoupper($ROW_CONSULT[0]['APELLIDO_MATERNO_PACIENTE']), 'ISO-8859-1', 'UTF-8'));
                    $this->pdf->Text(160, 46, $ROW_CONSULT[0]['ID_CONSULTA']);
                    $this->pdf->Text(33, 99, mb_convert_encoding($ROW_CONSULT[0]['CALLE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($ROW_CONSULT[0]['NUMERO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($ROW_CONSULT[0]['COLONIA_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                    $this->pdf->Text(33, 109, $ROW_CONSULT[0]['TELEFONO_PACIENTE']);
                    $this->pdf->Text(120, 109, $ROW_CONSULT[0]['EMAIL_PACIENTE']);

                    $TOTAL = $SUM_PROC[0]['suma'] + $SUM_FICHA[0]['sumaficha'];
                    $SUBTOTAL = $TOTAL / 1.16;
                    $IVA = ($TOTAL - $SUBTOTAL);
                    $this->pdf->Text(182, 221, to_currency($SUBTOTAL));
                    $this->pdf->Text(182, 234, to_currency($IVA));
                    $this->pdf->Text(182, 246, to_currency($TOTAL));

                    if ($ROW_CONSULT[0]['TARIFA2'] > NULO) {

                        //---------TO DO -> RECALCULAR EL IVA CON EL SUBTOTAL PARA CORRECION DEL TOTA -------------
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
                        //$this->pdf->Cell(128, 5, 'PERFIL:', 1, 1, 'L');
                        $this->pdf->Text(100, 43, $ROW_PERFIL[0]['NOMBRE_PERFIL']);
                    }

                    $posicionY = 133;

                    for ($x = 0; $x < 9; $x++) {
                        $NOMBRE_PROCEDIMIENTO = isset($ROW_PROC[$x]['NOMBRE_PROCEDIMIENTO']) ? $ROW_PROC[$x]['NOMBRE_PROCEDIMIENTO'] : '';
                        $CANT_PROCEDIMIENTO = isset($ROW_PROC[$x]['CANT_PROCEDIMIENTO']) ? $ROW_PROC[$x]['CANT_PROCEDIMIENTO'] : '';
                        $PRECIO_PROCEDIMIENTO = isset($ROW_PROC[$x]['PRECIO_PROCEDIMIENTO']) ? $ROW_PROC[$x]['PRECIO_PROCEDIMIENTO'] : '';
                        $PNETO_PROCEDIMIENTO = isset($ROW_PROC[$x]['precio_procedimiento']) ? $ROW_PROC[$x]['precio_procedimiento'] : '';

                        //-------------- PROCEDIMIENTOS ------------
                        if (!empty($NOMBRE_PROCEDIMIENTO)) {
                            $this->pdf->SetFont('Arial', '', 9);
                            $limit = strlen($NOMBRE_PROCEDIMIENTO);
                            $nom_Procedim = '';

                            if ($limit > 29) {
                                $nom_Procedim = substr(mb_convert_encoding($NOMBRE_PROCEDIMIENTO, 'ISO-8859-1', 'UTF-8'), 0, 28) . '...';
                            } else {
                                $nom_Procedim = $NOMBRE_PROCEDIMIENTO;
                            }
                            $this->pdf->setXY(11, $posicionY);
                            $this->pdf->Cell(10, 6, mb_convert_encoding($nom_Procedim, 'ISO-8859-1', 'UTF-8'));

                            $this->pdf->setXY(122, $posicionY);
                            $this->pdf->Cell(20, 6, $CANT_PROCEDIMIENTO);

                            $this->pdf->setXY(152, $posicionY);
                            $this->pdf->Cell(30, 6, floatval($PNETO_PROCEDIMIENTO) > 0 ? to_currency(floatval($PNETO_PROCEDIMIENTO / 1.16)) : "");

                            $this->pdf->setXY(184, $posicionY);
                            $this->pdf->Cell(30, 6, floatval($PRECIO_PROCEDIMIENTO) > 0 ? to_currency(floatval($PRECIO_PROCEDIMIENTO / 1.16)) : "");
                            $posicionY += 10;
                        }
                    }

                    //------------- PRODUCTOS   Y   MEDICAMENTOS ---------------

                    for ($x = 0; $x < 9; $x++) {
                        $NOMBRE_PRODUCTO = isset($ROW_MAT[$x]['NOMBRE_PRODUCTO']) ? $ROW_MAT[$x]['NOMBRE_PRODUCTO'] : '';
                        $CANT_PRODUCTO = isset($ROW_MAT[$x]['CANT_PRODUCTO']) ? $ROW_MAT[$x]['CANT_PRODUCTO'] : '';
                        $PRECIO_PRODUCTO = isset($ROW_MAT[$x]['PRECIO_TOTAL']) ? $ROW_MAT[$x]['PRECIO_TOTAL'] : '';
                        $PNETO_PRODUCTO = isset($ROW_MAT[$x]['PRECIO_UNITARIO']) ? $ROW_MAT[$x]['PRECIO_UNITARIO'] : '';

                        $this->pdf->setXY(11, $posicionY);

                        if (!empty($NOMBRE_PRODUCTO)) {
                            $this->pdf->SetFont('Arial', '', 9);
                            $limit = strlen($NOMBRE_PRODUCTO);
                            $nom_Producto = '';
                            if ($limit > 50) {
                                $nom_Producto = substr(mb_convert_encoding($NOMBRE_PRODUCTO, 'ISO-8859-1', 'UTF-8'), 0, 49) . '...';
                            } else {
                                $nom_Producto = $NOMBRE_PRODUCTO;
                            }

                            $this->pdf->Cell(10, 6, mb_convert_encoding($nom_Producto, 'ISO-8859-1', 'UTF-8'));

                            $this->pdf->setXY(122, $posicionY);
                            $this->pdf->Cell(20, 6, $CANT_PRODUCTO);

                            $this->pdf->setXY(152, $posicionY);
                            $this->pdf->Cell(30, 6, floatval($PNETO_PRODUCTO) > 0 ? to_currency(floatval($PNETO_PRODUCTO / 1.16)) : "");

                            $this->pdf->setXY(184, $posicionY);
                            $this->pdf->Cell(40, 6, floatval($PRECIO_PRODUCTO) > 0 ? to_currency(floatval($PRECIO_PRODUCTO / 1.16)) : "");
                            $posicionY += 10;
                        }
                    }

                    if ($ROW_CONSULT[0]['MEMBRECIA2'] > NULL) {

                        $this->pdf->setXY(86, 127);
                        $this->pdf->SetFont('Arial', '', 10);
                        $this->pdf->Cell(23, 5, '$0.00', 1, 1, 'R');
                    } else {
                        $this->pdf->setXY(86, 127);
                        $this->pdf->SetFont('Arial', '', 10);
                    }

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
                        $this->pdf->Text(72, 141, mb_convert_encoding('%' . $porcentaje, 'ISO-8859-1', 'UTF-8'));
                    }

                    $this->pdf->Output(); //Salida al navegador del pdf
                } else {
                    echo "redirect('consult/index')";
                }
            } else {
                redirect('consult/index');
            }
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
                    $modo = $this->input->get('modo'); // o $this->input->post('modo')

                    $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                    $this->pdf->SetFont('Arial', 'B', 10); //Arial, negrita, 12 puntos
                    $this->pdf->designUp();

                    if ($modo != 'imprimir') {
                        $this->pdf->Image(FCPATH . "assets/img/ZC_LABORATORIOS.png", 0, 0, 215.9, 279.4);
                    }

                    $this->pdf->setXY(11, 29);
                    $this->pdf->SetFont('Arial', '', 9);
                    $this->pdf->Text(27, 45, mb_convert_encoding(mb_strtoupper($ROW_CONSULT[0]['NOMBRE_PACIENTE']), 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding(mb_strtoupper($ROW_CONSULT[0]['APELLIDO_PATERNO_PACIENTE']), 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding(mb_strtoupper($ROW_CONSULT[0]['APELLIDO_MATERNO_PACIENTE']), 'ISO-8859-1', 'UTF-8'));
                    $this->pdf->Text(11, 73, date('d', strtotime($ROW_CONSULT[0]['FECHA_NAC_PACIENTE'])));
                    $this->pdf->Text(20, 73, date('m', strtotime($ROW_CONSULT[0]['FECHA_NAC_PACIENTE'])));
                    $this->pdf->Text(30, 73, date('Y', strtotime($ROW_CONSULT[0]['FECHA_NAC_PACIENTE'])));
                    $this->pdf->Text(182, 73, date('d', strtotime($ROW_CONSULT[0]['FECHA_CONSULTA'])));
                    $this->pdf->Text(193, 73, date('m', strtotime($ROW_CONSULT[0]['FECHA_CONSULTA'])));
                    $this->pdf->Text(201, 73, date('Y', strtotime($ROW_CONSULT[0]['FECHA_CONSULTA'])));
                    $this->pdf->Text(47, 73, $ROW_CONSULT[0]['PESO_CONSULTA']);
                    $this->pdf->Text(75, 73, $ROW_CONSULT[0]['TALLA_CONSULTA']);
                    $this->pdf->Text(99, 73, $ROW_CONSULT[0]['IMC_CONSULTA']);
                    $this->pdf->Text(134, 73, $ROW_CONSULT[0]['TEMP_CONSULTA']);
                    $this->pdf->Text(152, 73, $ROW_CONSULT[0]['PA']);

                    $this->pdf->setXY(11, 95);
                    $this->pdf->Multicell(190, 6, mb_convert_encoding($ROW_CONSULT[0]['LABORATORIOS_SOLICITADOS'], 'ISO-8859-1', 'UTF-8'));

                    $this->pdf->setXY(11, 155);
                    $this->pdf->Multicell(190, 6, mb_convert_encoding($ROW_CONSULT[0]['IMPRESION_DIAGNOSTICA'], 'ISO-8859-1', 'UTF-8'));
                    $this->pdf->setXY(25, 145);


                    $this->pdf->Output(); //Salida al navegador del pdf
                } else {
                    echo "redirect('consult/index')";
                }
            } else {
                redirect('consult/index');
            }
        }
    }

    public function ConsentimientoInformado($ID_CONSULT)
    {
        if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {

            if ($ID_CONSULT > NULO) {
                $ROW_CONSULT = $this->mconsult->get_consult_by_id_consult($ID_CONSULT);

                if (count($ROW_CONSULT) > NULO) {
                    $this->load->library('PDF');

                    $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                    $this->pdf->SetFont('Arial', 'B', 10); //Arial, negrita, 12 puntos
                    $this->pdf->designUp();

                    $this->pdf->Image(FCPATH . "assets/img/ZC_LABORATORIOS.png", 0, 0, 215.9, 279.4);

                    $this->pdf->setXY(11, 29);
                    $this->pdf->SetFont('Arial', '', 9);
                    $this->pdf->Text(27, 45, mb_convert_encoding(mb_strtoupper($ROW_CONSULT[0]['NOMBRE_PACIENTE']), 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding(mb_strtoupper($ROW_CONSULT[0]['APELLIDO_PATERNO_PACIENTE']), 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding(mb_strtoupper($ROW_CONSULT[0]['APELLIDO_MATERNO_PACIENTE']), 'ISO-8859-1', 'UTF-8'));
                    $this->pdf->Text(11, 73, date('d', strtotime($ROW_CONSULT[0]['FECHA_NAC_PACIENTE'])));
                    $this->pdf->Text(20, 73, date('m', strtotime($ROW_CONSULT[0]['FECHA_NAC_PACIENTE'])));
                    $this->pdf->Text(30, 73, date('Y', strtotime($ROW_CONSULT[0]['FECHA_NAC_PACIENTE'])));
                    $this->pdf->Text(182, 73, date('d', strtotime($ROW_CONSULT[0]['FECHA_CONSULTA'])));
                    $this->pdf->Text(193, 73, date('m', strtotime($ROW_CONSULT[0]['FECHA_CONSULTA'])));
                    $this->pdf->Text(201, 73, date('Y', strtotime($ROW_CONSULT[0]['FECHA_CONSULTA'])));
                    $this->pdf->Text(47, 73, $ROW_CONSULT[0]['PESO_CONSULTA']);
                    $this->pdf->Text(75, 73, $ROW_CONSULT[0]['TALLA_CONSULTA']);
                    $this->pdf->Text(99, 73, $ROW_CONSULT[0]['IMC_CONSULTA']);
                    $this->pdf->Text(134, 73, $ROW_CONSULT[0]['TEMP_CONSULTA']);
                    $this->pdf->Text(152, 73, $ROW_CONSULT[0]['PA']);

                    $this->pdf->setXY(11, 95);
                    $this->pdf->Multicell(190, 6, mb_convert_encoding($ROW_CONSULT[0]['LABORATORIOS_SOLICITADOS'], 'ISO-8859-1', 'UTF-8'));

                    $this->pdf->setXY(11, 155);
                    $this->pdf->Multicell(190, 6, mb_convert_encoding($ROW_CONSULT[0]['IMPRESION_DIAGNOSTICA'], 'ISO-8859-1', 'UTF-8'));
                    $this->pdf->setXY(25, 145);


                    $this->pdf->Output(); //Salida al navegador del pdf
                } else {
                    echo "redirect('consult/index')";
                }
            } else {
                redirect('consult/index');
            }
        }
    }
    public function creaHistClinica($ID_CONSULT)
    {
        if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {

            if ($ID_CONSULT > NULO) {
                $ROW_CONSULT = $this->mconsult->get_consult_by_id_consult($ID_CONSULT);
                $TRATAMIENTOS = $this->mconsult->get_tratamientos_by_id_consult($ID_CONSULT);

                if (count($ROW_CONSULT) > NULO) {
                    $this->load->library('PDF');
                    $base = FCPATH . 'assets/img/historiaClinica/';

                    $modo = $this->input->get('modo');

                    $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                    $this->pdf->SetFont('Arial', 'B', 10); //Arial, negrita, 12 puntos
                    $this->pdf->designUp();

                    if ($modo != 'imprimir' && file_exists($base . '1.png')) {
                        $this->pdf->Image($base . '1.png', 0, 0, 215.9, 279.4, '', '', '', false, 300, '', false, false, 0);
                    }

                    $this->pdf->setXY(11, 29);
                    $this->pdf->SetFont('Arial', '', 9);
                    $this->pdf->Text(167, 7, date('d', strtotime($ROW_CONSULT[0]['FECHA_CONSULTA'])));
                    $this->pdf->Text(180, 7, date('m', strtotime($ROW_CONSULT[0]['FECHA_CONSULTA'])));
                    $this->pdf->Text(190, 7, date('Y', strtotime($ROW_CONSULT[0]['FECHA_CONSULTA'])));
                    $this->pdf->Text(35, 25, mb_convert_encoding(mb_strtoupper($ROW_CONSULT[0]['NOMBRE_PACIENTE']), 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding(mb_strtoupper($ROW_CONSULT[0]['APELLIDO_PATERNO_PACIENTE']), 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding(mb_strtoupper($ROW_CONSULT[0]['APELLIDO_MATERNO_PACIENTE']), 'ISO-8859-1', 'UTF-8'));
                    $this->pdf->Text(152, 25, $ROW_CONSULT[0]['NOMBRE_SEXO']);
                    $this->pdf->Text(185, 25, calcula_edad_2($ROW_CONSULT[0]['FECHA_NAC_PACIENTE'], $ROW_CONSULT[0]['FECHA_CONSULTA']));
                    $this->pdf->Text(62, 34, date('d', strtotime($ROW_CONSULT[0]['FECHA_NAC_PACIENTE'])));
                    $this->pdf->Text(74, 34, date('m', strtotime($ROW_CONSULT[0]['FECHA_NAC_PACIENTE'])));
                    $this->pdf->Text(85, 34, date('Y', strtotime($ROW_CONSULT[0]['FECHA_NAC_PACIENTE'])));
                    $this->pdf->Text(124, 33, $ROW_CONSULT[0]['ESTADO_CIVIL_PACIENTE']);
                    $this->pdf->Text(170, 33, $ROW_CONSULT[0]['RELIGION_PACIENTE']);
                    $this->pdf->Text(39, 41, $ROW_CONSULT[0]['OCUPACION_PACIENTE']);
                    $this->pdf->Text(94, 41, mb_convert_encoding($ROW_CONSULT[0]['CALLE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($ROW_CONSULT[0]['NUMERO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($ROW_CONSULT[0]['COLONIA_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                    $this->pdf->Text(57, 48, $ROW_CONSULT[0]['EMAIL_PACIENTE']);
                    $this->pdf->Text(145, 48, $ROW_CONSULT[0]['TELEFONO_PACIENTE']);
                    $this->pdf->Text(65, 55, $ROW_CONSULT[0]['TELEFONO_URGENCIA']);
                    $this->pdf->Text(185, 55, $ROW_CONSULT[0]['tipo_sangre']);
                    $this->pdf->Text(70, 80, $ROW_CONSULT[0]['DIABETES_MADRE'] ? 'X' : '');
                    $this->pdf->Text(107, 80, $ROW_CONSULT[0]['HIPERTENSION_MADRE'] ? 'X' : '');
                    $this->pdf->Text(147, 80, $ROW_CONSULT[0]['ENF_AUTOINMUNES_MADRE'] ? 'X' : '');
                    $this->pdf->Text(182, 80, $ROW_CONSULT[0]['CANCER_MADRE'] ? 'X' : '');
                    $this->pdf->Text(70, 86, $ROW_CONSULT[0]['DIABETES_PADRE'] ? 'X' : '');
                    $this->pdf->Text(107, 86, $ROW_CONSULT[0]['HIPERTENSION_PADRE'] ? 'X' : '');
                    $this->pdf->Text(147, 86, $ROW_CONSULT[0]['ENF_AUTOINMUNES_PADRE'] ? 'X' : '');
                    $this->pdf->Text(182, 86, $ROW_CONSULT[0]['CANCER_PADRE'] ? 'X' : '');
                    $this->pdf->Text(70, 92, $ROW_CONSULT[0]['DIABETES_HERMANOS'] ? 'X' : '');
                    $this->pdf->Text(107, 92, $ROW_CONSULT[0]['HIPERTENSION_HERMANOS'] ? 'X' : '');
                    $this->pdf->Text(147, 92, $ROW_CONSULT[0]['ENF_AUTOINMUNES_HERMANOS'] ? 'X' : '');
                    $this->pdf->Text(182, 92, $ROW_CONSULT[0]['CANCER_HERMANOS'] ? 'X' : '');
                    $this->pdf->Text(30, 99, $ROW_CONSULT[0]['OTROS_HEREDOFAMILIARES']);
                    if ($ROW_CONSULT[0]['DIABETES_MELLITUS'] == 1) {
                        $this->pdf->Text(77, 122, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(89, 122, 'X'); // Marca el "no"
                    }
                    $this->pdf->Text(100, 122, $ROW_CONSULT[0]['TIEMPO_EVOLUCION_DIABETES']);

                    if ($ROW_CONSULT[0]['HIPERTENSION_ARTERIAL'] == 1) {
                        $this->pdf->Text(77, 128, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(89, 128, 'X'); // Marca el "no"
                    }
                    $this->pdf->Text(100, 128, $ROW_CONSULT[0]['TIEMPO_EVOLUCION_HIPERTENSION']);

                    if ($ROW_CONSULT[0]['ENFERMEDADES_ENDOCRINOLOGICAS'] == 1) {
                        $this->pdf->Text(77, 134, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(89, 134, 'X'); // Marca el "no"
                    }
                    $this->pdf->Text(100, 134, $ROW_CONSULT[0]['TIEMPO_EVOLUCION_ENFERMEDADES_ENDOCRINOLOGICAS']);

                    if ($ROW_CONSULT[0]['ENFERMEDADES_PSIQUIATRICAS'] == 1) {
                        $this->pdf->Text(77, 140, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(89, 140, 'X'); // Marca el "no"
                    }
                    $this->pdf->Text(100, 140, $ROW_CONSULT[0]['TIEMPO_EVOLUCION_ENFERMEDADES_PSIQUIATRICAS']);

                    if ($ROW_CONSULT[0]['ENFERMEDADES_AUTOINMUNES'] == 1) {
                        $this->pdf->Text(77, 145, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(89, 145, 'X'); // Marca el "no"
                    }
                    $this->pdf->Text(100, 145, $ROW_CONSULT[0]['TIEMPO_EVOLUCION_ENFERMEDADES_AUTOINMUNES']);

                    if ($ROW_CONSULT[0]['VIH'] == 1) {
                        $this->pdf->Text(77, 151, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(89, 151, 'X'); // Marca el "no"
                    }
                    $this->pdf->Text(100, 151, $ROW_CONSULT[0]['TIEMPO_EVOLUCION_VIH']);

                    if ($ROW_CONSULT[0]['HERPES_LABIAL'] == 1) {
                        $this->pdf->Text(77, 157, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(89, 157, 'X'); // Marca el "no"
                    }
                    $this->pdf->Text(100, 157, $ROW_CONSULT[0]['TIEMPO_EVOLUCION_HERPES_LABIAL']);

                    if ($ROW_CONSULT[0]['TRANSFUSIONES_SANGUINEAS'] == 1) {
                        $this->pdf->Text(77, 163, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(89, 163, 'X'); // Marca el "no"
                    }
                    $this->pdf->Text(100, 163, $ROW_CONSULT[0]['TIEMPO_EVOLUCION_TRANSFUSIONES_SANGUINEAS']);

                    if ($ROW_CONSULT[0]['FRACTURAS'] == 1) {
                        $this->pdf->Text(77, 168, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(89, 168, 'X'); // Marca el "no"
                    }
                    $this->pdf->Text(100, 168, $ROW_CONSULT[0]['TIEMPO_EVOLUCION_FRACTURAS']);

                    if ($ROW_CONSULT[0]['HOSPITALIZACIONES'] == 1) {
                        $this->pdf->Text(77, 174, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(89, 174, 'X'); // Marca el "no"
                    }
                    $this->pdf->Text(100, 174, $ROW_CONSULT[0]['TIEMPO_EVOLUCION_HOSPITALIZACIONES']);

                    if ($ROW_CONSULT[0]['CIRUGIAS_PREVIAS'] == 1) {
                        $this->pdf->Text(77, 180, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(89, 180, 'X'); // Marca el "no"
                    }
                    $this->pdf->Text(100, 180, $ROW_CONSULT[0]['TIEMPO_EVOLUCION_CIRUGIAS_PREVIAS']);

                    if ($ROW_CONSULT[0]['HEPATITIS'] == 1) {
                        $this->pdf->Text(77, 186, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(89, 186, 'X'); // Marca el "no"
                    }
                    $this->pdf->Text(100, 185, $ROW_CONSULT[0]['TIEMPO_EVOLUCION_HEPATITIS']);

                    if ($ROW_CONSULT[0]['CANCER'] == 1) {
                        $this->pdf->Text(77, 191, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(89, 191, 'X'); // Marca el "no"
                    }
                    $this->pdf->Text(100, 191, $ROW_CONSULT[0]['TIEMPO_EVOLUCION_CANCER']);

                    if ($ROW_CONSULT[0]['EPILEPSIA'] == 1) {
                        $this->pdf->Text(77, 197, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(89, 197, 'X'); // Marca el "no"
                    }
                    $this->pdf->Text(100, 197, $ROW_CONSULT[0]['TIEMPO_EVOLUCION_EPILEPSIA']);

                    if ($ROW_CONSULT[0]['ALERGIAS'] == 1) {
                        $this->pdf->Text(77, 203, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(89, 203, 'X'); // Marca el "no"
                    }
                    $this->pdf->Text(100, 203, $ROW_CONSULT[0]['TIEMPO_EVOLUCION_ALERGIAS']);

                    $this->pdf->Text(30, 209, $ROW_CONSULT[0]['OTROS_PATOLOGICO']);

                    if ($ROW_CONSULT[0]['FUMA'] == 1) {
                        $this->pdf->Text(31.5, 218, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(42, 218, 'X'); // Marca el "no"
                    }
                    $this->pdf->Text(84, 217, $ROW_CONSULT[0]['FUMA_CUANTOS']);

                    if ($ROW_CONSULT[0]['ADICCIONES'] == 1) {
                        $this->pdf->Text(125.5, 218, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(135.5, 218, 'X'); // Marca el "no"
                    }
                    $this->pdf->Text(168, 217, $ROW_CONSULT[0]['ESPECIFIQUE_ADICCIONES']);

                    if ($ROW_CONSULT[0]['BEBE_ALCOHOL'] == 1) {
                        $this->pdf->Text(47, 222.5, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(57, 222.5, 'X'); // Marca el "no"
                    }
                    $this->pdf->Text(90, 222, $ROW_CONSULT[0]['ESPECIFIQUE_ADICCIONES']);

                    if ($ROW_CONSULT[0]['FOBIA'] == 1) {
                        $this->pdf->Text(184.5, 222.5, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(194.5, 222.5, 'X'); // Marca el "no"
                    }

                    if ($ROW_CONSULT[0]['DESMAYOS'] == 1) {
                        $this->pdf->Text(73.5, 229, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(84.5, 229, 'X'); // Marca el "no"
                    }

                    if ($ROW_CONSULT[0]['ASPIRINA'] == 1) {
                        $this->pdf->Text(179.5, 229, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(189.5, 229, 'X'); // Marca el "no"
                    }

                    if ($ROW_CONSULT[0]['MORETES'] == 1) {
                        $this->pdf->Text(73, 235, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(83.5, 235, 'X'); // Marca el "no"
                    }

                    if ($ROW_CONSULT[0]['BRONCEADO'] == 1) {
                        $this->pdf->Text(186, 235, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(196, 235, 'X'); // Marca el "no"
                    }

                    if ($ROW_CONSULT[0]['ANESTESIA'] == 1) {
                        $this->pdf->Text(177.5, 241, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(187.5, 241, 'X'); // Marca el "no"
                    }

                    if ($ROW_CONSULT[0]['PROBLEMA_ANESTESIA'] == 1) {
                        $this->pdf->Text(99, 247, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(109.5, 247, 'X'); // Marca el "no"
                    }

                    $this->pdf->Text(137, 246, $ROW_CONSULT[0]['ESPECIFIQUE_PROBLEMA_ANESTESIA']);

                    $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                    $this->pdf->designUp();
                    if ($modo != 'imprimir' && file_exists($base . '2.png')) {
                        $this->pdf->Image($base . '2.png', 0, 0, 215.9, 279.4, '', '', '', false, 300, '', false, false, 0);
                    }

                    if ($ROW_CONSULT[0]['INMUNIZACION'] == 1) {
                        $this->pdf->Text(133, 4, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(142.5, 4, 'X'); // Marca el "no"
                    }
                    $this->pdf->Text(159, 3, $ROW_CONSULT[0]['ESPECIFIQUE_INMUNIZACION']);

                    if ($ROW_CONSULT[0]['INFECCION_PIEL'] == 1) {
                        $this->pdf->Text(137, 10.5, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(148, 10.5, 'X'); // Marca el "no"
                    }
                    $this->pdf->Text(165, 10, $ROW_CONSULT[0]['ESPECIFIQUE_INFECCION_PIEL']);

                    if ($ROW_CONSULT[0]['ESTEROIDES'] == 1) {
                        $this->pdf->Text(180, 21, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(190, 21, 'X'); // Marca el "no"
                    }
                    $this->pdf->Text(35, 25, $ROW_CONSULT[0]['ESPECIFIQUE_ESTEROIDES']);

                    if ($ROW_CONSULT[0]['EJERCICIO'] == 1) {
                        $this->pdf->Text(47, 32, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(57, 32, 'X'); // Marca el "no"
                    }
                    $this->pdf->Text(69, 31, $ROW_CONSULT[0]['ESPECIFIQUE_EJERCICIO']);

                    if ($ROW_CONSULT[0]['DIETA'] == 1) {
                        $this->pdf->Text(138, 32, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(148, 32, 'X'); // Marca el "no"
                    }
                    $this->pdf->Text(168, 31, $ROW_CONSULT[0]['ESPECIFIQUE_DIETA']);

                    if ($ROW_CONSULT[0]['ACTUALMENTE_EMBARAZADA'] == 1) {
                        $this->pdf->Text(190.5, 48, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(200.5, 48, 'X'); // Marca el "no"
                    }
                    $this->pdf->Text(40, 54, $ROW_CONSULT[0]['MENARCA']);
                    $this->pdf->Text(71, 54, $ROW_CONSULT[0]['FUM']);
                    $this->pdf->Text(123, 54, $ROW_CONSULT[0]['RITMO_MENSTRUAL']);
                    $this->pdf->Text(173, 54, $ROW_CONSULT[0]['FUP_CESAREA']);
                    $this->pdf->Text(20, 60, $ROW_CONSULT[0]['G']);
                    $this->pdf->Text(33, 60, $ROW_CONSULT[0]['P']);
                    $this->pdf->Text(46, 60, $ROW_CONSULT[0]['A']);
                    $this->pdf->Text(59, 60, $ROW_CONSULT[0]['C']);
                    $this->pdf->Text(113, 60, $ROW_CONSULT[0]['METODO_ANTICONCEPTIVO']);

                    if ($ROW_CONSULT[0]['EXPOSICION_SOLAR'] == 'SI') {
                        $this->pdf->Text(49.5, 78, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(59.5, 78, 'X'); // Marca el "no"
                    }
                    $this->pdf->Text(113, 77, $ROW_CONSULT[0]['TIEMPO_EXPOSICION_SOLAR']);

                    if ($ROW_CONSULT[0]['USO_PROTECCION_SOLAR'] == 'SI') {
                        $this->pdf->Text(184.5, 78, 'X'); // Marca el "sí"
                    } else {
                        $this->pdf->Text(194.5, 78, 'X'); // Marca el "no"
                    }

                    $this->pdf->Text(58, 82, $ROW_CONSULT[0]['MARCA_PROTECTOR_SOLAR']);
                    $this->pdf->Text(140, 82, $ROW_CONSULT[0]['FPS_PROTECTOR_SOLAR']);
                    $this->pdf->Text(71, 99, $ROW_CONSULT[0]['ENVEJECIMIENTO_CUTANEO'] ? 'X' : '');
                    $this->pdf->Text(137, 99, $ROW_CONSULT[0]['RITIDES'] ? 'X' : '');
                    $this->pdf->Text(196, 99, $ROW_CONSULT[0]['BRUXISMO'] ? 'X' : '');

                    $this->pdf->Text(71, 105, $ROW_CONSULT[0]['ADIP_LOCALIZADA'] ? 'X' : '');
                    $this->pdf->Text(137, 105, $ROW_CONSULT[0]['ESTRIAS'] ? 'X' : '');
                    $this->pdf->Text(196, 105, $ROW_CONSULT[0]['VARICES'] ? 'X' : '');

                    $this->pdf->Text(71, 111, $ROW_CONSULT[0]['HIPERMEGTACION'] ? 'X' : '');
                    $this->pdf->Text(137, 111, $ROW_CONSULT[0]['ALOPECIA'] ? 'X' : '');
                    $this->pdf->Text(196, 111, $ROW_CONSULT[0]['VERRUGAS'] ? 'X' : '');

                    $this->pdf->Text(71, 117, $ROW_CONSULT[0]['FLACIDEZ_CUTANEA'] ? 'X' : '');
                    $this->pdf->Text(137, 117, $ROW_CONSULT[0]['ACNE'] ? 'X' : '');
                    $this->pdf->Text(196, 117, $ROW_CONSULT[0]['PEFE'] ? 'X' : '');

                    $this->pdf->Text(71, 123, $ROW_CONSULT[0]['CICATRICES'] ? 'X' : '');
                    $this->pdf->Text(137, 123, $ROW_CONSULT[0]['ROSACEA'] ? 'X' : '');
                    $this->pdf->Text(196, 123, $ROW_CONSULT[0]['HIPERHIDROSIS'] ? 'X' : '');

                    $this->pdf->Text(30, 130, $ROW_CONSULT[0]['OTROS_MOTIVO_CONSULTA']);

                    $procedimientos = [
                        'TOXINA_BOTULINICA' => 153,
                        'ACIDO_HIALURONICO' => 159,
                        'BIOESTIMULADORES' => 165,
                        'DERMAPEN' => 171,
                        'PEELING' => 177,
                        'PLASMA' => 183,
                        'HILOS' => 189,
                        'MESOTERAPIA' => 195,
                        'APARATOLOGIA_CORPORAL' => 201
                    ];
                    foreach ($procedimientos as $nombre_procedimiento => $y_pos) {
                        // Buscar el procedimiento en $TRATAMIENTOS
                        foreach ($TRATAMIENTOS as $row) {
                            if ($row['PROCEDIMIENTO'] === $nombre_procedimiento) {
                                // Producto en X=96
                                $producto = mb_convert_encoding($row['PRODUCTO'], 'ISO-8859-1', 'UTF-8');
                                $this->pdf->Text(90, $y_pos, $producto);

                                // Fecha de aplicación en X=172
                                $fecha = !empty($row['FECHA_APLICACION']) ? date('d/m/Y', strtotime($row['FECHA_APLICACION'])) : 'N/A';
                                $fecha = mb_convert_encoding($fecha, 'ISO-8859-1', 'UTF-8');
                                $this->pdf->Text(172, $y_pos, $fecha);

                                break; // Salir del bucle interno una vez encontrado el procedimiento
                            }
                        }
                    }

                    $this->pdf->Text(30, 208, $ROW_CONSULT[0]['OTROS_TRATAMIENTOS_ESTETICOS']);

                    $fitzpatrick = [
                        '1' => 40,
                        '2' => 47,
                        '3' => 55,
                        '4' => 62,
                        '5' => 70,
                        '6' => 77
                    ];
                    // Obtener el valor de FITZPATRICK (asumiendo que está en $ROW_CONSULT[0])
                    $fitzpatrick_value = isset($ROW_CONSULT[0]['FITZPATRICK']) ? (string)$ROW_CONSULT[0]['FITZPATRICK'] : '';

                    if (array_key_exists($fitzpatrick_value, $fitzpatrick)) {
                        $x_pos = $fitzpatrick[$fitzpatrick_value];
                        $this->pdf->Text($x_pos, 226, 'X'); // Dibujar una "X" en la posición correspondiente
                    }

                    $glogau = [
                        '1' => 105,
                        '2' => 112,
                        '3' => 119,
                        '4' => 127
                    ];
                    // Obtener el valor de FITZPATRICK (asumiendo que está en $ROW_CONSULT[0])
                    $glogau_value = isset($ROW_CONSULT[0]['GLOGAU']) ? (string)$ROW_CONSULT[0]['GLOGAU'] : '';

                    if (array_key_exists($glogau_value, $glogau)) {
                        $x_pos = $glogau[$glogau_value];
                        $this->pdf->Text($x_pos, 226, 'X'); // Dibujar una "X" en la posición correspondiente
                    }

                    $piel = [
                        'MIXTA' => 167,
                        'SECA' => 180,
                        'GRASA' => 195
                    ];
                    // Obtener el valor de FITZPATRICK (asumiendo que está en $ROW_CONSULT[0])
                    $piel_value = isset($ROW_CONSULT[0]['TIPO_PIEL']) ? (string)$ROW_CONSULT[0]['TIPO_PIEL'] : '';

                    if (array_key_exists($piel_value, $piel)) {
                        $x_pos = $piel[$piel_value];
                        $this->pdf->Text($x_pos, 226, 'X'); // Dibujar una "X" en la posición correspondiente
                    }

                    $rostro = [
                        'OVALADO' => 53,
                        'RECTANGULAR' => 78,
                        'REDONDO' => 102,
                        'CUADRADO' => 122,
                        'TRIANGULAR' => 147,
                        'DIAMANTE' => 170
                    ];
                    // Obtener el valor de FITZPATRICK (asumiendo que está en $ROW_CONSULT[0])
                    $rostro_value = isset($ROW_CONSULT[0]['TIPO_ROSTRO']) ? (string)$ROW_CONSULT[0]['TIPO_ROSTRO'] : '';

                    if (array_key_exists($rostro_value, $rostro)) {
                        $x_pos = $rostro[$rostro_value];
                        $this->pdf->Text($x_pos, 233, 'X'); // Dibujar una "X" en la posición correspondiente
                    }

                    $this->pdf->Text(62, 239, $ROW_CONSULT[0]['LESIONES_DERMATOLOGICAS']);
                    $this->pdf->Text(29, 245, $ROW_CONSULT[0]['TIPO_DERMATOLOGICAS']);
                    $this->pdf->Text(128, 245, $ROW_CONSULT[0]['LOCALIZACION_DERMATOLOGICAS']);

                    $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                    $this->pdf->designUp();

                    if ($modo != 'imprimir' && file_exists($base . '3.png')) {
                        $this->pdf->Image($base . '3.png', 0, 0, 215.9, 279.4, '', '', '', false, 300, '', false, false, 0);
                    }


                    $this->pdf->Text(59, 12, $ROW_CONSULT[0]['CONDICION_PACIENTE']);
                    $this->pdf->Text(38, 17, $ROW_CONSULT[0]['CONSTITUCION_HABITUS']);
                    $this->pdf->Text(112, 17, $ROW_CONSULT[0]['CONFORMACION_HABITUS']);
                    $this->pdf->Text(173, 17, $ROW_CONSULT[0]['ACTITUD_HABITUS']);
                    $this->pdf->Text(27, 23, $ROW_CONSULT[0]['FACIES_HABITUS']);
                    $this->pdf->Text(115, 23, $ROW_CONSULT[0]['MOVIMIENTOS_ANORMALES_HABITUS']);
                    $this->pdf->Text(28, 29, $ROW_CONSULT[0]['MARCHA_HABITUS']);
                    $this->pdf->Text(115, 29, $ROW_CONSULT[0]['ESTADO_CONCIENCIA_HABITUS']);
                    $this->pdf->Text(28, 35, $ROW_CONSULT[0]['OTROS_HABITUS']);
                    $this->pdf->Text(46, 41, $ROW_CONSULT[0]['FC_CONSULTA']);
                    $this->pdf->Text(65, 41, $ROW_CONSULT[0]['FR_CONSULTA']);
                    $this->pdf->Text(82, 41, $ROW_CONSULT[0]['TA_CONSULTA']);
                    $this->pdf->Text(106, 41, $ROW_CONSULT[0]['TEMP_CONSULTA']);
                    $this->pdf->Text(125, 41, $ROW_CONSULT[0]['PESO_CONSULTA']);
                    $this->pdf->Text(150, 41, $ROW_CONSULT[0]['TALLA_CONSULTA']);
                    $this->pdf->Text(170, 41, $ROW_CONSULT[0]['IMC_CONSULTA']);
                    $this->pdf->Text(39, 69, mb_convert_encoding($ROW_CONSULT[0]['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($ROW_CONSULT[0]['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($ROW_CONSULT[0]['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                    $this->pdf->SetFont('Arial', '', 7);
                    $this->pdf->Text(158, 160, mb_convert_encoding($ROW_CONSULT[0]['NOMBRE_USUARIO'] . ' ' . $ROW_CONSULT[0]['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));
                    $this->pdf->SetFont('Arial', '', 9);
                    $this->pdf->Text(57, 181, mb_convert_encoding($ROW_CONSULT[0]['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($ROW_CONSULT[0]['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($ROW_CONSULT[0]['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                    $this->pdf->Text(45, 188, date('d', strtotime($ROW_CONSULT[0]['FECHA_CONSULTA'])));
                    $meses = [
                        '01' => 'Enero',
                        '02' => 'Febrero',
                        '03' => 'Marzo',
                        '04' => 'Abril',
                        '05' => 'Mayo',
                        '06' => 'Junio',
                        '07' => 'Julio',
                        '08' => 'Agosto',
                        '09' => 'Septiembre',
                        '10' => 'Octubre',
                        '11' => 'Noviembre',
                        '12' => 'Diciembre'
                    ];
                    $mes_numero = date('m', strtotime($ROW_CONSULT[0]['FECHA_CONSULTA']));
                    $mes_nombre = isset($meses[$mes_numero]) ? $meses[$mes_numero] : 'N/A';
                    $mes_nombre = mb_convert_encoding($mes_nombre, 'ISO-8859-1', 'UTF-8');
                    $this->pdf->Text(70, 188, $mes_nombre);
                    $this->pdf->Text(103, 188, date('Y', strtotime($ROW_CONSULT[0]['FECHA_CONSULTA'])));
                    $this->pdf->Text(64, 217, mb_convert_encoding($ROW_CONSULT[0]['PROC_PROPUESTO'], 'ISO-8859-1', 'UTF-8'));
                    $this->pdf->Text(58, 230, mb_convert_encoding($ROW_CONSULT[0]['IND_TERAPEUTICA'], 'ISO-8859-1', 'UTF-8'));
                    $this->pdf->Text(62, 244, mb_convert_encoding($ROW_CONSULT[0]['PROC_REALIZAR'], 'ISO-8859-1', 'UTF-8'));

                    $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                    $this->pdf->designUp();

                    if ($modo != 'imprimir' && file_exists($base . '4.png')) {
                        $this->pdf->Image($base . '4.png', 0, 0, 215.9, 279.4, '', '', '', false, 300, '', false, false, 0);
                    }

                    $this->pdf->Text(58, 3, mb_convert_encoding($ROW_CONSULT[0]['PRE_PROCEDIMIENTO'], 'ISO-8859-1', 'UTF-8'));
                    $this->pdf->Text(60, 16, mb_convert_encoding($ROW_CONSULT[0]['POST_PROCEDIMIENTO'], 'ISO-8859-1', 'UTF-8'));
                    $this->pdf->Text(20, 40, mb_convert_encoding($ROW_CONSULT[0]['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($ROW_CONSULT[0]['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($ROW_CONSULT[0]['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                    $this->pdf->Text(145, 40, calcula_edad_2($ROW_CONSULT[0]['FECHA_NAC_PACIENTE'], $ROW_CONSULT[0]['FECHA_CONSULTA']));
                    $this->pdf->Text(128, 84, date('d', strtotime($ROW_CONSULT[0]['FECHA_CONSULTA'])));
                    $mes_nombre = isset($meses[$mes_numero]) ? $meses[$mes_numero] : 'N/A';
                    $mes_nombre = mb_convert_encoding($mes_nombre, 'ISO-8859-1', 'UTF-8');
                    $this->pdf->Text(153, 84, $mes_nombre);
                    $this->pdf->Text(192, 84, date('Y', strtotime($ROW_CONSULT[0]['FECHA_CONSULTA'])));
                    $this->pdf->Text(40, 92, mb_convert_encoding($ROW_CONSULT[0]['NOMBRE_USUARIO'] . ' ' . $ROW_CONSULT[0]['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));



                    $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                    $this->pdf->designUp();

                    if ($modo != 'imprimir' && file_exists($base . '5.png')) {
                        $this->pdf->Image($base . '5.png', 0, 0, 215.9, 279.4, '', '', '', false, 300, '', false, false, 0);
                    }

                    $this->pdf->Text(165, 127, date('d/m/Y', strtotime($ROW_CONSULT[0]['FECHA_CONSULTA'])));
                    $this->pdf->Text(165, 160, date('d/m/Y', strtotime($ROW_CONSULT[0]['FECHA_CONSULTA'])));
                    $this->pdf->Text(58, 127, mb_convert_encoding($ROW_CONSULT[0]['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($ROW_CONSULT[0]['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($ROW_CONSULT[0]['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                    $this->pdf->Text(55, 161, mb_convert_encoding($ROW_CONSULT[0]['NOMBRE_USUARIO'] . ' ' . $ROW_CONSULT[0]['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));

                    $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                    $this->pdf->designUp();

                    if ($modo != 'imprimir' && file_exists($base . '6.png')) {
                        $this->pdf->Image($base . '6.png', 0, 0, 215.9, 279.4, '', '', '', false, 300, '', false, false, 0);
                    }

                    $this->pdf->Text(52, 10, mb_convert_encoding($ROW_CONSULT[0]['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($ROW_CONSULT[0]['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($ROW_CONSULT[0]['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                    $this->pdf->Text(170, 10, date('d/m/Y', strtotime($ROW_CONSULT[0]['FECHA_CONSULTA'])));
                    $this->pdf->Text(56, 190, mb_convert_encoding($ROW_CONSULT[0]['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($ROW_CONSULT[0]['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($ROW_CONSULT[0]['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                    $this->pdf->Text(55, 199, mb_convert_encoding($ROW_CONSULT[0]['NOMBRE_USUARIO'] . ' ' . $ROW_CONSULT[0]['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));


                    $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                    $this->pdf->designUp();

                    if ($modo != 'imprimir' && file_exists($base . '7.png')) {
                        $this->pdf->Image($base . '7.png', 0, 0, 215.9, 279.4, '', '', '', false, 300, '', false, false, 0);
                    }

                    $this->pdf->Text(52, 10, mb_convert_encoding($ROW_CONSULT[0]['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($ROW_CONSULT[0]['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($ROW_CONSULT[0]['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                    $this->pdf->Text(170, 10, date('d/m/Y', strtotime($ROW_CONSULT[0]['FECHA_CONSULTA'])));
                    $this->pdf->Text(30, 17, $ROW_CONSULT[0]['NOMBRE_SEXO']);
                    $this->pdf->Text(62, 17, calcula_edad_2($ROW_CONSULT[0]['FECHA_NAC_PACIENTE'], $ROW_CONSULT[0]['FECHA_CONSULTA']));
                    $this->pdf->Text(53, 31, $ROW_CONSULT[0]['FC_CONSULTA']);
                    $this->pdf->Text(71, 31, $ROW_CONSULT[0]['FR_CONSULTA']);
                    $this->pdf->Text(88, 31, $ROW_CONSULT[0]['TA_CONSULTA']);
                    $this->pdf->Text(111, 31, $ROW_CONSULT[0]['TEMP_CONSULTA']);
                    $this->pdf->Text(132, 31, $ROW_CONSULT[0]['PESO_CONSULTA']);
                    $this->pdf->Text(157, 31, $ROW_CONSULT[0]['TALLA_CONSULTA']);
                    $this->pdf->Text(175, 31, $ROW_CONSULT[0]['IMC_CONSULTA']);
                    $this->pdf->Text(52, 220, mb_convert_encoding($ROW_CONSULT[0]['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($ROW_CONSULT[0]['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($ROW_CONSULT[0]['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                    $this->pdf->Text(115, 220, mb_convert_encoding($ROW_CONSULT[0]['NOMBRE_USUARIO'] . ' ' . $ROW_CONSULT[0]['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));

                    $this->pdf->Output(); //Salida al navegador del pdf
                } else {
                    echo "redirect('consult/index')";
                }
            } else {
                redirect('consult/index');
            }
        }
    }

    public function ajax_get_tipos_por_consulta()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id_consulta = $this->input->post('id_consulta');

        $this->db->select('tipo_consulta.id_tipo_consulta, tipo_consulta.nombre_tipo_consulta');
        $this->db->from('consulta_tipo_consulta ctc');
        $this->db->join('tipo_consulta', 'tipo_consulta.id_tipo_consulta = ctc.id_tipo_consulta');
        $this->db->where('ctc.id_consulta', $id_consulta);
        $this->db->order_by('tipo_consulta.nombre_tipo_consulta', 'ASC');

        $data = $this->db->get()->result_array();

        echo json_encode($data);
    }

    public function creaConsentimiento($ID_CONSULT = null, $ID_TIPO = null)
    {
        if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {

            if ($ID_CONSULT > NULO) {
                $ROW_CONSULT = $this->mconsult->get_consult_by_id_consult($ID_CONSULT);

                if (count($ROW_CONSULT) > NULO) {
                    $row = $ROW_CONSULT[0];

                    $id_tipo_usar = $ID_TIPO ? (int)$ID_TIPO : (int)$row['ID_TIPO_CONSULTA'];

                    $this->load->library('PDF');

                    $modo = $this->input->get('modo');

                    //----------------TIPO DE CONSULTA 1 ------------------

                    if ($id_tipo_usar == 1) {
                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', 'B', 10); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/acidoHialuronico/1.png", 0, 0, 215.9, 279.4);
                        }

                        $this->pdf->setXY(11, 29);
                        $this->pdf->SetFont('Arial', '', 10);

                        $this->pdf->Text(60, 32, mb_convert_encoding($row['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(60, 40, $row['ID_CONSULTA']);
                        $this->pdf->Text(60, 48, mb_convert_encoding($row['NOMBRE_USUARIO'] . ' ' . $row['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(60, 56, date('d/m/Y', strtotime($row['FECHA_CONSULTA'])));

                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', 'B', 10); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/acidoHialuronico/2.png", 0, 0, 215.9, 279.4);
                        }

                        $this->pdf->setXY(11, 29);
                        $this->pdf->SetFont('Arial', '', 9);

                        $this->pdf->Text(73, 222, mb_convert_encoding($row['NOMBRE_USUARIO'] . ' ' . $row['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));

                        $campos = [
                            'ENVEJECIMIENTO_CUTANEO' => 'Envejecimiento cutáneo',
                            'RITIDES' => 'Ritides',
                            'BRUXISMO' => 'Bruxismo',
                            'ADIP_LOCALIZADA' => 'Adiposidad Localizada',
                            'ESTRIAS' => 'Estrías',
                            'VARICES' => 'Várices',
                            'HIPERMEGTACION' => 'Hiperpigmentación',
                            'ALOPECIA' => 'Alopecia',
                            'VERRUGAS' => 'Verrugas',
                            'FLACIDEZ_CUTANEA' => 'Flacidez cutánea',
                            'ACNE' => 'Acné',
                            'PEFE' => 'Celulitis',
                            'CICATRICES' => 'Cicatrices',
                            'ROSACEA' => 'Rosácea',
                            'HIPERHIDROSIS' => 'Hiperhidrósis',

                        ];

                        $x = 161;          // Coordenada X inicial
                        $y = 227;         // Coordenada Y inicial
                        $maxX = 205;      // Límite derecho de la página (ajusta según tu margen)
                        $espaciado = 3; // Espacio entre textos

                        foreach ($campos as $campo => $texto) {
                            if ($row[$campo] == 1) {
                                // Convertir texto al encoding correcto
                                $textoPDF = mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8');

                                // Obtener ancho real del texto
                                $anchoTexto = $this->pdf->GetStringWidth($textoPDF);

                                // Si ya no cabe en la línea actual, pasa a la siguiente
                                if ($x + $anchoTexto > $maxX) {
                                    $x = 20;
                                    $y += 5;
                                }

                                // Imprimir el texto
                                $this->pdf->Text($x, $y, $textoPDF);

                                // Avanzar X según el ancho del texto + espacio
                                $x += $anchoTexto + $espaciado;
                            }
                        }


                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', 'B', 10); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/acidoHialuronico/3.png", 0, 0, 215.9, 279.4);
                        }

                        $this->pdf->setXY(11, 29);
                        $this->pdf->SetFont('Arial', '', 9);

                        $this->pdf->Text(80, 137, mb_convert_encoding($row['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(80, 156, mb_convert_encoding($row['NOMBRE_USUARIO'] . ' ' . $row['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));

                        $this->pdf->Output(); //Salida al navegador del pdf
                    }

                    //----------------TIPO DE CONSULTA 2 ------------------

                    if ($id_tipo_usar == 2) {
                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', 'B', 10); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/bioestimulador/1.png", 0, 0, 215.9, 279.4);
                        }

                        $this->pdf->setXY(11, 29);
                        $this->pdf->SetFont('Arial', '', 10);
                        $this->pdf->Text(60, 32, mb_convert_encoding($row['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(60, 40, $row['ID_CONSULTA']);
                        $this->pdf->Text(60, 48, mb_convert_encoding($row['NOMBRE_USUARIO'] . ' ' . $row['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(60, 56, date('d/m/Y', strtotime($row['FECHA_CONSULTA'])));

                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', '', 9); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/bioestimulador/2.png", 0, 0, 215.9, 279.4);
                        }

                        $this->pdf->setXY(11, 29);
                        $this->pdf->Text(73, 187, mb_convert_encoding($row['NOMBRE_USUARIO'] . ' ' . $row['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));
                        $campos = [
                            'ENVEJECIMIENTO_CUTANEO' => 'Envejecimiento cutáneo',
                            'RITIDES' => 'Ritides',
                            'BRUXISMO' => 'Bruxismo',
                            'ADIP_LOCALIZADA' => 'Adiposidad Localizada',
                            'ESTRIAS' => 'Estrías',
                            'VARICES' => 'Várices',
                            'HIPERMEGTACION' => 'Hiperpigmentación',
                            'ALOPECIA' => 'Alopecia',
                            'VERRUGAS' => 'Verrugas',
                            'FLACIDEZ_CUTANEA' => 'Flacidez cutánea',
                            'ACNE' => 'Acné',
                            'PEFE' => 'Celulitis',
                            'CICATRICES' => 'Cicatrices',
                            'ROSACEA' => 'Rosácea',
                            'HIPERHIDROSIS' => 'Hiperhidrósis',

                        ];

                        $x = 161;          // Coordenada X inicial
                        $y = 192;         // Coordenada Y inicial
                        $maxX = 205;      // Límite derecho de la página (ajusta según tu margen)
                        $espaciado = 3; // Espacio entre textos
                        $mtvActivo = false; // Variable para controlar si se ha impreso "Otros tratamientos estéticos"

                        foreach ($campos as $campo => $texto) {
                            if ($row[$campo] == 1) {
                                $mtvActivo = true; // Marca que al menos un campo está activo

                                // Convertir texto al encoding correcto
                                $textoPDF = mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8');

                                // Obtener ancho real del texto
                                $anchoTexto = $this->pdf->GetStringWidth($textoPDF);

                                // Si ya no cabe en la línea actual, pasa a la siguiente
                                if ($x + $anchoTexto > $maxX) {
                                    $x = 20;
                                    $y += 5;
                                }

                                // Imprimir el texto
                                $this->pdf->Text($x, $y, $textoPDF);

                                // Avanzar X según el ancho del texto + espacio
                                $x += $anchoTexto + $espaciado;
                            }
                        }
                        if (!$mtvActivo) {
                            // Si no se ha impreso "Otros tratamientos estéticos", lo imprimimos aquí
                            $this->pdf->Text(161, 176, mb_convert_encoding($row['OTROS_TRATAMIENTOS_ESTETICOS'], 'ISO-8859-1', 'UTF-8'));
                        }

                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', '', 9); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/bioestimulador/3.png", 0, 0, 215.9, 279.4);
                        }

                        $this->pdf->setXY(11, 29);
                        $this->pdf->setXY(11, 29);
                        $this->pdf->Text(80, 101, mb_convert_encoding($row['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(80, 120, mb_convert_encoding($row['NOMBRE_USUARIO'] . ' ' . $row['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));

                        $this->pdf->Output(); //Salida al navegador del pdf
                    }

                    //----------------TIPO DE CONSULTA 3 ------------------

                    if ($id_tipo_usar == 3) {
                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', 'B', 10); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/co2/1.png", 0, 0, 215.9, 279.4);
                        }

                        $this->pdf->setXY(11, 29);
                        $this->pdf->SetFont('Arial', '', 10);
                        $this->pdf->Text(60, 32, mb_convert_encoding($row['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(60, 40, $row['ID_CONSULTA']);
                        $this->pdf->Text(60, 48, mb_convert_encoding($row['NOMBRE_USUARIO'] . ' ' . $row['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(60, 56, date('d/m/Y', strtotime($row['FECHA_CONSULTA'])));

                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', 'B', 10); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/co2/2.png", 0, 0, 215.9, 279.4);
                        }

                        $this->pdf->setXY(11, 29);
                        $this->pdf->SetFont('Arial', '', 9);
                        $this->pdf->Text(80, 129, mb_convert_encoding($row['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(80, 148, mb_convert_encoding($row['NOMBRE_USUARIO'] . ' ' . $row['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(80, 200, mb_convert_encoding($row['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(80, 218, mb_convert_encoding($row['NOMBRE_USUARIO'] . ' ' . $row['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));


                        $this->pdf->Output(); //Salida al navegador del pdf
                    }

                    //----------------TIPO DE CONSULTA 4 ------------------

                    if ($id_tipo_usar == 4) {
                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', '', 10); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/laser/1.png", 0, 0, 215.9, 279.4);
                        }

                        $this->pdf->setXY(11, 29);
                        $this->pdf->Text(60, 32, mb_convert_encoding($row['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(60, 40, $row['ID_CONSULTA']);
                        $this->pdf->Text(60, 48, mb_convert_encoding($row['NOMBRE_USUARIO'] . ' ' . $row['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(60, 56, date('d/m/Y', strtotime($row['FECHA_CONSULTA'])));

                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', '', 10); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/laser/2.png", 0, 0, 215.9, 279.4);
                        }

                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', '', 8); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/laser/3.png", 0, 0, 215.9, 279.4);
                        }

                        $this->pdf->setXY(11, 29);
                        $this->pdf->Text(73, 170, mb_convert_encoding($row['NOMBRE_USUARIO'] . ' ' . $row['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));
                        $campos = [
                            'ENVEJECIMIENTO_CUTANEO' => 'Envejecimiento cutáneo',
                            'RITIDES' => 'Ritides',
                            'BRUXISMO' => 'Bruxismo',
                            'ADIP_LOCALIZADA' => 'Adiposidad Localizada',
                            'ESTRIAS' => 'Estrías',
                            'VARICES' => 'Várices',
                            'HIPERMEGTACION' => 'Hiperpigmentación',
                            'ALOPECIA' => 'Alopecia',
                            'VERRUGAS' => 'Verrugas',
                            'FLACIDEZ_CUTANEA' => 'Flacidez cutánea',
                            'ACNE' => 'Acné',
                            'PEFE' => 'Celulitis',
                            'CICATRICES' => 'Cicatrices',
                            'ROSACEA' => 'Rosácea',
                            'HIPERHIDROSIS' => 'Hiperhidrósis',

                        ];

                        $x = 161;          // Coordenada X inicial
                        $y = 175;         // Coordenada Y inicial
                        $maxX = 205;      // Límite derecho de la página (ajusta según tu margen)
                        $espaciado = 3; // Espacio entre textos
                        $mtvActivo = false; // Variable para controlar si se ha impreso "Otros tratamientos estéticos"

                        foreach ($campos as $campo => $texto) {
                            if ($row[$campo] == 1) {
                                $mtvActivo = true; // Marca que al menos un campo está activo

                                // Convertir texto al encoding correcto
                                $textoPDF = mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8');

                                // Obtener ancho real del texto
                                $anchoTexto = $this->pdf->GetStringWidth($textoPDF);

                                // Si ya no cabe en la línea actual, pasa a la siguiente
                                if ($x + $anchoTexto > $maxX) {
                                    $x = 20;
                                    $y += 5;
                                }

                                // Imprimir el texto
                                $this->pdf->Text($x, $y, $textoPDF);

                                // Avanzar X según el ancho del texto + espacio
                                $x += $anchoTexto + $espaciado;
                            }
                        }
                        if (!$mtvActivo) {
                            // Si no se ha impreso "Otros tratamientos estéticos", lo imprimimos aquí
                            $this->pdf->Text(161, 176, mb_convert_encoding($row['OTROS_TRATAMIENTOS_ESTETICOS'], 'ISO-8859-1', 'UTF-8'));
                        }

                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', '', 8); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/laser/4.png", 0, 0, 215.9, 279.4);
                        }

                        $this->pdf->setXY(11, 29);
                        $this->pdf->Text(80, 88, mb_convert_encoding($row['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(80, 106, mb_convert_encoding($row['NOMBRE_USUARIO'] . ' ' . $row['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));

                        $this->pdf->Output(); //Salida al navegador del pdf
                    }

                    //----------------TIPO DE CONSULTA 5 ------------------

                    if ($id_tipo_usar == 5) {
                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', '', 10); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/endolifting/1.png", 0, 0, 215.9, 279.4);
                        }

                        $this->pdf->setXY(11, 29);
                        $this->pdf->Text(60, 30, mb_convert_encoding($row['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(60, 38, $row['ID_CONSULTA']);
                        $this->pdf->Text(60, 47, mb_convert_encoding($row['NOMBRE_USUARIO'] . ' ' . $row['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(60, 55, date('d/m/Y', strtotime($row['FECHA_CONSULTA'])));

                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', '', 9); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/endolifting/2.png", 0, 0, 215.9, 279.4);
                        }

                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', '', 9); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/endolifting/3.png", 0, 0, 215.9, 279.4);
                        }

                        $this->pdf->setXY(11, 29);

                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', '', 9); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/endolifting/4.png", 0, 0, 215.9, 279.4);
                        }

                        $this->pdf->setXY(11, 29);
                        $this->pdf->Text(80, 170, mb_convert_encoding($row['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(80, 188, mb_convert_encoding($row['NOMBRE_USUARIO'] . ' ' . $row['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));

                        $this->pdf->Output(); //Salida al navegador del pdf
                    }

                    //----------------TIPO DE CONSULTA 6 ------------------

                    if ($id_tipo_usar == 6) {
                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', '', 10); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/enzimas/1.png", 0, 0, 215.9, 279.4);
                        }

                        $this->pdf->setXY(11, 29);
                        $this->pdf->Text(60, 30, mb_convert_encoding($row['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(60, 38, $row['ID_CONSULTA']);
                        $this->pdf->Text(60, 46, mb_convert_encoding($row['NOMBRE_USUARIO'] . ' ' . $row['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(60, 54, date('d/m/Y', strtotime($row['FECHA_CONSULTA'])));

                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', '', 9); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/enzimas/2.png", 0, 0, 215.9, 279.4);
                        }

                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', '', 8); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/enzimas/3.png", 0, 0, 215.9, 279.4);
                        }

                        $this->pdf->setXY(11, 29);
                        $this->pdf->Text(73, 141, mb_convert_encoding($row['NOMBRE_USUARIO'] . ' ' . $row['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->SetFont('Arial', '', 9);
                        $campos = [
                            'ENVEJECIMIENTO_CUTANEO' => 'Envejecimiento cutáneo',
                            'RITIDES' => 'Ritides',
                            'BRUXISMO' => 'Bruxismo',
                            'ADIP_LOCALIZADA' => 'Adiposidad Localizada',
                            'ESTRIAS' => 'Estrías',
                            'VARICES' => 'Várices',
                            'HIPERMEGTACION' => 'Hiperpigmentación',
                            'ALOPECIA' => 'Alopecia',
                            'VERRUGAS' => 'Verrugas',
                            'FLACIDEZ_CUTANEA' => 'Flacidez cutánea',
                            'ACNE' => 'Acné',
                            'PEFE' => 'Celulitis',
                            'CICATRICES' => 'Cicatrices',
                            'ROSACEA' => 'Rosácea',
                            'HIPERHIDROSIS' => 'Hiperhidrósis',

                        ];

                        $x = 162;          // Coordenada X inicial
                        $y = 146;         // Coordenada Y inicial
                        $maxX = 205;      // Límite derecho de la página (ajusta según tu margen)
                        $espaciado = 3; // Espacio entre textos
                        $mtvActivo = false; // Variable para controlar si se ha impreso "Otros tratamientos estéticos"

                        foreach ($campos as $campo => $texto) {
                            if ($row[$campo] == 1) {
                                $mtvActivo = true; // Marca que al menos un campo está activo

                                // Convertir texto al encoding correcto
                                $textoPDF = mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8');

                                // Obtener ancho real del texto
                                $anchoTexto = $this->pdf->GetStringWidth($textoPDF);

                                // Si ya no cabe en la línea actual, pasa a la siguiente
                                if ($x + $anchoTexto > $maxX) {
                                    $x = 20;
                                    $y += 5;
                                }

                                // Imprimir el texto
                                $this->pdf->Text($x, $y, $textoPDF);

                                // Avanzar X según el ancho del texto + espacio
                                $x += $anchoTexto + $espaciado;
                            }
                        }
                        if (!$mtvActivo) {
                            // Si no se ha impreso "Otros tratamientos estéticos", lo imprimimos aquí
                            $this->pdf->Text(161, 176, mb_convert_encoding($row['OTROS_TRATAMIENTOS_ESTETICOS'], 'ISO-8859-1', 'UTF-8'));
                        }

                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', '', 9); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/enzimas/4.png", 0, 0, 215.9, 279.4);
                        }

                        $this->pdf->setXY(11, 29);
                        $this->pdf->Text(80, 58, mb_convert_encoding($row['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(80, 76.5, mb_convert_encoding($row['NOMBRE_USUARIO'] . ' ' . $row['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));


                        $this->pdf->Output(); //Salida al navegador del pdf
                    }

                    //----------------TIPO DE CONSULTA 7 ------------------

                    if ($id_tipo_usar == 7) {
                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', '', 10); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/hialuronidasa/1.png", 0, 0, 215.9, 279.4);
                        }
                        $this->pdf->setXY(11, 29);
                        $this->pdf->Text(60, 32, mb_convert_encoding($row['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(60, 40, $row['ID_CONSULTA']);
                        $this->pdf->Text(60, 48, mb_convert_encoding($row['NOMBRE_USUARIO'] . ' ' . $row['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(60, 56, date('d/m/Y', strtotime($row['FECHA_CONSULTA'])));

                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', '', 8); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/hialuronidasa/2.png", 0, 0, 215.9, 279.4);
                        }
                        $this->pdf->Text(73, 208, mb_convert_encoding($row['NOMBRE_USUARIO'] . ' ' . $row['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));
                        $campos = [
                            'ENVEJECIMIENTO_CUTANEO' => 'Envejecimiento cutáneo',
                            'RITIDES' => 'Ritides',
                            'BRUXISMO' => 'Bruxismo',
                            'ADIP_LOCALIZADA' => 'Adiposidad Localizada',
                            'ESTRIAS' => 'Estrías',
                            'VARICES' => 'Várices',
                            'HIPERMEGTACION' => 'Hiperpigmentación',
                            'ALOPECIA' => 'Alopecia',
                            'VERRUGAS' => 'Verrugas',
                            'FLACIDEZ_CUTANEA' => 'Flacidez cutánea',
                            'ACNE' => 'Acné',
                            'PEFE' => 'Celulitis',
                            'CICATRICES' => 'Cicatrices',
                            'ROSACEA' => 'Rosácea',
                            'HIPERHIDROSIS' => 'Hiperhidrósis',

                        ];

                        $x = 154;          // Coordenada X inicial
                        $y = 213;         // Coordenada Y inicial
                        $maxX = 205;      // Límite derecho de la página (ajusta según tu margen)
                        $espaciado = 3; // Espacio entre textos
                        $mtvActivo = false; // Variable para controlar si se ha impreso "Otros tratamientos estéticos"

                        foreach ($campos as $campo => $texto) {
                            if ($row[$campo] == 1) {
                                $mtvActivo = true; // Marca que al menos un campo está activo

                                // Convertir texto al encoding correcto
                                $textoPDF = mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8');

                                // Obtener ancho real del texto
                                $anchoTexto = $this->pdf->GetStringWidth($textoPDF);

                                // Si ya no cabe en la línea actual, pasa a la siguiente
                                if ($x + $anchoTexto > $maxX) {
                                    $x = 20;
                                    $y += 5;
                                }

                                // Imprimir el texto
                                $this->pdf->Text($x, $y, $textoPDF);

                                // Avanzar X según el ancho del texto + espacio
                                $x += $anchoTexto + $espaciado;
                            }
                        }
                        if (!$mtvActivo) {
                            // Si no se ha impreso "Otros tratamientos estéticos", lo imprimimos aquí
                            $this->pdf->Text(161, 176, mb_convert_encoding($row['OTROS_TRATAMIENTOS_ESTETICOS'], 'ISO-8859-1', 'UTF-8'));
                        }

                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', '', 9); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/hialuronidasa/3.png", 0, 0, 215.9, 279.4);
                        }
                        $this->pdf->setXY(11, 29);
                        $this->pdf->Text(80, 124, mb_convert_encoding($row['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(80, 143, mb_convert_encoding($row['NOMBRE_USUARIO'] . ' ' . $row['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));


                        $this->pdf->Output(); //Salida al navegador del pdf
                    }

                    //----------------TIPO DE CONSULTA 8 ------------------

                    if ($id_tipo_usar == 8) {
                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', '', 10); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/peeling/1.png", 0, 0, 215.9, 279.4);
                        }
                        $this->pdf->setXY(11, 29);
                        $this->pdf->Text(60, 32, mb_convert_encoding($row['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(60, 40, $row['ID_CONSULTA']);
                        $this->pdf->Text(60, 48, mb_convert_encoding($row['NOMBRE_USUARIO'] . ' ' . $row['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(60, 56, date('d/m/Y', strtotime($row['FECHA_CONSULTA'])));

                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', '', 10); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/peeling/2.png", 0, 0, 215.9, 279.4);
                        }
                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', '', 9); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/peeling/3.png", 0, 0, 215.9, 279.4);
                        }
                        $this->pdf->setXY(11, 29);
                        $this->pdf->Text(73, 33, mb_convert_encoding($row['NOMBRE_USUARIO'] . ' ' . $row['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));
                        $campos = [
                            'ENVEJECIMIENTO_CUTANEO' => 'Envejecimiento cutáneo',
                            'RITIDES' => 'Ritides',
                            'BRUXISMO' => 'Bruxismo',
                            'ADIP_LOCALIZADA' => 'Adiposidad Localizada',
                            'ESTRIAS' => 'Estrías',
                            'VARICES' => 'Várices',
                            'HIPERMEGTACION' => 'Hiperpigmentación',
                            'ALOPECIA' => 'Alopecia',
                            'VERRUGAS' => 'Verrugas',
                            'FLACIDEZ_CUTANEA' => 'Flacidez cutánea',
                            'ACNE' => 'Acné',
                            'PEFE' => 'Celulitis',
                            'CICATRICES' => 'Cicatrices',
                            'ROSACEA' => 'Rosácea',
                            'HIPERHIDROSIS' => 'Hiperhidrósis',

                        ];

                        $x = 175;          // Coordenada X inicial
                        $y = 39;         // Coordenada Y inicial
                        $maxX = 205;      // Límite derecho de la página (ajusta según tu margen)
                        $espaciado = 3; // Espacio entre textos
                        $mtvActivo = false; // Variable para controlar si se ha impreso "Otros tratamientos estéticos"

                        foreach ($campos as $campo => $texto) {
                            if ($row[$campo] == 1) {
                                $mtvActivo = true; // Marca que al menos un campo está activo

                                // Convertir texto al encoding correcto
                                $textoPDF = mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8');

                                // Obtener ancho real del texto
                                $anchoTexto = $this->pdf->GetStringWidth($textoPDF);

                                // Si ya no cabe en la línea actual, pasa a la siguiente
                                if ($x + $anchoTexto > $maxX) {
                                    $x = 20;
                                    $y += 5;
                                }

                                // Imprimir el texto
                                $this->pdf->Text($x, $y, $textoPDF);

                                // Avanzar X según el ancho del texto + espacio
                                $x += $anchoTexto + $espaciado;
                            }
                        }
                        if (!$mtvActivo) {
                            // Si no se ha impreso "Otros tratamientos estéticos", lo imprimimos aquí
                            $this->pdf->Text(161, 176, mb_convert_encoding($row['OTROS_TRATAMIENTOS_ESTETICOS'], 'ISO-8859-1', 'UTF-8'));
                        }
                        $this->pdf->Text(80, 200, mb_convert_encoding($row['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(80, 219, mb_convert_encoding($row['NOMBRE_USUARIO'] . ' ' . $row['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));

                        $this->pdf->Output(); //Salida al navegador del pdf
                    }

                    //----------------TIPO DE CONSULTA 9 ------------------

                    if ($id_tipo_usar == 9) {
                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', '', 10); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/toxina/1.png", 0, 0, 215.9, 279.4);
                        }

                        $this->pdf->setXY(11, 29);
                        $this->pdf->Text(60, 32, mb_convert_encoding($row['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(60, 40, $row['ID_CONSULTA']);
                        $this->pdf->Text(60, 48, mb_convert_encoding($row['NOMBRE_USUARIO'] . ' ' . $row['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(60, 56, date('d/m/Y', strtotime($row['FECHA_CONSULTA'])));

                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', '', 8); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/toxina/2.png", 0, 0, 215.9, 279.4);
                        }
                        $this->pdf->Text(73, 152, mb_convert_encoding($row['NOMBRE_USUARIO'] . ' ' . $row['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));
                        $campos = [
                            'ENVEJECIMIENTO_CUTANEO' => 'Envejecimiento cutáneo',
                            'RITIDES' => 'Ritides',
                            'BRUXISMO' => 'Bruxismo',
                            'ADIP_LOCALIZADA' => 'Adiposidad Localizada',
                            'ESTRIAS' => 'Estrías',
                            'VARICES' => 'Várices',
                            'HIPERMEGTACION' => 'Hiperpigmentación',
                            'ALOPECIA' => 'Alopecia',
                            'VERRUGAS' => 'Verrugas',
                            'FLACIDEZ_CUTANEA' => 'Flacidez cutánea',
                            'ACNE' => 'Acné',
                            'PEFE' => 'Celulitis',
                            'CICATRICES' => 'Cicatrices',
                            'ROSACEA' => 'Rosácea',
                            'HIPERHIDROSIS' => 'Hiperhidrósis',

                        ];

                        $x = 161;          // Coordenada X inicial
                        $y = 157;         // Coordenada Y inicial
                        $maxX = 205;      // Límite derecho de la página (ajusta según tu margen)
                        $espaciado = 3; // Espacio entre textos
                        $mtvActivo = false; // Variable para controlar si se ha impreso "Otros tratamientos estéticos"

                        foreach ($campos as $campo => $texto) {
                            if ($row[$campo] == 1) {
                                $mtvActivo = true; // Marca que al menos un campo está activo

                                // Convertir texto al encoding correcto
                                $textoPDF = mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8');

                                // Obtener ancho real del texto
                                $anchoTexto = $this->pdf->GetStringWidth($textoPDF);

                                // Si ya no cabe en la línea actual, pasa a la siguiente
                                if ($x + $anchoTexto > $maxX) {
                                    $x = 20;
                                    $y += 5;
                                }

                                // Imprimir el texto
                                $this->pdf->Text($x, $y, $textoPDF);

                                // Avanzar X según el ancho del texto + espacio
                                $x += $anchoTexto + $espaciado;
                            }
                        }
                        if (!$mtvActivo) {
                            // Si no se ha impreso "Otros tratamientos estéticos", lo imprimimos aquí
                            $this->pdf->Text(161, 176, mb_convert_encoding($row['OTROS_TRATAMIENTOS_ESTETICOS'], 'ISO-8859-1', 'UTF-8'));
                        }

                        $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
                        $this->pdf->SetFont('Arial', '', 9); //Arial, negrita, 12 puntos
                        $this->pdf->designUp();

                        if ($modo != 'imprimir') {
                            $this->pdf->Image(FCPATH . "assets/img/toxina/3.png", 0, 0, 215.9, 279.4);
                        }
                        $this->pdf->setXY(11, 29);
                        $this->pdf->Text(80, 72, mb_convert_encoding($row['NOMBRE_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_PATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8') . ' ' . mb_convert_encoding($row['APELLIDO_MATERNO_PACIENTE'], 'ISO-8859-1', 'UTF-8'));
                        $this->pdf->Text(80, 90, mb_convert_encoding($row['NOMBRE_USUARIO'] . ' ' . $row['APELLIDO_USUARIO'], 'ISO-8859-1', 'UTF-8'));

                        $this->pdf->Output(); //Salida al navegador del pdf
                    }
                } else {
                    echo "redirect('consult/index')";
                }
            } else {
                redirect('consult/index');
            }
        }
    }
    public function previewConsentimiento($idPacienteActual = null, $idTipoConsentimiento = null, $idMedico = null, $indicacionesIds = null)
    {
        // ... validaciones previas ...

        if (!$idPacienteActual || !$idTipoConsentimiento || !$idMedico) {
            show_error('Faltan parámetros requeridos (paciente, tipo o médico)');
        }

        // Obtener datos del paciente
        $paciente = $this->mpatient->get_patient_by_id($idPacienteActual);

        if (empty($paciente)) {
            show_error('Paciente no encontrado');
        }

        $p = $paciente; // o row_array() según tu modelo

        // Obtener nombre completo del médico seleccionado (¡aquí usamos $idMedico!)
        $medicoData = $this->mpatient->get_medico_by_id($idMedico);

        $nombreMedico = mb_convert_encoding(
            trim(
                (isset($medicoData['NOMBRE_USUARIO']) ? $medicoData['NOMBRE_USUARIO'] : '') . ' ' .
                    (isset($medicoData['APELLIDO_USUARIO']) ? $medicoData['APELLIDO_USUARIO'] : '')
            ),
            'ISO-8859-1',
            'UTF-8'
        );

        if (empty($nombreMedico)) {
            $nombreMedico = 'Médico no identificado'; // fallback
        }

        // Nombre del paciente
        $nombrePaciente = mb_convert_encoding(
            trim($p->NOMBRE_PACIENTE . ' ' . $p->APELLIDO_PATERNO_PACIENTE . ' ' . $p->APELLIDO_MATERNO_PACIENTE),
            'ISO-8859-1',
            'UTF-8'
        );

        // Fecha actual (hoy)
        $fechaHoy = date('d/m/Y');

        $this->db->select("AUTO_INCREMENT");
        $this->db->from("information_schema.tables");
        $this->db->where("table_schema", $this->db->database);
        $this->db->where("table_name", "consulta");

        $query = $this->db->get();
        $siguiente = ($query->num_rows() > 0) ? $query->row()->AUTO_INCREMENT : 1;

        $historiaClinica =  str_pad($siguiente, 6);

        // Cargar librería PDF
        $this->load->library('PDF');

        $indicaciones = [];
        if ($indicacionesIds && $indicacionesIds !== '0') {
            $codigos = explode('-', $indicacionesIds);
            $opcionesFijas = [
                'ENVEJECIMIENTO_CUTANEO' => 'Envejecimiento cutáneo',
                'RITIDES' => 'Rítides',
                'BRUXISMO' => 'Bruxismo',
                'ADIPOSIDAD_LOCALIZADA' => 'Adiposidad Localizada',
                'ESTRIAS' => 'Estrías',
                'VARICES' => 'Várices',
                'HIPERPIGMENTACION' => 'Hiperpigmentación',
                'ALOPECIA' => 'Alopecia',
                'VERRUGAS' => 'Verrugas',
                'FLACIDEZ_CUTANEA' => 'Flacidez cutánea',
                'ACNE' => 'Acné',
                'CELULITIS' => 'Celulitis',
                'CICATRICES' => 'Cicatrices',
                'ROSACEA' => 'Rosácea',
                'HIPERHIDROSIS' => 'Hiperhidrósis',
            ];

            foreach ($codigos as $codigo) {
                if (isset($opcionesFijas[$codigo])) {
                    $indicaciones[] = $opcionesFijas[$codigo];
                }
            }
        }

        // Agregar texto de "Otros" si existe
        $otros = $this->input->get('otros');
        if ($otros) {
            $indicaciones[] = urldecode($otros);
        }

        $textoIndicaciones = empty($indicaciones)
            ? 'No se especificaron indicaciones'
            : implode(', ', $indicaciones);

        // ---------------- TIPO DE CONSENTIMIENTO 1 ------------------
        if ($idTipoConsentimiento == 1) {
            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            //$this->pdf->Image(FCPATH . "assets/img/acidoHialuronico/1.png", 0, 0, 215.9, 279.4);
            $this->pdf->SetFont('Arial', '', 10);


            $this->pdf->Text(60, 47, $nombrePaciente);
            //$this->pdf->Text(60, 39, $historiaClinica);
            $this->pdf->Text(60, 54, $nombreMedico);
            $this->pdf->Text(60, 62, $fechaHoy);

            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            //$this->pdf->Image(FCPATH . "assets/img/acidoHialuronico/2.png", 0, 0, 215.9, 279.4);
            $this->pdf->Text(73, 222, $nombreMedico);
            $this->pdf->SetFont('Arial', '', 9);

            $x = 161;          // Coordenada X inicial
            $y = 228 ;
            $maxX = 205;
            $espaciado = 3;

            if (empty($textoIndicaciones)) {
                $this->pdf->Text($x, $y, mb_convert_encoding('No se especificaron indicaciones', 'ISO-8859-1', 'UTF-8'));
            } else {
                $items = explode(', ', $textoIndicaciones);
                foreach ($items as $texto) {
                    $textoPDF = mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8');
                    $anchoTexto = $this->pdf->GetStringWidth($textoPDF);

                    if ($x + $anchoTexto > $maxX) {
                        $x = 20;
                        $y += 5;
                    }

                    $this->pdf->Text($x, $y, $textoPDF);
                    $x += $anchoTexto + $espaciado;
                }
            }

            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            // $this->pdf->Image(FCPATH . "assets/img/acidoHialuronico/3.png", 0, 0, 215.9, 279.4);
            $this->pdf->SetFont('Arial', '', 9);
            $this->pdf->Text(80, 145, $nombrePaciente);

            $this->pdf->Output('I');
        }
        // ---------------- TIPO DE CONSENTIMIENTO 2 ------------------
        elseif ($idTipoConsentimiento == 2) {
            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            // $this->pdf->Image(FCPATH . "assets/img/bioestimulador/1.png", 0, 0, 215.9, 279.4);
            $this->pdf->SetFont('Arial', '', 10);

            $this->pdf->Text(60, 47, $nombrePaciente);
            //$this->pdf->Text(60, 39, $historiaClinica);
            $this->pdf->Text(60, 54, $nombreMedico);
            $this->pdf->Text(60, 62, $fechaHoy);

            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            //$this->pdf->Image(FCPATH . "assets/img/bioestimulador/2.png", 0, 0, 215.9, 279.4);
            $this->pdf->Text(73, 188, $nombreMedico);
            $this->pdf->SetFont('Arial', '', 9);

            $x = 161;          // Coordenada X inicial
            $y = 193;
            $maxX = 205;
            $espaciado = 3;

            if (empty($indicaciones)) {
                $this->pdf->Text($x, $y, mb_convert_encoding('No se especificaron indicaciones', 'ISO-8859-1', 'UTF-8'));
            } else {
                foreach ($indicaciones as $texto) {
                    $textoPDF = mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8');
                    $anchoTexto = $this->pdf->GetStringWidth($textoPDF);

                    if ($x + $anchoTexto > $maxX) {
                        $x = 20;
                        $y += 5;
                    }

                    $this->pdf->Text($x, $y, $textoPDF);
                    $x += $anchoTexto + $espaciado;
                }
            }

            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            //$this->pdf->Image(FCPATH . "assets/img/bioestimulador/3.png", 0, 0, 215.9, 279.4);
            $this->pdf->SetFont('Arial', '', 9);
            $this->pdf->Text(80, 108, $nombrePaciente);

            $this->pdf->Output('I');
        }

        // ---------------- TIPO DE CONSENTIMIENTO 3 ------------------
        elseif ($idTipoConsentimiento == 3) {
            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            //$this->pdf->Image(FCPATH . "assets/img/co2/1.png", 0, 0, 215.9, 279.4);
            $this->pdf->SetFont('Arial', '', 10);

            $this->pdf->Text(60, 47, $nombrePaciente);
            //$this->pdf->Text(60, 39, $historiaClinica);
            $this->pdf->Text(60, 54, $nombreMedico);
            $this->pdf->Text(60, 62, $fechaHoy);

            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            // $this->pdf->Image(FCPATH . "assets/img/co2/2.png", 0, 0, 215.9, 279.4);
            $this->pdf->SetFont('Arial', '', 9);
            $this->pdf->Text(80, 134, $nombrePaciente);
            $this->pdf->Text(80, 201, $nombrePaciente);


            $this->pdf->Output('I');
        }
        // ==================== TIPO 4 - Laser ====================
        elseif ($idTipoConsentimiento == 4) {
            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            //$this->pdf->Image(FCPATH . "assets/img/laser/1.png", 0, 0, 215.9, 279.4);
            $this->pdf->SetFont('Arial', '', 10);
            $this->pdf->Text(60, 47, $nombrePaciente);
            //$this->pdf->Text(60, 39, $historiaClinica);
            $this->pdf->Text(60, 54, $nombreMedico);
            $this->pdf->Text(60, 62, $fechaHoy);

            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            //$this->pdf->Image(FCPATH . "assets/img/laser/2.png", 0, 0, 215.9, 279.4);

            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            //$this->pdf->Image(FCPATH . "assets/img/laser/3.png", 0, 0, 215.9, 279.4);
            $this->pdf->SetFont('Arial', '', 8);
            $this->pdf->Text(73, 176, $nombreMedico);

            $x = 161;          // Coordenada X inicial
            $y = 178;
            $maxX = 208;
            $espaciado = 3;

            if (empty($indicaciones)) {
                $this->pdf->Text($x, $y, mb_convert_encoding('No se especificaron indicaciones', 'ISO-8859-1', 'UTF-8'));
            } else {
                foreach ($indicaciones as $texto) {
                    $textoPDF = mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8');
                    $anchoTexto = $this->pdf->GetStringWidth($textoPDF);

                    if ($x + $anchoTexto > $maxX) {
                        $x = 20;
                        $y += 5;
                    }

                    $this->pdf->Text($x, $y, $textoPDF);
                    $x += $anchoTexto + $espaciado;
                }
            }

            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            //$this->pdf->Image(FCPATH . "assets/img/laser/4.png", 0, 0, 215.9, 279.4);
            $this->pdf->SetFont('Arial', '', 9);
            $this->pdf->Text(80, 99, $nombrePaciente);

            $this->pdf->Output('I');
        }

        // ==================== TIPO 5 - Endolifting ====================
        elseif ($idTipoConsentimiento == 5) {
            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            //$this->pdf->Image(FCPATH . "assets/img/endolifting/1.png", 0, 0, 215.9, 279.4);
            $this->pdf->SetFont('Arial', '', 10);
            $this->pdf->Text(60, 47, $nombrePaciente);
            //$this->pdf->Text(60, 39, $historiaClinica);
            $this->pdf->Text(60, 54, $nombreMedico);
            $this->pdf->Text(60, 62, $fechaHoy);

            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            //$this->pdf->Image(FCPATH . "assets/img/endolifting/2.png", 0, 0, 215.9, 279.4);

            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            //$this->pdf->Image(FCPATH . "assets/img/endolifting/3.png", 0, 0, 215.9, 279.4);

            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            //$this->pdf->Image(FCPATH . "assets/img/endolifting/4.png", 0, 0, 215.9, 279.4);
            $this->pdf->SetFont('Arial', '', 9);
            $this->pdf->Text(80, 174, $nombrePaciente);
            //$this->pdf->Text(80, 188, $nombreMedico);

            $this->pdf->Output('I');
        }

        // ==================== TIPO 6 - Enzimas ====================
        elseif ($idTipoConsentimiento == 6) {
            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            //$this->pdf->Image(FCPATH . "assets/img/enzimas/1.png", 0, 0, 215.9, 279.4);
            $this->pdf->SetFont('Arial', '', 10);
            $this->pdf->Text(60, 47, $nombrePaciente);
            //$this->pdf->Text(60, 39, $historiaClinica);
            $this->pdf->Text(60, 54, $nombreMedico);
            $this->pdf->Text(60, 62, $fechaHoy);

            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            //$this->pdf->Image(FCPATH . "assets/img/enzimas/2.png", 0, 0, 215.9, 279.4);

            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            //$this->pdf->Image(FCPATH . "assets/img/enzimas/3.png", 0, 0, 215.9, 279.4);
            $this->pdf->SetFont('Arial', '', 8);
            $this->pdf->Text(73, 147, $nombreMedico);

            $x = 162;          // Coordenada X inicial
            $y = 150;
            $maxX = 205;
            $espaciado = 3;

            if (empty($indicaciones)) {
                $this->pdf->Text($x, $y, mb_convert_encoding('No se especificaron indicaciones', 'ISO-8859-1', 'UTF-8'));
            } else {
                foreach ($indicaciones as $texto) {
                    $textoPDF = mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8');
                    $anchoTexto = $this->pdf->GetStringWidth($textoPDF);

                    if ($x + $anchoTexto > $maxX) {
                        $x = 20;
                        $y += 5;
                    }

                    $this->pdf->Text($x, $y, $textoPDF);
                    $x += $anchoTexto + $espaciado;
                }
            }

            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            //$this->pdf->Image(FCPATH . "assets/img/enzimas/4.png", 0, 0, 215.9, 279.4);
            $this->pdf->SetFont('Arial', '', 9);
            $this->pdf->Text(80, 70, $nombrePaciente);
            //$this->pdf->Text(80, 76.5, $nombreMedico);

            $this->pdf->Output('I');
        }

        // ==================== TIPO 7 - Hialuronidasa ====================
        elseif ($idTipoConsentimiento == 7) {
            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            //$this->pdf->Image(FCPATH . "assets/img/hialuronidasa/1.png", 0, 0, 215.9, 279.4);
            $this->pdf->SetFont('Arial', '', 10);
            $this->pdf->Text(60, 47, $nombrePaciente);
            //$this->pdf->Text(60, 39, $historiaClinica);
            $this->pdf->Text(60, 54, $nombreMedico);
            $this->pdf->Text(60, 62, $fechaHoy);

            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            // $this->pdf->Image(FCPATH . "assets/img/hialuronidasa/2.png", 0, 0, 215.9, 279.4);
            $this->pdf->SetFont('Arial', '', 8);
            $this->pdf->Text(73, 211, $nombreMedico);

            $x = 154;          // Coordenada X inicial
            $y = 215;
            $maxX = 205;
            $espaciado = 3;

            if (empty($indicaciones)) {
                $this->pdf->Text($x, $y, mb_convert_encoding('No se especificaron indicaciones', 'ISO-8859-1', 'UTF-8'));
            } else {
                foreach ($indicaciones as $texto) {
                    $textoPDF = mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8');
                    $anchoTexto = $this->pdf->GetStringWidth($textoPDF);

                    if ($x + $anchoTexto > $maxX) {
                        $x = 20;
                        $y += 5;
                    }

                    $this->pdf->Text($x, $y, $textoPDF);
                    $x += $anchoTexto + $espaciado;
                }
            }


            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            //$this->pdf->Image(FCPATH . "assets/img/hialuronidasa/3.png", 0, 0, 215.9, 279.4);
            $this->pdf->SetFont('Arial', '', 9);
            $this->pdf->Text(80, 133, $nombrePaciente);
            //$this->pdf->Text(80, 143, $nombreMedico);

            $this->pdf->Output('I');
        }

        // ==================== TIPO 8 - Peeling ====================
        elseif ($idTipoConsentimiento == 8) {
            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            //$this->pdf->Image(FCPATH . "assets/img/peeling/1.png", 0, 0, 215.9, 279.4);
            $this->pdf->SetFont('Arial', '', 10);
            $this->pdf->Text(60, 47, $nombrePaciente);
            //$this->pdf->Text(60, 39, $historiaClinica);
            $this->pdf->Text(60, 54, $nombreMedico);
            $this->pdf->Text(60, 62, $fechaHoy);

            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            //$this->pdf->Image(FCPATH . "assets/img/peeling/2.png", 0, 0, 215.9, 279.4);
            $this->pdf->SetFont('Arial', '', 8);
            //$this->pdf->Text(73, 208, $nombreMedico);

            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            //$this->pdf->Image(FCPATH . "assets/img/peeling/3.png", 0, 0, 215.9, 279.4);
            $this->pdf->SetFont('Arial', '', 9);
            $this->pdf->Text(73, 48, $nombreMedico);
            $this->pdf->Text(80, 204, $nombrePaciente);
            //$this->pdf->Text(80, 219, $nombreMedico);

            $x = 185;          // Coordenada X inicial
            $y = 53;
            $maxX = 205;
            $espaciado = 3;

            if (empty($indicaciones)) {
                $this->pdf->Text($x, $y, mb_convert_encoding('No se especificaron indicaciones', 'ISO-8859-1', 'UTF-8'));
            } else {
                foreach ($indicaciones as $texto) {
                    $textoPDF = mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8');
                    $anchoTexto = $this->pdf->GetStringWidth($textoPDF);

                    if ($x + $anchoTexto > $maxX) {
                        $x = 20;
                        $y += 5;
                    }

                    $this->pdf->Text($x, $y, $textoPDF);
                    $x += $anchoTexto + $espaciado;
                }
            }

            $this->pdf->Output('I');
        }

        // ==================== TIPO 9 - Toxina ====================
        elseif ($idTipoConsentimiento == 9) {
            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            //$this->pdf->Image(FCPATH . "assets/img/toxina/1.png", 0, 0, 215.9, 279.4);
            $this->pdf->SetFont('Arial', '', 10);
            $this->pdf->Text(60, 47, $nombrePaciente);
            //$this->pdf->Text(60, 39, $historiaClinica);
            $this->pdf->Text(60, 54, $nombreMedico);
            $this->pdf->Text(60, 62, $fechaHoy);

            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            //$this->pdf->Image(FCPATH . "assets/img/toxina/2.png", 0, 0, 215.9, 279.4);
            $this->pdf->SetFont('Arial', '', 8);
            $this->pdf->Text(73, 159, $nombreMedico);

            $x = 161;          // Coordenada X inicial
            $y = 164;
            $maxX = 205;
            $espaciado = 3;

            if (empty($indicaciones)) {
                $this->pdf->Text($x, $y, mb_convert_encoding('No se especificaron indicaciones', 'ISO-8859-1', 'UTF-8'));
            } else {
                foreach ($indicaciones as $texto) {
                    $textoPDF = mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8');
                    $anchoTexto = $this->pdf->GetStringWidth($textoPDF);

                    if ($x + $anchoTexto > $maxX) {
                        $x = 20;
                        $y += 5;
                    }

                    $this->pdf->Text($x, $y, $textoPDF);
                    $x += $anchoTexto + $espaciado;
                }
            }

            $this->pdf->AddPage('P', 'Letter');
            $this->pdf->designUp();
            // $this->pdf->Image(FCPATH . "assets/img/toxina/3.png", 0, 0, 215.9, 279.4);
            $this->pdf->SetFont('Arial', '', 9);
            $this->pdf->Text(80, 85, $nombrePaciente);
            //$this->pdf->Text(80, 90, $nombreMedico);

            $this->pdf->Output('I');
        } else {
            show_error('Tipo de consentimiento no válido');
        }
    }
}
