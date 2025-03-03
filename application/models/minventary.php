<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Minventary extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function obtenerNombres() {
        try {
            $this->db->distinct();
            $this->db->select("NOMBRE_PRODUCTO");
            $this->db->from("producto");
            $this->db->where("ACTIVO_PRODUCTO", ACTIVO);
            $this->db->where('ID_TIPO_PRODUCTO', 2);

            return $this->db->get()->result_array();
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    function get_all_valid_products() {
        try {
            $this->db->select("*");
            $this->db->from('producto');
            $this->db->where('ACTIVO_PRODUCTO', ACTIVO);
            $this->db->order_by('ID_PRODUCTO', 'DESC');
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    /* AGREGAR NUEVO PRODUCTO */

    function add_new_product_on_db($row) {

        try {
            $this->db->insert('producto', $row);
            //var_dump($this->db->last_query());
            return $this->db->insert_id();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    /* obtener prodyctos by id */

    function get_product_by_id($ID_PRODUCT) {
        try {
            $this->db->select("*");
            $this->db->from('producto');
            $this->db->where('id_producto', $ID_PRODUCT);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function edit_product_on_db($row, $id_product) {
        try {
            $this->db->where('ID_PRODUCTO', $id_product);
            $this->db->update('producto', $row);
            return $this->db->affected_rows();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function disable_product_on_db($ID_PRODUCT) {
        try {
            $data = array(
                'ACTIVO_PRODUCTO' => 0,
                'CODIGO_PRODUCTO' => ""
            );

            $this->db->where('ID_PRODUCTO', $ID_PRODUCT);
            $this->db->update('producto', $data);
            return $this->db->affected_rows();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function get_all_valid_procedures() {
        try {
            $this->db->select("*");
            $this->db->from('procedimiento');
            $this->db->where('activo_procedimiento', 1);
            $this->db->order_by('descripcion_procedimiento', 'ASC');
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    /* PROCEDIMIENTOS CRUD */

    function add_new_procedure_on_db($row) {
        try {
            $data = array(
                //'ID_PRODUCTO' => $row['ID_PRODUCTO'],
                'descripcion_procedimiento' => $row['descripcion_procedimiento'],
                'precio_procedimiento' => $row['precio_procedimiento'],
                    // 'ACTIVO_PROCEDIMIENTO' => $row['ACTIVO_PROCEDIMIENTO']
            );

            $this->db->insert('procedimiento', $data);
            //var_dump($this->db->last_query());
            return $this->db->insert_id();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function get_procedure_by_id($ID_PROC) {
        try {
            $this->db->select("*");
            $this->db->from('procedimiento');
            $this->db->where('id_procedimiento', $ID_PROC);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function edit_procedure_on_db($row) {
        try {
            $data = array(
                'id_procedimiento' => trim($row['id_procedimiento']),
                'descripcion_procedimiento' => $row['descripcion_procedimiento'],
                'precio_procedimiento' => $row['precio_procedimiento']
            );
            $this->db->where('id_procedimiento', $row['id_procedimiento']);
            $this->db->update('procedimiento', $data);
            return $this->db->affected_rows();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function disable_procedure_on_db($ID_PROC) {
        try {
            $data = array(
                'activo_procedimiento' => 0
            );

            $this->db->where('id_procedimiento', $ID_PROC);
            $this->db->update('procedimiento', $data);
            return $this->db->affected_rows();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    /*  END CRUD PROCEDIMIENTOS */

    /*  suuuupliers CURD */

    function getBuybyDates($dates) {
        try {
            $this->db->select("*");
            $this->db->from('compra as c');
            $this->db->join('usuario as u', 'c.ID_USUARIO=u.ID_USUARIO');
            $this->db->join('proveedor as p', 'c.ID_PROVEEDOR=p.ID_PROVEEDOR');
            $this->db->join('tipopago as tp', 'c.ID_TIPO_PAGO=tp.ID_TIPOPAGO');
            $this->db->where('c.FECHA_COMPRA >= "' . $dates['fechaini'] . '" and c.FECHA_COMPRA <= "' . $dates['fechafin'] . '"');
            $this->db->order_by('c.ID_COMPRA', 'DESC');
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function getAllValidSuppliers() {
        try {
            $this->db->select("*");
            $this->db->from('proveedor');
            $this->db->where('VIGENTE_PROVEEDOR', VIGENTE);
            $this->db->order_by('ID_PROVEEDOR', 'DESC');
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function add_new_supplier_on_db($row) {
        try {
            $this->db->insert('proveedor', $row);
            return $this->db->insert_id();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function get_supplier_by_id_on_db($ID_SUPPLIER) {
        try {
            $this->db->select("*");
            $this->db->from('proveedor');
            $this->db->where('ID_PROVEEDOR', $ID_SUPPLIER);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function edit_supplier_on_db($ID_PROVEEDOR, $row) {
        try {
            $this->db->where('ID_PROVEEDOR', $ID_PROVEEDOR);
            $this->db->update('proveedor', $row);
            return $this->db->affected_rows();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function disable_supplier_on_db($ID_SUPPLIER) {
        try {
            $data = array(
                'VIGENTE_PROVEEDOR' => NULO
            );

            $this->db->where('ID_PROVEEDOR', $ID_SUPPLIER);
            $this->db->update('proveedor', $data);
            return $this->db->affected_rows();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function get_buy_temp_on_db() {
        try {
            $this->db->select("*");
            $this->db->from('producto_compra_temp as POT');
            $this->db->join('producto as P', 'POT.ID_PRODUCTO=P.ID_PRODUCTO');
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function cancel_buy() {
        try {
            $ID_BUY = $this->input->post('ID_BUY');

            $data = array(
                'VIGENCIA_COMPRA' => 0
            );

            $this->db->where('ID_COMPRA', $ID_BUY);
            $this->db->update('compra', $data);
            return $this->db->affected_rows();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function get_product_temp_by_id_on_db($ID_PRODUCTO) {
        try {
            $this->db->select("*");
            $this->db->from('producto_compra_temp');
            $this->db->where('ID_PRODUCTO', $ID_PRODUCTO);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function get_product_search_suggestions($search, $limit = 25) {
        $suggestions = array();

        $this->db->from('producto');
        $this->db->where('ACTIVO_PRODUCTO', 1);
        $this->db->where('CODIGO_PRODUCTO', $search);
        $this->db->order_by("CODIGO_PRODUCTO", "asc");
        $by_item_number = $this->db->get();
        foreach ($by_item_number->result() as $row) {
            $suggestions[] = $row->ID_PRODUCTO . '|' . $row->CODIGO_PRODUCTO;
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function searchs_products_by_string($ROW) {
        try {
            $this->db->select("*");
            $this->db->from('producto');
            $this->db->where('NOMBRE_PRODUCTO LIKE "%' . $ROW . '%" ');
            $this->db->where('ACTIVO_PRODUCTO', 1);

            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function update_product_compra_temp_on_db($ID_PRODUCTO, $row) {
        try {
            $this->db->where('ID_PRODUCTO', $ID_PRODUCTO);
            $this->db->update('producto_compra_temp', $row);
            return $this->db->affected_rows();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function add_product_compra_temp_on_db($row) {
        try {

            $this->db->insert('producto_compra_temp', $row);
            //var_dump($this->db->last_query());
            return $this->db->insert_id();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function get_all_valid_payments_type() {
        try {
            $this->db->select("*");
            $this->db->from('tipopago');
            $this->db->where('VIGENCIA_TIPOPAGO', VIGENTE);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function delete_product_buy_compra_by_id($ID_PRODUCT) {
        try {
            $this->db->where('ID_PRODUCTO_ORDEN_TEMP', $ID_PRODUCT);
            $this->db->delete('producto_compra_temp');
            return $this->db->affected_rows();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function delete_compra_temp() {
        try {
            $this->db->truncate('producto_compra_temp');
            return 1;
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function add_new_compra_on_db($row) {
        try {
            $this->db->insert('compra', $row);
            return $this->db->insert_id();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function add_product_compra_on_db($row) {
        try {
            $this->db->insert('producto_compra', $row);
            return $this->db->insert_id();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function delete_compra_buy_temp() {
        try {
            $this->db->truncate('producto_compra_temp');
            return 1;
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function get_buy_by_id($ID_COMPRA) {
        try {
            $this->db->select("*");
            $this->db->from('compra AS C');
            $this->db->join('proveedor as P', "C.ID_PROVEEDOR=P.ID_PROVEEDOR");
            $this->db->join('tipopago as TP', "C.ID_TIPO_PAGO=TP.ID_TIPOPAGO");
            $this->db->where('ID_COMPRA', $ID_COMPRA);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function get_producto_compra_by_id($ID_COMPRA) {
        try {
            $this->db->select("*");
            $this->db->from('producto_compra as PC');
            $this->db->join('producto as P', "PC.ID_PRODUCTO=P.ID_PRODUCTO");
            $this->db->where('PC.ID_COMPRA', $ID_COMPRA);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function update_product_on_db_from_compra($row) {
        try {
            $data = array(
            'STOCK_PRODUCTO' => $row['STOCK_PRODUCTO'],
            'COSTO_PRODUCTO' => $row['COSTO'],
            'PRECIO_PRODUCTO' => $row['PRECIO']
            );
            $this->db->where('ID_PRODUCTO', $row['ID_PRODUCTO']);
            $this->db->update('producto', $data);
            return $this->db->affected_rows();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    // ======== ServerSide Processing Productos ================ //
    function make_query_products() {

        $order_column = array(NULL, "NOMBRE_PRODUCTO", "CODIGO_PRODUCTO", "STOCK_PRODUCTO", "STOCK_MINIMO_PRODUCTO", "PRECIO_PRODUCTO");

        $this->db->select("*");
        $this->db->from('producto as p');   
        $this->db->join('VIGENCIA as v', 'p.ACTIVO_PRODUCTO = v.VIGENCIA');
        $this->db->where('ID_TIPO_PRODUCTO', 1);
        $this->db->where('ACTIVO_PRODUCTO', ACTIVO);

        if ($_POST["search"]["value"] != "") {
            $this->db->like("CODIGO_PRODUCTO", $_POST["search"]["value"]);
            $this->db->or_like("NOMBRE_PRODUCTO", $_POST["search"]["value"]);
           
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($order_column[$_POST["order"]['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by("NOMBRE_PRODUCTO", "ASC");
        }
    }

    // ======== ServerSide Processing Productos ================ //
    function make_query_med() {

        $order_column = array(NULL, "NOMBRE_PRODUCTO", "CODIGO_PRODUCTO", "STOCK_PRODUCTO", "STOCK_MINIMO_PRODUCTO", "PRECIO_PRODUCTO");

        $this->db->select("*");
        $this->db->from('producto');
        $this->db->where('ID_TIPO_PRODUCTO', 2);
        $this->db->where('ACTIVO_PRODUCTO', ACTIVO);

        if ($_POST["search"]["value"] != "") {
            $this->db->like("CODIGO_PRODUCTO", $_POST["search"]["value"]);
            $this->db->or_like("NOMBRE_PRODUCTO", $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($order_column[$_POST["order"]['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by("ID_PRODUCTO", "DESC");
        }
    }

    function make_datatables_products() {
        $this->make_query_products();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST["length"], $_POST["start"]);
        }
        $query = $this->db->get()->result_array();
        return $query;
    }

    function make_datatables_med() {
        $this->make_query_med();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST["length"], $_POST["start"]);
        }
        $query = $this->db->get()->result_array();
        return $query;
    }

    function get_all_data_products() {
        $this->db->select("*");
        $this->db->from("producto");
        $this->db->where("ACTIVO_PRODUCTO", ACTIVO);
        return $this->db->count_all_results();
    }

    function get_filtered_data_products() {
        $this->make_query_products();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_filtered_data_med() {
        $this->make_query_med();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_products() {
        $fetch_data = $this->make_datatables_products();
        $total_products = $this->get_all_data_products();
        $filt_products = $this->get_filtered_data_products();

        $data = array();
        foreach ($fetch_data as $row) {
            $actions = "
         <button id='btnEditProduct' class='btn btn-defaultx btn-edit-product' data-original-title='Editar producto' data-toggle='tooltip' data-id-product='" . $row['ID_PRODUCTO'] . "'>
         <i class='fa fa-edit fa-x' aria-hidden='true'></i>
         </button>
         <button id='btnDeleteProduct'  class='btn btn-defaultz btn-delete-product' data-original-title='Eliminar producto' data-toggle='tooltip' data-id-product='" . $row['ID_PRODUCTO'] . "' >
               <i class='fa fa-trash fa-x' aria-hidden='true'></i>
         </button>";

            $sub_array = array();

            $sub_array[] = $actions;
            $sub_array[] = mb_strtoupper($row['NOMBRE_PRODUCTO']);
            $sub_array[] = mb_strtoupper($row['CODIGO_PRODUCTO']);
            $sub_array[] = mb_strtoupper($row['STOCK_PRODUCTO']);
            $sub_array[] = mb_strtoupper($row['STOCK_MINIMO_PRODUCTO']);
            $sub_array[] = mb_strtoupper("$ " . $row['PRECIO_PRODUCTO']);

            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" => $total_products,
            "recordsFiltered" => $filt_products,
            "data" => $data
        );
        return $output;
    }

    function get_med() {
        $fetch_data = $this->make_datatables_med();
        $total_products = $this->get_all_data_products();
        $filt_products = $this->get_filtered_data_med();

        $data = array();
        foreach ($fetch_data as $row) {
            $actions = "
         <button id='btnEditProduct' class='btn btn-defaultx btn-edit-product' data-original-title='Editar producto' data-toggle='tooltip' data-id-product='" . $row['ID_PRODUCTO'] . "'>
         <i class='fa fa-edit fa-x' aria-hidden='true'></i>
         </button>
         <button id='btnDeleteProduct'  class='btn btn-defaultz btn-delete-med' data-original-title='Eliminar producto' data-toggle='tooltip' data-id-med='" . $row['ID_PRODUCTO'] . "' >
               <i class='fa fa-trash fa-x' aria-hidden='true'></i>
         </button>";

            $sub_array = array();

            $sub_array[] = $actions;
            $sub_array[] = mb_strtoupper($row['NOMBRE_PRODUCTO']);
            $sub_array[] = mb_strtoupper($row['CODIGO_PRODUCTO']);
            $sub_array[] = mb_strtoupper($row['STOCK_PRODUCTO']);
            $sub_array[] = mb_strtoupper($row['STOCK_MINIMO_PRODUCTO']);
            $sub_array[] = mb_strtoupper("$ " . $row['PRECIO_PRODUCTO']);

            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" => $total_products,
            "recordsFiltered" => $filt_products,
            "data" => $data
        );
        return $output;
    }

    // ======== ServerSide Processing Compras =================== //
    function make_query_compras($dates) {

        $order_column = array(NULL, "FECHA_COMPRA", "NOMBRE_USUARIO", "EMPRESA_PROVEEDOR", NULL, "COMENTARIOS_COMPRA");

        $this->db->select("*");
        $this->db->from('compra as c');
        $this->db->join('usuario as u', 'c.ID_USUARIO=u.ID_USUARIO');
        $this->db->join('proveedor as p', 'c.ID_PROVEEDOR=p.ID_PROVEEDOR');
        $this->db->join('tipopago as tp', 'c.ID_TIPO_PAGO=tp.ID_TIPOPAGO');
        $this->db->where('c.FECHA_COMPRA >= "' . $dates['fechaini'] . '" and c.FECHA_COMPRA <= "' . $dates['fechafin'] . '"');


        if ($_POST["search"]["value"] != "") {
            $this->db->like("NOMBRE_USUARIO", $_POST["search"]["value"]);
            $this->db->or_like("EMPRESA_PROVEEDOR", $_POST["search"]["value"]);
            $this->db->or_like("FECHA_COMPRA", $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($order_column[$_POST["order"]['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by("ID_COMPRA", "DESC");
        }
    }

    function make_datatables_compras($dates) {

        $this->make_query_compras($dates);

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST["length"], $_POST["start"]);
        }
        $query = $this->db->get()->result_array();
        return $query;
    }

    function get_all_data_compras() {
        $this->db->select("*");
        $this->db->from("compra");
        /* $this->db->get('urgencias')->num_rows(); */
        return $this->db->count_all_results();
    }

    function get_filtered_data_compras($dates) {
        $this->make_query_compras($dates);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_compras($dates) {
        $fetch_data = $this->make_datatables_compras($dates);
        $total_compras = $this->get_all_data_compras();
        $filt_compras = $this->get_filtered_data_compras($dates);
        $data = array();
        foreach ($fetch_data as $row) {
            if ($row['VIGENCIA_COMPRA'] == 1) {
                $status = "success";
                $txt = "Confirmada";
            } else {
                $status = "danger";
                $txt = "Cancelada";
            }

            $actions = "
         <button id='btnViewEntrie' class='btn btn-defaultx btn-view-entrie'
            data-original-title='Ver compra'               
            data-toggle='tooltip'  data-id-buy='" . $row['ID_COMPRA'] . "'>
            <i class='fa fa-eye fa-x'></i>
         </button>
         <button title='Cancelar compra' id='btnDeleteBuy'class='btn btn-defaultz btn-del-buy' 
               data-toggle='tooltip'
               data-id-buy='" . $row['ID_COMPRA'] . "'>
               <i class='fa fa-times fa-x'></i>
         </button>";

            $sub_array = array();

            $sub_array[] = $actions;
            $sub_array[] = mb_strtoupper($row['FECHA_COMPRA']);
            $sub_array[] = "<span class='label label-$status'>$txt</span>";
            $sub_array[] = mb_strtoupper($row['NOMBRE_USUARIO'] . " " . $row['APELLIDO_USUARIO']);
            $sub_array[] = mb_strtoupper($row['EMPRESA_PROVEEDOR']);
            $sub_array[] = mb_strtoupper($row['TOTAL_COMPRA']);
            $sub_array[] = mb_strtoupper($row['COMENTARIOS_COMPRA']);

            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" => $total_compras,
            "recordsFiltered" => $filt_compras,
            "data" => $data
        );
        return $output;
    }

    // ======== ServerSide Processing Provedores ================//
    function make_query_supliers() {

        $order_column = array(NULL, "EMPRESA_PROVEEDOR", "TELEFONO_PROVEEDOR", "DOMICILIO_PROVEEDOR");

        $this->db->select("*");
        $this->db->from('proveedor');
        $this->db->where('VIGENTE_PROVEEDOR', VIGENTE);

        if ($_POST["search"]["value"] != "") {
            $this->db->like("EMPRESA_PROVEEDOR", $_POST["search"]["value"]);
            $this->db->or_like("TELEFONO_PROVEEDOR", $_POST["search"]["value"]);
            $this->db->or_like("DOMICILIO_PROVEEDOR", $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($order_column[$_POST["order"]['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by("ID_PROVEEDOR", "DESC");
        }
    }

    function make_datatables_supliers() {
        $this->make_query_supliers();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST["length"], $_POST["start"]);
        }
        $query = $this->db->get()->result_array();
        return $query;
    }

    function get_all_data_supliers() {
        $this->db->select("*");
        $this->db->from("proveedor");
        /* $this->db->get('urgencias')->num_rows(); */
        return $this->db->count_all_results();
    }

    function get_filtered_data_supliers() {
        $this->make_query_supliers();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_supliers() {
        $fetch_data = $this->make_datatables_supliers();
        $total_supliers = $this->get_all_data_supliers();
        $filt_supliers = $this->get_filtered_data_supliers();

        $data = array();
        /*  if (count($fetch_data) > 0) {   */
        foreach ($fetch_data as $row) {
            $actions = "
                                                            
               <button title='Editar proveedor' id='btnEditSupplier' class='btn btn-defaultx btn-edit-supplier' data-id-supplier='" . $row['ID_PROVEEDOR'] . "'>
                  <i class='fa fa-edit fa-x' aria-hidden='true'></i>
               </button>
               <button title='Borrar proveedor' id='btnDeleteSupplier' class='btn btn-defaultz btn-del-supplier' data-id-supplier='" . $row['ID_PROVEEDOR'] . "'>
                  <i class='fa fa-trash fa-x' aria-hidden='true'></i>
               </button>";

            $sub_array = array();

            $sub_array[] = $actions;
            $sub_array[] = mb_strtoupper($row['EMPRESA_PROVEEDOR']);
            $sub_array[] = mb_strtoupper($row['TELEFONO_PROVEEDOR']);
            $sub_array[] = mb_strtoupper($row['DOMICILIO_PROVEEDOR']);

            $data[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" => $total_supliers,
            "recordsFiltered" => $filt_supliers,
            "data" => $data
        );
        return $output;
        /*  } else {
          return false;
          } */
    }

    // ======== ServerSide Processing Procedimientos ================//
    function make_query_procedure() {

        $order_column = array(NULL, "descripcion_procedimiento", "precio_procedimiento");

        $this->db->select("*");
        $this->db->from('procedimiento');
        $this->db->where('activo_procedimiento', 1);

        if ($_POST["search"]["value"] != "") {
            $this->db->like("descripcion_procedimiento", $_POST["search"]["value"]);
            $this->db->or_like("precio_procedimiento", $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($order_column[$_POST["order"]['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by("id_procedimiento", "DESC");
        }
    }

    function make_datatables_procedure() {
        $this->make_query_procedure();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST["length"], $_POST["start"]);
        }
        $query = $this->db->get()->result_array();
        return $query;
    }

    function get_all_data_procedure() {
        $this->db->select("*");
        $this->db->from("procedimiento");
        /* $this->db->get('urgencias')->num_rows(); */
        return $this->db->count_all_results();
    }

    function get_filtered_data_procedure() {
        $this->make_query_procedure();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_procedures() {
        $fetch_data = $this->make_datatables_procedure();
        $total_procedure = $this->get_all_data_procedure();
        $filt_procedure = $this->get_filtered_data_procedure();

        $data = array();
        /*  if (count($fetch_data) > 0) {   */
        foreach ($fetch_data as $row) {
            $actions = "
                                                                        
            <button id='btnEditProcedure' class='btn btn-defaultx btn-edit-procedure' 
               data-title='Editar procedimiento' 
               data-toggle='tooltip' 
               data-placement='right'
               data-id-procedure='" . $row['id_procedimiento'] . "'>
                <i class='fa fa-edit fa-x'></i>
            </button>
            <button id='btnDeleteProcedure' class='btn btn-defaultz btn-delete-procedure' 
               data-title='Eliminar procedimiento' 
               data-toggle='tooltip' 
               data-placement='right'
               data-id-procedure='" . $row['id_procedimiento'] . "' >
                <i class='fa fa-trash fa-x'></i>
            </button>";

            $sub_array = array();

            $sub_array[] = $actions;
            $sub_array[] = mb_strtoupper($row['descripcion_procedimiento']);
            $sub_array[] = "$ " . mb_strtoupper($row['precio_procedimiento']);

            $data[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" => $total_procedure,
            "recordsFiltered" => $filt_procedure,
            "data" => $data
        );
        return $output;
        /*  } else {
          return false;
          } */
    }

    function get_all_valid_products_type() {
        try {
            $this->db->select("*");
            $this->db->from("tipo_producto");
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }
    function get_cod_product($codigo) {
        try {
            $this->db->select("*");
            $this->db->from('PRODUCTO');
            $this->db->where('CODIGO_PRODUCTO',$codigo);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

}
