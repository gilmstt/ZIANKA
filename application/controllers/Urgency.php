<?php defined('BASEPATH') or exit('No direct script access allowed');

class Urgency extends CI_Controller
{
// CONSTRUCT
   public function __construct()
   {
      parent::__construct();
      $this->load->model('Mpatient');
      $this->load->model('Murgency');
      $this->load->model('Mconsult');
      $this->load->model('Minventary');
      $this->load->helper('functions');
      $this->load->helper('general');
      $this->ID_SESSION = $this->session->userdata('CAREYES_ID_USUARIO');
   }
// INDEX
   public function index()
   {
      if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
        
         $data['ROW_PATIENTS'] = $this->Mpatient->get_all_valid_patients();
         $data['PRODUCTOS'] = $this->Murgency->get_productos_();
         
         $this->load->view('esqueleton/header', getActive("classUrg"));
         $this->load->view('Urgency/v_index_urgency', $data);
         $this->load->view('esqueleton/footer');
      } else {
         redirect('login/salir');
      }
   }
   public function ajax_get_all_urgencys()
   {
      if ($this->input->is_ajax_request()) {
         $data = $this->Murgency->get_urgencias();
         echo json_encode($data, true);
      } else {
         show_404();
      }
   }
   public function ajax_get_all_patients()
   {
      if ($this->input->is_ajax_request()) {
         $data = $this->Murgency->get_patients();
         echo json_encode($data, true);
      } else {
         show_404();
      }
   }
   public function ajax_get_urgency_by_id()
   {
      if ($this->input->is_ajax_request()) {
         $Urgency = $this->Murgency->get_urgency_by_id();
         echo json_encode($Urgency);
      } else {
         show_404();
      }
   }
   public function ajax_update_urgency()
   {
      if ($this->input->is_ajax_request()) {
         $this->Murgency->update_urgency();
      } else {

      }
   }
   public function ajax_delete_urgency()
   {
      if ($this->input->is_ajax_request()) {
          $ID_URGENCIA = $this->input->post('id_urgencia');
          $ROW_ITEMS = $this->Mconsult->get_producto_by_urgency_id($ID_URGENCIA);
          foreach ($ROW_ITEMS as $ROW) {
              $ID_PRODUCTO = $ROW['ID_PRODUCTO'];
              $ITEM_ON_DB = $this->Minventary->get_product_by_id($ID_PRODUCTO);
              $data['STOCK_PRODUCTO'] = $ITEM_ON_DB[0]['STOCK_PRODUCTO'] + $ROW['CANT_PRODUCTO'];
              $UPDATE = $this->Minventary->edit_product_on_db($data, $ID_PRODUCTO);
              
          }
         if ($this->Murgency->delete_urgency()) {
            echo "success";
         } else {
            echo "error";
         }

      } else {
         redirect('index', 'refresh');
      }
   }
   public function ajax_get_tarifa_by_id()
   {
      if ($this->input->is_ajax_request()) {
         $Tarifa = $this->Murgency->get_tarifa_by_id();
         echo json_encode($Tarifa);
      } 
   }
   public function ajax_edit_desc_tarifa(){
      if ($this->input->is_ajax_request()) {
         $edit= $this->Murgency->edit_desc_tarifa();
         if ($edit == "bien") {
            echo "success";
          }else{
            if($edit == "no ficha"){
               echo 'no ficha';   
            }else{
               echo 'repetido';
            }
         }
      } else {
         redirect('index');
      }
   }
   public function ajax_edit_total_pagado()
   {
      if ($this->input->is_ajax_request()) {
         $this->Murgency->edit_tot_pag();
      }else{
         redirect('Urgency/index');
      }
   }
   public function ajax_close_urgency()
   {
      if ($this->input->is_ajax_request()) {
         if($this->Murgency->close_urgencia()){
            echo "success";
         }
      }else{
         redirect('Urgency/index');
      }
   }
// MODAL FICHA CONSUMO PRODUCTOS & PROCEDIMIENTOS

   public function ajax_get_procedimientos()
   {
      if ($this->input->is_ajax_request()) {
         $data = $this->Murgency->get_procedimientos();
         echo json_encode($data);

      } else {
         redirect('index');
      }
   }
   public function ajax_get_productos()
   {
      if ($this->input->is_ajax_request()) {
         $data = $this->Murgency->get_productos();
         echo json_encode($data);

      } else {
         redirect('index');
      }
   }
   public function ajax_insert_relProcedimiento()
   {
      if ($this->input->is_ajax_request()) {
         $id_ficha = $this->Murgency->insert_relProcedimiento();
         echo $id_ficha;

      } else {
         redirect('index');
      }
   }
   public function ajax_delete_relProcedimiento()
   {
      if ($this->input->is_ajax_request()) {
         $this->Murgency->delete_relProcedimiento();

      } else {
         redirect('index');
      }
   }
   public function ajax_insert_relProducto()
   {
      if ($this->input->is_ajax_request()) {
         $id_ficha = $this->Murgency->insert_relProducto();
         echo $id_ficha;
      } else {
         redirect('index');
      }
   }
   public function ajax_delete_relProducto()
   {
      if ($this->input->is_ajax_request())
      {
         $this->Murgency->delete_relProducto();
      } else {
         redirect('index');
      }
   }
// VIEW FORM BY PATIENT & IF NOT EXIST
   public function form_add_urgency_by_patient()
   {
      $id = $this->input->post('ID_PACIENTE');
    
      $data['row_user'] = $this->Mpatient->get_patient_by_id($id);
      $this->load->view('esqueleton/header', getActive("classUrg"));
      $this->load->view('Urgency/v_new_urgency_by_patient', $data);
      $this->load->view('esqueleton/footer');
      
      $this->db->where('ID_SESSION',$this->ID_SESSION); 
      $this->db->delete(array('temp_procedimiento','temp_producto'));

   }
   public function form_add_urgency()
   {
      $this->load->view('esqueleton/header', getActive("classUrg"));
      $this->load->view('Urgency/v_new_urgency');
      $this->load->view('esqueleton/footer');
      
      $this->db->where('ID_SESSION',$this->ID_SESSION); 
      $this->db->delete(array('temp_procedimiento','temp_producto'));

   }
// INSERT NEW URGENCY
   public function ajax_add_urgency_by_patient()
   {
      if ($this->input->is_ajax_request()) {
         $this->Murgency->add_urgency();
      } else {
         redirect('index');
      }
   }
// ADJUNTAR ARCHIVOS
   // MODAL ADJUNTAR ARCHIVO
   public function ajax_get_files_urgency()
   {
      if ($this->input->is_ajax_request() && !empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
         $ID_URGENCIA = $this->input->post('ID_URGENCIA');
         $FILES_URGENCY = $this->Murgency->get_files_urgency_on_db($ID_URGENCIA);
         if (count($FILES_URGENCY) > NULO):
            $this->output->set_content_type("application/json")->set_output(json_encode($FILES_URGENCY));
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
         $ID_URGENCIA = $this->input->post('ID_URGENCIA');
         $ID_DOCUMENTO = $this->input->post('ID_DOCUMENTO');
         $NOMBRE_DOCUMENTO = $this->input->post('NOMBRE_DOCUMENTO');

         $affected = $this->Murgency->delete_file_by_id($ID_DOCUMENTO);
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

         $ID_URGENCIA = $_POST['ID_URGENCIA'];

         if (strlen(trim($_FILES['userfile']['name'])) > NULO) {
            $tmpNombreDir = $ID_URGENCIA . '_FILES' . '/';
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
               $data_aux['ID_URGENCIA'] = $ID_URGENCIA;
               $INSERT_FILE_URGENCIA = $this->Murgency->insert_file_by_urgency_id($data_aux);
               echo $INSERT_FILE_URGENCIA;

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
   //RECETA URGENCIA
   public function creaPdfReceta($ID_URGENCIA) {
      if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {

          if ($ID_URGENCIA > NULO) {
              $ROW_URGENCY = $this->Mconsult->get_urgency_by_id($ID_URGENCIA);
              
              if (count($ROW_URGENCY) > NULO) {
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
                  $this->pdf->text(140, 43 , utf8_decode('Fecha:'), 0, 0, 'L');
                  $this->pdf->Text(160, 42, $ROW_URGENCY[0]['FECHA_URGENCIA']);

                  $this->pdf->text(16, 43 , utf8_decode('Paciente:'), 0, 0, 'L');

                  $this->pdf->setXY(11, 34);
                  $this->pdf->line(40, 43, 140, 43);
                  $this->pdf->Text(41, 42, utf8_decode(mb_strtoupper($ROW_URGENCY[0]['NOMBRE_PACIENTE'])) . ' ' . utf8_decode(mb_strtoupper($ROW_URGENCY[0]['APELLIDO_PATERNO_PACIENTE'])) . ' ' . utf8_decode(mb_strtoupper($ROW_URGENCY[0]['APELLIDO_MATERNO_PACIENTE'])));

                  $this->pdf->text(16, 53 , utf8_decode('Diagnóstico:'), 0, 0, 'L');
                  $this->pdf->Text(41, 52, utf8_decode($ROW_URGENCY[0]['DIAGNOSTICO_EGRESO']));
                  $this->pdf->line(40, 53, 140, 53);

                  $this->pdf->text(141, 53, 'Edad:', 0, 0, 'L');
                  $this->pdf->Text(167, 52, calcula_edad_2($ROW_URGENCY[0]['FECHA_NAC_PACIENTE'], $ROW_URGENCY[0]['FECHA_URGENCIA']));
                  $this->pdf->line(153, 53, 199, 53);
                  
                  $this->pdf->setXY(15, 56);
                  $this->pdf->Multicell(163, 5.5, utf8_decode($ROW_URGENCY[0]['TRATAMIENTO_URGENCIA']));
                     
                  $this->pdf->setXY(25, 145);
                  $y= $this->pdf->GetY();

                  $this->pdf->Text(25, $y+5 , utf8_decode('DR.:'), 0, 0, 'L');
                  $this->pdf->Text(35, $y+5, $ROW_URGENCY[0]['NOMBRE_USUARIO'].' '.$ROW_URGENCY[0]['APELLIDO_USUARIO']);
                  $this->pdf->line(34, $y+6, 139, $y+6);
                  $this->pdf->Text(140,$y+5, utf8_decode('CEDULA:'), 0, 0, 'L');
                  $this->pdf->Text(167, $y+5, $ROW_URGENCY[0]['CEDULA_USUARIO']);
                  $this->pdf->line(159, $y+6, 199,$y+6);

                  $this->pdf->SetFont('Arial', 'B', 8); //Arial, negrita, 12 puntos
                  $this->pdf->setXY(10, 157);
                  $this->pdf->Cell(0, 0, utf8_decode('Km. 53.5 CARRETERA MELAQUE-PUERTO VALLARTA TELS:(315) 351 0170 Y 351 0169 FAX:(315) 351 0043 CAREYITOS,JALISCO. C.P.48890'), 0, 0, 'C');
                  $this->pdf->line(12, $y+17, 205, $y+17);
                  $this->pdf->Output(); //Salida al navegador del pdf
              } else {
                  echo "redirect('urgencia/index')";
              }
          } else {
              redirect('Urgency/index');
          }
      }
  }

  public function change_tarifa_urgency() {
      if ($this->input->is_ajax_request()) {

         $ficha = $this->input->post('ficha');
         $id = $this->input->post('id_tarifa');

         $this->db->where('ID_FICHA', $ficha);
         $this->db->update('urgencia', array('ID_TARIFA' => $id));
         if ($this->db->affected_rows() > 0) {
            echo "success";
         }
      }
   }

   public function ajax_update_cantidad_producto() {
      if ($this->input->is_ajax_request()) {
         $id = $this->input->post('id');
         $producto_ficha = $this->Murgency->get_producto_ficha($id);
         $id_producto = $producto_ficha->ID_PRODUCTO;
         $row_producto = $this->Minventary->get_product_by_id($id_producto);
         $precio = $row_producto[0]['PRECIO_PRODUCTO'];
         $existencia_actual = $row_producto[0]['STOCK_PRODUCTO'];

         // actualizar producto ficha
         $precioxCant = $precio * $this->input->post('cantidad');
         $data = array(
            'CANT_PRODUCTO' => intval($this->input->post('cantidad')),
            "PRECIO_PRODUCTO" => $precioxCant
         );
         $update = $this->Murgency->update_rel_producto_ficha($id, $data);

         // actualizar stock
         $current_stock = $existencia_actual + ($producto_ficha->CANT_PRODUCTO - $this->input->post('cantidad'));
         $data = array(
            'STOCK_PRODUCTO' => $current_stock
         );
         $update = $this->Minventary->edit_product_on_db($data, $id_producto);

         echo $producto_ficha->ID_FICHA;
      }
   }

}

/* End of file Urgencias.php */
