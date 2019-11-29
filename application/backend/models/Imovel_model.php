<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Imovel_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
    }


    public function get_all_imoveis(){
    	$this->db->select('	PROD.id, PROD.idTipoProduto, PROD.txtTituloImovel, PROD.txtDescricaoImovel, PROD.txtBairro, PROD.txtEstado, PROD.txtMetragemPrivada, PROD.datLancamento, PROD.datEntrega, 
                            PROD.txtLatitude, PROD.txtLongitude, PROD.bitAtivo, PROD.idImoveisRelacionados, PROD.txtUrlAmigavel, PROD.txtPathDocumento');
    	$this->db->select('	TPP.txtTipoProduto');
    	$this->db->from('tabImovel AS PROD');
    	$this->db->join('tabTipoProduto AS TPP', 'TPP.id = PROD.idTipoProduto', 'left');

    	$this->db->order_by('PROD.idTipoProduto, PROD.txtTituloImovel');

    	$get = $this->db->get();

		if($get->num_rows() > 0) 
			return $get->result();
		
		return array();
    }

    public function get_all_tipo_produto(){
    	$this->db->select('	TPP.id, TPP.txtTipoProduto');

    	$this->db->from('tabTipoProduto AS TPP');

    	$get = $this->db->get();

		if($get->num_rows() > 0) 
			return $get->result();
		
		return array();
    }

    public function get_imovel($idProduto = 0){
    	$this->db->select(' PROD.id, PROD.idTipoProduto, PROD.txtTituloImovel, PROD.txtDescricaoImovel,PROD.idImoveisRelacionados, PROD.txtBairro, PROD.txtEstado, PROD.txtMetragemPrivada, PROD.datLancamento, PROD.datEntrega, 
                            PROD.txtLatitude, PROD.txtLongitude, PROD.bitAtivo, PROD.txtUrlAmigavel, PROD.txtDescriptionSeo');
    	$this->db->select('	TPP.txtTipoProduto');

    	$this->db->from('tabImovel AS PROD');
    	$this->db->join('tabTipoProduto AS TPP', 'TPP.id = PROD.idTipoProduto', 'left');

    	$this->db->where('PROD.id', $idProduto);

    	$get = $this->db->get();

		if($get->num_rows() > 0) 
			return $get->result();
		
		return array();
    }

    public function valida_duplicidade_urlAmigavel($txtUrlAmigavel = '', $idProduto= 0){
        $this->db->from('tabImovel AS PROD');
        $this->db->where('PROD.id !=', $idProduto);
        $this->db->where('PROD.txtUrlAmigavel', $txtUrlAmigavel);
        $total = $this->db->count_all_results();

        return ($total > 0) ? TRUE : FALSE;
    }

    public function get_tipo_diferencial($idDiferencial = 0){
        $this->db->select(' TPM.id, TPM.idImovel, TPM.txtDescricao, TPM.txtPathIcone, TPM.intOrdem');

        $this->db->from('tabDiferencialImovel AS TPM');

        $this->db->where('TPM.idImovel', $idDiferencial);
        $this->db->order_by('TPM.intOrdem', 'ASC');

        $get = $this->db->get();

        if($get->num_rows() > 0) 
            return $get->result();
        
        return array();
    }

    public function get_tipo_obra($idObra = 0){
        $this->db->select(' OBR.id, OBR.idImovel, OBR.txtTitulo, OBR.intPorcentagem, OBR.intOrdem');

        $this->db->from('tabStatusObra AS OBR');

        $this->db->where('OBR.idImovel', $idObra);
        $this->db->order_by('OBR.intOrdem', 'ASC');

        $get = $this->db->get();

        if($get->num_rows() > 0) 
            return $get->result();
        
        return array();
    }

    public function get_all_tipo_lugar(){
        $this->db->select('PR.id, PR.txtProximidade AS txtTipoProduto');

        $this->db->from('tabProximidades as PR');

        $get = $this->db->get();

        if($get->num_rows() > 0)
            return $get->result();

        return array();
    }

    function get_all_especificacoes($idImovel = 0){
        $this->db->select('ESP.id, ESP.idProximidades, ESP.idImovel, ESP.txtLugarProximo');
        $this->db->select('TP.txtProximidade');

        $this->db->from('tabLugaresProximos as ESP');
        $this->db->join('tabProximidades AS TP', 'TP.id = ESP.idProximidades', 'left');

        $this->db->where('ESP.idImovel', $idImovel);


        $get = $this->db->get();

        if($get->num_rows() > 0)
            return $get->result();

        return array();
    }
}