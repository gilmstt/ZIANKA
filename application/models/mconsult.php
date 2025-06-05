<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mconsult extends CI_Model
{

    

    function agregarReceta($idConsulta, $idReceta)
    {
        try {
            $this->db->set('ID_RECETA', $idReceta);
            $this->db->where('ID_CONSULTA', $idConsulta);
            $this->db->update("consulta");
            return ($this->db->affected_rows() > 0);
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    // FICHA CONSUMO
    function insertFicha($id_consulta)
    {
        try {
            $values = array(
                "ID_PACIENTE" => $this->input->post('ID_PACIENTE'),
                "ID_CONSULTA" => $id_consulta,
                "FECHA_FICHA" => $this->input->post('RG_FECHA_FICHA'),
                "HR_FICHA" => $this->input->post('RG_HR_FICHA'),
            );
            $this->db->insert('ficha_consumo', $values);
            $id_ficha = $this->db->insert_id();
            $id_user = $this->session->userdata('CAREYES_ID_USUARIO');
            $this->db->where('ID_CONSULTA', $id_consulta);
            $this->db->update('consulta', array('ID_FICHA' => $id_ficha));

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

    // CRUD CONSULTA
    function clear_temps($ID_SESSION)
    {
        try {
            $this->db->where('ID_SESSION', $ID_SESSION);
            $this->db->delete(array('temp_procedimiento', 'temp_producto'));
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function nueva_consulta()
    {
        try {
            $id_user = $this->session->userdata('CAREYES_ID_USUARIO');
            $temps_proce = $this->db->get_where('temp_procedimiento', array('ID_SESSION' => $id_user))->num_rows();
            $temps_product = $this->db->get_where('temp_producto', array('ID_SESSION' => $id_user))->num_rows();

            $idTarifa = ($this->input->post('ID_TARIFA')) ? $this->input->post('ID_TARIFA') : NULL;
            $idMembresia = ($this->input->post('ID_MEMBRESIA')) ? $this->input->post('ID_MEMBRESIA') : NULL;
            $descTarifa = ($this->input->post('DESC_TARIFA')) ? $this->input->post('DESC_TARIFA') : intval("0");
            /* $descMembresia = ($this->input->post('RG_DESCUENTO')) ? $this->input->post('RG_DESCUENTO') : intval("0"); */

            $data = array(
                "ID_PACIENTE" => $this->input->post('ID_PACIENTE'),
                "ID_TARIFA" => $idTarifa,
                "ID_MEMBRESIA" => $idMembresia,
                "ID_MEDICO" => $this->input->post('ID_MEDICO'),
                "ID_USER" => $this->session->userdata('CAREYES_ID_USUARIO'),
                /* "DESC_MEMBRESIA" => $descMembresia, */
                "DESC_TARIFA" => $descTarifa,
                "FECHA_CONSULTA" => convierte_fecha($this->input->post('RG_FECHA_FICHA')),
                "HORA_CONSULTA" => $this->input->post('RG_HR_FICHA'),
                "ID_TIPO_CONSULTA" => $this->input->post('RG_TIPO_CONSULTA'),
                "EXPOSICION_SOLAR" => $this->input->post('EXPOSICION_SOLAR_SI') ? 'SI' : ($this->input->post('EXPOSICION_SOLAR_NO') ? 'NO' : null),
                "TIEMPO_EXPOSICION_SOLAR" => $this->input->post('TIEMPO_EXPOSICION_SOLAR'),
                "USO_PROTECCION_SOLAR" => $this->input->post('USO_PROTECTOR_SOLAR_SI') ? 'SI' : ($this->input->post('USO_PROTECTOR_SOLAR_NO') ? 'NO' : null),
                "MARCA_PROTECTOR_SOLAR" => $this->input->post('MARCA_PROTECTOR_SOLAR'),
                "FPS_PROTECTOR_SOLAR" => $this->input->post('FPS_PROTECTOR_SOLAR'),
                "ENVEJECIMIENTO_CUTANEO" => $this->input->post('ENVEJECIMIENTO_CUTANEO') ? 1 : 0,
                "RITIDES" => $this->input->post('RITIDES') ? 1 : 0,
                "BRUXISMO" => $this->input->post('BRUXISMO') ? 1 : 0,
                "ADIP_LOCALIZADA" => $this->input->post('ADIP_LOCALIZADA') ? 1 : 0,
                "ESTRIAS" => $this->input->post('ESTRIAS') ? 1 : 0,
                "VARICES" => $this->input->post('VARICES') ? 1 : 0,
                "HIPERMEGTACION" => $this->input->post('HIPERMEGTACION') ? 1 : 0,
                "ALOPECIA" => $this->input->post('ALOPECIA') ? 1 : 0,
                "VERRUGAS" => $this->input->post('VERRUGAS') ? 1 : 0,
                "FLACIDEZ_CUTANEA" => $this->input->post('FLACIDEZ_CUTANEA') ? 1 : 0,
                "ACNE" => $this->input->post('ACNE') ? 1 : 0,
                "PEFE" => $this->input->post('PEFE') ? 1 : 0,
                "CICATRICES" => $this->input->post('CICATRICES') ? 1 : 0,
                "ROSACEA" => $this->input->post('ROSACEA') ? 1 : 0,
                "HIPERHIDROSIS" => $this->input->post('HIPERHIDROSIS') ? 1 : 0,
                "OTROS_MOTIVO_CONSULTA" => $this->input->post('OTROS_MOTIVO_CONSULTA'),
                'FITZPATRICK' => $this->input->post('FITZPATRICK'),
                'GLOGAU' => $this->input->post('GLOGAU'),
                'TIPO_PIEL' => $this->input->post('TIPO_PIEL'),
                'TIPO_ROSTRO' => $this->input->post('TIPO_ROSTRO'),
                'LESIONES_DERMATOLOGICAS' => $this->input->post('LESIONES_DERMATOLOGICAS'),
                'TIPO_DERMATOLOGICAS' => $this->input->post('TIPO_DERMATOLOGICAS'),
                'LOCALIZACION_DERMATOLOGICAS' => $this->input->post('LOCALIZACION_DERMATOLOGICAS'),
                'CONDICION_PACIENTE' => $this->input->post('CONDICION_PACIENTE'),
                'CONSTITUCION_HABITUS' => $this->input->post('CONSTITUCION_HABITUS'),
                'CONFORMACION_HABITUS' => $this->input->post('CONFORMACION_HABITUS'),
                'ACTITUD_HABITUS' => $this->input->post('ACTITUD_HABITUS'),
                'FACIES_HABITUS' => $this->input->post('FACIES_HABITUS'),
                'MOVIMIENTOS_ANORMALES_HABITUS' => $this->input->post('MOVIMIENTOS_ANORMALES_HABITUS'),
                'MARCHA_HABITUS' => $this->input->post('MARCHA_HABITUS'),
                'ESTADO_CONCIENCIA_HABITUS' => $this->input->post('ESTADO_CONCIENCIA_HABITUS'),
                'OTROS_HABITUS' => $this->input->post('OTROS_HABITUS'),
                "FC_CONSULTA" => $this->input->post('RG_FC_CONSULTA'),
                "FR_CONSULTA" => $this->input->post('RG_FR_CONSULTA'),
                "TA_CONSULTA" => $this->input->post('RG_TA_CONSULTA'),
                "TEMP_CONSULTA" => $this->input->post('RG_TEMP_CONSULTA'),
                "PESO_CONSULTA" => $this->input->post('RG_PESO_CONSULTA'),
                "TALLA_CONSULTA" => $this->input->post('RG_TALLA_CONSULTA'),
                "IMC_CONSULTA" => $this->input->post('RG_IMC_CONSULTA'),
                "LABORATORIOS_SOLICITADOS" => $this->input->post('RG_LABORATORIOS'),
                "IMPRESION_DIAGNOSTICA"   => $this->input->post('RG_LABORATORIOS_I_DIAGNOSTICA'),
                "TOTAL_PAGADO_CONSULTA" =>  floatval($this->input->post('RG_TOTAL_PAGADO_CONSULTA')),
                "OTROS_TRATAMIENTOS_ESTETICOS" => $this->input->post('OTROS_TRATAMIENTOS_ESTETICOS'),
                "VIGENCIA_CONSULTA" => ACTIVO,
                "ORIGEN_CONSULTA" => $this->input->post('RG_ORIGEN_CONSULTA'),
                "MOTIVO_CONSULTA" => $this->input->post('RG_MOTIVO_CONSULTA'),
                "INICIOEVOLUCION_CONSULTA" => $this->input->post('RG_INICIOEVOLUCION_CONSULTA'),
                "SIGNOS_VITALES" => $this->input->post('RG_SIGNOS_VITALES_CONSULTA'),
                "RITMO_CARDIACO_CONSULTA" => $this->input->post('RG_RITMO_CARDIACO_CONSULTA'),
                "SAT_CONSULTA" => $this->input->post('RG_SAT_CONSULTA'),
                "GLICEMIA_CAPILAR_CONSULTA" => $this->input->post('RG_GLICEMIA_CAPILAR_CONSULTA'),
                "DIAGNOSTICO" => $this->input->post('RG_DIAGNOSTICO_CONSULTA'),
                "EXPLORACION_FISICA" => $this->input->post('RG_EXPLORACION_FISICA'),
                "DESARROLLO_PSICOMOTOR" => $this->input->post('RG_DESARROLLO_PSICOMOTOR'),
                "MANEJO_INTRAHOSPITALARIO_CONSULTA" => $this->input->post('RG_MANEJO_INTRAHOSPITALARIO_CONSULTA'),
                "TRATAMIENTO_CONSULTA" => $this->input->post('RG_TRATAMIENTO_CONSULTA'),
                "EVOLUCION_CONSULTA" => $this->input->post('RG_EVOLUCION_CONSULTA'),
                "OBSERVACIONES_CONSULTA" => $this->input->post('RG_OBSERVACION_CONSULTA'),
                "PC" => $this->input->post('RG_PC_CONSULTA'),
                "PA" => $this->input->post('RG_PA_CONSULTA'),
                "ID_CASA" => intval($this->input->post('ID_CASA')),
            );
            $this->db->insert('consulta', $data);
            $id_consulta = $this->db->insert_id();

            // Insertar tratamientos si existen
            $tratamientos = $this->input->post('TRATAMIENTOS'); // Suponiendo que los tratamientos vienen en un array

            if (!empty($tratamientos) && is_array($tratamientos)) {
                foreach ($tratamientos as $tratamiento) {
                    $procedimiento = $tratamiento['PROCEDIMIENTO'];
                    $producto = $tratamiento['PRODUCTO'];
                    $fecha = convierte_fecha($tratamiento['FECHA']); // Formato a Y-m-d
    
                    // Insertar cada tratamiento
                    $this->db->insert('tratamientos_aplicados_consulta', [
                        'id_consulta' => $id_consulta,  // Asociamos el tratamiento con la consulta recién insertada
                        'procedimiento' => $procedimiento,
                        'producto' => $producto,
                        'fecha_aplicacion' => $fecha
                    ]);
                }
            }

            if ($temps_proce > 0 || $temps_product > 0) {
                $this->insertFicha($id_consulta);
            }

            echo json_encode(array("msj" => "okay"));
        } catch (Exception $ex) {
            $_data = array(
                "error" => TRUE,
                "msj" => $ex->getMessage()
            );
            echo json_encode($_data);
        }
    }

    function update_consulta()
    {
        $inputFecha = $this->input->post('RG_FECHA_EGRESO');
        $inputHora = $this->input->post('RG_HORA_EGRESO');
        $Fecha = ($inputFecha != "Sin registrar") ? convierte_fecha($inputFecha) : NULL;
        $Hora = ($inputHora != "") ? $inputHora : NULL;

        $data = array(
            "ID_MEDICO" => $this->input->post('ID_MEDICO'),
            "ID_USER" => $this->session->userdata('CAREYES_ID_USUARIO'),
            /* "CONDICION_CONSULTA" => $this->input->post('RG_CONDICION_CONSULTA'), */
            "ORIGEN_CONSULTA" => $this->input->post('RG_ORIGEN_CONSULTA'),
            "MOTIVO_CONSULTA" => $this->input->post('RG_MOTIVO_CONSULTA'),
            "INICIOEVOLUCION_CONSULTA" => $this->input->post('RG_INICIOEVOLUCION_CONSULTA'),
            "SIGNOS_VITALES" => $this->input->post('RG_SIGNOS_VITALES_CONSULTA'),
            "FC_CONSULTA" => $this->input->post('RG_FC_CONSULTA'),
            "RITMO_CARDIACO_CONSULTA" => $this->input->post('RG_RITMO_CARDIACO_CONSULTA'),
            "TEMP_CONSULTA" => $this->input->post('RG_TEMP_CONSULTA'),
            "FR_CONSULTA" => $this->input->post('RG_FR_CONSULTA'),
            "SAT_CONSULTA" => $this->input->post('RG_SAT_CONSULTA'),
            "GLICEMIA_CAPILAR_CONSULTA" => $this->input->post('RG_GLICEMIA_CAPILAR_CONSULTA'),
            "PESO_CONSULTA" => $this->input->post('RG_PESO_CONSULTA'),
            "TALLA_CONSULTA" => $this->input->post('RG_TALLA_CONSULTA'),
            "PC" => $this->input->post('RG_PC_CONSULTA'),
            "PA" => $this->input->post('RG_PA_CONSULTA'),
            "EXPLORACION_FISICA" => $this->input->post('RG_EXPLORACION_FISICA'),
            "DIAGNOSTICO" => $this->input->post('RG_DIAGNOSTICO_CONSULTA'),
            "MANEJO_INTRAHOSPITALARIO_CONSULTA" => $this->input->post('RG_MANEJO_INTRAHOSPITALARIO_CONSULTA'),
            "TRATAMIENTO_CONSULTA" => $this->input->post('RG_TRATAMIENTO_CONSULTA'),
            "EVOLUCION_CONSULTA" => $this->input->post('RG_EVOLUCION_CONSULTA'),
            "OBSERVACIONES_CONSULTA" => $this->input->post('RG_OBSERVACION_CONSULTA'),
            "DIAGNOSTICO_EGRESO_CONSULTA" => $this->input->post('RG_DIAGNOSTICO_EGRESO_CONSULTA'),
            "FECHAEGRESO_CONSULTA" => $Fecha,
            "HREGRESO_CONSULTA" => $Hora,
        );
        $this->db->where("ID_CONSULTA", $this->input->post('ID_CONSULTA'));
        $this->db->update('consulta', $data);
    }

    function get_all_consults()
    {
        try {

            $query = $this->db->query("SELECT consulta.* , paciente.NOMBRE_PACIENTE, usuario.NOMBRE_USUARIO, tarifa.NOMBRE_TARIFA
         FROM consulta
         INNER JOIN paciente
         ON consulta.ID_PACIENTE = paciente.ID_PACIENTE
         INNER JOIN usuario
         ON consulta.ID_MEDICO = usuario.ID_USUARIO
         INNER JOIN tarifa
         ON consulta.ID_TARIFA = tarifa.ID_TARIFA");

            /* $this->db->select('consulta.* , paciente.NOMBRE_PACIENTE, usuario.NOMBRE_USUARIO, tarifa.NOMBRE_TARIFA');
              $this->db->from('consulta');
              $this->db->join('paciente', 'paciente.ID_PACIENTE = consulta.ID_PACIENTE');
              $this->db->join('usuario',  'usuario.ID_USUARIO = consulta.ID_MEDICO');
              $this->db->join('tarifa',   'tarifa.ID_TARIFA = consulta.ID_TARIFA');
              $query = $this->db->get(); */

            return $query->result_array();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    function get_consult_by_id()
    {
        $id_consulta = $this->input->post('consulta');
        $id_paciente = $this->input->post('paciente');
        $id_tarifa = $this->input->post('tarifa');
        try {
            $Tarifa = $this->db->get_where('tarifa', array('ID_TARIFA' => $id_tarifa))->row();
            $Medicos = $this->db->get_where('usuario', array('ID_ROL' => 4))->result_array();
            $Consulta = $this->db->get_where('consulta', array('ID_CONSULTA' => $id_consulta))->row();
            $Paciente = $this->db->get_where('paciente', array('ID_PACIENTE' => $id_paciente))->row();

            $data = array(
                'Tarifa' => $Tarifa,
                'Consulta' => $Consulta,
                'Paciente' => $Paciente,
                'Medicos' => $Medicos
            );
            return $data;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    function delete_consult()
    {
        $id = $this->input->post('id_consulta');

        try {
            $this->db->where('ID_CONSULTA', $id);
            $this->db->update('consulta', array('VIGENCIA_CONSULTA' => 0));

            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    function costo_total()
    { //index (modal)
        $ficha = $this->input->post('ficha');
        $descuento = $this->input->post('descuento');
        $PrecioConsulta = $this->input->post('precio');
        $IsTarifa = $this->input->post('tarifa');

        $fichaRow = $this->db->get_where('ficha_consumo', array('ID_FICHA' => $ficha))->row();
        $is_IdConsulta = $fichaRow->ID_CONSULTA;
        $is_IdUrgencia = $fichaRow->ID_URGENCIA;

        if ($is_IdConsulta > 0) {
            $sql = $this->db->get_where('consulta', array('ID_FICHA' => $ficha))->row();
            $get = $sql->TOTAL_PAGADO_CONSULTA;
        } elseif ($is_IdUrgencia > 0) {
            $sql = $this->db->get_where('urgencia', array('ID_FICHA' => $ficha))->row();
            $get = $sql->TOTAL_PAGADO_URGENCIA;
        }

        $productos = $this->db->select_sum('PRECIO_PRODUCTO', 'sumProductos')->get_where('rel_producto_ficha', array('ID_FICHA' => $ficha))->row();
        $procedimientos = $this->db->select_sum('PRECIO_PROCEDIMIENTO', 'sumProcedimientos')->get_where('rel_procedimiento_ficha', array('ID_FICHA' => $ficha))->row();

        $suma_productos = $productos->sumProductos;
        $suma_procedimientos = ($IsTarifa != "") ? $procedimientos->sumProcedimientos : 0;
        $suma = $suma_productos + $suma_procedimientos + $PrecioConsulta;

        if ($descuento) {
            $desc = $suma * ($descuento / 100);
            $total = $suma - $desc;
            // $totalx = ($IsTarifa != 1) ? $total : $total + $suma_productos;
            $totalx = $total;
        } else {
            $totalx = $suma;
        }

        $desc = (isset($desc)) ? $desc : 0;
        $data['costo'] = $suma;
        $data['desc'] = $desc;
        $data['total'] = $totalx;
        $data['totalpagado'] = $get;

        /*$data = array(
            'costo' => $suma,
            'desc' => $desc,
            'total' => $totalx,
            'totalpagado' => $sql->TOTAL_PAGADO_URGENCIA
        );*/
        return $data;
    }

    function total_final()
    { //form consulta
        $session = $this->session->userdata('CAREYES_ID_USUARIO');
        $descuento = $this->input->post('descuento');
        $PrecioConsulta = $this->input->post('precio');
        $IsMembresia = $this->input->post('membresia');
        $Tarifa = $this->input->post('tarifa');

        $isTarifa = (isset($Tarifa)) ? $Tarifa : "";

        $productos = $this->db->select_sum('PRECIO_PRODUCTO', 'sumProductos')->get_where('temp_producto', array('ID_SESSION' => $session))->row();

        $procedimientos = $this->db->select_sum('PRECIO_PROCEDIMIENTO', 'sumProcedimientos')->get_where('temp_procedimiento', array('ID_SESSION' => $session))->row();

        $suma_productos = $productos->sumProductos;

        $suma_procedimientos = ($IsMembresia != "") ? 0 : $procedimientos->sumProcedimientos;

        $suma = $suma_productos + $suma_procedimientos + $PrecioConsulta;


        if ($descuento) {
            $desc = $suma * ($descuento / 100);
            $total = $suma - $desc;
            //$totalx = ($isTarifa != 1) ? $total : $total + $suma_productos;
            $totalx = $total;
        } else {
            $totalx = $suma;
        }

        $desc = (isset($desc)) ? $desc : 0;


        $data = array(
            'costo' => $suma,
            'desc' => $desc,
            'total' => $totalx
        );
        return $data;
    }

    function close_consult()
    {
        try {
            $id = $this->input->post('id_consulta');

            $this->db->where('ID_CONSULTA', $id);
            $this->db->update('consulta', array('CLOSE_CONSULTA' => 1));

            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    // TEMP PROCEDIMIENTOS
    function obtenerProcedimiento($var)
    {
        try {
            $this->db->select("*");
            $this->db->from('procedimiento');
            $this->db->where('descripcion_procedimiento', $var);
            $query = $this->db->get()->row();

            $data = array("row" => $query);
            echo json_encode($data);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function getProcedimientosPorTipo($id_tipo_consulta)
    {
        $this->db->select('p.id_procedimiento, p.descripcion_procedimiento');
        $this->db->from('tipo_consulta_procedimientos tcp');
        $this->db->join('procedimiento p', 'p.id_procedimiento = tcp.id_procedimiento');
        $this->db->where('tcp.id_tipo_consulta', $id_tipo_consulta);
        $query = $this->db->get();

        return $query->result_array();
    }

    function tempProcedimiento()
    {
        try {

            $precio = $this->input->post('COSTO_PROCEDIMIENTO');
            $cant_proc = $this->input->post('CANT_PROCEDIMIENTO');
            $nombre_proc = $this->input->post('NOMBRE_PROCEDIMIENTO');

            $exist = $this->db->get_where('temp_procedimiento', array('NOMBRE_PROCEDIMIENTO' => $nombre_proc, 'ID_SESSION' => $this->session->userdata('CAREYES_ID_USUARIO')))->row();

            if (count($exist) > 0) {
                $cant_db = $exist->CANT_PROCEDIMIENTO;
                $cant_total = $cant_proc + $cant_db;

                $precioXcant = $precio * $cant_total;
                /*  $_precioXcant= $precioXcant * ($tarifa / 100); */

                $this->db->where('NOMBRE_PROCEDIMIENTO', $nombre_proc);
                $this->db->where('ID_SESSION', $this->session->userdata('CAREYES_ID_USUARIO'));
                $this->db->update('temp_procedimiento', array('CANT_PROCEDIMIENTO' => $cant_total, "PRECIO_PROCEDIMIENTO" => $precioXcant));
            } else {
                $precioXcant = $precio * $cant_proc;
                /*  $_precioXcant= $precioXcant * ($tarifa / 100); */

                $data = array(
                    "ID_PROCEDIMIENTO" => $this->input->post('ID_PROCEDIMIENTO'),
                    "ID_SESSION" => $this->session->userdata('CAREYES_ID_USUARIO'),
                    "PRECIO_PROCEDIMIENTO" => $precioXcant,
                    "CANT_PROCEDIMIENTO" => $this->input->post('CANT_PROCEDIMIENTO'),
                    "NOMBRE_PROCEDIMIENTO" => $nombre_proc,
                );

                $this->db->insert('temp_procedimiento', $data);
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function get_tempProcedimientos()
    {
        $id_user = $this->session->userdata('CAREYES_ID_USUARIO');
        $data = $this->db->get_where('temp_procedimiento', array('ID_SESSION' => $id_user))->result();
        $suma = $this->db->select_sum('PRECIO_PROCEDIMIENTO')->get_where('temp_procedimiento', array('ID_SESSION' => $id_user))->row();

        $json = array('data' => $data, 'suma' => $suma);
        return $json;
    }

    function delete_temProcedimiento()
    {
        try {
            $id = $this->input->post('id_temp');

            $this->db->where('ID_TEMP', $id);
            $this->db->delete('temp_procedimiento');
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    // TEMP MATERIALES
    function obtenerProducto($var)
    {
        try {
            $this->db->select("*");
            $this->db->from('producto');
            $this->db->where('NOMBRE_PRODUCTO', $var);
            $this->db->where('ACTIVO_PRODUCTO', 1);
            $query = $this->db->get()->row();

            $data = array("row" => $query);
            echo json_encode($data);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function get_tempProductos()
    {
        $id_user = $this->session->userdata('CAREYES_ID_USUARIO');

        $data = $this->db->get_where('temp_producto', array('ID_SESSION' => $id_user))->result();
        $suma = $this->db->select_sum('PRECIO_PRODUCTO')->get_where('temp_producto', array('ID_SESSION' => $id_user))->row();

        $json = array('data' => $data, 'sumaProductos' => $suma);
        return $json;
    }

    function tempProducto()
    {
        try {

            if ($this->input->post('ID_TARIFA')) {
                $tarifa = $this->db->get_where('tarifa', array('ID_TARIFA' => $this->input->post('ID_TARIFA')))->row();
                $tarifa = $tarifa->PORCENTAJE_TARIFA;
            }

            $precio = $this->input->post('COSTO_PRODUCTO');
            $cant_producto = $this->input->post('CANT_PRODUCTO');
            $nombre_producto = $this->input->post('NOMBRE_PRODUCTO');

            $exist = $this->db->get_where('temp_producto', array('NOMBRE_PRODUCTO' => $nombre_producto, 'ID_SESSION' => $this->session->userdata('CAREYES_ID_USUARIO')))->row();

            if (count($exist) > 0) {
                $cant_db = $exist->CANT_PRODUCTO;
                $cant_total = $cant_producto + $cant_db;

                /* if(isset($tarifa)){
                  $precioXcant = $precio * $cant_total;
                  $descuento = $precioXcant * ($tarifa / 100);
                  $precioXcant = $precioXcant - $descuento;
                  }else{ */
                $precioXcant = $precio * $cant_total;
                /*      } */

                $this->db->where('NOMBRE_PRODUCTO', $nombre_producto);
                $this->db->where('ID_SESSION', $this->session->userdata('CAREYES_ID_USUARIO'));
                $this->db->update('temp_producto', array('CANT_PRODUCTO' => $cant_total, "PRECIO_PRODUCTO" => $precioXcant));
            } else {

                /* if(isset($tarifa)){
                  $precioXcant = $precio * $cant_producto;
                  $precioXcant = $precioXcant * ($tarifa / 100);
                  }else{ */
                $precioXcant = $precio * $cant_producto;
                /*  } */

                $data = array(
                    "ID_PRODUCTO" => $this->input->post('ID_PRODUCTO'),
                    "ID_SESSION" => $this->session->userdata('CAREYES_ID_USUARIO'),
                    "PRECIO_PRODUCTO" => $precioXcant,
                    "CANT_PRODUCTO" => $cant_producto,
                    "NOMBRE_PRODUCTO" => $nombre_producto,
                    //"CODIGO_PRODUCTO" => $codigo_producto,
                );
                $this->db->insert('temp_producto', $data);
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function delete_temProducto()
    {
        try {
            $id = $this->input->post('id_temp');

            $this->db->where('ID_TEMP', $id);
            $this->db->delete('temp_producto');
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    // MODAL FICHA CONSUMO
    function get_procedimientos()
    {
        try {
            $id_ficha = $this->input->post('id_ficha');
            $data = $this->db->get_where('rel_procedimiento_ficha', array('ID_FICHA' => $id_ficha))->result_array();
            return $data;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function get_productos()
    {
        try {
            $id_ficha = $this->input->post('id_ficha');
            $data = $this->db->get_where('rel_producto_ficha', array('ID_FICHA' => $id_ficha))->result_array();
            return $data;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function insert_relProcedimiento()
    {
        try {
            // Guardo las variables recibidas //
            $input_ficha = $this->input->post('id_ficha');
            $cantidad = $this->input->post('cantidad');
            /*  $id_tarifa        = $this->input->post('id_tarifa'); */
            $id_consulta = $this->input->post('id_consulta');
            $id_paciente = $this->input->post('id_paciente');
            $id_procedimiento = $this->input->post('id_procedimiento');
            $get_precio = $this->input->post('precio_proce');

            if ($input_ficha <= 0) {
                $values = array(
                    "ID_PACIENTE" => $id_paciente,
                    "ID_CONSULTA" => $id_consulta,
                    "FECHA_FICHA" => date('Y-m-d'),
                    "HR_FICHA" => date('H:i'),
                );
                $this->db->insert('ficha_consumo', $values);
                $id_ficha = $this->db->insert_id();
                $this->db->where('ID_CONSULTA', $id_consulta);
                $this->db->update('consulta', array('ID_FICHA' => $id_ficha));
            } else {
                $id_ficha = $input_ficha;
            }

            // Obtengo datos de las tablas procedimientos y tarifas
            /*  $row_tarifa        = $this->db->get_where('tarifa',array('ID_TARIFA' => $id_tarifa))->row();
              $tarifa = $row_tarifa->PORCENTAJE_TARIFA; */

            $row_procedimiento = $this->db->get_where('procedimiento', array('id_procedimiento' => $id_procedimiento))->row();
            /* $precio = $row_procedimiento->precio_procedimiento; */
            $precio = ($get_precio > 0) ? $get_precio : $row_procedimiento->precio_procedimiento;

            $exist = $this->db->get_where('rel_procedimiento_ficha', array('ID_PROCEDIMIENTO' => $id_procedimiento, 'ID_FICHA' => $id_ficha))->row();
            // Valido si existe el id procedimiento en la tabla rel_procedimiento
            if (count($exist) > 0) {

                $cant_db = $exist->CANT_PROCEDIMIENTO;
                $cant_total = $cantidad + $cant_db;

                $precioXcant = $precio * $cant_total;
                /*  $_precioXcant_= $precioXcant * ($tarifa / 100); */

                $this->db->where('ID_PROCEDIMIENTO', $id_procedimiento);
                $this->db->where('ID_FICHA', $id_ficha);
                $this->db->update('rel_procedimiento_ficha', array('CANT_PROCEDIMIENTO' => $cant_total, "PRECIO_PROCEDIMIENTO" => $precioXcant));
            } else {

                $precioXcant = $precio * $cantidad;
                /*  $_precioXcant_= $precioXcant * ($tarifa / 100); */

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

    function delete_relProcedimiento()
    {
        try {
            $id = $this->input->post('id_rel');
            $this->db->where('ID', $id);
            $this->db->delete('rel_procedimiento_ficha');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    function insert_relProducto()
    {
        try {

            if ($this->input->post('id_tarifa')) {
                $id_tarifa = $this->input->post('id_tarifa');
                $row_tarifa = $this->db->get_where('tarifa', array('ID_TARIFA' => $id_tarifa))->row();
                $tarifa = $row_tarifa->PORCENTAJE_TARIFA;
            }

            // Guardo las variables recibidas //
            $cantidad = $this->input->post('cantidad');
            $input_ficha = $this->input->post('id_ficha');
            $id_consulta = $this->input->post('id_consulta');
            $id_paciente = $this->input->post('id_paciente');
            $id_producto = $this->input->post('id_producto');
            log_message("error", "agregando producto ficha consumo id: " .  $input_ficha . ", id_usuario: " . $this->session->userdata('CAREYES_ID_USUARIO'));

            if ($input_ficha <= 0) {
                $values = array(
                    "ID_PACIENTE" => $id_paciente,
                    "ID_CONSULTA" => $id_consulta,
                    "FECHA_FICHA" => date('d-m-Y'),
                    "HR_FICHA" => date('H:i'),
                );
                $this->db->insert('ficha_consumo', $values);
                $id_ficha = $this->db->insert_id();
                $this->db->where('ID_CONSULTA', $id_consulta);
                $this->db->update('consulta', array('ID_FICHA' => $id_ficha));
            } else {
                $id_ficha = $input_ficha;
            }

            // Obtengo datos de las tablas productos y tarifas
            $row_producto = $this->db->get_where('producto', array('ID_PRODUCTO' => $id_producto))->row();
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

                /*  if(isset($tarifa)){
                  $precioXcant = $precio * $cant_total;
                  $precioXcant = $precioXcant * ($tarifa / 100);
                  }else{ */
                $precioXcant = $precio * $cant_total;
                /*  } */
                $this->db->where('ID_PRODUCTO', $id_producto);
                $this->db->where('ID_FICHA', $id_ficha);
                $this->db->update('rel_producto_ficha', array('CANT_PRODUCTO' => $cant_total, "PRECIO_PRODUCTO" => $precioXcant));
                $verify = 1;
            } else {
                /* if(isset($tarifa)){
                  $precioXcant = $precio * $cantidad;
                  $precioXcant = $precioXcant * ($tarifa / 100);
                  }else{ */
                $precioXcant = $precio * $cantidad;
                /*  } */

                $data = array(
                    'ID_FICHA' => $id_ficha,
                    'ID_PRODUCTO' => $row_producto->ID_PRODUCTO,
                    'NOMBRE_PRODUCTO' => $row_producto->NOMBRE_PRODUCTO,
                    'PRECIO_PRODUCTO' => $precioXcant,
                    'CANT_PRODUCTO' => $cantidad,
                );
                $this->db->insert('rel_producto_ficha', $data);
                log_message("error", "nuevos datos de stock de producto" . json_encode($data));
                $verify = 1;
            }

            if ($verify == 1) {
                $this->db->where('ID_PRODUCTO', $id_producto);
                $this->db->update('producto', array('STOCK_PRODUCTO' => $current_stock));
                log_message("error", "stock actualizado: " . $current_stock);
            }

            ///////////////////////////////////////////////////////////
            return $id_ficha;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function delete_relProducto()
    {
        try {
            $id_rel = $this->input->post('id_relP');

            $row_FichaProduct = $this->db->get_where('rel_producto_ficha', array('ID' => $id_rel))->row();
            $ID_PRODUCTO = $row_FichaProduct->ID_PRODUCTO;
            $CANT_PRODUCTO = $row_FichaProduct->CANT_PRODUCTO;
            log_message("error", "eliminando producto de ficha consumo id: " . $row_FichaProduct->ID_FICHA . " , id_producto: " . $ID_PRODUCTO . " , cantidad: " . $CANT_PRODUCTO . " , id_usuario: " . $this->session->userdata('CAREYES_ID_USUARIO'));

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

    function edit_desc_tarifa()
    {
        try {
            $data = array();
            if (!empty($this->input->post('desc'))) $data['DESC_TARIFA'] = $this->input->post('desc');
            if (!empty($this->input->post('TotPag'))) $data['TOTAL_PAGADO_CONSULTA'] = $this->input->post('TotPag');
            $data['FOLIO_CONSULTA'] = 0;
            if (intval($this->input->post('FolCon') > 0)) $data['FOLIO_CONSULTA'] = intval($this->input->post('FolCon'));
            if (intval($this->input->post('FolConM') > 0)) $data['FOLIO_CONSULTA'] = intval($this->input->post('FolConM'));

            $ficha = $this->input->post('ficha');

            $findFolio = $this->db->get_where("consulta", array("ID_CONSULTA <>" . $this->input->post('consulta') . "FOLIO_CONSULTA =" => $data['FOLIO_CONSULTA']))->num_rows();
            if ($findFolio <= 0 || intval($data['FOLIO_CONSULTA'] == 0)) {
                if ($ficha > 0) {
                    $this->db->where('ID_FICHA', $ficha);
                    $this->db->update('consulta', $data);

                    return "bien";
                } else {
                    return 'no ficha';
                }
            } else {
                if ($findFolio > 0 && intval($data['FOLIO_CONSULTA']) > 0) {
                    return 'repetido';
                } else {
                    return "error";
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    // MODAL ADJUNTAR ARCHIVO
    function delete_file_by_id($ID_DOCUMENTO)
    {
        try {

            $this->db->where('ID_DOCUMENTO', $ID_DOCUMENTO);
            $this->db->delete('DOCUMENTO');
            return $this->db->affected_rows();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function get_files_consult_on_db($ID_CONSULTA)
    {
        try {
            $this->db->where('D.ID_CONSULTA', $ID_CONSULTA);
            $this->db->from('DOCUMENTO AS D');
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function insert_file_by_consult_id($ROW)
    {
        try {
            $data = array(
                //'ID_MEMBRESIA' => $row['ID_MEMBRESIA'],
                'ID_CONSULTA' => intval($ROW['ID_CONSULTA']),
                'TIPO_DOCUMENTO' => trim($ROW['TIPO_DOCUMENTO']),
                'NOMBRE_DOCUMENTO' => $ROW['NOMBRE_DOCUMENTO'],
                'FECHA_CREACION_DOCUMENTO' => date("Y-m-d H:i:s")
            );
            $this->db->insert('DOCUMENTO', $data);
            return $this->db->insert_id();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // PDF IMRESIÓN
    function get_consult_by_id_consult($ID_CONSULT)
    {
        try {
            $this->db->select("*, c.ID_TARIFA as TARIFA2, c.ID_MEMBRESIA as MEMBRECIA2");
            $this->db->from('consulta as c');
            $this->db->join('usuario as u', 'c.ID_MEDICO=u.ID_USUARIO');
            $this->db->join('paciente as p', 'c.ID_PACIENTE=p.ID_PACIENTE');
            //$this->db->join('tarifa as t', 'c.ID_TARIFA=t.ID_TARIFA');
            $this->db->join('sexo as s', 'p.ID_SEXO=s.ID_SEXO');
            $this->db->join('sangre as sa', 'p.ID_SANGRE=sa.id_sangre');
            $this->db->where('c.ID_CONSULTA', $ID_CONSULT);

            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function get_tratamientos_by_id_consult($ID_CONSULT)
    {
        try {
            $this->db->select("*");
            $this->db->from('tratamientos_aplicados_consulta as tac');
            $this->db->where('tac.ID_CONSULTA', $ID_CONSULT);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function get_procedimiento_by_consult_id($ID_CONSULT)
    {
        try {
            $this->db->select("*");
            $this->db->from('consulta as c');
            $this->db->join('ficha_consumo as fc', 'c.ID_FICHA=fc.ID_FICHA');
            $this->db->join('rel_procedimiento_ficha as rpf', 'fc.ID_FICHA=rpf.ID_FICHA');
            $this->db->where('c.ID_CONSULTA', $ID_CONSULT);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function get_producto_by_consult_id($ID_CONSULT)
    {
        try {
            $this->db->select("*");
            $this->db->from('consulta as c');
            $this->db->join('ficha_consumo as fc', 'c.ID_FICHA=fc.ID_FICHA');
            $this->db->join('rel_producto_ficha as rp', 'rp.ID_FICHA=fc.ID_FICHA');
            $this->db->where('c.ID_CONSULTA', $ID_CONSULT);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    function get_sum($ID_FICHA)
    {
        try {
            $this->db->select_sum('PRECIO_PROCEDIMIENTO', 'suma');
            $this->db->where('ID_FICHA', $ID_FICHA);
            $suma = $this->db->get('rel_procedimiento_ficha')->result_array();
            return $suma;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function get_sum_ficha($ID_FICHA)
    {
        try {
            $this->db->select_sum('PRECIO_PRODUCTO', 'sumaficha');
            $this->db->where('ID_FICHA', $ID_FICHA);
            $suma = $this->db->get('rel_producto_ficha')->result_array();
            return $suma;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function get_urgency_by_id($ID_URGENCY)
    {
        try {
            $this->db->select("*, u.ID_TARIFA as TARIFA2, u.ID_MEMBRESIA as MEMBRESIA2");
            $this->db->from('urgencia as u');
            $this->db->join('usuario as us', 'u.ID_MEDICO=us.ID_USUARIO');
            $this->db->join('paciente as p', 'u.ID_PACIENTE=p.ID_PACIENTE');
            $this->db->join('sexo as s', 'p.ID_SEXO=s.ID_SEXO');
            //$this->db->join('tarifa as t', 'u.ID_TARIFA=t.ID_TARIFA');
            $this->db->where('u.ID_URGENCIA', $ID_URGENCY);

            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function get_procedimiento_by_urgency_id($ID_URGENCY)
    {
        try {
            $this->db->select("*");
            $this->db->from('urgencia as u');
            $this->db->join('ficha_consumo as fc', 'u.ID_FICHA=fc.ID_FICHA');
            $this->db->join('rel_procedimiento_ficha as rpf', 'fc.ID_FICHA=rpf.ID_FICHA');
            $this->db->where('u.ID_URGENCIA', $ID_URGENCY);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function get_producto_by_urgency_id($ID_URGENCY)
    {
        try {
            $this->db->select("*");
            $this->db->from('urgencia as u');
            $this->db->join('ficha_consumo as fc', 'u.ID_FICHA=fc.ID_FICHA');
            $this->db->join('rel_producto_ficha as rp', 'fc.ID_FICHA=rp.ID_FICHA');
            $this->db->where('u.ID_URGENCIA', $ID_URGENCY);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    // SERVERSIDE CONSULTAS //
    function make_query()
    {
        //$pacientes = $this->db->get_where('paciente', array('ACTIVO_PACIENTE' => 1))->result_array();

        $order_column = array(NULL, NULL,NULL, NULL, NULL, NULL, NULL, NULL);
        $this->db->select('consulta.*, paciente.NOMBRE_PACIENTE, paciente.APELLIDO_PATERNO_PACIENTE, paciente.APELLIDO_MATERNO_PACIENTE, usuario.NOMBRE_USUARIO, tarifa.NOMBRE_TARIFA, membresia.NOMBRE_MEMBRESIA, tipo_consulta.nombre_tipo_consulta');
        $this->db->from('consulta');
        $this->db->join('paciente', 'paciente.ID_PACIENTE = consulta.ID_PACIENTE');
        $this->db->join('tipo_consulta', 'consulta.ID_TIPO_CONSULTA = tipo_consulta.id_tipo_consulta', 'left');
        $this->db->join('usuario', 'usuario.ID_USUARIO = consulta.ID_MEDICO');
        $this->db->join('tarifa', 'tarifa.ID_TARIFA = consulta.ID_TARIFA', 'left');
        $this->db->join('membresia', 'membresia.ID_MEMBRESIA = consulta.ID_MEMBRESIA', 'left');
        $this->db->join('VIGENCIA as v', 'consulta.VIGENCIA_CONSULTA = v.VIGENCIA');
        $this->db->where('VIGENCIA_CONSULTA', 1);


        if (!empty($_POST["search"]["value"] != "")) {
            $search_value = $_POST["search"]["value"];

            $this->db->like("CONCAT(paciente.NOMBRE_PACIENTE, ' ', `paciente`.`APELLIDO_PATERNO_PACIENTE`, ' ', `paciente`.APELLIDO_MATERNO_PACIENTE)", $search_value);

            $this->db->or_like("NOMBRE_USUARIO", $search_value);
            $this->db->or_like("APELLIDO_USUARIO", $search_value);

            $this->db->or_like("FECHA_CONSULTA", $search_value);
            $this->db->or_like("MOTIVO_CONSULTA", $search_value);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($order_column[$_POST["order"]['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by("ID_CONSULTA", "DESC");
        }
    }

    function make_datatables()
    {
        $this->make_query();

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST["length"], $_POST["start"]);
        }
        $query = $this->db->get()->result_array();
        return $query;
    }

    function get_all_data()
    {
        $this->db->select("*");
        $this->db->where('VIGENCIA_CONSULTA', 1);
        $this->db->from("consulta");
        /* $this->db->get('urgencias')->num_rows(); */
        return $this->db->count_all_results();
    }

    function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_consults()
    {
        $fetch_data = $this->mconsult->make_datatables();
        $total_consults = $this->mconsult->get_all_data();
        $filtered_consults = $this->mconsult->get_filtered_data();
        $data = array();

        foreach ($fetch_data as $row) {
            $type = ($row['NOMBRE_TARIFA']) ? $row['NOMBRE_TARIFA'] : $row['NOMBRE_MEMBRESIA'];
            $status = ($row['CLOSE_CONSULTA']) <= 0 ? "Abierta" : "Cerrada";
            $badge = ($row['CLOSE_CONSULTA']) <= 0 ? "badge-open" : "badge-close";

            if (isset($row['ID_TARIFA'])) {
                $PrecioConsulta = $this->db->select('CONSULTA_TARIFA,NOMBRE_TARIFA')->get_where('tarifa', array('ID_TARIFA' => $row['ID_TARIFA']))->row();
                $PrecioC = $PrecioConsulta->CONSULTA_TARIFA;
                $NameTarifa = $PrecioConsulta->NOMBRE_TARIFA;
            } else {
                $PrecioC = floatval(0.00);
                $NameTarifa = "";
            }

            $actions = '
<div class="dropdown">
    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton_'.$row['ID_CONSULTA'].'" 
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Acciones">
        <i class="fas fa-ellipsis-v"></i>
    </button>
    <ul class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuButton_'.$row['ID_CONSULTA'].'" style="right: auto; left: 40px; transform: translateX(-25%);"  >
        <li>
            <a id="BTN_RECETA_'.$row['ID_CONSULTA'].'" class="btn-receta-show" 
                title="Imprimir Receta" data-toggle="tooltip"
                data-id_consulta="'.$row['ID_CONSULTA'].'"
                data-id_paciente="'.$row['ID_PACIENTE'].'">
                <i class="fas fa-print fa-fw" style="margin-right: 8px;"></i>
                Imprimir Receta
            </a>
        </li>
        <li>
            <a id="BTN_RECETA_VER_'.$row['ID_CONSULTA'].'" class="btn-receta-ver" 
                title="Ver Receta" data-toggle="tooltip"
                data-id_consulta="'.$row['ID_CONSULTA'].'"
                data-id_paciente="'.$row['ID_PACIENTE'].'">
                <i class="fas fa-eye fa-fw" style="margin-right: 8px;"></i>
                Ver Receta
            </a>
        </li>
        <li>
            <a id="BTN_HISTORIA_CLINICA_'.$row['ID_CONSULTA'].'" class="btn_hist_clinica" 
                title="Historia clínica" data-toggle="tooltip"
                data-id_consulta="'.$row['ID_CONSULTA'].'"
                data-id_paciente="'.$row['ID_PACIENTE'].'">
                <i class="fas fa-history fa-fw" style="margin-right: 8px;"></i>
                Historia Clínica
            </a>
        </li>
        <li>
            <a id="BTN_IMPRIMIR_HISTORIAL_'.$row['ID_CONSULTA'].'" class="btn_impr_clinica" 
                title="Imprimir historia clínica" data-toggle="tooltip"
                data-id_consulta="'.$row['ID_CONSULTA'].'"
                data-id_paciente="'.$row['ID_PACIENTE'].'">
                <i class="fas fa-print fa-fw" style="margin-right: 8px;"></i>
                Imprimir Historial
            </a>
        </li>
        <li>
            <a id="BTN_CONSENTIMIENTO_'.$row['ID_CONSULTA'].'" class="btn_consentimiento" 
                title="Consentimiento" data-toggle="tooltip"
                data-id_consulta="'.$row['ID_CONSULTA'].'"
                data-id_paciente="'.$row['ID_PACIENTE'].'">
                <i class="fas fa-info fa-fw" style="margin-right: 8px;"></i>
                Consentimiento
            </a>
        </li>
        <li>
            <a id="BTN_IMPRIMIR_CONSENTIMIENTO_'.$row['ID_CONSULTA'].'" class="btn_impr_consentimiento" 
                title="Imprimir consentimiento" data-toggle="tooltip"
                data-id_consulta="'.$row['ID_CONSULTA'].'"
                data-id_paciente="'.$row['ID_PACIENTE'].'">
                <i class="fas fa-print fa-fw" style="margin-right: 8px;"></i>
                Imprimir Consentimiento
            </a>
        </li>
        <li>
            <a id="BTN_ADJUNTAR_ARCHIVO_'.$row['ID_CONSULTA'].'" class="" href="#modAddFiles"
                data-toggle="modal" title="Adjuntar archivo"
                data-id_consult="'.$row['ID_CONSULTA'].'">
                <i class="fas fa-file-medical fa-fw" style="margin-right: 8px;"></i>
                Adjuntar Archivo
            </a>
        </li>'.
    
        /*<button id='BTN_FICHA_CLINICA'  class='btn btn-defaultx' type='button'
               title='Ficha Diagnóstico' data-toggle='tooltip'
               data-id_tarifa='" . $row['ID_TARIFA'] . "'
               data-id_consulta='" . $row['ID_CONSULTA'] . "'
               data-id_paciente='" . $row['ID_PACIENTE'] . "'>
               <i class='fas fa-file-contract fa-x'></i>
            </button>
           

            <button id='BTN_FICHA_CONSUMO' class='btn btn-defaultz' title='Ficha consumo' data-toggle='tooltip'
               data-nombre_paciente='" . $row['NOMBRE_PACIENTE'] . "'
               data-id_paciente='" . $row['ID_PACIENTE'] . "'
               data-id_consulta='" . $row['ID_CONSULTA'] . "'
               data-id_ficha='" . $row['ID_FICHA'] . "'
               data-precio_consult='" . $PrecioC . "'
               data-close='" . $row['CLOSE_CONSULTA'] . "'
               data-desc_tarifa='" . $row['DESC_TARIFA'] . "'
               data-membresia='" . $row['NOMBRE_MEMBRESIA'] . "'
               data-tarifa='" . $NameTarifa . "'
               data-folio='" . $row['FOLIO_CONSULTA'] . "'
               data-folio_m='" . $row['FOLIO_CONSULTA'] . "'
               data-id_tarifa='" . $row['ID_TARIFA'] . "'>
               <i class='fas fa-file-invoice fa-x' aria-hidden='true'></i>
            </button>*/

        '<li class="divider"></li>
        <li>
            <a id="BTN_ELIMINAR_CONSULTA_'.$row['ID_CONSULTA'].'" class="text-danger"
                title="Eliminar consulta" data-toggle="tooltip"
                data-id-consult="'.$row['ID_CONSULTA'].'">
                <i class="fas fa-trash fa-fw" style="margin-right: 8px;"></i>
                Eliminar Consulta
            </a>
        </li>
    </ul>
</div>';

            $sub_array = array();

            $sub_array[] = $actions;
            $sub_array[] = "<span class='" . $badge . "'>" . $status . "</span>";
            $sub_array[] = $row['NOMBRE_PACIENTE'] . " " . $row['APELLIDO_PATERNO_PACIENTE'] . " " . $row['APELLIDO_MATERNO_PACIENTE'];
            $sub_array[] = $row['NOMBRE_USUARIO'];
            $sub_array[] = $row['nombre_tipo_consulta'];
            $sub_array[] = $row['FECHA_CONSULTA'];
            $sub_array[] = $row['HORA_CONSULTA'];
            $sub_array[] = $type;

            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST['draw']),
            "recordsTotal" => $total_consults,
            "recordsFiltered" => $filtered_consults,
            "data" => $data
        );

        return $output;
    }
}

/* End of file Mconsult.php */