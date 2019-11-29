<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Informacoes_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
    }


    public function list_informacoes($datInicio, $datFinal){
        $this->db->select('CON.id, CON.txtNome, CON.txtEmail, CON.txtTelefone, CON.txtMensagem, CON.datCreate');

        $this->db->from('tabMaisInformacoes AS CON');

        $this->db->where('CON.datCreate >=', str_replace('_','-',$datInicio) . ' 00:00:000');
        $this->db->where('CON.datCreate <=', str_replace('_','-',$datFinal) . ' 23:59:999');

        $get = $this->db->get();

        if($get->num_rows() > 0) 
            return $get->result();
        
        return array();
    }
}