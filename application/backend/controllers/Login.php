<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct() {
        parent::__construct();

        // Model
		$this->load->model('user_model');

		// Library
		$this->load->library('form_validation');
		$this->load->library('encryption');
		$this->load->library('session');

		// Helper
		$this->load->helper('security');
    }

	public function index(){
		$this->template->showAdmin('form-login', array(), array());
	}

	public function validar_login(){
		if(!$_POST)
			redirect('login','refresh');

		$objData = new stdClass();
		$objData = (object)$_POST;

		// Validar os campos que foram inseridos
		$this->form_validation->set_rules($this->_set_rules_login());

		if ($this->form_validation->run() === FALSE){
			echo json_encode(array("valid" => true, 'mensagem' => $this->lang->line('dados_invalidos')));

			// $data['message'][1] = array(
	  //           'msg'       =>  $this->lang->line('usuario_invalido'),
	  //           'type'      =>  'danger',
   //          	'time'		=>	3000
	  //       );
	  //   	$this->session->set_userdata($data);
			
			// $this->login_admin();
		}
		else{
			$objData->txtSenha = do_hash(do_hash($objData->txtSenha, 'md5'));
			$query = $this->user_model->validate_user($objData->txtLogin, $objData->txtSenha);
			
			if ($query){
				// Monta um array com o ID de todas os menus que o usuário possui acesso, para validar acessos
				$idMenu = explode(',', $query[0]->txtIdMenu);
				// Salva os dados na sessão do usuário
				$this->data['user-adm'] = array(
					'id'						=> $query[0]->id,
					'txtNome' 					=> $query[0]->txtNome,
					'txtEmail' 					=> $query[0]->txtEmail,
					'txtMenuFile' 				=> $query[0]->txtMenuFile,
					'txtPathAvatar'				=> $query[0]->txtPathAvatar,
					'arrayIdMenu'				=> serialize($idMenu),
					'idGroupAccess'				=> $query[0]->idGroupAccess,
					'txtTituloGroupAccess'		=> $query[0]->txtTituloGroupAccess,
					'logged' 					=> true
				);

				$this->session->set_userdata($this->data);
				//die(var_dump($this->data));
				//die(var_dump($this->session->set_userdata($this->data)));

				echo json_encode(array("valid" => true));
			}
			else{
				echo json_encode(array("valid" => false, 'mensagem'=>$this->lang->line('usuario_invalido')));
				
				// $this->data['message'][1] = array(
		  //           'msg'       =>  $this->lang->line('usuario_invalido'),
		  //           'type'      =>  'danger',
	   //          	'time'		=>	3000
		  //       );
				
				// $this->session->set_userdata($this->data);

				// redirect('login', 'refresh');
			}
		}
	}

	public function logout(){
		$this->session->sess_destroy();
		$this->template->showAdmin('form-login');
	}

	/*
	|--------------------------------------------------------------------------
	| Métodos privados
	|--------------------------------------------------------------------------
	*/

	/**
	 *  [_set_rules_login_admin 	Definie a validação dos parâmetros de login]
	 *  @method  					_set_rules_login_admin
	 *
	 *  @author 					Jorge Ribeiro Junior
	 *  @version 					[1.0.0]
	 *  @date    					2015-04-03
	 */
	private function _set_rules_login(){

		$config = array(
			array(
				'field' => 'txtSenha',
                'label' => 'Senha',
                'rules' => 'trim|required|min_length[5]|max_length[100]'
			),
			array(	
				'field' => 'txtLogin',
                'label' => 'Login',
                'rules' => 'trim|required|min_length[4]|max_length[100]'
            )
		);

		return $config;
	}
}
