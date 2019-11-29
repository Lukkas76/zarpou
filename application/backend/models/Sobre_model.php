<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sobre_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
    }


    public function get_sobre_site(){
    	$this->db->select('SOB.id, SOB.txtTitulo, SOB.txtDescricao');

    	$this->db->from('tabSobre AS SOB');

    	$get = $this->db->get();

		if($get->num_rows() > 0) 
			return $get->result();
		
		return array();
    }

    public function get_sobre($idSobre = 0){
    	$this->db->select('SOB.id, SOB.txtTitulo, SOB.txtDescricao');

    	$this->db->from('tabSobre AS SOB');

    	$this->db->where('SOB.id', $idSobre);

    	$get = $this->db->get();

		if($get->num_rows() > 0) 
			return $get->result();
		
		return array();
    }
}