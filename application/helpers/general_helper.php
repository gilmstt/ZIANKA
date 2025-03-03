<?php

function getActive($menu) {

    $menuArray = array(
        "classIni" => '',
        "classPat" => '',
        "classInv" => '',
        "classCon" => '',
        "classUrg" => '',
        "classCfg" => '',
        "classSch" => '',
        "classRep" => '');
    
    foreach ($menuArray as $key => $value) {
        if ($key == $menu) $menuArray[$key] = 'class="dropdown active"';
    }
    return $menuArray;
}

function hasInfo($data) {
    $value = false;

    foreach ($data as $info) {
        if ($info != '') {
            $value = true;
            break;
        }
    }
    return $value;
}

function loadView($path, $data) {
    $INSTANCE = get_instance();
    $INSTANCE->load->view('esqueleton/header', $data);
    $INSTANCE->load->view($path, $data);
    $INSTANCE->load->view('esqueleton/footer');
}

function grabValue($array, $key) {
    $values = [];
    foreach ($array as $item) {
        array_push($values, $item[$key]);
    }
    return $values;
}
