<?php
class Banner_model extends CI_Model {
	public function __construct(){
		// Call the CI_Model constructor
		parent::__construct();
    }


    function list_all_banner(){
        $this->db->select(  'BAN.id, BAN.idPagina, BAN.txtFileName, BAN.txtPath,
                             BAN.txtTitle, BAN.txtDescription, BAN.txtAlt, BAN.intOrdenacao, BAN.txtUrl, BAN.txtTypeTarget, BAN.txtIcone');

        $this->db->from('tabBanner AS BAN');

        $this->db->order_by('BAN.intOrdenacao', 'ASC');

        $get = $this->db->get();

        if($get->num_rows() > 0)
            return $get->result();
        
        return array();

    }
}
