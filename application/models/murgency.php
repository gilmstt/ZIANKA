<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Murgency extends CI_Model {

    function agregarReceta($idUrgencia, $idReceta) {
        try {
            $this->db->set('ID_RECETA', $idReceta);
            $this->db->where('ID_URGENCIA', $idUrgencia);
            $this->db->update("urgencia");
            return ($this->db->affected_rows() > 0);
        }
        catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    // FICHA CONSUMO
    function insertFicha($id_urgencia, $id_paciente) {
        try {
            $values = array(
                "ID_PACIENTE" => $id_paciente,
                "ID_URGENCIA" => $id_urgencia,
                "FECHA_FICHA" => $this->input->post('RG_FECHA_FICHA'),
                "HR_FICHA" => $this->input->post('RG_HR_FICHA'),
            );
            $this->db->insert('ficha_consumo', $values);
            $id_ficha = $this->db->insert_id();
            $id_user = $this->session->userdata('CAREYES_ID_USUARIO');
            $this->db->where('ID_URGENCIA', $id_urgencia);
            $this->db->update('urgencia', array('ID_FICHA' => $id_ficha));

            $temps_proce = $this->db->get_where('temp_procedimiento', array('ID_SESSION' => $id_user))->result();
            $temps_product = $this->db->get_where('temp_producto', array('ID_SESSION' => $id_user))->result();

            if (count($temps_proce > 0)) {

                foreach ($temps_proce as $row) {
                    $data = array(
                        "ID_FICHA" => $id_ficha,
                        "ID_PROCEDIMIENTO" => $row->ID_PROCEDIMIENTO,
                        "NOMBRE_PROCEDIMIENTO" => $row->NOMBRE_PROCEDIMIENTO,
                        "PRECIO_PROCEDIMIENTO" => $row->PRECIO_PROCEDIMIENTO,
                        "CANT_PROCEDIMIENTO" => $row->CANT_PROCEDIMIENTO
                    );

                    $this->db->insert('rel_procedimiento_ficha', $data);
                }

                if ($this->db->affected_rows() > 0) {
                    $this->db->where('ID_SESSION', $id_user);
                    $this->db->delete('temp_procedimiento');
                }
            }
            if (count($temps_product > 0)) {

                foreach ($temps_product as $row) {
                    $data = array(
                        "ID_FICHA" => $id_ficha,
                        "ID_PRODUCTO" => $row->ID_PRODUCTO,
                        "NOMBRE_PRODUCTO" => $row->NOMBRE_PRODUCTO,
                        "PRECIO_PRODUCTO" => $row->PRECIO_PRODUCTO,
                        "CANT_PRODUCTO" => $row->CANT_PRODUCTO
                    );

                    $this->db->insert('rel_producto_ficha', $data);

                    $_row = $this->db->get_where('producto', array('ID_PRODUCTO' => $row->ID_PRODUCTO))->row();

                    $stock = $_row->STOCK_PRODUCTO;
                    $cant = $row->CANT_PRODUCTO;
                    $stock_total = $stock - $cant;

                    $this->db->where('ID_PRODUCTO', $row->ID_PRODUCTO);
                    $this->db->update('producto', array('STOCK_PRODUCTO' => $stock_total));
                }
                if ($this->db->affected_rows() > 0) {
                    $this->db->where('ID_SESSION', $id_user);
                    $this->db->delete('temp_producto');
                }
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    // URGENCIA
    function add_urgency() {
        try {
            $idTarifa = ($this->input->post('ID_TARIFA')) ? $this->input->post('ID_TARIFA') : NULL;
            $idMembresia = ($this->input->post('ID_MEMBRESIA')) ? $this->input->post('ID_MEMBRESIA') : NULL;
            $Perfil = ($this->input->post('RG_ID_PERFIL_MEMBRESIA')) ? $this->input->post('RG_ID_PERFIL_MEMBRESIA') : NULL;

            if ($this->input->post('RG_NOMBRE_PACIENTE')) {
                $new_pacient = array(
                    "ID_SEXO" => $this->input->post('RG_SEXO'),
                    "NOMBRE_PACIENTE" => trim($this->input->post('RG_NOMBRE_PACIENTE')),
                    "FECHA_NAC_PACIENTE" => convierte_fecha($this->input->post('RG_FECHA_NAC_PACIENTE')),
                    "APELLIDO_PATERNO_PACIENTE" => trim($this->input->post('RG_APELLIDO_PATERNO')),
                    "APELLIDO_MATERNO_PACIENTE" => trim($this->input->post('RG_APELLIDO_MATERNO')),
                    "CALLE_PACIENTE" => trim($this->input->post('RG_CALLE_PACIENTE')),
                    "NUMERO_PACIENTE" => trim($this->input->post('RG_NUMERO_PACIENTE')),
                    "COLONIA_PACIENTE" => trim($this->input->post('RG_COLONIA_PACIENTE')),
                    "ID_PERFIL_MEMBRESIA" => $Perfil,
                    "ID_TARIFA" => $idTarifa,
                    "ID_MEMBRESIA" => $idMembresia
                );
                $this->db->insert('paciente', $new_pacient);
                $id_paciente = $this->db->insert_id();

                $Antecedentes = array(
                    'ID_PACIENTE' => $id_paciente,
                );
                $this->db->insert('antecedentes', $Antecedentes);
            } else {
                $id_paciente = $this->input->post('ID_PACIENTE');
            }

            $id_user = $this->session->userdata('CAREYES_ID_USUARIO');
            $temps_proce = $this->db->get_where('temp_procedimiento', array('ID_SESSION' => $id_user))->num_rows();
            $temps_product = $this->db->get_where('temp_producto', array('ID_SESSION' => $id_user))->num_rows();
            $descTarifa = ($this->input->post('DESC_TARIFA')) ? $this->input->post('DESC_TARIFA') : intval("0");
            /* $descMembresia = ($this->input->post('RG_DESCUENTO')) ? $this->input->post('RG_DESCUENTO') : intval("0"); */

            $data = array(
                "ID_PACIENTE" => $id_paciente,
                "ID_TARIFA" => $idTarifa,
                "ID_MEMBRESIA" => $idMembresia,
                "ID_MEDICO" => $this->input->post('ID_MEDICO'),
                "ID_USER" => $this->session->userdata('CAREYES_ID_USUARIO'),
                /*  "DESC_MEMBRESIA" => $descMembresia, */
                "DESC_TARIFA" => $descTarifa,
                "FECHA_URGENCIA" => convierte_fecha($this->input->post('RG_FECHA_FICHA')),
                "HORA_URGENCIA" => $this->input->post('RG_HR_FICHA'),
                "CONDICION_URGENCIA" => $this->input->post('RG_CONDICION_URGENCIA'),
                "ORIGEN_URGENCIA" => $this->input->post('RG_ORIGEN_URGENCIA'),
                "MOTIVO_URGENCIA" => $this->input->post('RG_MOTIVO_URGENCIA'),
                "INICIOEVOLUCION_URGENCIA" => $this->input->post('RG_INICIOEVOLUCION_URGENCIA'),
                "SIGNOS_VITALES" => $this->input->post('RG_SIGNOS_VITALES_URGENCIA'),
                "FC_URGENCIA" => $this->input->post('RG_FC_URGENCIA'),
                "RITMO_CARDIACO_URGENCIA" => $this->input->post('RG_RITMO_CARDIACO_URGENCIA'),
                "TEMP_URGENCIA" => $this->input->post('RG_TEMP_URGENCIA'),
                "FR_URGENCIA" => $this->input->post('RG_FR_URGENCIA'),
                "SAT_URGENCIA" => $this->input->post('RG_SAT_URGENCIA'),
                "GLICEMIA_CAPILAR_URGENCIA" => $this->input->post('RG_GLICEMIA_CAPILAR_URGENCIA'),
                "DIAGNOSTICO" => $this->input->post('RG_DIAGNOSTICO_URGENCIA'),
                "EXPLORACION_FISICA" => $this->input->post('RG_EXPLORACION_FISICA'),
                "MANEJO_INTRAHOSPITALARIO_URGENCIA" => $this->input->post('RG_MANEJO_INTRAHOSPITALARIO_URGENCIA'),
                "TRATAMIENTO_URGENCIA" => $this->input->post('RG_TRATAMIENTO_URGENCIA'),
                "EVOLUCION_URGENCIA" => $this->input->post('RG_EVOLUCION_URGENCIA'),
                "DIAGNOSTICO_EGRESO" => $this->input->post('RG_DIAGNOSTICO_EGRESO'),
                "OBSERVACION_URGENCIA" => $this->input->post('RG_OBSERVACION_URGENCIA'),
                "DESTINO" => $this->input->post('RG_DESTINO'),
                "TOTAL_PAGADO_URGENCIA" => floatval($this->input->post('RG_TOTAL_PAGADO_URGENCIA')),
                "VIGENCIA_URGENCIA" => ACTIVO,
            );
            $this->db->insert('urgencia', $data);
            $id_urgencia = $this->db->insert_id();
            if ($temps_proce > 0 || $temps_product > 0) {
                $this->insertFicha($id_urgencia, $id_paciente);
            }

            echo json_encode(array("true" => "success"));
        } catch (Exception $ex) {
            $_data = array(
                "error" => TRUE,
                "msj" => $e->getMessage()
            );
            echo json_encode($_data);
        }
    }

    function update_urgency() {
        $inputFecha = $this->input->post('RG_FECHA_EGRESO');
        $inputHora = $this->input->post('RG_HORA_EGRESO');
        $Fecha = ($inputFecha != "Sin registrar") ? convierte_fecha($inputFecha) : NULL;
        $Hora = ($inputHora != "") ? $inputHora : NULL;

        $data = array(
            "ID_PACIENTE" => $this->input->post('ID_PACIENTE'),
            //"ID_TARIFA" => $this->input->post('ID_TARIFA'),
            "ID_MEDICO" => $this->input->post('ID_MEDICO'),
            "ID_USER" => $this->session->userdata('CAREYES_ID_USUARIO'),
            "CONDICION_URGENCIA" => $this->input->post('RG_CONDICION_URGENCIA'),
            "ORIGEN_URGENCIA" => $this->input->post('RG_ORIGEN_URGENCIA'),
            "MOTIVO_URGENCIA" => $this->input->post('RG_MOTIVO_URGENCIA'),
            "INICIOEVOLUCION_URGENCIA" => $this->input->post('RG_INICIOEVOLUCION_URGENCIA'),
            "SIGNOS_VITALES" => $this->input->post('RG_SIGNOS_VITALES_URGENCIA'),
            "FC_URGENCIA" => $this->input->post('RG_FC_URGENCIA'),
            "RITMO_CARDIACO_URGENCIA" => $this->input->post('RG_RITMO_CARDIACO_URGENCIA'),
            "TEMP_URGENCIA" => $this->input->post('RG_TEMP_URGENCIA'),
            "FR_URGENCIA" => $this->input->post('RG_FR_URGENCIA'),
            "SAT_URGENCIA" => $this->input->post('RG_SAT_URGENCIA'),
            "GLICEMIA_CAPILAR_URGENCIA" => $this->input->post('RG_GLICEMIA_CAPILAR_URGENCIA'),
            "DIAGNOSTICO" => $this->input->post('RG_DIAGNOSTICO_URGENCIA'),
            "EXPLORACION_FISICA" => $this->input->post('RG_EXPLORACION_FISICA'),
            "MANEJO_INTRAHOSPITALARIO_URGENCIA" => $this->input->post('RG_MANEJO_INTRAHOSPITALARIO_URGENCIA'),
            "TRATAMIENTO_URGENCIA" => $this->input->post('RG_TRATAMIENTO_URGENCIA'),
            "EVOLUCION_URGENCIA" => $this->input->post('RG_EVOLUCION_URGENCIA'),
            "OBSERVACION_URGENCIA" => $this->input->post('RG_OBSERVACION_URGENCIA'),
            "DESTINO" => $this->input->post('RG_DESTINO'),
            "DIAGNOSTICO_EGRESO" => $this->input->post('RG_DIAGNOSTICO_EGRESO'),
            "FECHAEGRESO_URGENCIA" => $Fecha,
            "HREGRESO_URGENCIA" => $Hora,
        );

        $this->db->where("ID_URGENCIA", $this->input->post('ID_URGENCIA'));
        $this->db->update('urgencia', $data);
    }

    function get_all_urgencys() {
        try {
            $query = $this->db->query("SELECT urgencia.* , paciente.NOMBRE_PACIENTE, usuario.NOMBRE_USUARIO, tarifa.NOMBRE_TARIFA FROM urgencia
         INNER JOIN paciente
         ON urgencia.ID_PACIENTE = paciente.ID_PACIENTE
         INNER JOIN usuario
         ON urgencia.ID_MEDICO = usuario.ID_USUARIO
         INNER JOIN tarifa
         ON urgencia.ID_TARIFA = tarifa.ID_TARIFA");

            return $query->result_array();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    function get_urgency_by_id() {
        $id_urgencia = $this->input->post('urgencia');
        $id_paciente = $this->input->post('paciente');
        $id_tarifa = $this->input->post('tarifa');
        try {
            $Tarifa = $this->db->get_where('tarifa', array('ID_TARIFA' => $id_tarifa))->row();
            $Medicos = $this->db->get_where('usuario', array('ID_ROL' => 4))->result_array();
            $Urgencia = $this->db->get_where('urgencia', array('ID_URGENCIA' => $id_urgencia))->row();
            $Paciente = $this->db->get_where('paciente', array('ID_PACIENTE' => $id_paciente))->row();

            $data = array(
                'Tarifa' => $Tarifa,
                'Urgencia' => $Urgencia,
                'Paciente' => $Paciente,
                'Medicos' => $Medicos
            );
            return $data;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    function delete_urgency() {
        $id = $this->input->post('id_urgencia');

        try {
            $this->db->where('ID_URGENCIA', $id);
            $this->db->update('urgencia', array('VIGENCIA_URGENCIA' => 0));

            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
            /* return $Delete = ($this->db->affected_rows() > 0) ? return true : return false; */
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    
    function get_tarifa_by_id() {
        try {
            $id = $this->input->post('tarifa');
            return $this->db->get_where('tarifa', array('ID_TARIFA' => $id))->row();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    function edit_desc_tarifa() {
        try {
            $data = array();
            if(!empty($this->input->post('desc'))) $data['DESC_TARIFA'] = $this->input->post('desc');
            if(!empty($this->input->post('TotPag'))) $data['TOTAL_PAGADO_URGENCIA'] = $this->input->post('TotPag');
            $data['FOLIO_URGENCIA'] = 0;
            if(intval($this->input->post('FolUrg')>0)) $data['FOLIO_URGENCIA'] = intval($this->input->post('FolUrg'));
            if(intval($this->input->post('FolUrgM')>0)) $data['FOLIO_URGENCIA'] = intval($this->input->post('FolUrgM'));
            
            $ficha = $this->input->post('ficha');

            $findFolio = $this->db->get_where("urgencia", array("ID_URGENCIA <> " . $this->input->post('urgencia') . " AND FOLIO_URGENCIA=" => $data['FOLIO_URGENCIA']))->num_rows();
            //var_dump( $this->input->post());
            if($findFolio <= 0 || intval($data['FOLIO_URGENCIA']==0)){
                if($ficha>0){
                $this->db->where('ID_FICHA', $ficha);
                $this->db->update('urgencia', $data);

                    return "bien";
                }else{
                    return 'no ficha';
                }
            }else{
                if($findFolio >0 && intval($data['FOLIO_URGENCIA'])>0){
                    return 'repetido';
                }else{
                    return "error";
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    function edit_tot_pag() {
        try {
            $data = array(
                'TOTAL_PAGADO_URGENCIA' =>floatval($this->input->post('TotPag')),
            );

            $ficha = $this->input->post('ficha');

            $this->db->where('ID_FICHA', $ficha);
            $this->db->update('urgencia', $data);

            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    function close_urgencia() {
        try {
            $id = $this->input->post('id_urgencia');

            $this->db->where('ID_URGENCIA', $id);
            $this->db->update('urgencia', array('CLOSE_URGENCIA' => 1));

            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    // REL PRODUCTOS & PROCEDIMIENOTS
    function get_procedimientos() {
        try {
            $id_ficha = $this->input->post('id_ficha');
            $data = $this->db->get_where('rel_procedimiento_ficha', array('ID_FICHA' => $id_ficha))->result_array();
            return $data;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function get_productos() {
        try {
            $id_ficha = $this->input->post('id_ficha');
            $data = $this->db->get_where('rel_producto_ficha', array('ID_FICHA' => $id_ficha))->result_array();
            return $data;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function insert_relProcedimiento() {
        try {
            // Guardo las variables recibidas //
            $input_ficha = $this->input->post('id_ficha');
            $cantidad = $this->input->post('cantidad');
            //$id_tarifa        = $this->input->post('id_tarifa');
            $id_urgencia = $this->input->post('id_urgencia');
            $id_paciente = $this->input->post('id_paciente');
            $id_procedimiento = $this->input->post('id_procedimiento');
            $get_precio = $this->input->post('precio_proce');

            if ($input_ficha <= 0) {
                $values = array(
                    "ID_PACIENTE" => $id_paciente,
                    "ID_URGENCIA" => $id_urgencia,
                    "FECHA_FICHA" => date('Y-m-d'),
                    "HR_FICHA" => date('H:i'),
                );
                $this->db->insert('ficha_consumo', $values);
                $id_ficha = $this->db->insert_id();
                $this->db->where('ID_URGENCIA', $id_urgencia);
                $this->db->update('urgencia', array('ID_FICHA' => $id_ficha));
            } else {
                $id_ficha = $input_ficha;
            }

            // Obtengo datos de las tablas procedimientos y tarifas
            // $row_tarifa        = $this->db->get_where('tarifa',array('ID_TARIFA' => $id_tarifa))->row();
            $row_procedimiento = $this->db->get_where('procedimiento', array('id_procedimiento' => $id_procedimiento))->row();

            //$tarifa = $row_tarifa->PORCENTAJE_TARIFA;
            /* $precio = $row_procedimiento->precio_procedimiento; */
            $precio = ($get_precio > 0) ? $get_precio : $row_procedimiento->precio_procedimiento;

            $exist = $this->db->get_where('rel_procedimiento_ficha', array('ID_PROCEDIMIENTO' => $id_procedimiento, 'ID_FICHA' => $id_ficha))->row();
            // Valido si existe el id procedimiento en la tabla rel_procedimiento
            if (count($exist) > 0) {

                $cant_db = $exist->CANT_PROCEDIMIENTO;
                $cant_total = $cantidad + $cant_db;

                $precioXcant = $precio * $cant_total;
                //$_precioXcant_= $precioXcant * ($tarifa / 100);

                $this->db->where('ID_PROCEDIMIENTO', $id_procedimiento);
                $this->db->where('ID_FICHA', $id_ficha);
                $this->db->update('rel_procedimiento_ficha', array('CANT_PROCEDIMIENTO' => $cant_total, "PRECIO_PROCEDIMIENTO" => $precioXcant));
            } else {

                $precioXcant = $precio * $cantidad;
                //$_precioXcant= $precioXcant * ($tarifa / 100);

                $data = array(
                    'ID_FICHA' => $id_ficha,
                    'ID_PROCEDIMIENTO' => $row_procedimiento->id_procedimiento,
                    'NOMBRE_PROCEDIMIENTO' => $row_procedimiento->descripcion_procedimiento,
                    'PRECIO_PROCEDIMIENTO' => $precioXcant,
                    'CANT_PROCEDIMIENTO' => $cantidad,
                );
                $this->db->insert('rel_procedimiento_ficha', $data);
            }
            ///////////////////////////////////////////////////////////
            return $id_ficha;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function delete_relProcedimiento() {
        try {
            $id = $this->input->post('id_rel');
            $this->db->where('ID', $id);
            $this->db->delete('rel_procedimiento_ficha');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    function insert_relProducto() {
        try {
            if ($this->input->post('id_tarifa')) {
                $id_tarifa = $this->input->post('id_tarifa');
                $row_tarifa = $this->db->get_where('tarifa', array('ID_TARIFA' => $id_tarifa))->row();
                $tarifa = $row_tarifa->PORCENTAJE_TARIFA;
            }
            // Guardo las variables recibidas //
            $input_ficha = $this->input->post('id_ficha');
            $cantidad = $this->input->post('cantidad');
            $id_tarifa = $this->input->post('id_tarifa');
            $id_urgencia = $this->input->post('id_urgencia');
            $id_paciente = $this->input->post('id_paciente');
            $id_producto = $this->input->post('id_producto');
            log_message("error", "agregando producto ficha consumo id: ".  $input_ficha . ", id_usuario: " . $this->session->userdata('CAREYES_ID_USUARIO'));

            //Valido si existe ficha consumo
            if ($input_ficha <= 0) {
                $values = array(
                    "ID_PACIENTE" => $id_paciente,
                    "ID_URGENCIA" => $id_urgencia,
                    "FECHA_FICHA" => date('Y-m-d'),
                    "HR_FICHA" => date('H:i'),
                );
                $this->db->insert('ficha_consumo', $values);
                $id_ficha = $this->db->insert_id();
                $this->db->where('ID_URGENCIA', $id_urgencia);
                $this->db->update('urgencia', array('ID_FICHA' => $id_ficha));
            } else {
                $id_ficha = $input_ficha;
            }
            // Obtengo datos de las tablas productos y tarifas         
            $row_producto = $this->db->get_where('producto', array('id_producto' => $id_producto))->row();
            log_message("error", "producto antes de edición" . json_encode($row_producto));
            $precio = $row_producto->PRECIO_PRODUCTO;
            $stock_db = $row_producto->STOCK_PRODUCTO;
            $current_stock = $stock_db - $cantidad;

            $verify = 0;

            $exist = $this->db->get_where('rel_producto_ficha', array('ID_PRODUCTO' => $id_producto, 'ID_FICHA' => $id_ficha))->row();
            // Valido si existe el id producto en la tabla rel_producto
            if (count($exist) > 0) {
                $cant_db = $exist->CANT_PRODUCTO;
                $cant_total = $cantidad + $cant_db;

                /* if(isset($tarifa)){
                  $precioXcant = $precio * $cant_total;
                  $precioXcant= $precioXcant * ($tarifa / 100);
                  }else{ */
                $precioXcant = $precio * $cant_total;
                /* } */

                $this->db->where('ID_PRODUCTO', $id_producto);
                $this->db->update('rel_producto_ficha', array('CANT_PRODUCTO' => $cant_total, "PRECIO_PRODUCTO" => $precioXcant));
                $verify = 1;
            } else {
                /* if(isset($tarifa)){
                  $precioXcant = $precio * $cantidad;
                  $precioXcant= $precioXcant * ($tarifa / 100);
                  }else{ */
                $precioXcant = $precio * $cantidad;
                /* } */

                $data = array(
                    'ID_FICHA' => $id_ficha,
                    'ID_PRODUCTO' => $row_producto->ID_PRODUCTO,
                    'NOMBRE_PRODUCTO' => $row_producto->NOMBRE_PRODUCTO,
                    'PRECIO_PRODUCTO' => $precioXcant,
                    'CANT_PRODUCTO' => $cantidad,
                );
                $this->db->insert('rel_producto_ficha', $data);
                log_message("error", "nuevos datos de stock de producto" .json_encode($data));
                $verify = 1;
            }

            //////////////////////////////////////////////////////////////////////////////
            if ($verify == 1) {
                $this->db->where('ID_PRODUCTO', $id_producto);
                $this->db->update('producto', array('STOCK_PRODUCTO' => $current_stock));
                log_message("error", "stock actualizado: " . $current_stock);
            }
            /////////////////////////////////////////////////////////////////////////////
            return $id_ficha;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function delete_relProducto() {
        try {
            $id_rel = $this->input->post('id_relP');

            $row_FichaProduct = $this->db->get_where('rel_producto_ficha', array('ID' => $id_rel))->row();
            $ID_PRODUCTO = $row_FichaProduct->ID_PRODUCTO;
            $CANT_PRODUCTO = $row_FichaProduct->CANT_PRODUCTO;
            log_message("error", "eliminando producto de ficha consumo id: " . $row_FichaProduct->ID_FICHA . " , id_producto: " . $ID_PRODUCTO . " , cantidad: " . $CANT_PRODUCTO. " , id_usuario: " . $this->session->userdata('CAREYES_ID_USUARIO'));

            $row_TableProduct = $this->db->get_where('producto', array('ID_PRODUCTO' => $ID_PRODUCTO))->row();
            log_message("error", "producto antes de edición" . json_encode($row_TableProduct));
            $stock_db = $row_TableProduct->STOCK_PRODUCTO;

            $current_stock = $stock_db + $CANT_PRODUCTO;

            $this->db->delete('rel_producto_ficha', array('ID' => $id_rel));

            if ($this->db->affected_rows() > 0) {
                $this->db->where('ID_PRODUCTO', $ID_PRODUCTO);
                $this->db->update('producto', array('STOCK_PRODUCTO' => $current_stock));
                log_message("error", "producto actualizado: " . $current_stock);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    // MODAL ADJUNTAR ARCHIVO
    function delete_file_by_id($ID_DOCUMENTO) {
        try {

            $this->db->where('ID_DOCUMENTO', $ID_DOCUMENTO);
            $this->db->delete('DOCUMENTO');
            return $this->db->affected_rows();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function get_files_urgency_on_db($ID_URGENCIA) {
        try {
            $this->db->where('D.ID_URGENCIA', $ID_URGENCIA);
            $this->db->from('DOCUMENTO AS D');
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function insert_file_by_urgency_id($ROW) {
        try {
            $data = array(
                'ID_URGENCIA' => intval($ROW['ID_URGENCIA']),
                'TIPO_DOCUMENTO' => trim($ROW['TIPO_DOCUMENTO']),
                'NOMBRE_DOCUMENTO' => $ROW['NOMBRE_DOCUMENTO'],
                'FECHA_CREACION_DOCUMENTO' => date("Y-m-d H:i:s")
            );
            $this->db->insert('documento', $data);
            return $this->db->insert_id();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // ServerSide Processing Urgrncias //
    function make_query() {

        $order_column = array(NULL, "NOMBRE_PACIENTE", "NOMBRE_USUARIO", "NOMBRE_TARIFA", NULL, "CALLE_PACIENTE", "FECHA_URGENCIA", "HORA_URGENCIA");

        $this->db->select('urgencia.* , paciente.NOMBRE_PACIENTE , paciente.APELLIDO_PATERNO_PACIENTE , paciente.APELLIDO_MATERNO_PACIENTE , usuario.NOMBRE_USUARIO , tarifa.NOMBRE_TARIFA, paciente.CALLE_PACIENTE,paciente.NUMERO_PACIENTE,paciente.COLONIA_PACIENTE, membresia.NOMBRE_MEMBRESIA');
        $this->db->from('urgencia');
        $this->db->join('tarifa', 'tarifa.ID_TARIFA = urgencia.ID_TARIFA', 'left');
        $this->db->join('usuario', 'usuario.ID_USUARIO = urgencia.ID_MEDICO');
        $this->db->join('paciente', 'paciente.ID_PACIENTE = urgencia.ID_PACIENTE');
        $this->db->join('membresia', 'membresia.ID_MEMBRESIA = urgencia.ID_MEMBRESIA', 'left');
        $this->db->join('VIGENCIA as v', 'urgencia.VIGENCIA_URGENCIA = v.VIGENCIA');
        $this->db->where('VIGENCIA_URGENCIA', 1);


        if (!empty($_POST["search"]["value"] != "")) {
            $search_value = $_POST["search"]["value"];

            $this->db->like("CONCAT(paciente.NOMBRE_PACIENTE, ' ', `paciente`.`APELLIDO_PATERNO_PACIENTE`, ' ', `paciente`.APELLIDO_MATERNO_PACIENTE)", $search_value);
            
            $this->db->or_like("NOMBRE_USUARIO", $search_value);
            $this->db->or_like("APELLIDO_USUARIO", $search_value);

            $this->db->or_like("FECHA_URGENCIA", $search_value);
            $this->db->or_like("CALLE_PACIENTE", $search_value);
            $this->db->or_like("NUMERO_PACIENTE", $search_value);
            $this->db->or_like("COLONIA_PACIENTE", $search_value);
            $this->db->or_like("MOTIVO_URGENCIA", $_POST["search"]["value"]);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($order_column[$_POST["order"]['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by("ID_URGENCIA", "DESC");
        }
    }

    function make_datatables() {
        $this->make_query();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST["length"], $_POST["start"]);
        }
        $query = $this->db->get()->result_array();
        return $query;
    }

    function get_all_data() {
        $this->db->select("*");
        $this->db->where('VIGENCIA_URGENCIA', 1);
        $this->db->from("urgencia");
        /* $this->db->get('urgencias')->num_rows(); */
        return $this->db->count_all_results();
    }

    function get_filtered_data() {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_urgencias() {
        $fetch_data = $this->Murgency->make_datatables();
        $total_urgencys = $this->Murgency->get_all_data();
        $filtered_urgencys = $this->Murgency->get_filtered_data();

        $data = array();
        foreach ($fetch_data as $row) {
            $type = ($row['NOMBRE_TARIFA']) ? $row['NOMBRE_TARIFA'] : $row['NOMBRE_MEMBRESIA'];
            $status = ($row['CLOSE_URGENCIA']) <= 0 ? "Abierta" : "Cerrada";
            $badge = ($row['CLOSE_URGENCIA']) <= 0 ? "badge-open" : "badge-close";

            if ($row['ID_TARIFA']) {
                $PrecioUrgencia = $this->db->select('URGENCIA_TARIFA,NOMBRE_TARIFA')->get_where('tarifa', array('ID_TARIFA' => $row['ID_TARIFA']))->row();
                $PrecioU = $PrecioUrgencia->URGENCIA_TARIFA;
                $NameTarifa = $PrecioUrgencia->NOMBRE_TARIFA;
            } else {
                $PrecioU = floatval(0);
                $NameTarifa = "";
            }

            if ($row['ID_RECETA'] == null) {
                $actions = "
                    <button id='' title='Imprimir Receta' data-toggle='tooltip' 
                        class='btn-receta-urgency-show btn btn-defaultx' type='button'
                        data-id_urgencia='" . $row['ID_URGENCIA'] . "'
                        data-id_paciente='" . $row['ID_PACIENTE'] . "'>
                        <i class='fas fa-print fa-x'></i>
                    </button>";
            } else {
                $actions = "
                    <button id='EDIT_URGENCIA_RECETA' title='Editar Receta' data-toggle='tooltip'
                        class='btn btn-defaultx' type='button'
                        data-id_receta='" . $row['ID_RECETA'] . "'
                        data-id_urgencia='" . $row['ID_URGENCIA'] . "'
                        data-id_paciente='" . $row['ID_PACIENTE'] . "'>
                    <i class='fas fa-file-edit fa-x'></i>
                    </button>";
            }

            $actions = $actions . "   
      
            <button id='BTN_FICHA_CLINICA_U' title='Ficha Diagnóstico' data-toggle='tooltip'
               class='btn btn-defaultx' type='button'
               data-id_tarifa='" . $row['ID_TARIFA'] . "'
               data-id_urgencia='" . $row['ID_URGENCIA'] . "'
               data-id_paciente='" . $row['ID_PACIENTE'] . "'>
               <i class='fas fa-file-contract fa-x'></i>
            </button>

            <button id='BTN_FICHA_CONSUMO_U' title='Ficha Consumo' data-toggle='tooltip' 
               class='btn btn-defaultz' type='button'
               data-id_tarifa='" . $row['ID_TARIFA'] . "'             
               data-id_ficha='" . $row['ID_FICHA'] . "'
               data-precio_urgency='" . $PrecioU . "'
               data-tarifa='" . $NameTarifa . "'
               data-membresia='" . $row['NOMBRE_MEMBRESIA'] . "'
               data-desc_tarifau='" . $row['DESC_TARIFA'] . "'
               data-close='" . $row['CLOSE_URGENCIA'] . "'
               data-id_paciente='" . $row['ID_PACIENTE'] . "'
               data-id_urgencia='" . $row['ID_URGENCIA'] . "'
               data-folio_urgencia='" . $row['FOLIO_URGENCIA'] . "'
               data-folio_urgencia_m='" . $row['FOLIO_URGENCIA'] . "'
               data-nombre_paciente='" . $row['NOMBRE_PACIENTE'] . ' ' . $row['APELLIDO_PATERNO_PACIENTE'] . ' ' . $row['APELLIDO_MATERNO_PACIENTE'] . "'>
               <i class='fas fa-file-invoice fa-x'></i>
            </button>

            <button id='BTN_ADJUNTAR_ARCHIVO_U' title='Adjuntar archivo' data-toggle='tooltip'
               class='btn btn-defaultx' type='button'            
               data-id_urgencia='" . $row['ID_URGENCIA'] . "'>
               <i class='fas fa-file fa-x'></i>
            </button>
          
            <button id='BTN_ELIMINAR_URGENCIA' title='Eliminar urgencia'
              class='btn btn-defaultz '
              data-id-urgencia='" . $row['ID_URGENCIA'] . "'>
              <i class='fa fa-trash fa-x' aria-hidden='true'></i>

            </button>";

            $sub_array = array();

            $sub_array[] = $actions;
            $sub_array[] = "<span class='" . $badge . "'>" . $status . "</span>";
            $sub_array[] = $row['NOMBRE_PACIENTE'] . " " . $row['APELLIDO_PATERNO_PACIENTE'] . " " . $row['APELLIDO_MATERNO_PACIENTE'];
            $sub_array[] = $row['NOMBRE_USUARIO'];
            $sub_array[] = $type;
            $sub_array[] = $row['CALLE_PACIENTE'] . " " . $row['NUMERO_PACIENTE'] . ", " . $row['COLONIA_PACIENTE'];
            $sub_array[] = $row['MOTIVO_URGENCIA'];
            $sub_array[] = $row['FECHA_URGENCIA'];
           // $sub_array[] = $row['HORA_URGENCIA'];

            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" => $total_urgencys,
            "recordsFiltered" => $filtered_urgencys,
            "data" => $data
        );
        return $output;
    }

    // ServerSide Processing Urgrncias search patient //
    function make_query_patient() {

        $order_column = array(NULL, "NOMBRE_PACIENTE", "CALLE_PACIENTE", "ESTADO_REPUBLICA", NULL, "FECHA_NAC_PACIENTE", "ID_SEXO");

        $this->db->select("*");
        $this->db->from('paciente as P');
        $this->db->join('sexo as S', 'S.ID_SEXO = P.ID_SEXO');
        $this->db->where('P.ACTIVO_PACIENTE', ACTIVO);

        if (!empty($_POST["search"]["value"] != "")){
            $search_value = $_POST["search"]["value"];
            $this->db->like("CONCAT(P.NOMBRE_PACIENTE, ' ', `P`.`APELLIDO_PATERNO_PACIENTE`, ' ', `P`.APELLIDO_MATERNO_PACIENTE)", $search_value);
            
            $this->db->or_like("CALLE_PACIENTE", $search_value);
            $this->db->or_like("NUMERO_PACIENTE", $search_value);
            $this->db->or_like("COLONIA_PACIENTE", $search_value);

            $this->db->or_like("MUNICIPIO_PACIENTE", $search_value);
            $this->db->or_like("FECHA_NAC_PACIENTE", $search_value);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($order_column[$_POST["order"]['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by("P.ID_PACIENTE", "DESC");
        }
    }

    function make_datatables_patient() {
        $this->make_query_patient();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST["length"], $_POST["start"]);
        }
        $query = $this->db->get()->result_array();
        return $query;
    }

    function get_all_data_patient() {
        $this->db->select("*");
        $this->db->from("paciente as Pt");
        $this->db->where('Pt.ACTIVO_PACIENTE', ACTIVO);
        return $this->db->count_all_results();
    }

    function get_filtered_data_patient() {
        $this->make_query_patient();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_patients() {
        $fetch_data = $this->Murgency->make_datatables_patient();
        $total_patients = $this->Murgency->get_all_data_patient();
        $filtered_patients = $this->Murgency->get_filtered_data_patient();


        $data = array();
        foreach ($fetch_data as $row) {

            $actions = " 
         
         <form action='" . base_url() . "Urgency/form_add_urgency_by_patient' method='post'>        
            <input type='hidden' name='ID_PACIENTE' value='" . $row['ID_PACIENTE'] . "'>
            <button type='submit' id='btnAddUrgency'
               class='btn btn-defaultz btn-add-urgency'
              >
               Nueva Urgencia <i class='fa fa-stethoscope fa-1x'></i>
            </button>
         </form>";


            $sub_array = array();

            $sub_array[] = $actions;
            $sub_array[] = mb_strtoupper($row['NOMBRE_PACIENTE'] . " " . $row['APELLIDO_PATERNO_PACIENTE'] . " " . $row['APELLIDO_MATERNO_PACIENTE']);
            $sub_array[] = mb_strtoupper($row['CALLE_PACIENTE'] . " " . $row['NUMERO_PACIENTE'] . ", " . $row['COLONIA_PACIENTE']);
            $sub_array[] = mb_strtoupper($row['MUNICIPIO_PACIENTE']);
            $sub_array[] = mb_strtoupper($row['ESTADO_REPUBLICA']);
            $sub_array[] = calcula_edad($row['FECHA_NAC_PACIENTE']);
            $sub_array[] = mb_strtoupper($row['NOMBRE_SEXO']);


            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" => $total_patients,
            "recordsFiltered" => $filtered_patients,
            "data" => $data
        );
        return $output;
    }

    function get_productos_() {
        try {
            $this->db->select("*");
            $this->db->from('producto');
            $this->db->where('ACTIVO_PRODUCTO', 1);
            $this->db->order_by('NOMBRE_PRODUCTO','ASC');
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }

    function update_rel_producto_ficha($id, $data) {
        try {
            $this->db->where('ID', $id);
            return $this->db->update("rel_producto_ficha", $data);
        }
        catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function get_producto_ficha($id)
    {   
        try {
            $this->db->from('rel_producto_ficha');
            $this->db->where('ID', $id); 
            $query = $this->db->get();
            return $query->row();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
/* End of file ModelName.php */