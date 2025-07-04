<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('convierte_fecha')) {

    function convierte_fecha($fecha) {
        $array_fecha = explode("/", $fecha);
        $new_fecha = $array_fecha[2] . "-" . $array_fecha[1] . "-" . $array_fecha[0];
        return $new_fecha;
    }

}

if (!function_exists('convierte_fecha_valida_db')) {

    function convierte_fecha_valida_db($fecha) { //para almacenar db con formato valido
        if ($fecha != null) {
            //echo checkdate($valor);
            $fecha_esp = str_replace("/", "-", $fecha);
            $timestamp = strtotime($fecha_esp);
            $fechaFormateada = date("Y-m-d", $timestamp);
            return $fechaFormateada;
        } else
            return;
    }

}

if (!function_exists('convierte_fecha_db_to_show')) {

    function convierte_fecha_db_to_show($fecha) { //para mostrar con formato valido
        if ($fecha != null) {
            //echo checkdate($valor);
            $timestamp = strtotime($fecha);
            $fechaFormateada = date("d/m/Y", $timestamp);
            return $fechaFormateada;
        } else
            return;
    }

}

if (!function_exists('FloatToLtr')) {

    function FloatToLtr($NumRaw) {

        function ShowTriplet($Triplet) {
            $CadTri = "";
            $TriLen = strlen($Triplet);
            $Trigger1 = intval(substr($Triplet, 0, 1));
            if ($TriLen > 1)
                $Trigger2 = intval(substr($Triplet, 1, 1));
            else
                $Trigger2 = -1;
            switch ($TriLen) {
                case 3:
                    switch ($Trigger1) {
                        case 1:
                            if ($Triplet == "100")
                                $CadTri = "cien";
                            else
                                $CadTri = "ciento";
                            break;
                        case 2:
                            $CadTri = "doscientos";
                            break;
                        case 3:
                            $CadTri = "trescientos";
                            break;
                        case 4:
                            $CadTri = "cuatrocientos";
                            break;
                        case 5:
                            $CadTri = "quinientos";
                            break;
                        case 6:
                            $CadTri = "seiscientos";
                            break;
                        case 7:
                            $CadTri = "setecientos";
                            break;
                        case 8:
                            $CadTri = "ochocientos";
                            break;
                        case 9:
                            $CadTri = "novecientos";
                    }
                    $Trigger1 = intval(substr($Triplet, 1, 1));
                    $Trigger2 = intval(substr($Triplet, 2, 1));
                case 2:
                    switch ($Trigger1) {
                        case 0: break;
                        case 1:
                            switch ($Trigger2) {
                                case 0:
                                    $CadTri .= " diez";
                                    break;
                                case 1:
                                    $CadTri .= " once";
                                    break;
                                case 2:
                                    $CadTri .= " doce";
                                    break;
                                case 3:
                                    $CadTri .= " trece";
                                    break;
                                case 4:
                                    $CadTri .= " catorce";
                                    break;
                                case 5:
                                    $CadTri .= " quince";
                                    break;
                                case 6:
                                    $CadTri .= " dieciseis";
                                    break;
                                case 7:
                                    $CadTri .= " diecisiete";
                                    break;
                                case 8:
                                    $CadTri .= " dieciocho";
                                    break;
                                case 9:
                                    $CadTri .= " diecinueve";
                            }
                            break;
                        case 2:
                            $CadTri .= " veint";
                            break;
                        case 3:
                            $CadTri .= " treinta";
                            break;
                        case 4:
                            $CadTri .= " cuarenta";
                            break;
                        case 5:
                            $CadTri .= " cincuenta";
                            break;
                        case 6:
                            $CadTri .= " sesenta";
                            break;
                        case 7:
                            $CadTri .= " setenta";
                            break;
                        case 8:
                            $CadTri .= " ochenta";
                            break;
                        case 9:
                            $CadTri .= " noventa";
                    }
                    $TmpTri = $Trigger1;
                    $Trigger1 = $Trigger2;
                    $Trigger2 = $TmpTri;
                case 1:
                    if ($Trigger2 == -1) {
                        switch ($Trigger1) {
                            case 1:
                                $CadTri = "un";
                                break;
                            case 2:
                                $CadTri = "dos";
                                break;
                            case 3:
                                $CadTri = "tres";
                                break;
                            case 4:
                                $CadTri = "cuatro";
                                break;
                            case 5:
                                $CadTri = "cinco";
                                break;
                            case 6:
                                $CadTri = "seis";
                                break;
                            case 7:
                                $CadTri = "siete";
                                break;
                            case 8:
                                $CadTri = "ocho";
                                break;
                            case 9:
                                $CadTri = "nueve";
                        }
                    } else {
                        if ($Trigger2 == 1)
                            break;
                        switch ($Trigger1) {
                            case 0:
                                if ($Trigger2 == 2)
                                    $CadTri .= "e";
                                break;
                            case 1:
                                if ($Trigger2 == 2)
                                    $CadTri .= "iun";
                                elseif ($Trigger2 == 0)
                                    $CadTri .= " un";
                                else
                                    $CadTri .= " y un";
                                break;
                            case 2:
                                if ($Trigger2 == 2)
                                    $CadTri .= "idos";
                                elseif ($Trigger2 == 0)
                                    $CadTri .= " dos";
                                else
                                    $CadTri .= " y dos";
                                break;
                            case 3:
                                if ($Trigger2 == 2)
                                    $CadTri .= "itres";
                                elseif ($Trigger2 == 0)
                                    $CadTri .= " tres";
                                else
                                    $CadTri .= " y tres";
                                break;
                            case 4:
                                if ($Trigger2 == 2)
                                    $CadTri .= "icuatro";
                                elseif ($Trigger2 == 0)
                                    $CadTri .= " cuatro";
                                else
                                    $CadTri .= " y cuatro";
                                break;
                            case 5:
                                if ($Trigger2 == 2)
                                    $CadTri .= "icinco";
                                elseif ($Trigger2 == 0)
                                    $CadTri .= " cinco";
                                else
                                    $CadTri .= " y cinco";
                                break;
                            case 6:
                                if ($Trigger2 == 2)
                                    $CadTri .= "iseis";
                                elseif ($Trigger2 == 0)
                                    $CadTri .= " seis";
                                else
                                    $CadTri .= " y seis";
                                break;
                            case 7:
                                if ($Trigger2 == 2)
                                    $CadTri .= "isiete";
                                elseif ($Trigger2 == 0)
                                    $CadTri .= " siete";
                                else
                                    $CadTri .= " y siete";
                                break;
                            case 8:
                                if ($Trigger2 == 2)
                                    $CadTri .= "iocho";
                                elseif ($Trigger2 == 0)
                                    $CadTri .= " ocho";
                                else
                                    $CadTri .= " y ocho";
                                break;
                            case 9:
                                if ($Trigger2 == 2)
                                    $CadTri .= "inueve";
                                elseif ($Trigger2 == 0)
                                    $CadTri .= " nueve";
                                else
                                    $CadTri .= " y nueve";
                        }
                    }
            }
            return $CadTri;
        }

        function ShowHex($HexNum) {
            $HexLen = strlen($HexNum);
            $CadHex = "";
            if ($HexLen > 3) {
                if ($HexNum == "000000")
                    $CadHex .= " de ";
                else
                    $CadHex .= ShowTriplet(substr($HexNum, 0, -3)) . " mil " . ShowTriplet(substr($HexNum, -3));
            } else
                $CadHex .= ShowTriplet($HexNum);
            return $CadHex;
        }

        function ShowDozen($DozNum) {
            $DozLen = strlen($DozNum);
            $PriDoz = substr($DozNum, 0, -6);
            $CadDoz = "";
            if ($DozLen > 6) {
                if ($PriDoz == "1")
                    $CadDoz .= ShowHex($PriDoz) . " millon " . ShowHex(substr($DozNum, -6));
                else
                    $CadDoz .= ShowHex($PriDoz) . " millones " . ShowHex(substr($DozNum, -6));
            } else
                $CadDoz .= ShowHex($DozNum);
            return $CadDoz;
        }

        $Num = sprintf("%.02f", $NumRaw);
        $NumInt = strtok($Num, ".");
        $NumDec = strtok(".");
        $LenInt = strlen($NumInt);
        $Num = floatval($NumInt);
        $Cadena = ShowDozen($Num);
        $Cadena = strtoupper($Cadena);
        if ($NumInt == 1)
            $Moneda = " PESO ";
        else
            $Moneda = " PESOS ";
        $Cadena = $Cadena . $Moneda . $NumDec . "/100 M.N.";

        return $Cadena;
    }

    if (!function_exists('calcula_edad')) {
        function calcula_edad($fecha_nacimiento) {
            // Convierte la fecha de nacimiento a un objeto DateTime
            $fecha_nacimiento = new DateTime($fecha_nacimiento);
            // Obtiene la fecha actual
            $ahora = new DateTime();
            // Calcula la diferencia
            $diferencia = $ahora->diff($fecha_nacimiento);
            
            // Extrae los años y meses de la diferencia
            $años = $diferencia->y;
            $meses = $diferencia->m;
            
            // Retorna la edad en años y meses
            return "$años . $meses ";
        }
    }
    
    if (!function_exists('calcula_edad_2')) {
        function calcula_edad_2($fecha_nacimiento, $fecha_final) {
            // Convierte las fechas a objetos DateTime
            $fecha_nacimiento = new DateTime($fecha_nacimiento);
            $fecha_final = new DateTime($fecha_final);
            // Calcula la diferencia
            $diferencia = $fecha_final->diff($fecha_nacimiento);
            
            // Extrae los años y meses de la diferencia
            $años = $diferencia->y;
            $meses = $diferencia->m;
            
            // Retorna la edad en años y meses
            return "$años. $meses ";
        }
    }
    
}