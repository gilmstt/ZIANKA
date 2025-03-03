<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mreport extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->helper('general');
    }

    /* 	Busca y filtra las fichas por fecha, regresa un solo array con los Id
     */

    function obtenerFichas($fechas) {
        try {
            $this->db->select("ID_FICHA");
            $this->db->from("ficha_consumo");
            $this->db->where("FECHA_FICHA >=", $fechas["inicio"]);
            $this->db->where("FECHA_FICHA <=", $fechas["final"]);
            $ids = $this->db->get()->result_array();

            if (count($ids) > 0) {
                $idList = [];
                foreach ($ids as $id)
                    array_push($idList, $id["ID_FICHA"]);
                return $idList;
            }
        } catch (Exception $ex) {
            // ???
        }
        return array();
    }

    /* 	Busqueda de procedimientos respecto al id de las fichas (array),
      suma la cantidad y precio, los agrupa por el nombre.
     */

    function informacionProcedimientos($fichaId) {
        try {
            if (count($fichaId) > 0) {
                $this->db->select(
                        "rel.NOMBRE_PROCEDIMIENTO, SUM(rel.CANT_PROCEDIMIENTO), SUM(rel.PRECIO_PROCEDIMIENTO)"
                );
                $this->db->from("rel_procedimiento_ficha as rel");
                $this->db->where_in("ID_FICHA", $fichaId);
                $this->db->group_by("NOMBRE_PROCEDIMIENTO");
                return $this->db->get()->result_array();
            }
        } catch (Exception $e) {
            // ???
        }
        return array();
    }

    /* 	Busqueda de productos respecto al id de las fichas (array),
      suma la cantidad, costo y precio, los agrupa por el nombre.
     */

    function informacionProductos($fichaId) {
        try {
            if (count($fichaId) > 0) {
                $this->db->select(
                        "rel.NOMBRE_PRODUCTO, SUM(rel.CANT_PRODUCTO), SUM(rel.PRECIO_PRODUCTO)"
                );
                $this->db->from("rel_producto_ficha as rel");
                $this->db->where_in("ID_FICHA", $fichaId);
                $this->db->group_by("NOMBRE_PRODUCTO");
                return $this->db->get()->result_array();
            }
        } catch (Exception $e) {
            // ???
        }
        return array();
    }

    /* 	Funciones para el auto-complete del medico
     */

    function obtenerApMedico() {
        try {
            $this->db->distinct();
            $this->db->select("APELLIDO_USUARIO");
            $this->db->from('usuario');
            $this->db->where('ID_ROL', 4);
            $this->db->where('VIGENCIA_USUARIO', 1);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            // ???
        }
        return array();
    }

    function obtenerNomMedico($ap) {
        try {
            $this->db->distinct();
            $this->db->select("NOMBRE_USUARIO");
            $this->db->from('usuario AS u');
            $this->db->where('u.APELLIDO_USUARIO', $ap);
            $this->db->where('ID_ROL', 4);
            $this->db->where('VIGENCIA_USUARIO', 1);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            // ???
        }
        return array();
    }
    
    function get_consults_houses_by_dates($dates) {
        try {
            $this->db->select("COUNT(c.ID_CONSULTA) as suma, p.ID_CASA, ca.NOMBRE_CASA");
            $this->db->from('consulta as c');
            $this->db->join('paciente as p','c.ID_PACIENTE=p.ID_PACIENTE');
            $this->db->join('casas as ca','ca.ID_CASA=p.ID_CASA');
            $this->db->where('c.FECHA_CONSULTA >= "'. $dates['FECHAINI'] . '"');
            $this->db->where('c.FECHA_CONSULTA <= "'. $dates['FECHAFIN'] . '"');
           // $this->db->where('VIGENCIA_PACIENTE', 1);
            $this->db->group_by('p.ID_CASA');
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            // ???
        }
        return array();
    }
    function get_urgencies_houses_by_dates($dates) {
        try {
            $this->db->select("COUNT(u.ID_URGENCIA) as suma, p.ID_CASA, ca.NOMBRE_CASA");
            $this->db->from('urgencia as u');
            $this->db->join('paciente as p','u.ID_PACIENTE=p.ID_PACIENTE');
            $this->db->join('casas as ca','ca.ID_CASA=p.ID_CASA');
            $this->db->where('u.FECHA_URGENCIA >= "'. $dates['FECHAINI'] . '"');
            $this->db->where('u.FECHA_URGENCIA <= "' . $dates['FECHAFIN']. '"');
            $this->db->group_by('p.ID_CASA');
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            // ???
        }
        return array();
    }

    /* 	Funciones para el auto-complete del paciente
     */

    function obtenerAppPaciente() {
        try {
            $this->db->distinct();
            $this->db->select("APELLIDO_PATERNO_PACIENTE");
            $this->db->from('paciente');
            $this->db->where('ACTIVO_PACIENTE', 1);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            // ???
        }
        return array();
    }

    function obtenerApmPaciente($app) {
        try {
            $this->db->distinct();
            $this->db->select("APELLIDO_MATERNO_PACIENTE");
            $this->db->from('paciente AS p');
            $this->db->where('p.APELLIDO_PATERNO_PACIENTE', $app);
            $this->db->where('ACTIVO_PACIENTE', 1);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            // ???
        }
        return array();
    }

    function obtenerNomPaciente($app, $apm) {
        try {
            $this->db->distinct();
            $this->db->select("NOMBRE_PACIENTE");
            $this->db->from('paciente AS p');
            $this->db->where('p.APELLIDO_PATERNO_PACIENTE', $app);
            $this->db->where('p.APELLIDO_MATERNO_PACIENTE', $apm);
            $this->db->where('ACTIVO_PACIENTE', 1);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $ex) {
            // ???
        }
        return array();
    }

    /* 	Busca el ID del paciente o pacientes dependiendo de la informacion ingresada
     * 	y regresa los ID dentro de un mismo array, sin keys.
     */

    function obtenerPacientes($datos) {
        try {
            if (hasInfo($datos)) {
                $this->db->select("ID_PACIENTE");
                $this->db->from("paciente");

                if ($datos['app'] != '')
                    $this->db->where("APELLIDO_PATERNO_PACIENTE", $datos['app']);
                if ($datos['apm'] != '')
                    $this->db->where("APELLIDO_MATERNO_PACIENTE", $datos['apm']);
                if ($datos['nom'] != '')
                    $this->db->where("NOMBRE_PACIENTE", $datos['nom']);
                $this->db->where("ACTIVO_PACIENTE", 1);
                $ids = $this->db->get()->result_array();

                if (count($ids) > 0) {
                    $idList = [];
                    foreach ($ids as $id)
                        array_push($idList, $id["ID_PACIENTE"]);
                    return $idList;
                }
            }
        } catch (Exception $e) {
            // ???
        }
        return array();
    }

    /* 	Busca el ID del medico o medicos dependiendo de la informacion ingresada
     * 	y regresa los ID dentro de un mismo array, sin keys.
     */

    function obtenerMedicos($datos) {
        try {
            if (hasInfo($datos)) {
                $this->db->select("ID_USUARIO");
                $this->db->from("usuario");

                if ($datos['ap'] != '')
                    $this->db->where("APELLIDO_USUARIO", $datos['ap']);
                if ($datos['nom'] != '')
                    $this->db->where("NOMBRE_USUARIO", $datos['nom']);
                $this->db->where("VIGENCIA_USUARIO", 1);
                $ids = $this->db->get()->result_array();

                if (count($ids) > 0) {
                    $idList = [];
                    foreach ($ids as $id)
                        array_push($idList, $id["ID_USUARIO"]);
                    return $idList;
                }
            }
        } catch (Exception $e) {
            // ???
        }
        return array();
    }

    /* 	Busca y regresa los registros de la tabla especificada
     */

    function obtenerRegistros($arrayID, $select, $table, $column) {
        if (!empty($arrayID)) {
            try {
                $this->db->select($select);
                $this->db->from($table);
                $this->db->where_in($column, $arrayID);
                $ids = $this->db->get()->result_array();

                if (count($ids) > 0) {
                    $idList = [];
                    foreach ($ids as $id)
                        array_push($idList, $id[$select]);
                    return $idList;
                }
            } catch (Exception $e) {
                // ???
            }
        }
        return array();
    }

    /* 	Regresa la informacion de las consultas para mostrar en la pagina
     */

    function InformacionConsultas($consultaId, $fechas, $tipo_descuento = 1, $tarifa = 0, $membresia = 0) {
        if (!empty($consultaId)) {
            try {
                $this->db->select(
                        "*"
                );

                $this->db->from("consulta as c");
                $this->db->join("paciente as p", "c.ID_PACIENTE = p.ID_PACIENTE", "INNER");
                $this->db->join("usuario as u", "c.ID_MEDICO = u.ID_USUARIO", "INNER");
                if ($tipo_descuento == 0) {
                    $this->db->join("tarifa as t", "c.ID_TARIFA = t.ID_TARIFA", "left");
                    $this->db->join("membresia as m", "c.ID_MEMBRESIA = m.ID_MEMBRESIA", "left");
                }
                if ($tipo_descuento == 1)
                    $this->db->join("tarifa as t", "c.ID_TARIFA = t.ID_TARIFA", "INNER");
                if ($tipo_descuento == 2)
                    $this->db->join("membresia as m", "c.ID_MEMBRESIA = m.ID_MEMBRESIA", "INNER");
                $this->db->where("FECHA_CONSULTA >=", $fechas["inicio"]);
                $this->db->where("FECHA_CONSULTA <=", $fechas["final"]);
                $this->db->where("p.ACTIVO_PACIENTE", 1);
                $this->db->where("VIGENCIA_CONSULTA", 1);
                if ($tipo_descuento == 1 && $tarifa > 0)
                    $this->db->where("c.ID_TARIFA", $tarifa);
                if ($tipo_descuento == 2 && $membresia > 0)
                    $this->db->where("c.ID_MEMBRESIA", $membresia);
                /* $this->db->join("tarifa as t", "c.ID_TARIFA = t.ID_TARIFA", "INNER");
                  $this->db->join("tarifa as t", "c.ID_TARIFA = t.ID_TARIFA", "left");
                  $this->db->join("membresia as m", "c.ID_MEMBRESIA = m.ID_MEMBRESIA", "left");


                  if (count($consultaId) > 0)
                  $this->db->where_in("ID_CONSULTA", $consultaId);
                  $this->db->where("FECHA_CONSULTA >=", $fechas["inicio"]);
                  $this->db->where("FECHA_CONSULTA <=", $fechas["final"]);
                  $this->db->where("p.ACTIVO_PACIENTE", 1);
                  $this->db->where("VIGENCIA_CONSULTA", 1);
                  if ($tarifa != '')
                  $this->db->where("c.ID_TARIFA", $tarifa); */

                return $this->db->get()->result_array();
            } catch (Exception $e) {
                // ???
            }
        }
        return array();
    }

    function InformacionConsultaPaciente($paciente) {

        try {
            $this->db->select(
                    "*"
            );

            $this->db->from("consulta as c");
            $this->db->join("paciente as p", "c.ID_PACIENTE = p.ID_PACIENTE", "INNER");
            $this->db->join("usuario as u", "c.ID_MEDICO = u.ID_USUARIO", "INNER");
            $this->db->join("tarifa as t", "c.ID_TARIFA = t.ID_TARIFA", "left");
            $this->db->join("membresia as m", "c.ID_MEMBRESIA = m.ID_MEMBRESIA", "left");
            $this->db->like("p.APELLIDO_PATERNO_PACIENTE", $paciente['app']);
            $this->db->like("p.APELLIDO_MATERNO_PACIENTE", $paciente['apm']);
            $this->db->like("p.NOMBRE_PACIENTE", $paciente['nom']);
            $this->db->where("p.ACTIVO_PACIENTE", 1);
            $this->db->where("VIGENCIA_CONSULTA", 1);

            return $this->db->get()->result_array();
        } catch (Exception $e) {
            // ???
        }

        return array();
    }
    function InformacionUrgenciaPaciente($paciente) {

        try {
            $this->db->select(
                    "*"
            );

            $this->db->from("urgencia as u");
            $this->db->join("paciente as p", "u.ID_PACIENTE = p.ID_PACIENTE", "INNER");
            $this->db->join("usuario as us", "u.ID_MEDICO = us.ID_USUARIO", "INNER");
            $this->db->join("tarifa as t", "u.ID_TARIFA = t.ID_TARIFA", "left");
            $this->db->join("membresia as m", "u.ID_MEMBRESIA = m.ID_MEMBRESIA", "left");
            $this->db->like("p.APELLIDO_PATERNO_PACIENTE", $paciente['app']);
            $this->db->like("p.APELLIDO_MATERNO_PACIENTE", $paciente['apm']);
            $this->db->like("p.NOMBRE_PACIENTE", $paciente['nom']);
            $this->db->where("p.ACTIVO_PACIENTE", 1);
            $this->db->where("VIGENCIA_URGENCIA", 1);

            return $this->db->get()->result_array();
        } catch (Exception $e) {
            // ???
        }

        return array();
    }

    function InformacionUrgencias($urgenciaId, $fechas, $tarifa) {
        if ($urgenciaId != null) {
            try {
                $this->db->select(
                        "p.NOMBRE_PACIENTE, u.NOMBRE_USUARIO, t.NOMBRE_TARIFA,
					ur.MOTIVO_URGENCIA, ur.FECHA_URGENCIA, ur.HORA_URGENCIA"
                );

                $this->db->from("urgencia as ur");
                $this->db->join("paciente as p", "ur.ID_PACIENTE = p.ID_PACIENTE", "INNER");
                $this->db->join("usuario as u", "ur.ID_MEDICO = u.ID_USUARIO", "INNER");
                $this->db->join("tarifa as t", "ur.ID_TARIFA = t.ID_TARIFA", "INNER");

                if (count($urgenciaId) > 0)
                $this->db->where_in("ur.ID_URGENCIA", $urgenciaId);
                $this->db->where("FECHA_URGENCIA >=", $fechas["inicio"]);
                $this->db->where("FECHA_URGENCIA <=", $fechas["final"]);
                $this->db->where("p.ACTIVO_PACIENTE", 1);
                $this->db->where("VIGENCIA_URGENCIA", 1);
                if ($tarifa != '')
                    $this->db->where("ur.ID_TARIFA", $tarifa);

                return $this->db->get()->result_array();
            } catch (Exception $e) {
                // ???
            }
        }
        return array();
    }

    function todasConsultas($fechas, $tipo_descuento = 1, $tarifa = 0, $membresia = 0) {
        try {
            // return "ok";
            $this->db->select("*");
            $this->db->from("consulta as c");
            $this->db->join("paciente as p", "c.ID_PACIENTE = p.ID_PACIENTE", "INNER");
            $this->db->join("usuario as u", "c.ID_MEDICO = u.ID_USUARIO", "INNER");
            if ($tipo_descuento == 0) {
                $this->db->join("tarifa as t", "c.ID_TARIFA = t.ID_TARIFA", "left");
                $this->db->join("membresia as m", "c.ID_MEMBRESIA = m.ID_MEMBRESIA", "left");
            }
            if ($tipo_descuento == 1)
                $this->db->join("tarifa as t", "c.ID_TARIFA = t.ID_TARIFA", "INNER");
            if ($tipo_descuento == 2)
                $this->db->join("membresia as m", "c.ID_MEMBRESIA = m.ID_MEMBRESIA", "INNER");
            $this->db->where("FECHA_CONSULTA >=", $fechas["inicio"]);
            $this->db->where("FECHA_CONSULTA <=", $fechas["final"]);
            $this->db->where("p.ACTIVO_PACIENTE", 1);
            $this->db->where("VIGENCIA_CONSULTA", 1);
            if ($tipo_descuento == 1 && $tarifa > 0)
                $this->db->where("c.ID_TARIFA", $tarifa);
            if ($tipo_descuento == 2 && $membresia > 0)
                $this->db->where("c.ID_MEMBRESIA", $membresia);

            return $this->db->get()->result_array();
        } catch (Exception $e) {
            // ???
        }

        return array();
    }

    function todasUrgencias($fechas, $tipo_descuento = 1, $tarifa = 0, $membresia = 0) {
        try {
            $this->db->select( "*" );

            $this->db->from("urgencia as ur");
            $this->db->join("paciente as p", "ur.ID_PACIENTE = p.ID_PACIENTE", "INNER");
            $this->db->join("usuario as u", "ur.ID_MEDICO = u.ID_USUARIO", "INNER");
            if ($tipo_descuento == 0) {
                $this->db->join("tarifa as t", "ur.ID_TARIFA = t.ID_TARIFA", "left");
                $this->db->join("membresia as m", "ur.ID_MEMBRESIA = m.ID_MEMBRESIA", "left");
            }
            if ($tipo_descuento == 1)
                $this->db->join("tarifa as t", "ur.ID_TARIFA = t.ID_TARIFA", "INNER");
            if ($tipo_descuento == 2)
                $this->db->join("membresia as m", "ur.ID_MEMBRESIA = m.ID_MEMBRESIA", "INNER");
            $this->db->where("FECHA_URGENCIA >=", $fechas["inicio"]);
            $this->db->where("FECHA_URGENCIA <=", $fechas["final"]);
            $this->db->where("p.ACTIVO_PACIENTE", 1);
            $this->db->where("VIGENCIA_URGENCIA", 1);
            if ($tipo_descuento == 1 && $tarifa > 0)
                $this->db->where("ur.ID_TARIFA", $tarifa);
            if ($tipo_descuento == 2 && $membresia > 0)
                $this->db->where("ur.ID_MEMBRESIA", $membresia);

            return $this->db->get()->result_array();
        } catch (Exception $e) {
            // ???
        }
        return array();
    }
    function get_pacient_by_id($ID_PACIENTE){
      try {
         $this->db->select("*");
         $this->db->from('paciente as p');
         $this->db->join("sexo as s", "s.ID_SEXO = p.ID_SEXO");
         $this->db->join("antecedentes as a","a.ID_PACIENTE = p.ID_PACIENTE");
         $this->db->where("p.ID_PACIENTE", $ID_PACIENTE);
         $query = $this->db->get();
         return $query->result_array();
      } catch (Exception $ex) {
         return $e->getMessage();
      }
   }
   function InformacionConsultaPacienteId($id_paciente) {

        try {
            $this->db->select(
                    "*"
            );

            $this->db->from("consulta as c");
            $this->db->join("paciente as p", "c.ID_PACIENTE = p.ID_PACIENTE", "INNER");
            $this->db->join("usuario as u", "c.ID_MEDICO = u.ID_USUARIO", "INNER");
            $this->db->join("tarifa as t", "c.ID_TARIFA = t.ID_TARIFA", "left");
            $this->db->join("membresia as m", "c.ID_MEMBRESIA = m.ID_MEMBRESIA", "left");
            $this->db->where("p.id_paciente", $id_paciente);
            $this->db->where("p.ACTIVO_PACIENTE", 1);
            $this->db->where("VIGENCIA_CONSULTA", 1);

            return $this->db->get()->result_array();
        } catch (Exception $e) {
            // ???
        }

        return array();
    }
    
    function InformacionUrgenciaPacienteId($id_paciente) {

        try {
            $this->db->select(
                    "*"
            );

            $this->db->from("urgencia as ur");
            $this->db->join("paciente as p", "ur.ID_PACIENTE = p.ID_PACIENTE", "INNER");
            $this->db->join("usuario as u", "ur.ID_MEDICO = u.ID_USUARIO", "INNER");
            $this->db->join("tarifa as t", "ur.ID_TARIFA = t.ID_TARIFA", "left");
            $this->db->join("membresia as m", "ur.ID_MEMBRESIA = m.ID_MEMBRESIA", "left");
            $this->db->where("p.id_paciente", $id_paciente);
            $this->db->where("p.ACTIVO_PACIENTE", 1);
            $this->db->where("VIGENCIA_URGENCIA", 1);

            return $this->db->get()->result_array();
        } catch (Exception $e) {
            // ???
        }

        return array();
    }
    function consultameses($fechainipast,$fechafinpast){
      try {
         $this->db->select("COUNT(ID_CONSULTA) AS TOTAL");
         $this->db->from('consulta');
         $this->db->where("FECHA_CONSULTA BETWEEN '".$fechainipast."' AND '".$fechafinpast."'");
         
         return $this->db->get()->result_array();
      } catch (Exception $ex) {
         return $e->getMessage();
      }
   }
   function consulta_x_tarifas($fechaini, $fechafin){
       try {
         $this->db->select("COUNT(ID_CONSULTA) as TOTAL, ID_TARIFA");
         $this->db->from('consulta');
         $this->db->where("FECHA_CONSULTA >=",$fechaini);
         $this->db->where("FECHA_CONSULTA <=",$fechafin);
         $this->db->group_by("ID_TARIFA");
         
         return $this->db->get()->result_array();
      } catch (Exception $ex) {
         return $e->getMessage();
      }
   }
   function consulta_x_membresias($fechaini, $fechafin){
       try {
         $this->db->select("COUNT(ID_CONSULTA) as TOTAL, ID_MEMBRESIA");
         $this->db->from('consulta');
         $this->db->where("FECHA_CONSULTA >=",$fechaini);
         $this->db->where("FECHA_CONSULTA <=",$fechafin);
         $this->db->group_by("ID_MEMBRESIA");
         
         return $this->db->get()->result_array();
      } catch (Exception $ex) {
         return $e->getMessage();
      }
   }
   function consulta_x_membresias_casa($fechaini, $fechafin, $membresia){
       try {
         $this->db->select("COUNT(c.ID_CONSULTA) as TOTAL, c.ID_MEMBRESIA, ca.NOMBRE_CASA");
         $this->db->from('consulta as c');
         $this->db->join('paciente as p', 'c.ID_PACIENTE=p.ID_PACIENTE');
         $this->db->join('casas as ca', 'p.ID_CASA=ca.ID_CASA');
         $this->db->where("c.FECHA_CONSULTA >=",$fechaini);
         $this->db->where("c.FECHA_CONSULTA <=",$fechafin);
         $this->db->where("c.ID_MEMBRESIA",$membresia);
         $this->db->group_by("p.ID_CASA");
         
         return $this->db->get()->result_array();
      } catch (Exception $ex) {
         return $e->getMessage();
      }
   }
   function urgenciameses($fechainipast,$fechafinpast){
      try {
         $this->db->select("COUNT(ID_URGENCIA) AS TOTAL");
         $this->db->from('urgencia');
         $this->db->where("FECHA_URGENCIA BETWEEN '".$fechainipast."' AND '".$fechafinpast."'");
         
         return $this->db->get()->result_array();
      } catch (Exception $ex) {
         return $e->getMessage();
      }
   }
   function urgencia_x_tarifas($fechaini,$fechafin){
       try {
         $this->db->select("COUNT(ID_URGENCIA) as TOTAL, ID_TARIFA");
         $this->db->from('urgencia');
         $this->db->where("FECHA_URGENCIA >=",$fechaini);
         $this->db->where("FECHA_URGENCIA <=",$fechafin);
         $this->db->group_by("ID_TARIFA");
         
         return $this->db->get()->result_array();
      } catch (Exception $ex) {
         return $e->getMessage();
      }
   }
   function urgencia_x_membresias($fechaini,$fechafin){
       try {
         $this->db->select("COUNT(ID_URGENCIA) as TOTAL, ID_MEMBRESIA");
         $this->db->from('urgencia');
         $this->db->where("FECHA_URGENCIA >=",$fechaini);
         $this->db->where("FECHA_URGENCIA <=",$fechafin);
         $this->db->group_by("ID_MEMBRESIA");
         
         return $this->db->get()->result_array();
      } catch (Exception $ex) {
         return $e->getMessage();
      }
   }
   function urgencia_x_membresias_casa($fechaini, $fechafin, $membresia){
       try {
         $this->db->select("COUNT(u.ID_URGENCIA) as TOTAL, u.ID_MEMBRESIA, ca.NOMBRE_CASA");
         $this->db->from('urgencia as u');
         $this->db->join('paciente as p', 'u.ID_PACIENTE=p.ID_PACIENTE');
         $this->db->join('casas as ca', 'p.ID_CASA=ca.ID_CASA');
         $this->db->where("u.FECHA_URGENCIA >=",$fechaini);
         $this->db->where("u.FECHA_URGENCIA <=",$fechafin);
         $this->db->where("u.ID_MEMBRESIA",$membresia);
         $this->db->group_by("p.ID_CASA");
         
         return $this->db->get()->result_array();
      } catch (Exception $ex) {
         return $e->getMessage();
      }
   }

}
