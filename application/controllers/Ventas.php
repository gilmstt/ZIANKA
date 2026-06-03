<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
defined('BASEPATH') or exit('No direct script access allowed');

class Ventas extends CI_Controller
{
   /*
   * @var Mventas
   * @var Mconfig
   * @var LIST_CART
   * @var PAYMENTS_CART
   * @var mfactura
   */
   public $Mventas;
   public $Mconfig;
   public $LIST_CART;
   public $PAYMENTS_CART;
   public $mfactura;
   public function __construct()
   {
      parent::__construct();
      $this->load->helper('api');
      $this->load->helper('general');
      $this->load->helper('currency');
      $this->load->helper('functions');
      $this->load->library('escpos');
      $this->load->model('Mventas');
      $this->load->model('Mconfig');
      //$this->load->model('mfactura');

      $this->LIST_CART =  $this->session->userdata('LIST_CART');
      $this->PAYMENTS_CART =  $this->session->userdata('PAYMENTS_CART');

      if (!$this->session->userdata('VET_USER_ID'))
         redirect('inicio/index');
   }

   public function index()
   {
      $add = $this->input->post('search');
      if ($add > 0) {
         $producto = $this->Mventas->get_product_by_code($add);
         $this->Mventas->addProductCart($producto->ID_PRODUCTO);
      }
      $data = getActive("classVent");
      $this->load->view('esqueleton/header', $data);
      $this->load->view('Ventas/index_venta');
      $this->load->view('esqueleton/footer');
   }
   public function history()
   {
      $data = getActive("classRpt");
      $this->load->view('esqueleton/header', $data);
      $data['CLIENTES'] = $this->mfactura->get_all_clients();
      $this->load->view('Ventas/historial', $data);
      $this->load->view('esqueleton/footer');
   }
   public function searchCode()
   {
      $code = $this->input->post('code');

      echo $this->Mventas->searchCode($code);
   }
   public function getPayments()
   {
      //inits params
      $total_cart = 0;
      $change = '0.00';
      $total_payments = array_sum(array_column($this->PAYMENTS_CART, 'amount'));
      //sum prices * qty of all products in cart
      foreach ($this->LIST_CART as $item) {
         if ($item['desc'] > 0) {
            $desc = (($item['price'] * $item['qty']) * $item['desc']) / 100;
            $total_cart += ($item['price'] * $item['qty']) - $desc;
         } else {
            $total_cart += $item['price'] * $item['qty'];
         }
      }
      //Get remaining amount to pay
      $amount_payment = $total_payments >= $total_cart ? '0.00'  : $total_cart - $total_payments;

      //Get change if need
      $change = $total_payments > $total_cart ? $total_payments - $total_cart  : '0.00';

      echo json_encode(
         array(
            'data' => $this->PAYMENTS_CART,
            'change' => $change,
            'totalCart' => $amount_payment,
            'totalPayments' => $total_payments,
         )
      );
   }
   public function getSales()
   {
      $date1 = '?start_date=' . $this->input->post('start_date');
      $date2 = '&end_date=' . $this->input->post('end_date');
      echo json_encode(api_get(GET_SALES . $date1 . $date2));
   }
   public function getCart()
   {
      echo json_encode($this->session->userdata('LIST_CART'));
   }
   public function VentaLibre()
   {
      echo $this->Mventas->addVentaLibre();
   }

   public function ProductCart()
   {
      $id = $this->input->post('id');
      $action = $this->input->post('action');

      if ($action == 'add') {
         echo $this->Mventas->addProductCart($id);
      }
      if ($action == 'update') {
         echo $this->Mventas->updateProductCart($id);
      }
      if ($action == 'remove') {
         echo $this->Mventas->removeProductCart($id);
      }
   }

   public function insertPayment()
   {
      echo $this->Mventas->insertPayment();
   }
   public function removePayment()
   {
      $id = $this->input->post('id');
      echo $this->Mventas->removePayment($id);
   }
   public function insertSale()
   {
      $sale = json_encode($this->Mventas->insertSale());
      if ($this->Mventas->get_config('print_after_sale')->value == 1) $this->print_ticket($sale);
      echo $sale;
   }
   public function print_ticket($data)
   {
      $data_venta = json_decode($data);
      if (($data_venta->data->status == true)) {
         $venta = $data_venta->data->data;
         $articulos = $venta->products;
         $cajero = $this->Mconfig->get_user_by_id($venta->ID_USUARIO);
         $nombre_impresora = 'EC-PM-5890X';

         $connector = new Escpos\PrintConnectors\WindowsPrintConnector($nombre_impresora);
         $printer = new Escpos\Printer($connector);
         $printer->setJustification(Escpos\Printer::JUSTIFY_CENTER);

         try {
            $logo = Escpos\EscposImage::load("assets/img/logo_mini.png", false);
            $printer->bitImageColumnFormat($logo);
         } catch (Exception $e) {
         }

         $printer->text("***** VAZVET *****\n");
         $printer->text("SERVICIOS VETERINARIOS\n");
         $printer->text("MVZ. EDSEL ADRIAN VAZQUEZ B.\n");
         $printer->text("RCF. VABE880505N20 CP. 28970\n");
         $printer->text("DOM. INDEPENDENCIA #240 V. DE A.\n");
         $printer->text(TIC_LineaS() . "\n");
         $printer->text($venta->FECHA . ' TICKET #' . $venta->ID_VENTA . "\n");
         $printer->text("CAJERO: " . $cajero[0]['NOMBRE_USUARIO'] . " " . $cajero[0]['APELLIDO_USUARIO'] . "\n");
         $printer->text(TIC_LineaS() . "\n");
         $printer->text("\n");

         $subtot = 0;
         foreach ($articulos as $articulo) {
            $printer->setJustification(Escpos\Printer::JUSTIFY_LEFT);
            $printer->text($articulo->CANTIDAD . " " . MB_strtoupper($articulo->DESCRIPCION) . " " . to_currency($articulo->PRECIO) . "\n");
            $descuento = $articulo->PRECIO * floatval($articulo->DESCUENTO_PRODUCTO) / 100;
            $printer->text("DESC. %" . $articulo->DESCUENTO_PRODUCTO . " " . $descuento * $articulo->CANTIDAD . "\n");
            $printer->setJustification(Escpos\Printer::JUSTIFY_RIGHT);
            $printer->text(to_currency(($articulo->CANTIDAD * floatval($articulo->PRECIO)) - ($descuento * $articulo->CANTIDAD)) . "\n");
            $subtot += (floatval($articulo->CANTIDAD) * floatval($articulo->PRECIO)) - ($descuento * $articulo->CANTIDAD);
         }

         $printer->text("\nTOTAL " . to_currency($subtot) . "\n");

         $printer->setJustification(Escpos\Printer::JUSTIFY_LEFT);
         $tipos_pago = $venta->payments;
         foreach ($tipos_pago as $tipo_pago) {
            if ($tipo_pago->TIPO_PAGO == "Efectivo") {
               $cant = $tipo_pago->CANTIDAD_PAGADA;
            } else {
               $cant = $tipo_pago->CANTIDAD_RECIBIDA;
            }
            $printer->text("\nPAGO " . $tipo_pago->TIPO_PAGO . ":" . to_currency($cant) . "\n");
            if ($tipo_pago->TIPO_PAGO == "Efectivo") {
               $printer->text("\nRECIBIDO " . to_currency($tipo_pago->CANTIDAD_RECIBIDA) . "\n");
               $cambio = floatval($tipo_pago->CANTIDAD_RECIBIDA) - floatval($tipo_pago->CANTIDAD_PAGADA);
               if ($cambio >= 0)
                  $printer->text("CAMBIO " . to_currency($cambio) . "\n");
            }
         }
         $printer->text("\n");

         $printer->text(TIC_DFeed());
         $printer->setJustification(Escpos\Printer::JUSTIFY_CENTER);
         $printer->text("GRACIAS POR SU COMPRA\n");

         $printer->feed(3);
         $printer->cut();
         $printer->pulse();
         $printer->close();

         return 1;
      }
   }

   public function searchSale()
   {
      $sale_id = $this->input->post('sale_id');
      $venta_data = api_get(SEARCH_SALE . $sale_id);
      $venta = $venta_data['data'];
      $html = "<h3>Venta: #" . $venta['ID_VENTA'] . "&nbsp;&nbsp;&nbsp;&nbsp;Fecha: " . $venta['FECHA'] . "</h3><hr>PRODUCTOS<br>";
      $html .= '<table style="text-align:left;"><tr><th style="width:15%;">Cant</th><th style="width:50%;">Descripción</th><th style="width:20%;">Precio</th><th style="width:15%;">Monto</th></tr>';
      foreach ($venta['products'] as $producto) {
         $monto = intval($producto['CANTIDAD']) * floatval($producto['PRECIO']);
         $html .= '<tr><td>' . $producto['CANTIDAD'] . '</td><td>' . $producto['DESCRIPCION'] . '</td><td>' . to_currency($producto['PRECIO']) . '</td><td>' . to_currency($monto) . '</td></tr>';
      }
      $html .= '</table>';
      $html .= '<hr>PAGOS<br>';
      $html .= '<table style="text-align:left; width:100%;"><tr><th style="width:40%;">Tipo de pago</th><th style="width:20%;">Pagado</th><th style="width:20%;">Recibido</th><th style="width:20%;">Cambio</th></tr>';
      foreach ($venta['payments'] as $pago) {
         if ($pago['TIPO_PAGO'] == "Efectivo") {
            $cambio = to_currency($pago['CANTIDAD_RECIBIDA'] - $pago['CANTIDAD_PAGADA']);
            $cambio = $cambio < 0 ? 0 : $cambio;
         } else {
            $cambio = "N/A";
         }
         $html .= '<tr><td>' . $pago['TIPO_PAGO'] . '</td><td>' . to_currency($pago['CANTIDAD_PAGADA']) . '</td><td>' . to_currency($pago['CANTIDAD_RECIBIDA']) . '</td><td>' . $cambio . '</td></tr>';
      }
      echo $html;
   }

   public function cancelSale()
   {
      $sale_id = $this->input->post('sale_id');
      $cancel_sale = api_delete(DELETE_SALE, $sale_id);
      echo json_encode($cancel_sale);
   }
}

/* End of file Ventas.php */
