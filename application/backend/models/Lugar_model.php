<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lugar_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
    }


    public function get_all_tipo_lugar(){
        $this->db->select('PR.id, PR.txtProximidade');

        $this->db->from('tabProximidades as PR');

        $get = $this->db->get();

        if($get->num_rows() > 0)
            return $get->result();

        return array();
    }
}