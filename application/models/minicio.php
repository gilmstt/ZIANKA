<?php

class Minicio extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getCount($table, $active) {
        try {
            $this->db->select("COUNT(*)");
            $this->db->from($table);
            if ($active != '') $this->db->where($active, 1);

            return $this->db->get()->row("COUNT(*)");
        } catch (Exception $ex) {
            return $e->getMessage();
        }
    }
}
