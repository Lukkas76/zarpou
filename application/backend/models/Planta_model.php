<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Planta_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
    }


    public function get_all_tipo_planta(){
        $this->db->select('PR.id, PR.txtPlanta');

        $this->db->from('tabPlanta as PR');

        $get = $this->db->get();

        if($get->num_rows() > 0)
            return $get->result();

        return array();
    }
}