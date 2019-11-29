<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
	public function __construct(){
		parent::__construct();
    }

    function validate_user($txtLogin = '', $txtSenha = ''){
		$this->db->select('	USER.id, USER.txtNome, USER.txtEmail, USER.idGroupAccess, USER.bitAtivo, USER.txtPathAvatar');
		$this->db->select('	GPA.txtTituloGroupAccess');
        $this->db->select('(SELECT GP.txtRandonNumber FROM tabGroupAccess AS GP WHERE USER.idGroupAccess = GP.id) AS txtMenuFile');
        $this->db->select('(SELECT GROUP_CONCAT(GAM.idMenuAdmin) FROM tabGroupAccessMenuAdmin AS GAM WHERE GAM.idGroupAccess = USER.idGroupAccess) AS txtIdMenu');
        
        $this->db->from('tabUsuarioAdministrativo AS USER');
        $this->db->join('tabGroupAccess AS GPA', 'GPA.id = USER.idGroupAccess', 'left');
                    
		$this->db->where('(USER.txtEmail = \'' . $txtLogin . '\' OR USER.txtLogin = \'' . $txtLogin . '\')');
        $this->db->where('USER.txtSenha', $txtSenha);

        $this->db->where('bitAtivo', 1);
        
        $get = $this->db->get();

        if($get->num_rows() > 0)
        	return $get->result();
		
		return array();
	}

	function get_users($idUsuario = 0){
		$this->db->select( 'USER.id, USER.txtNome, USER.txtEmail, USER.txtLogin, USER.bitAtivo, USER.bitDelete, USER.idGroupAccess, USER.txtPathAvatar');
		$this->db->select( 'GPA.txtTituloGroupAccess, GPA.bitVisivel');

		$this->db->from('tabUsuarioAdministrativo AS USER');
		$this->db->join('tabGroupAccess AS GPA', 'USER.idGroupAccess = GPA.id', 'left');

		$this->db->where('USER.bitAtivo', 1);

		if ($idUsuario != 0)
			$this->db->where('USER.id', $idUsuario);

		$this->db->order_by('USER.txtNome', 'ASC');

		$get = $this->db->get();

		if($get->num_rows() > 0) 
			return $get->result();
		
		return array();
    }

    function get_group_access_menu($idMenu = 0, $orderBy = 'MEN.id, MEN.idMenuPrincipal', $idGroup = 0, $bitOculto = array(0,1)){
		$this->db->select('MEN.id, MEN.idMenuPrincipal, MEN.idMenuCabecalho, MEN.txtIcone, MEN.txtMenu, 
							MEN.txtIdMenu, MEN.txtUrl, MEN.intOrdem, MEN.bitCabecalho, MEN.txtButtonAction');
	
		if($idGroup != 0){
			$this->db->from('tabGroupAccessMenuAdmin AS GAM');
			$this->db->join('tabGroupAccess AS GA', 'GAM.idGroupAccess = GA.id', 'left');
			$this->db->join('tabMenuAdmin AS MEN', 'GAM.idMenuAdmin = MEN.id');
			$this->db->where('GAM.idGroupAccess', $idGroup);
		}
		else{
			$this->db->from('tabMenuAdmin AS MEN');
		}
    	
		if($idMenu != 0)
			$this->db->where('MEN.id', $idMenu);

		$this->db->where_in('MEN.bitOculto', $bitOculto);

		$this->db->order_by($orderBy);

		$get = $this->db->get();
		
		if($get->num_rows() >0)
			return $get->result();
		
		return array();
    }

    function list_group_access($bitVisivel = array(0,1)){
    	$this->db->select('GPA.id, GPA.txtTituloGroupAccess, GPA.txtRandonNumber, GPA.bitVisivel');
    	$this->db->select('(SELECT GROUP_CONCAT(GPM.idMenuAdmin) FROM tabGroupAccessMenuAdmin AS GPM WHERE GPM.idGroupAccess = GPA.id) AS txtMenuAccess');
    	$this->db->select('(	SELECT GROUP_CONCAT(CONCAT(GPM.idGroupAccess, \'|\', GPM.idMenuAdmin, \'|\', GPM.txtPermissoes)) 
    							FROM tabGroupAccessMenuAdmin AS GPM WHERE GPM.idGroupAccess = GPA.id) AS txtPermissaoGroupAccess', FALSE);
		
		$this->db->from('tabGroupAccess AS GPA');

		$this->db->where_in('GPA.bitVisivel', $bitVisivel);
		
		$this->db->order_by('GPA.txtTituloGroupAccess');
		
		$get = $this->db->get();
		
		if($get->num_rows() >0)
			return $get->result();
		
		return array();
    }

    function valida_duplicidade_email($txtEmail = '', $idUser = 0){
        $this->db->from('tabUsuarioAdministrativo AS USER');
        $this->db->where('USER.id !=', $idUser);
        $this->db->where('USER.txtEmail', $txtEmail);
        $total = $this->db->count_all_results();

        return ($total > 0) ? TRUE : FALSE;
    }

    function valida_duplicidade_login($txtLogin = '', $idUser = 0){
        $this->db->from('tabUsuarioAdministrativo AS USER');
        $this->db->where('USER.id !=', $idUser);
        $this->db->where('USER.txtLogin', $txtLogin);
        $total = $this->db->count_all_results();

        return ($total > 0) ? TRUE : FALSE;
    }

    function logged_admin($class = '', $method = '') {
    	if (!isset($this->session->userdata['user-adm']))
			redirect('login', 'refresh');

		if(isset($this->session->userdata['user-adm']['logged']))
			$logged = $this->session->userdata['user-adm']['logged'];

		if($class != '' && $method != '' && isset($this->session->userdata['user-adm']['logged'])){
			// Buscar o ID do menu que esta classe e método pode acessar
			$this->db->select('CLA.idMenuAdmin, GRA.txtPermissoes');
			$this->db->from('tabClasses AS CLA');
			$this->db->join('tabGroupAccessMenuAdmin AS GRA', 'GRA.idMenuAdmin = CLA.idMenuAdmin', 'left');
			$this->db->where('CLA.txtClasse', $class);
			$this->db->where('CLA.txtMetodo', $method);
			$this->db->where('GRA.idGroupAccess', $this->session->userdata['user-adm']['idGroupAccess']);
			$get = $this->db->get();
			$get = $get->result();

			if(count($get)){
				for ($i=0; $i < count($get); $i++) { 
					$access = in_array($get[$i]->idMenuAdmin, unserialize($this->session->userdata['user-adm']['arrayIdMenu']));
					if($access){
						return $get;
						break;
					}
				}
			}
			else{
				$access = false;
			}
		}

		if(isset($access) && $access == false)
			redirect('dashboard/acesso-negado', 'refresh');

		if (!isset($logged) || $logged != true)
			redirect('login', 'refresh');
	}

	function get_cabecalho_menu($idMenu = array()){
		$this->db->select( 'DISTINCT(MENU.idMenuCabecalho)');

		$this->db->from('tabMenuAdmin AS MENU');

		$this->db->where('MENU.idMenuCabecalho <> 0');
		$this->db->where_in('MENU.id', $idMenu);

		$get = $this->db->get();

		if($get->num_rows() > 0) 
			return $get->result();
		
		return array();
	}

	function list_menu_access_group($idGroupAccess = 0){
		$this->db->select('GPM.idMenuAdmin');
	
		$this->db->from('tabGroupAccessMenuAdmin AS GPM');

		$this->db->where('GPM.idGroupAccess', $idGroupAccess);
		
		$this->db->order_by('GPM.idMenuAdmin');
		
		$get = $this->db->get();
	
		if($get->num_rows() >0)
			return $get->result();
		
		return array();
    }
}



