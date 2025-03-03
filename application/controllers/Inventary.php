<?php


if (!defined('BASEPATH')) {
   exit('No direct script access allowed');
}


class Inventary extends CI_Controller
{

   public function __construct()
   {
      parent::__construct();

      $this->load->model('minventary');
      $this->load->helper('functions');
      $this->load->helper('general');
   }

   public function index()
   {
      if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
         $data = getActive("classInv");
         $this->load->view('esqueleton/header', $data);
         $this->load->view('Inventary/v_index_products');
         $this->load->view('esqueleton/footer');
      } else {
         redirect('login/salir');
      }
   }

   public function ajax_dt_product()
   {
      if ($this->input->is_ajax_request()) {
         $PRODUCTOS = $this->minventary->get_products();
         echo json_encode($PRODUCTOS);
      } else {
         redirect('inventary');
      }
   }
   public function ajax_dt_med()
   {
      if ($this->input->is_ajax_request()) {
         $PRODUCTOS = $this->minventary->get_med();
         echo json_encode($PRODUCTOS);
      } else {
         redirect('inventary');
      }
   }

   public function form_add_product($param)
   {
      if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
         $data = getActive("classInv");
         $data['ID_TIPO_PRODUCTO' ] = $param;
         $this->load->view('esqueleton/header', $data);
         $data['ROW_TYPE_PRODUCT'] = $this->minventary->get_all_valid_products_type();
         $this->load->view('Inventary/v_add_product', $data);
         $this->load->view('esqueleton/footer');
      } else {
         redirect('login/salir');
      }
   }

   public function ajax_add_product()
   {
      if ($this->input->is_ajax_request()) {

         $data['NOMBRE_PRODUCTO'] = trim($this->input->post("RG_NOMBRE_PRODUCTO"));
         $data['CODIGO_PRODUCTO'] = trim($this->input->post("RG_CODIGO_PRODUCTO"));
         $data['STOCK_PRODUCTO'] = trim($this->input->post("RG_STOCK_PRODUCTO"));
         $data['STOCK_MINIMO_PRODUCTO'] = trim($this->input->post("RG_STOCK_MINIMO_PRODUCTO"));
         $data['COSTO_PRODUCTO'] = trim($this->input->post("RG_COSTO_PRODUCTO"));
         $data['PRECIO_PRODUCTO'] = trim($this->input->post("RG_PRECIO_PRODUCTO"));
         $data['ID_TIPO_PRODUCTO'] = trim($this->input->post("RG_TIPO_PRODUCTO"));
         $data['FECHA_CADUCIDAD_MES'] = trim($this->input->post("RG_FECHA_MES_PRODUCTO"));
         $data['FECHA_CADUCIDAD_AÑO'] = trim($this->input->post("RG_FECHA_ANNIO_PRODUCTO"));
         $data['ACTIVO_PRODUCTO'] = 1;
         
         $ID_PRODUCTO = -3;
         $rep = array();
         if($data['CODIGO_PRODUCTO']!="") $rep = $this->minventary->get_cod_product($data['CODIGO_PRODUCTO']);
         if(count($rep)>0){
                    $ID_PRODUCTO = -2;
                }else{
                    $ID_PRODUCTO = $this->minventary->add_new_product_on_db($data);
                }
                echo $ID_PRODUCTO;
      } else {
         redirect('inventary');
      }
   }

   public function form_edit_product($PARAM)
   {

      if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
         $ID_PRODUCT = intval($PARAM);
         if ($ID_PRODUCT > NULO) {
            $ROW_PRODUCT = $this->minventary->get_product_by_id($ID_PRODUCT);
            if (count($ROW_PRODUCT) > NULO) {
               //CARGAR LA VISTA..
               $data = getActive("classInv");
               $this->load->view('esqueleton/header', $data);
               $data['ROW_DATA_PRODUCT'] = $ROW_PRODUCT;
               $data['ROW_TYPE_PRODUCT'] = $this->minventary->get_all_valid_products_type();
               $this->load->view('Inventary/v_edit_product', $data);
               $this->load->view('esqueleton/footer');
            } else {
               redirect('Inventary/v_index_products');
            }
         } else {
            redirect('Inventary/v_index_products');
         }
      }
   }

   /*     * ************* */

   /*     * **FIN EDITAR PROYECTO* */

   public function ajax_edit_product()
   {
      if ($this->input->is_ajax_request()) {
         $data['ID_PRODUCTO'] = trim($this->input->post("RG_ID_PRODUCT"));
         $data['NOMBRE_PRODUCTO'] = trim($this->input->post("RG_NOMBRE_PRODUCT"));
         $data['CODIGO_PRODUCTO'] = trim($this->input->post("RG_CODIGO_PRODUCTO"));
         $data['STOCK_PRODUCTO'] = trim($this->input->post("RG_STOCK_PRODUCT"));
         $data['STOCK_MINIMO_PRODUCTO'] = trim($this->input->post("RG_STOCK_MINIMO_PRODUCT"));
         $data['COSTO_PRODUCTO'] = trim($this->input->post("RG_COSTO_PRODUCT"));
         $data['PRECIO_PRODUCTO'] = trim($this->input->post("RG_PRECIO_PRODUCT"));
         $data['ID_TIPO_PRODUCTO'] = trim($this->input->post("RG_TIPO_PRODUCTO"));
         $data['FECHA_CADUCIDAD_MES'] = trim($this->input->post("RG_FECHA_MES_PRODUCTO"));
         $data['FECHA_CADUCIDAD_AÑO'] = trim($this->input->post("RG_FECHA_ANNIO_PRODUCTO"));
         

         $id_product = $this->input->post("RG_ID_PRODUCT");
         $AFFECTED_ROWS = $this->minventary->edit_product_on_db($data,$id_product);
         if ($AFFECTED_ROWS > NULO) {
            echo $AFFECTED_ROWS;
         } else {
            echo -1;
         }
      } else {
         redirect('inventary');
      }
   }

   public function ajax_disable_product()
   {
      if ($this->input->is_ajax_request()) {
         $ID_PRODUCT = $this->input->post('ID_PRODUCT');
         $AFFECTED_ROWS = $this->minventary->disable_product_on_db($ID_PRODUCT);
         echo $AFFECTED_ROWS;
      } else {
         redirect('proyectos');
      }
   }

   /* PROCEDIMIENTOS */

   public function index_procedure()
   {
      if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
         $data = getActive("classInv");
         $this->load->view('esqueleton/header', $data);
         $data['ROW_PROCEDURES'] = $this->minventary->get_all_valid_procedures();
         $this->load->view('Inventary/v_index_procedure', $data);
         $this->load->view('esqueleton/footer');
      } else {
         redirect('login/salir');
      }
   }

   public function form_add_procedure()
   {
      if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
         $data = getActive("classInv");
         $this->load->view('esqueleton/header', $data);
         //$data['ROW_PROCEDURES'] = $this->minventary->get_all_valid_procedures();
         $this->load->view('Inventary/v_add_procedure', $data);
         $this->load->view('esqueleton/footer');
      } else {
         redirect('login/salir');
      }
   }

   public function ajax_add_procedure()
   {
      if ($this->input->is_ajax_request()) {

         $data['descripcion_procedimiento'] = trim($this->input->post("RG_DESCRIPCION_PROCEDIMIENTO"));
         $data['precio_procedimiento'] = trim($this->input->post("RG_PRECIO_PROCEDIMIENTO"));
         $data['activo_procedimiento'] = 1;
         $ID_PROCEDIMIENTO = $this->minventary->add_new_procedure_on_db($data);
         if ($ID_PROCEDIMIENTO > NULO) {
            echo $ID_PROCEDIMIENTO;
         } else {
            echo -1;
         }
      } else {
         redirect('inventary');
      }
   }

   public function form_edit_procedure($PARAM)
   {
      if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
         $ID_PROC = intval($PARAM);
         if ($ID_PROC > NULO) {
            $ROW_PROC = $this->minventary->get_procedure_by_id($ID_PROC);
            if (count($ROW_PROC) > NULO) {
               //CARGAR LA VISTA..
               $data = getActive("classInv");
               //$data['ROW_PRODUCTS_TYPES'] = $this->minventary->get_all_valid_products_types();
               $this->load->view('esqueleton/header', $data);
               $data['ROW_DATA_PROC'] = $ROW_PROC;
               $this->load->view('Inventary/v_edit_procedure', $data);
               $this->load->view('esqueleton/footer');
            } else {
               redirect('Inventary/v_index_procedure');
            }
         } else {
            redirect('Inventary/v_index_procedure');
         }
      }
   }

   public function ajax_edit_procedure()
   {
      if ($this->input->is_ajax_request()) {
         $data['id_procedimiento'] = trim($this->input->post("RG_ID_PROCEDURE"));
         $data['descripcion_procedimiento'] = trim($this->input->post("RG_DESCRIPCION_PROCEDURE"));
         $data['precio_procedimiento'] = trim($this->input->post("RG_PRECIO_PROCEDURE"));
         $AFFECTED_ROWS = $this->minventary->edit_procedure_on_db($data);
         if ($AFFECTED_ROWS > NULO) {
            echo $AFFECTED_ROWS;
         } else {
            echo -1;
         }
      } else {
         redirect('inventary');
      }
   }

   public function ajax_disable_procedure()
   {
      if ($this->input->is_ajax_request()) {
         $ID_PROC = $this->input->post('ID_PROC');
         $AFFECTED_ROWS = $this->minventary->disable_procedure_on_db($ID_PROC);
         echo $AFFECTED_ROWS;
      } else {
         redirect('proyectos');
      }
   }

   /* FIN PROCEDIMIENTOS */

   /* INICIO COMPRAS */

   public function index_buy()
   {
      if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
         $data = getActive("classInv");
         $this->load->view("esqueleton/header", $data);

         $year = date('Y');
         $month = date('m');
         $day = date("d", mktime(0, 0, 0, $month + 1, 0, $year));
         $fechaini = date('d/m/Y', mktime(0, 0, 0, $month, 1, $year));
         $fechafin = date('d/m/Y');
         $data['fechaini'] = $fechaini;
         $data['fechafin'] = $fechafin;
         $this->load->view("Inventary/v_index_buy", $data);
         $this->load->view("esqueleton/footer");
      }
   }
   public function search_compras()
   {
      if ($this->input->is_ajax_request()) {
         $month = date('m');
         $year = date('Y');
         $day = date("d", mktime(0, 0, 0, $month + 1, 0, $year));
         $fechaini = date('d/m/Y', mktime(0, 0, 0, $month, 1, $year));
         $fechafin = date('d/m/Y');

         if ($this->input->post("RG_BUSCAR") == 1) {
            $dates['fechaini'] = convierte_fecha($this->input->post("RG_FECHA_INICIAL")) . " 00:00:00";
            $dates['fechafin'] = convierte_fecha($this->input->post("RG_FECHA_FINAL")) . " 23:59:59";
         } else {
            $dates['fechaini'] = convierte_fecha($fechaini) . " 00:00:00";
            $dates['fechafin'] = convierte_fecha($fechafin) . " 23:59:59";
         }

         $xdata = $this->minventary->get_compras($dates);
         echo json_encode($xdata);
      } else {
         show_404();
      }

   }

   public function index_supplier()
   {
      if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
         
         $this->load->view("esqueleton/header", getActive("classInv"));
         $this->load->view("Inventary/v_index_supplier");
         $this->load->view("esqueleton/footer");
      } else {
         redirect('login/salir');
      }
   }
   public function ajax_dt_supliers()
   {
      if ($this->input->is_ajax_request()) {
         $SUPLIERS = $this->minventary->get_supliers();
         echo json_encode($SUPLIERS);
      } else {
         redirect('inventary');
      }
   }
   public function ajax_dt_procedures()
   {
      if ($this->input->is_ajax_request()) {
         $SUPLIERS = $this->minventary->get_procedures();
         echo json_encode($SUPLIERS);
      } else {
         redirect('inventary');
      }
   }

   public function form_add_supplier()
   {
      if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
         $data = getActive("classInv");
         $this->load->view("esqueleton/header", $data);
         $this->load->view('Inventary/v_add_supplier');
         $this->load->view("esqueleton/footer");
      } else {
         redirect('login/salir');
      }
   }

   public function ajax_add_supplier()
   {
      if ($this->input->is_ajax_request()) {

         $data['NOMBRE_PROVEEDOR'] = trim($this->input->post("RG_NOMBRE_PROVEEDOR"));
         $data['EMPRESA_PROVEEDOR'] = trim($this->input->post("RG_EMPRESA_PROVEEDOR"));
         $data['DOMICILIO_PROVEEDOR'] = trim($this->input->post("RG_DOMICILIO_PROVEEDOR"));
         $data['TELEFONO_PROVEEDOR'] = trim($this->input->post('RG_TELEFONO_PROVEEDOR'));
         $data['NO_CUENTA_PROVEEDOR'] = trim($this->input->post('RG_NO_CUENTA_PROVEEDOR'));
         $data['VIGENTE_PROVEEDOR'] = VIGENTE;
         $ID_SUPPLIER = $this->minventary->add_new_supplier_on_db($data);
         if ($ID_SUPPLIER > NULO) {
            echo $ID_SUPPLIER;
         } else {
            echo -1;
         }
      } else {
         redirect('inventary/index_supplier');
      }
   }

   public function form_edit_supplier($ID_SUPPLIER)
   {
      if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
         if ($ID_SUPPLIER > NULO) {
            $ROW_SUPPLIER = $this->minventary->get_supplier_by_id_on_db($ID_SUPPLIER);
            if (count($ROW_SUPPLIER) > NULO) {
               $data = getActive("classInv");
               $this->load->view("esqueleton/header", $data);
               $data['ROW_DATA_SUPPLIER'] = $ROW_SUPPLIER;
               $this->load->view('Inventary/v_edit_supplier', $data);
               $this->load->view("esqueleton/footer");
            } else {
               redirect('inventary/index_supplier');
            }
         } else {
            redirect('inventary/index_supplier');
         }
      } else {
         redirect('login/salir');
      }
   }

   public function ajax_edit_supplier()
   {
      if ($this->input->is_ajax_request()) {
         $ID_PROVEEDOR = trim($this->input->post("RG_ID_PROVEEDOR"));
         $data['NOMBRE_PROVEEDOR'] = trim($this->input->post("RG_NOMBRE_PROVEEDOR"));
         $data['EMPRESA_PROVEEDOR'] = trim($this->input->post("RG_EMPRESA_PROVEEDOR"));
         $data['DOMICILIO_PROVEEDOR'] = trim($this->input->post("RG_DOMICILIO_PROVEEDOR"));
         $data['TELEFONO_PROVEEDOR'] = trim($this->input->post('RG_TELEFONO_PROVEEDOR'));
         $data['NO_CUENTA_PROVEEDOR'] = trim($this->input->post('RG_NO_CUENTA_PROVEEDOR'));

         $AFFECTED_ROWS = $this->minventary->edit_supplier_on_db($ID_PROVEEDOR, $data);
         if ($AFFECTED_ROWS > NULO) {
            echo $AFFECTED_ROWS;
         } else {
            echo -1;
         }
      } else {
         //operacion no permitida..
         redirect('inventary/index_supplier');
      }
   }

   public function ajax_disable_supplier()
   {
      if ($this->input->is_ajax_request()) {
         $ID_PROVEEDOR = $this->input->post('ID_PROVEEDOR');
         $AFFECTED_ROWS = $this->minventary->disable_supplier_on_db($ID_PROVEEDOR);
         echo $AFFECTED_ROWS;
      } else {
         redirect('inventary/index_supplier');
      }
   }

   public function form_add_buy()
   {
      $data = getActive("classInv");
      $this->load->view("esqueleton/header", $data);
      $data['ROW_DATA_BUY'] = $this->minventary->get_buy_temp_on_db();
      $data['ROW_ITEMS'] = $this->minventary->get_all_valid_products();
      $data['ROW_SUPPLIERS'] = $this->minventary->getAllValidSuppliers();
      $data['ROW_PAYMENT_TYPE'] = $this->minventary->get_all_valid_payments_type();
      $this->load->view('Inventary/v_add_buy', $data);
      $this->load->view("esqueleton/footer");
   }

   public function product_search()
   {
      if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
         $abuscar = $this->security->xss_clean($this->input->post('autocomplete'));
         $search = $this->minventary->get_product_search_suggestions($abuscar, 100);

         if ($search != false) {
            $resultado = "";
            foreach ($search as $id => $fila) {
               $partes = explode("|", $fila);
               $resultado[$id]['id'] = $partes[0];
               $resultado[$id]['data'] = $partes[1];
            }
            echo json_encode(array('res' => 'full', 'data' => $resultado));
            //en otro caso decimos que no hay resultados
         } else {
            echo json_encode(array('res' => 'empty'));
         }
      }
   }

   public function ajax_search_product_by_param()
   {
      if ($this->input->is_ajax_request() && !empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
         $param = trim($this->input->post('data_params'));
         $ROW_MEMO = $this->minventary->searchs_products_by_string($param);

         if (count($ROW_MEMO) > NULO):
            $this->output->set_content_type("application/json")->set_output(json_encode($ROW_MEMO));
         else:
            echo null;
         endif;
      } else {
         show_404();
      }
   }

   public function ajax_get_product_by_id()
   {
      if ($this->input->is_ajax_request()) {
         $ID_PRODCUTO = $this->input->post('ID_PRODUCTO');
         $ROW_PRODUCTO = $this->minventary->get_product_by_id($ID_PRODCUTO);
         $this->output->set_content_type("application/json")->set_output(json_encode($ROW_PRODUCTO));
         //echo $ROW_PRODUCTO[0]['COSTO_PRODUCTO'];
      } else {
         redirect('items');
      }
   }

   public function ajax_add_compra()
   {
      if ($this->input->is_ajax_request()) {
         $ROW_PRODUCTO = $this->minventary->get_product_temp_by_id_on_db($this->input->post("RG_ID_PRODUCTO_O"));
         $ID_PRODUCTO = $this->input->post("RG_ID_PRODUCTO_O");
         $data['COSTO_PRODUCTO_ORDEN_TEMP'] = trim($this->input->post("RG_COSTO_PRODUCTO_ORDEN_TEMP"));
         $data['PRECIO_PRODUCTO_ORDEN_TEMP'] = trim($this->input->post("RG_PRECIO_PRODUCTO_ORDEN_TEMP"));
         $data['CANTIDAD_ACTUAL_PRODUCTO_ORDEN_TEMP'] = trim($this->input->post("RG_CANTIDAD_PRODUCTO_ACTUAL_TEMP"));
         if (count($ROW_PRODUCTO)) {
            $data['CANTIDAD_PRODUCTO_ORDEN_TEMP'] = intval(trim($this->input->post("RG_CANTIDAD_PRODUCTO_ORDEN_TEMP"))) + intval($ROW_PRODUCTO[0]['CANTIDAD_PRODUCTO_ORDEN_TEMP']);
            $AFFECTED_ROWS = $this->minventary->update_product_compra_temp_on_db($ID_PRODUCTO, $data);
         } else {
            $data['ID_PRODUCTO'] = $ID_PRODUCTO;
            $data['CANTIDAD_PRODUCTO_ORDEN_TEMP'] = trim($this->input->post("RG_CANTIDAD_PRODUCTO_ORDEN_TEMP"));
            $AFFECTED_ROWS = $this->minventary->add_product_compra_temp_on_db($data);
         }
         if ($AFFECTED_ROWS > NULO) {
            echo $AFFECTED_ROWS;
         } else {
            echo -1;
         }
      } else {
         //operacion no permitida..
         redirect('entradas/form_add_order');
      }
   }

   public function ajax_delete_product_compra()
   {
      if ($this->input->is_ajax_request()) {
         $ID_PRODUCT = $this->input->post("ID_PRODUCTO");
         $AFFECTED_ROWS = $this->minventary->delete_product_buy_compra_by_id($ID_PRODUCT);
         echo $AFFECTED_ROWS;
      } else {
         redirect('items/index_buy');
      }
   }

   public function ajax_delete_compra_temp()
   {
      if ($this->input->is_ajax_request()) {
         $AFFECTED_ROWS = $this->minventary->delete_compra_temp();
         echo $AFFECTED_ROWS;
      } else {
         echo -1;
      }
   }

   public function ajax_cancel_buy()
   {
      if ($this->input->is_ajax_request()) {
         $AFFECTED_ROWS = $this->minventary->cancel_buy();
         if($AFFECTED_ROWS>0){
             $ROW_ITEMS = $this->minventary->get_producto_compra_by_id($this->input->post('ID_BUY'));
             foreach ($ROW_ITEMS as $ROW){
                 $producto_db = $this->minventary->get_product_by_id($ROW['ID_PRODUCTO']);
                 $stock_producto_db = $producto_db[0]['STOCK_PRODUCTO'];
                 $new_stock = $stock_producto_db - $ROW['CANTIDAD'];
                 $data['STOCK_PRODUCTO'] = $new_stock;
                 $aff = $this->minventary->edit_product_on_db($data,$ROW['ID_PRODUCTO']);
             }
         }
         echo $AFFECTED_ROWS;
      } else {
         echo -1;
      }
   }


   public function ajax_add_new_compra()
   {
      if ($this->input->is_ajax_request()) {
         //Guardar compra
         $data['FECHA_COMPRA'] = convierte_fecha_valida_db($this->input->post('RG_FECHA_ORDEN'));
         $data['ID_PROVEEDOR'] = $this->input->post("RG_ID_PROVEEDOR");
         $data['ID_USUARIO'] = $this->session->userdata('CAREYES_ID_USUARIO');
         $data['COMENTARIOS_COMPRA'] = trim($this->input->post("RG_comment"));
         $data['TOTAL_COMPRA'] = trim($this->input->post("RG_total"));
         $data['ID_TIPO_PAGO'] = $this->input->post("RG_ID_TIPOPAGO");
         $ID_COMPRA = $this->minventary->add_new_compra_on_db($data);
         unset($data);

         $ROW_ITEMS = $this->minventary->get_buy_temp_on_db();
         foreach ($ROW_ITEMS as $ROW) {
            $data['ID_COMPRA'] = $ID_COMPRA;
            $data['ID_PRODUCTO'] = $ROW['ID_PRODUCTO'];
            $data['CANTIDAD'] = $ROW['CANTIDAD_PRODUCTO_ORDEN_TEMP'];
            $data['DESCRIPCION'] = $ROW['NOMBRE_PRODUCTO'] . " " . $ROW['DESCRIPCION_PRODUCTO'];
            $data['COSTO'] = $ROW['COSTO_PRODUCTO_ORDEN_TEMP'];
            $data['PRECIO'] = $ROW['PRECIO_PRODUCTO_ORDEN_TEMP'];
            $ITEM_ID = $this->minventary->add_product_compra_on_db($data);
            //ACTUALIZAR STOCK
            //$ITEM_ON_DB = $this->minventary->get_product_by_id($ROW['ID_PRODUCTO']);
            //$data['STOCK_PRODUCTO'] = $ITEM_ON_DB[0]['STOCK_PRODUCTO'] + $ROW['CANTIDAD_PRODUCTO_ORDEN_TEMP'];
            $data['STOCK_PRODUCTO'] = $ROW['CANTIDAD_ACTUAL_PRODUCTO_ORDEN_TEMP'] + $ROW['CANTIDAD_PRODUCTO_ORDEN_TEMP'];
            log_message("error", "producto: ". $ROW['NOMBRE_PRODUCTO'] . ", descripcion: ". $ROW['DESCRIPCION_PRODUCTO'] . ", id producto: " . $ROW['ID_PRODUCTO'] . ", costo: " . $ROW['COSTO_PRODUCTO_ORDEN_TEMP'] . ", stock anterior: " . $ITEM_ON_DB[0]['STOCK_PRODUCTO'] . ", stock actual: " . $data['STOCK_PRODUCTO']);
            $UPDATE = $this->minventary->update_product_on_db_from_compra($data);
            unset($data);
         }

         $AFFECTED_ROWS = $this->minventary->delete_compra_buy_temp();

         if ($ID_COMPRA > NULO) {
            echo $ID_COMPRA;
         } else {
            echo -1;
         }
      } else {
         //operacion no permitida..
         redirect('inventary/index_buy');
      }
   }

   public function buy_print($ID_BUY)
   {
      if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {

         if ($ID_BUY > NULO) {
            $ROW_BUY = $this->minventary->get_buy_by_id($ID_BUY);
            $ROW_NOMBRE = $this->minventary->get_producto_compra_by_id($ID_BUY);
            //$SUM_PROC = $this->Mconsult->get_sum($ROW_CONSULT[0]['ID_FICHA']);
            //$SUM_FICHA = $this->Mconsult->get_sum_ficha($ROW_CONSULT[0]['ID_FICHA']);
            if (count($ROW_BUY) > NULO) {
               $this->load->library('PDF');
               //Carpeta imágenes está un directorio arriba
               $directorioPadre = base_url() . "assets/img/";
               // $this->pdf->Image($directorioPadre."logo.jpg",10,10,10,28);

               $this->pdf->AddPage('P', 'Letter'); //Vertical, Carta
               $this->pdf->SetFont('Arial', 'B', 8); //Arial, negrita, 12 puntos
               $this->pdf->designUp();
               $this->pdf->image(base_url() . "assets/img/encabezado.png", 76, 8, 70);
               
               $this->pdf->setXY(178, 15);
               $this->pdf->Cell(27, 5, 'FECHA', 1, 1, 'C');

               $this->pdf->setXY(178, 20);
               $this->pdf->Cell(27, 5, $ROW_BUY[0]['FECHA_COMPRA'], 1, 1, 'C');

               $this->pdf->setXY(11, 32);
               $this->pdf->Cell(194, 5, 'PROVEEDOR', 1, 1, 'C');

               $this->pdf->setXY(11, 37);
               $this->pdf->Cell(194, 20, '', 1, 1, 'L');

               $this->pdf->setXY(11, 37);
               $this->pdf->Text(12, 41, utf8_decode(mb_strtoupper($ROW_BUY[0]['NOMBRE_PROVEEDOR'])));
               $this->pdf->Text(12, 45, utf8_decode(mb_strtoupper($ROW_BUY[0]['DOMICILIO_PROVEEDOR'])));
               $this->pdf->Text(12, 49, utf8_decode(mb_strtoupper($ROW_BUY[0]['EMPRESA_PROVEEDOR'])));
               $this->pdf->Text(12, 53, $ROW_BUY[0]['TELEFONO_PROVEEDOR']);
               //$this->pdf->Text(60, 37, utf8_decode(mb_strtoupper($ROW_CONSULT[0]['NOMBRE_PACIENTE'])) . ' ' . utf8_decode(mb_strtoupper($ROW_CONSULT[0]['APELLIDO_PATERNO_PACIENTE'])) . ' ' . utf8_decode(mb_strtoupper($ROW_CONSULT[0]['APELLIDO_MATERNO_PACIENTE'])));

               $this->pdf->setXY(11, 60);
               $this->pdf->cell(27, 5, 'CONDICIONES', 1, 1, 'C');

               $this->pdf->setXY(38, 60);
               $this->pdf->cell(167, 5, 'COMENTARIOS', 1, 1, 'C');

               $this->pdf->setXY(38, 65);
               $this->pdf->cell(167, 5, utf8_decode(mb_strtoupper($ROW_BUY[0]['COMENTARIOS_COMPRA'])), 1, 1, 'L');

               $this->pdf->setXY(11, 65);
               $this->pdf->cell(27, 5, utf8_decode(mb_strtoupper($ROW_BUY[0]['NOMBRE_TIPOPAGO'])), 1, 1, 'C');

               $this->pdf->setXY(11, 72);
               $this->pdf->cell(67, 5, utf8_decode(mb_strtoupper('ARTÍCULO')), 1, 1, 'C');

               $this->pdf->setXY(78, 72);
               $this->pdf->cell(30, 5, utf8_decode(mb_strtoupper('UNIDADES')), 1, 1, 'C');

               $this->pdf->setXY(108, 72);
               $this->pdf->cell(48.5, 5, utf8_decode(mb_strtoupper('PRECIO')), 1, 1, 'C');

               $this->pdf->setXY(156.5, 72);
               $this->pdf->cell(48.5, 5, utf8_decode(mb_strtoupper('IMPORTE')), 1, 1, 'C');

               $posicionY = $this->pdf->GetY();
               foreach ($ROW_NOMBRE as $ROW) {

                  $importe = 0;
                  $this->pdf->SetXY(11,$posicionY);
                  $this->pdf->Multicell(77, 5.5, utf8_decode($ROW['NOMBRE_PRODUCTO']),0,'L');
                  $this->pdf->Text(90, $posicionY+3, $ROW['CANTIDAD']);
                  $this->pdf->Text(129, $posicionY+3, $ROW['COSTO']);
                  $importe += $this->pdf->Text(178, $posicionY+3, $ROW['CANTIDAD'] * $ROW['COSTO']);
                  $posicionY = $this->pdf->GetY();

                  
               }
                  $posicionY = $this->pdf->GetY();
                  $this->pdf->setXY(165, $posicionY);
                  $this->pdf->Cell(26, 5, utf8_decode('TOTAL:'), 0, 0, 'L');
                  $this->pdf->Text(177, $posicionY+3, '$'.' '.$ROW_BUY[0]['TOTAL_COMPRA']);

               $this->pdf->Output(); //Salida al navegador del pdf
            } else {
               redirect('Consult/index');
            }
         } else {
            redirect('Consult/index');
         }
      }
   }
   public function index_usage()
   {
      if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
         
         $this->load->view("esqueleton/header", getActive("classInv"));
         $this->load->view("Inventary/v_index_usage");
         $this->load->view("esqueleton/footer");
      } else {
         redirect('login/salir');
      }
   }
   public function add_usage()
   {
      if (!empty($this->session->userdata('CAREYES_ID_USUARIO'))) {
         
         $this->load->view("esqueleton/header", getActive("classInv"));
         $this->load->view("Inventary/v_add_usage");
         $this->load->view("esqueleton/footer");
      } else {
         redirect('login/salir');
      }
   }
   public function ajax_add_usage()
   {
      if ($this->input->is_ajax_request()) {
                  
         $date = date("Y-m-d");
			$cant = $this->input->post('cant');			
         $ids  = $this->input->post('idProduct');
         $desc = $this->input->post('RG_DESCRIPCION');

         $data = array(
            'DESCRIPCION' =>  $desc,
            'ID_MEDICO' => $this->session->userdata('CAREYES_ID_USUARIO'),
            'FECHA' =>  $date 
         );
         $this->db->insert('uso_interno', $data);
         
			foreach($ids as $i => $row)
			{
            $this->db->select('STOCK_PRODUCTO');
            $this->db->where('ID_PRODUCTO',$ids[$i]);
            $stock = $this->db->get('producto')->row();
           
            $stock2 = $stock->STOCK_PRODUCTO - $cant[$i];

            $this->db->where('ID_PRODUCTO',$ids[$i]);
            $this->db->update('producto',array('STOCK_PRODUCTO'=>$stock2));				
         }
         echo "sucess";
      } else {
         //operacion no permitida..
         redirect('Inventary/index');
      }
   }
   /* FIN COMPRAS */
}
