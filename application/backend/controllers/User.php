<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
	function __construct() {
        parent::__construct();

        // Library
		$this->load->library('form_validation');

		// Helper
		$this->load->helper('security');
    }

    /**
     * Direciona o usuário para o controller USER e o método LIST-ALL-USERS
     * @method  index
     *
     * @author 		JRJ
     * @version 	1.0.0
     * @date    	2015-12-17
     * @return  	void 		Direciona o usuário para outro controller / método
     */
	public function index(){
		redirect('user/list-all-users','refresh');
	}

	/**
	 * Lista todos os usuários que estão autorizados a acessar a área administrativa do sistema
	 * @method  list_all_users
	 *
	 * @author 		JRJ
	 * @version 	1.0.0
	 * @date    	2015-12-17
	 * @return  	object 		Objeto contendo a lista de todos os usuários registrados no sistema e seus dados de cadastro
	 */
	public function list_all_users(){
		$permissao = $this->user_model->logged_admin($this->router->class, $this->router->method);
		$this->template->array_permissao_button($permissao);
		
		$this->data['users'] = $this->user_model->get_users();

		$this->template->showAdmin('list-user', $this->data, array());
	}

	/**
	 * Recebe a ação que deve ser executada, pode ser a inserção de um novo usuário ou a alteração do mesmo
	 * @method  action
	 *
	 * @author 		JRJ
	 * @version 	1.0.0
	 * @date    	2015-12-17
	 * @param   	integer    $idUsuario 		Código do usuário que deverá ser alterado os dados
	 * @return  	object                		Objeto contendo os dados do usuário pesquisado ou todos os campos de cadastro para um novo usuário
	 */
	function action($idUsuario = 0){
		$this->user_model->logged_admin($this->router->class, $this->router->method);

		$this->data['group_access'] = $this->user_model->list_group_access(array(1));

		if($idUsuario === 0){
			$this->data['usuario'] = $this->_set_fields_user();
			$this->data['breadcrumb'] = 'Novo usuário';
			$this->data['action'] = 'user/new-user';
		}
		else{
			$this->data['usuario'] = $this->user_model->get_users($this->encrypt->decode($idUsuario));
			$this->data['breadcrumb'] = 'Editar usuário';
			$this->data['action'] = 'user/alter-user';
		}

		$this->template->showAdmin('config-user', $this->data, array());
    }

    /**
     * Realiza a inserção de um novo usuário no sistema, usuário para acesso a área administrativa
     * @method  new_user
     *
     * @author 		JRJ
     * @version 	1.0.0
     * @date    	2015-12-17
     * @return  	array     	Retorna um array através de Json para a view
     */
	public function new_user(){
		$this->user_model->logged_admin($this->router->class, $this->router->method);

		if(!$_POST)
			redirect('user/list-all-users', 'refresh');

		$objData = new stdClass();
		$objInsertUser = new stdClass();
		$objData = (object)$_POST;

		// Validar os campos que foram inseridos
		$this->form_validation->set_rules($this->_set_rules_user($objData->id));

		if ($this->form_validation->run() === FALSE):
			header('Content-Type: application/json');
			echo json_encode(array("msg" => validation_errors(), 'validate'=>false, 'time'=>3000, 'type'=>'danger'));
		
		else:
			$objInsertUser->txtNome = $objData->txtNome;
			$objInsertUser->txtLogin = $objData->txtLogin;
			$objInsertUser->txtEmail = $objData->txtEmail;
			$objInsertUser->txtSenha = do_hash(do_hash($objData->txtSenha, 'md5'));
			$objInsertUser->idGroupAccess = $objData->idGroupAccess;
			$objInsertUser = $this->crud_model->insert('tabUsuarioAdministrativo', $objInsertUser);

			$data['message'][1] = array(
	            'msg'       	=>  $this->lang->line('new_user_success'),
	            'type'      	=>  'success',
            	'time'			=>	30,
            	'notie_notify'	=>	true
	        );

	    	$this->session->set_userdata($data);

	    	header('Content-Type: application/json');
			echo json_encode(array("msg" => 'success', 'validate'=>true));
 		endif;
	}

	/**
	 * Altera os dados de um determinado usuário dentro do sistema, neste caso os dados de cadsatro
	 * @method  alter_user
	 *
	 * @author 		JRJ
	 * @version 	1.0.0
	 * @date    	2015-12-17
	 * @return  	array     	Retorna um array com as informações da ação realizada
	 */
	function alter_user(){
		$this->user_model->logged_admin($this->router->class, $this->router->method);

		if(!$_POST)
			redirect('usuario/list-users', 'refresh');

		$objData = new stdClass();
		$objUpdateUser = new stdClass();
		$objData = (object)$_POST;

		// Library
		$this->load->library('form_validation');

		// Validar os campos que foram inseridos
		$this->form_validation->set_rules($this->_set_rules_user((int)$this->encrypt->decode($objData->id)));

		if ($this->form_validation->run() === FALSE):
			header('Content-Type: application/json');
			echo json_encode(array("msg" => validation_errors(), 'validate'=>false, 'time'=>3000, 'type'=>'danger'));
		else:
			$arrayCondition = array('id = ' . (int)$this->encrypt->decode($objData->id));
			$objUpdateUser->txtNome = $objData->txtNome;
			$objUpdateUser->txtEmail = $objData->txtEmail;
			$objUpdateUser->txtLogin = $objData->txtLogin;
			$objUpdateUser->idGroupAccess = $objData->idGroupAccess;

			$query = $this->crud_model->update($objUpdateUser, 'tabUsuarioAdministrativo', $arrayCondition);

			$data['message'][1] = array(
	            'msg'       =>  $this->lang->line('alter_user_success'),
	            'type'      =>  'success',
            	'icon'		=>	'fa fa-check'
	        );
    		
    		$this->session->set_userdata($data);
    	
			header('Content-Type: application/json');
			echo json_encode(array("msg" => 'success', 'validate'=>true));
		endif;
	}

	/**
	 * Remove um usuário administrativo do sistema, desde que o mesmo não tenha nenhum vínculo em alguma outra tabela
	 * @method  remove_user
	 *
	 * @author 		JRJ
	 * @version 	1.0.0
	 * @date    	2015-12-17
	 * @return  	array      Array com o resultado da ação que foi realizada
	 */
	function remove_user(){
		$this->user_model->logged_admin($this->router->class, $this->router->method);

		if(!$_POST)
			redirect('user/list-all-users', 'refresh');

		$objData = new stdClass();
		$objData = (object)$_POST;

		$arrayCondition = array('id = ' . (int)$objData->id);
		$this->crud_model->delete('tabUsuarioAdministrativo', $arrayCondition);

		header('Content-Type: application/json');
		echo json_encode(array("msg"=>$this->lang->line("remove_user_success"), 'type'=>'success', 'icon'=>'fa fa-check'));
	}

	/**
	 * Altera apenas a senha do usuário do administrativo, esta senha pode ser alterada pelo usuário ou por outro usuário com direito total ao sistema
	 * @method  alter_password_user
	 *
	 * @author 		JRJ
	 * @version 	1.0.0
	 * @date    	2015-12-17
	 * @param   	string         $return 	Informa o tipo de retorno, que pode ser um redirect para outra página ou um json
	 * @return  	array 					Array contendo o resultado da ação que foi realizada
	 */
	function alter_password_user($return = ''){
		if(!$_POST)
			redirect('user/list-all-users','refresh');

		$objData = new stdClass();
		$objUpdateUser = new stdClass();
		$objData = (object)$_POST;

		$arrayCondition = array('id = ' . (int)$objData->idUser);
		$objUpdateUser->txtSenha = do_hash(do_hash($objData->txtSenha, 'md5'));
		$this->crud_model->update($objUpdateUser, 'tabUsuarioAdministrativo', $arrayCondition);

    	if($return == ''){
    		$data['message'][1] = array(
	            'msg'       =>  $this->lang->line('alter_password_success'),
	            'type'      =>  'success'
	        );
    		
    		$this->session->set_userdata($data);
    		redirect('user/list-all-users','refresh');
    	}
    	else{
	    	header('Content-Type: application/json');
			echo json_encode(array("msg" => $this->lang->line('alter_password_success'), 'type'=>'success', 'icon'=>'fa fa-check'));
    	}
	}

	/**
	 * Direciona o usuário para a tela de perfil
	 * @method  perfil_user
	 *
	 * @author 		JRJ
	 * @version 	1.0.0
	 * @date    	2015-12-17
	 * @return  	void 		Direciona o usuário para a view de perfil
	 */
	function perfil_user(){
		$this->user_model->logged_admin();

		$this->template->showAdmin('perfil-user-administrativo');
	}

	/**
	 * Lista todos os grupos de usuários registrados no sistema
	 * 2015-01-30	Realizado uma alteração para poder comportar a questão de direitos a botões existentes dentro da página
	 * 
	 * @method  list_group
	 *
	 * @author 		JRJ
	 * @version 	2.0.0
	 * @date    	2015-12-17
	 * @return  	void 		Direciona o usuário para a view de configuração de acesso
	 */
	function list_group(){
		// $direitos = array(array('Nova Reserva', 'nova_reserva', '0'), array('Registrar venda', 'registrar_venda', '0'), array('Alterar senha', 'alterar_senha', '0'), array('Cancelar reserva','cancelar_reserva', '0'), array('Dados pessoais', 'dados_pessoais', '0'), array('Resumo compras', 'resumo_compras', '0'), array('Detalhe do pedido', 'detalhe_pedido', '0'), array('Histórico renovação','historico_renovacao', '0'), array('Renovar crédito', 'renovar_credito', '0'));

		// dvd(serialize($direitos));

        $this->user_model->logged_admin($this->router->class, $this->router->method);

        //	1	-	Busca todos os grupos existente no sistema
		$this->data['grupos'] = $this->user_model->list_group_access();

		//	2	-	Concatena todos os grupos, formando uma única string
		$this->data['idGrupoConcatenado'] = '';
		for ($i=0; $i < count($this->data['grupos']); $i++) { 
			//	A 	-	Organiza em um array todos os menus que o grupo possui acesso
			$this->data['grupos'][$i]->txtMenuAccess = explode(',', $this->data['grupos'][$i]->txtMenuAccess);

			//	B 	-	Organiza em um array todas as permissões de botões que o grupo possui acesso conforme o menu que está sendo populado
			//	C	-	Separa em um array caso o grupo tenha acesso a diversos botões de menus diferentes e lista todos os menus
			$menuPermissao = explode(',', $this->data['grupos'][$i]->txtPermissaoGroupAccess);
			$arrayDireitos = array();
			for ($men=0; $men < count($menuPermissao); $men++) { 
				//	D	-	Com base na lista de menus coloca em um array todos os grupos de botões, eliminando as duas primeiras posições no looping
				//			porque referem-se ao ID do Grupo e ID do Menu
				$listaPermissao = explode('|', $menuPermissao[$men]);
				for ($perm=2; $perm < count($listaPermissao); $perm++) { 
					//	E	-	Criar um array com os botões que o grupo tem acesso
					$direitos = explode(';', $listaPermissao[$perm]);
					if(isset($direitos[1]))
						array_push($arrayDireitos, array($listaPermissao[0], $listaPermissao[1], $direitos[0], $direitos[1], $direitos[2]));
				}
			}
		
			$this->data['grupos'][$i]->txtPermissaoGroupAccess = array();

			array_push($this->data['grupos'][$i]->txtPermissaoGroupAccess, $arrayDireitos);

			// Cria uma string concatenada dos menus que possui acesso para ser utilizado na função JS do Tree View
			$this->data['idGrupoConcatenado'] .= $this->data['grupos'][$i]->id . '||';
		}
		$this->data['idGrupoConcatenado'] = substr($this->data['idGrupoConcatenado'],0,-2);

		//	3	-	Busca todos os menus registrados no banco de dados
		$this->data['menu'] = $this->user_model->get_group_access_menu(0, 'MEN.idMenuPrincipal, MEN.intOrdem');
		
		//	4	-	Organiza todos os menus separando os mesmos em grupos
		$this->data['sub_menu'] = $this->_organiza_array_menu($this->data['menu']);
		
		$this->template->showAdmin('config-group-access', $this->data);
	}

	/**
	 * Altera os dados de um determinado grupo
	 * 
	 * @method  alter_group_access
	 *
	 * @author 		JRJ
	 * @version 	1.0.1
	 * @date    	2015-12-17
	 * @return  	array 		Array contendo os dados que foram atualizados no banco de dados
	 */
	public function alter_group_access(){
		$this->user_model->logged_admin($this->router->class, $this->router->method);
		
		if(!$_POST)
			redirect('home', 'refresh');


		$objData = new stdClass();
		$objData = new stdClass();
		$objData = (object)$_POST;
		$atualizarMenu = 0;
		$arrayPermissaoButton = array();

		if(isset($objData->txtPermissaoButton)){
			for ($but=0; $but < count($objData->txtPermissaoButton); $but++) { 
				array_push($arrayPermissaoButton, explode('||', $objData->txtPermissaoButton[$but]));
			}
		}

		// 1	-	Apagar os direitos atuais do grupo
		$arrayCondition = array('idGroupAccess = ' . (int)$objData->id);
		$this->crud_model->delete('tabGroupAccessMenuAdmin', $arrayCondition);

		// 2	-	Realizar a inserção dos novos direitos
		$objInsert = new stdClass();
		for ($i=0; $i < count($objData->menuAcesso); $i++) { 
			$stringPermissaoButton = '';
			$permissaoButtonInsert = array();
			$objInsert->idGroupAccess = (int)$objData->id;
			$objInsert->idMenuAdmin = (int)$objData->menuAcesso[$i];

			for ($k=0; $k < count($arrayPermissaoButton); $k++) { 
				if((int)$objData->menuAcesso[$i] == (int)$arrayPermissaoButton[$k][0]){
					$stringPermissaoButton .= '|' . $arrayPermissaoButton[$k][1] . ';' . $arrayPermissaoButton[$k][2] . ';1';
				}
			}
			if($stringPermissaoButton != ''){
				$objInsert->txtPermissoes = substr($stringPermissaoButton, 1);
			}
			
			$query = $this->crud_model->insert('tabGroupAccessMenuAdmin', $objInsert);
			
			unset($objInsert->id, $objInsert->txtPermissoes);
		}

		// 3	-	Verificar se algum dos menus inseridos possui um cabeçalho, se sim, faz a inserção do cabeçalho nos direitos de acesso
		$id_cabecalho = $this->user_model->get_cabecalho_menu($objData->menuAcesso);
		if(count($id_cabecalho)){
			for ($j=0; $j < count($id_cabecalho); $j++) { 
				$objInsert->idGroupAccess = (int)$objData->id;
				$objInsert->idMenuAdmin = (int)$id_cabecalho[$j]->idMenuCabecalho;

				$query = $this->crud_model->insert('tabGroupAccessMenuAdmin', $objInsert);

				unset($objInsert->id);
			}
		}

		// 4	-	Carregar os dados do usuário para poder atualizar o XML
		$this->data['menu'] = $this->user_model->get_group_access_menu(0, 'MEN.idMenuPrincipal, MEN.intOrdem', (int)$objData->id, array(0));

		// 5	-	Organiza os menus dentro de cada um dos seus grupos
		$this->data['sub_menu'] = $this->_organiza_array_menu($this->data['menu']);

		$this->dataMenu['menu_xml'] = $this->template->gera_arquivo_menu_xml(0, $this->data['sub_menu'], 0);
		
		$fp = fopen('../assets/menu/' . $objData->txtRandonNumber . '.xml', 'w+');
		fwrite($fp, $this->dataMenu['menu_xml']);
		fclose($fp);

		// Se o grupo que estiver sendo alterado for igual ao usuário que está logado, atualiza-se a sessão do usuário
		if((int)$this->session->userdata['user-adm']['idGroupAccess'] == (int)$objData->id){
			$atualizarMenu = 1;
			$idMenuAccess = $this->user_model->list_menu_access_group((int)$objData->id);
			$arrayIdMenu = array();
			for ($i=0; $i < count($idMenuAccess); $i++) { 
				array_push($arrayIdMenu, $idMenuAccess[$i]->idMenuAdmin);
			}

			$this->session->userdata['user-adm']['arrayIdMenu'] = serialize($arrayIdMenu);
		}

		$data['message'][1] = array(
	            'msg'       =>  $this->lang->line('alter_access_group_success'),
	            'type'      =>  'success',
            	'icon'		=>	'fa fa-check'
	        );

        $this->session->set_userdata($data);

		// Retorna via JSON para a página
		header('Content-Type: application/json');
		echo json_encode(array("msg" => $this->lang->line("alter_access_group_success"), "atualizarMenu"=>$atualizarMenu));
	}

    /*
	|--------------------------------------------------------------------------
	| Métodos privados
	|--------------------------------------------------------------------------
	*/

	/**
	 * Organiza todos os itens do menu conforme a ordem que foi definida dentro do sistema
	 * @method  _organiza_array_menu
	 *
	 * @author 		JRJ
	 * @version 	1.0.0
	 * @date    	2015-12-17
	 * @param   	array  			$arrayMenu 			Array contendo todos os itens do menu configurados no servidor
	 * @param   	array 			$arrayMenuAdmin 	É utilizado quando um submenu existe dentro do menu principal
	 * @param   	integer 		$idProduto 			Código do produto?
	 * @return  	array 								Retorna um array contendo todo o menu ordenado da forma correta
	 */
	private function _organiza_array_menu($arrayMenu, $arrayMenuAdmin = array(), $idProduto = 0){
    	// Model
    	$this->load->model('user_model');

    	for ($i=0; $i < count($arrayMenu); $i++) {
			if($arrayMenu[$i]->idMenuPrincipal != 0){
				$retornoData = $this->user_model->get_group_access_menu($arrayMenu[$i]->idMenuPrincipal);
				$arrayMenu[$i]->txtMenuPrincipal = $retornoData[0]->txtMenu;
			}
			else{
				$arrayMenu[$i]->txtMenuPrincipal = '';
			}
		}

		////////////////////////////////////////////////////////////////////
		// Inserir o resultado em arrays conforme o idCategoriaPrincial //
		////////////////////////////////////////////////////////////////////
		foreach ($arrayMenu as $key => $menu) {
			// chrome_log($menu);
			$menuItens[$menu->idMenuPrincipal][$menu->id] = array(
												'id' => $menu->id,
												'idMenuPrincipal' => $menu->idMenuPrincipal,
												'txtIcone' => $menu->txtIcone,
												'txtMenu' => $menu->txtMenu,
												'txtIdMenu' => $menu->txtIdMenu,
												'txtUrl' => $menu->txtUrl,
												'intOrdem' => $menu->intOrdem,
												'bitCabecalho' => $menu->bitCabecalho,
												'idMenuCabecalho' => $menu->idMenuCabecalho,
												'txtMenuButtonAction' => ($menu->txtButtonAction != '')?unserialize($menu->txtButtonAction) : '');
		}

    	return $menuItens;
    }

    /**
     * Seta os campos de cadastro de um novo usuário como nulo, para o registro de um novo usuário
     * @method  _set_fields_user
     *
     * @author 		JRJ
     * @version 	1.0.0
     * @date    	2015-12-17
     * @return 		array 		Array contendo todos os campos de cadastro de um usuário
     */
    private function _set_fields_user(){
    	$fields = array(
			(object)array(
				'id'				=>'', 
				'idCriptografado'	=>'',
				'txtNome'			=>'',
				'txtEmail'			=>'',
				'txtLogin'			=>'',
				'bitAtivo'			=>'',
				'bitDelete'			=>'',
				'datCreate'			=>'',
				'idGroupAccess'		=>'',
				'bitVisivel'		=>1
			));

		return $fields;
    }

    /**
     * Define quais são os campos obrigatórios para o cadastro de um novo usuário
     * @method  _set_rules_user
     *
     * @author 		JRJ
     * @version 	1.0.0
     * @date    	2015-12-17
     * @param   	integer         $idUsuarioAdministrativo 		Código do usuário, caso esteja sendo realizado uma alteração de dados
     * @return 		array 											Contendo os dados de cada campo analisado
     */
    private function _set_rules_user($idUsuarioAdministrativo = 0){

		$config = array(
			array(
				'field' => 'txtNome',
                'label' => 'Nome',
                'rules' => 'trim|required|min_length[4]|max_length[100]'
			),
			array(
				'field' => 'txtLogin',
                'label' => 'Login',
                'rules' => "trim|required|min_length[4]|max_length[100]|callback_check_login[$idUsuarioAdministrativo]"
			),
			array(	
				'field' => 'txtEmail',
                'label' => 'Email',
                'rules' => "trim|required|min_length[4]|max_length[255]|valid_email|callback_check_email[$idUsuarioAdministrativo]"
            )
		);

		return $config;
	}

	/**
	 * Checa se o email que está sendo registrado já não está cadastrado dentro do sistema
	 * @method  check_email
	 *
	 * @author 		JRJ
	 * @version 	1.0.0
	 * @date    	2015-12-17
	 * @param   	string 			$txtEmail 		Email do usuário que será analisado
	 * @param   	integer 		$idUser 		Id do usuário, para que não seja analisadoo mesmo usuário, quando se estiver realizando a alteração de dados
	 * @return 		boolean 						TRUE se o email existir e FALSE caso ele não exista
	 */
	public function check_email($txtEmail= '', $idUser = 0){
		$validaDuplicidadeEmail = $this->user_model->valida_duplicidade_email($txtEmail, $idUser);

		if($validaDuplicidadeEmail){
			$this->form_validation->set_message('check_email', 'O %s informado já está registrado em nosso sistema');
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * Checa se o login que está sendo registrado já não está cadastrado dentro do sistema
	 * @method  check_login
	 *
	 * @author 		JRJ
	 * @version 	1.0.0
	 * @date    	2015-12-17
	 * @param   	string 			$txtLogin 		Login que será analisado para validar duplicidade
	 * @param   	integer 		$idUser 		Id do usuário, para que não seja analisado o mesmo usuário, quando se estiver realizadno a alteração de dados
	 * @return 		boolean 						TRUE se o email existir e FALSE caso ele não exista
	 */
	public function check_login($txtLogin= '', $idUser = 0){
		$validaDuplicidadeLogin = $this->user_model->valida_duplicidade_login($txtLogin, $idUser);

		if($validaDuplicidadeLogin){
			$this->form_validation->set_message('check_login', 'O %s informado já está registrado em nosso sistema');
			return FALSE;
		}
		return TRUE;
	}
}
