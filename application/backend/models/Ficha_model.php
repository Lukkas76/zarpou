<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ficha_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
    }


    public function get_all_fichatecnica($idFicha = 0){
        $this->db->select('PR.id, PR.idImovel, PR.txtFichaTecnica, PR.txtConteudo');

        $this->db->from('tabFichaTecnica as PR');
        $this->db->where('PR.idImovel',$idFicha);

        $get = $this->db->get();

        if($get->num_rows() > 0)
            return $get->result();

        return array();
    }
}