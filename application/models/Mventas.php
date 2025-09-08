<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mventas extends CI_Model
{

   public function __construct()
   {
      parent::__construct();
      $this->load->helper('api');
   }

   function searchCode($code)
   {
      try {
         $html = "";
         /* $this->db->like('CODIGO_PRODUCTO', $code, 'after');
         $data = $this->db->get('producto')->result_array(); */

         $data = api_get(SEARCH_PRODUCT . str_replace(" ", "%20", $code));

         if ($data['status'] == 400) {
            return false;
         }
         foreach ($data['data'] as $value) {
            $html .= "
               <li class='list-group-item pointer AddItem'
               data-id='{$value['ID_PRODUCTO']}'
               data-name='{$value['NOMBRE_PRODUCTO']}'
               data-price='{$value['PRECIO_PRODUCTO']}'
               data-code='{$value['CODIGO_PRODUCTO']}'
            >
               {$value['NOMBRE_PRODUCTO']}  {$value['DESCRIPCION_PRODUCTO']} | {$value['PRECIO_PRODUCTO']}
            </li>";
         }

         return $html;
      } catch (\Throwable $th) {
         //throw $th;
      }
   }
   function updateProductCart($id)
   {
      try {
         $bool = 0;
         $qty = $this->input->post('qty');
         $desc = $this->input->post('desc');
         $list = $this->session->userdata('LIST_CART');

         foreach ($list as $key => $value) {
            if ($list[$key]['id'] == $id) {
               $bool = 1;
               $list[$key]['qty'] = $qty;
               $list[$key]['desc'] = $desc;
               $this->session->set_userdata('LIST_CART', $list);
            }
         }

         return $bool;
      } catch (\Throwable $th) {
         //throw $th;
      }
   }
   function removePayment($id)
   {
      try {
         $bool = 0;
         $list = $this->session->userdata('PAYMENTS_CART');

         foreach ($list as $key => $value) {
            if ($list[$key]['method'] == $id) {
               $bool = 1;
               unset($list[$key]);
               $this->session->set_userdata('PAYMENTS_CART', $list);
            }
         }
         return $bool;
      } catch (\Throwable $th) {
         //throw $th;
      }
   }
   function removeProductCart($id)
   {
      try {
         $bool = 0;
         $list = $this->session->userdata('LIST_CART');

         foreach ($list as $key => $value) {
            if ($value['id'] == $id) {
               $bool = 1;
               unset($list[$key]);
            }
         }
         $this->session->set_userdata('LIST_CART', $list);
         return $bool;
      } catch (\Throwable $th) {
         //throw $th;
      }
   }
   function addVentaLibre()
   {
      try {
         $ProductFree = array(
            'CODIGO_PRODUCTO' => rand(10000, 99999),
            'COSTO_PRODUCTO' =>  0,
            'NOMBRE_PRODUCTO' => $this->input->post('namefree'),
            'PRECIO_PRODUCTO' =>  $this->input->post('pricefree'),
            'ID_TIPO_PRODUCTO' =>  $this->input->post('type_product'),
            'DESCRIPCION_PRODUCTO' => $this->input->post('descriptionfree'),
            'CONTENIDO_PRODUCTO' => 0,
            'STOCK_PRODUCTO' => 9999,
            'STOCK_MINIMO_PRODUCTO' => 1,
            'UNIDAD_PRODUCTO' => 'SOLUCION',
            'LOTE_PRODUCTO' => date('Y-m-d'),
            'ACTIVO_PRODUCTO' => 0,
         );

         $this->db->insert('producto', $ProductFree);
         $last_id = $this->db->insert_id();

         $bool = 0;
         $list = $this->session->userdata('LIST_CART');
         $product = $this->db->get_where('producto', array('ID_PRODUCTO' => $last_id))->row();

         $item = array(
            'id' => $product->ID_PRODUCTO,
            'code' => $product->CODIGO_PRODUCTO,
            'name' => $product->NOMBRE_PRODUCTO,
            'price' => $product->PRECIO_PRODUCTO,
            'cost' => $product->COSTO_PRODUCTO,
            'qty' => 1,
            'desc' => 0,
         );

         array_push($list, $item);

         $this->session->set_userdata('LIST_CART', $list);

         return true;
      } catch (\Throwable $th) {
         //throw $th;
      }
   }
   function addProductCart($id)
   {
      try {
         $bool = 0;
         $list = $this->session->userdata('LIST_CART');
         $product = $this->db->get_where('producto', array('ID_PRODUCTO' => $id))->row();

         foreach ($list as $key => $value) {
            if ($list[$key]['id'] == $id) {
               $bool = 1;
               $list[$key]['qty'] = $value['qty'] + 1;
               $this->session->set_userdata('LIST_CART', $list);
            }
         }

         if ($bool <= 0) {
            $item = array(
               'id' => $product->ID_PRODUCTO,
               'code' => $product->CODIGO_PRODUCTO,
               'name' => $product->NOMBRE_PRODUCTO,
               'price' => $product->PRECIO_PRODUCTO,
               'cost' => $product->COSTO_PRODUCTO,
               'qty' => 1,
               'desc' => 0,
            );

            array_push($list, $item);

            $this->session->set_userdata('LIST_CART', $list);

            return true;
         }
      } catch (\Throwable $th) {
         //throw $th;
      }
   }
   function insertPayment()
   {
      try {

         $bool = 0;
         $amount =  $this->input->post('amount');
         $receive = $this->input->post('receive');
         $method_id = $this->input->post('method');
         $Payments = $this->session->userdata('PAYMENTS_CART');

         foreach ($Payments as $key => $value) {
            if ($Payments[$key]['method'] == $method_id) {
               $bool = 1;
               $Payments[$key]['amount'] = $value['amount'] + $amount;
               $this->session->set_userdata('PAYMENTS_CART', $Payments);
            }
         }

         if ($bool <= 0) {
            $NewPayment = array(
               'amount' => $amount,
               'receive' => $receive,
               'topay' => $this->input->post("topay"),
               'method' => $method_id,
               'name' => $this->input->post('name'),
            );
            array_push($Payments, $NewPayment);

            $this->session->set_userdata('PAYMENTS_CART', $Payments);

            return true;
         }
      } catch (\Throwable $th) {
         //throw $th;
      }
   }
   function insertSale()
   {
      try {
         $total_cart = 0;
         $change = '0.00';
         $total_payments = array_sum(array_column($this->PAYMENTS_CART, 'amount'));

         $data_products = [];
         $data_payments = [];
         $date_time = date('Y-m-d H:i:s');
         $comment =  $this->input->post('comment');
         $Cart = $this->session->userdata('LIST_CART');
         $user_id = $this->session->userdata('VET_USER_ID');
         $Payments = $this->session->userdata('PAYMENTS_CART');

         foreach ($Cart as $row) {

            $total_cart += $row['price'] * $row['qty'];

            $product = array(
               'cost' => $row['cost'],
               'desc' => $row['desc'],
               'price' => $row['price'],
               'quantity' => $row['qty'],
               'product_id' => $row['id'],
               'description' => $row['name'],
            );
            array_push($data_products, $product);
         }

         foreach ($Payments as $row) {
            $payment = array(
               'received' => $row['amount'],
               'amount' => $row['topay'],
               'payment_type' => $row['name'],
            );
            array_push($data_payments, $payment);
         }

         //Get change if need
         $change = $total_payments > $total_cart ? $total_payments - $total_cart  : '0.00';
         $sale = array(
            'user_id' => $user_id,
            'comment' => $comment,
            'datetime' => $date_time,
            'products' => $data_products,
            'payments' => $data_payments,
            'total_cart' => $total_cart,
            'change' => $change,
         );

         $send_sale = array('sale' => json_encode($sale));

         $this->session->set_userdata('LIST_CART', []);
         $this->session->set_userdata('PAYMENTS_CART', []);

         $sale = api_post(INSERT_SALE, $send_sale);
         return $sale;
      } catch (\Throwable $th) {
         //throw $th;
      }
   }

   function get_config($key)
   {
      try {
         $this->db->where('key', $key);
         $query = $this->db->get('app_config');
         return $query->row();
      } catch (Exception $ex) {
         return $ex->getMessage();
      }
   }

   function get_product_by_code($code)
   {
      try {
         $this->db->where('CODIGO_PRODUCTO', $code);
         $query = $this->db->get('producto');
         return $query->row();
      } catch (Exception $ex) {
         return $ex->getMessage();
      }
   }
}

/* End of file mventas.php */
