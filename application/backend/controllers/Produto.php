<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produto extends CI_Controller {
	
	function __construct() {
        parent::__construct();

        // Library
		$this->load->library('form_validation');

		//	Model
        $this->load->model('imovel_model');

        $this->CONFIG_UPLOAD =  array(
	        'upload_path'     => str_replace('/admin', '', dirname($_SERVER["SCRIPT_FILENAME"]))."/assets/documentos/",
	        'upload_url'      => assets_url("documentos"),
	        'allowed_types'   => "pdf",
	        'overwrite'       => FALSE,
	        'max_size'        => "10000KB",
	        'encrypt_name'	  => TRUE
        );
    }

    public function index(){
    	redirect('dashboard','refresh');
    }

    /**
     * Lista todos os produtos registrados no sistema
     * @method  	list_produtos
     *
     * @author 		JRJ
     * @version 	1.0.0
     * @date    	2016-09-20
     * @return  	void 			Direciona o usuário para a view que irá mostrar os dados registrados no sistema
     */
    public function list_produtos(){
    	$this->user_model->logged_admin($this->router->class, $this->router->method);

    	$this->data['produtos'] = $this->imovel_model->get_all_imoveis();

  		$this->template->showAdmin('list-all-produto', $this->data);

    }

	public function list_diferencial_imovel($idImovel = 0){
		$this->user_model->logged_admin($this->router->class, $this->router->method);

		if($idImovel == '')
			redirect('dashboard', 'refresh');

		$this->data['imovel'] = $this->imovel_model->get_tipo_diferencial(decode($idImovel));

		$this->data['idImovel'] = $idImovel;

		$this->data['nome'] = $this->imovel_model->get_imovel(decode($idImovel));
		
		
		$this->template->showAdmin('list-diferencial-imovel', $this->data);
	}

	public function list_obra_imovel($idImovel = 0){
		$this->user_model->logged_admin($this->router->class, $this->router->method);
		
		$this->data['imovel'] = $this->imovel_model->get_tipo_obra(decode($idImovel));

		$this->data['idImovel'] = $idImovel;

		$this->data['nome'] = $this->imovel_model->get_imovel(decode($idImovel));
		
		
		$this->template->showAdmin('list-obra-imovel', $this->data);
	}

    public function list_all_especificacoes($idImovel = 0){
		$this->user_model->logged_admin($this->router->class, $this->router->method);
		// 
		$this->data['idImovel'] = $idImovel;

		$this->data['nome'] = $this->imovel_model->get_imovel(decode($idImovel));

		$this->data['tipo_produto'] = $this->imovel_model->get_all_tipo_lugar();
		$this->data['especificacoes'] = $this->imovel_model->get_all_especificacoes(decode($idImovel));

		$this->template->showAdmin('list-especificacoes', $this->data, array());
	}

    public function action_produto($idProduto = ''){
    	$this->user_model->logged_admin($this->router->class, $this->router->method);
    	
    	$this->data['tipo_produtos'] = $this->imovel_model->get_all_tipo_produto();
 

    	if($idProduto === ''){
			$this->data['produto'] = $this->_set_fields_produto();
			$this->data['breadcrumb'] = 'Novo Imóvel';
			$this->data['action'] = 'produto/new-produto';
		}
		else{
			$this->data['produto'] = $this->imovel_model->get_imovel(decode($idProduto));
			$this->data['breadcrumb'] = 'Editar Imóvel';
			$this->data['action'] = 'produto/alter-produto';
		}

    	$this->template->showAdmin('config-produto', $this->data);

    }

    public function new_obra(){
		$this->user_model->logged_admin($this->router->class, $this->router->method);
		if(!$_POST)
			redirect('dashboard','refresh');

		$objData = new stdClass();
		$objInsertOp = new stdClass();
		$objData = (object)$_POST;
		unset($objData->btnInsert, $objDataId);

		$objInsertOp->idImovel = (decode($objData->idImovel));
		$objInsertOp->txtTitulo = $objData->txtTitulo;
		$objInsertOp->intPorcentagem = $objData->intPorcentagem;

		$query = $this->crud_model->insert('tabStatusObra', $objInsertOp);

		$data['message'][1] = array(
            'msg'       =>  $this->lang->line('insert_dados_success'),
            'type'      =>  'success',
        	'icon'		=>	'fa fa-check'
        );
		
		$this->session->set_userdata($data);

		redirect('produto/list-obra-imovel/'.encode($objInsertOp->idImovel),'refresh');
	}

	public function alter_obra(){
		$this->user_model->logged_admin($this->router->class, $this->router->method);
		
		if(!$_POST)
			redirect('dashboard','refresh');

		$objData = new stdClass();
		$objUpdateOp = new stdClass();
		$objData = (object)$_POST;
		
		$arrayCondition = array('id = ' . $objData->id);
		$objUpdateOp->txtTitulo = $objData->txtTitulo;
		$objUpdateOp->intPorcentagem = $objData->intPorcentagem;

		$query = $this->crud_model->update($objUpdateOp, 'tabStatusObra', $arrayCondition);

		$data['message'][1] = array(
            'msg'       =>  $this->lang->line('alter_dados_success'),
            'type'      =>  'success',
        	'icon'		=>	'fa fa-check'
        );
		
		$this->session->set_userdata($data);

		redirect('produto/list-obra-imovel/'.encode($objData->idImovel),'refresh');
	}

	public function alter_dados_obra(){
		$this->user_model->logged_admin($this->router->class, $this->router->method);

		$objData = new stdClass();
		$objUpdate = new stdClass();
		$objData = (object)$_POST;
		
		$arrayCondition = array('id = ' . (int)$objData->pk);
		$key = $objData->name;
		$objUpdate->$key = $objData->value;
			
		$tabela = $objData->table;

		$this->crud_model->update($objUpdate, $tabela, $arrayCondition);
	}

	public function remove_obra(){
		$this->user_model->logged_admin($this->router->class, $this->router->method);

		if(!$_POST)
			redirect('produto/list-produtos', 'refresh');

		$objData = new stdClass();
		$objData = (object)$_POST;

		$arrayCondition = array('id = ' . (int)$objData->id);
		$this->crud_model->delete('tabStatusObra', $arrayCondition);

		header('Content-Type: application/json');
		echo json_encode(array("msg"=>$this->lang->line("remove_dados_success"), 'type'=>'success', 'icon'=>'fa fa-check'));
	}

	public function remove_imovel(){
		$this->user_model->logged_admin($this->router->class, $this->router->method);

		if(!$_POST)
			redirect('produto/list-produtos', 'refresh');

		$objData = new stdClass();
		$objData = (object)$_POST;

		$arrayCondition = array('idImovel = ' . (int)$objData->id);
		$this->crud_model->delete('tabLugaresProximos', $arrayCondition);

		$arrayCondition = array('id = ' . (int)$objData->id);
		$this->crud_model->delete('tabImovel', $arrayCondition);

		header('Content-Type: application/json');
		echo json_encode(array("msg"=>$this->lang->line("remove_dados_success"), 'type'=>'success', 'icon'=>'fa fa-check'));
	}

	public function remove_pdf(){
		$this->user_model->logged_admin($this->router->class, $this->router->method);

		if(!$_POST)
			redirect('produto/list-produtos', 'refresh');

		$objData = new stdClass();
		$objDataPDF = new stdClass();
		$objData = (object)$_POST;
		// echo "<pre>";
		// die(var_dump(str_replace('\admin/', '', FCPATH) .  $objData->txtPathDocumento));

		$objDataPDF->txtPathDocumento = '';

		$arrayCondition = array('id = ' . (int)$objData->id);
		$this->crud_model->update($objDataPDF,'tabImovel', $arrayCondition);

		$success = unlink(str_replace('\admin/', '', FCPATH) .  $objData->txtPathDocumento);

		header('Content-Type: application/json');
		echo json_encode(array("msg"=>$this->lang->line("remove_dados_success"), 'type'=>'success', 'icon'=>'fa fa-check', 'idImovel'=>$objData->id));
	}


	public function new_diferencial(){
		$this->user_model->logged_admin($this->router->class, $this->router->method);
		if(!$_POST)
			redirect('dashboard','refresh');

		$objData = new stdClass();
		$objData = (object)$_POST;
		unset($objData->btnInsert, $objDataId);

		$objData->idImovel = (decode($objData->idImovel));

		$query = $this->crud_model->insert('tabDiferencialImovel', $objData);

		$data['message'][1] = array(
            'msg'       =>  $this->lang->line('insert_dados_success'),
            'type'      =>  'success',
        	'icon'		=>	'fa fa-check'
        );
		
		$this->session->set_userdata($data);

		redirect('produto/list-diferencial-imovel/'.encode($objData->idImovel),'refresh');
	}

	public function alter_diferencial(){
		$this->user_model->logged_admin($this->router->class, $this->router->method);
		
		if(!$_POST)
			redirect('dashboard','refresh');

		$objData = new stdClass();
		$objUpdateOp = new stdClass();
		$objData = (object)$_POST;
		
		$arrayCondition = array('id = ' . $objData->id);
		$objUpdateOp->txtDescricao = $objData->txtDescricao;

		$query = $this->crud_model->update($objUpdateOp, 'tabDiferencialImovel', $arrayCondition);

		$data['message'][1] = array(
            'msg'       =>  $this->lang->line('alter_dados_success'),
            'type'      =>  'success',
        	'icon'		=>	'fa fa-check'
        );
		
		$this->session->set_userdata($data);

		redirect('produto/list-diferencial-imovel/'.encode($objData->idImovel),'refresh');
	}

	public function alter_dados_diferencial(){
		$this->user_model->logged_admin($this->router->class, $this->router->method);

		$objData = new stdClass();
		$objUpdate = new stdClass();
		$objData = (object)$_POST;
		
		$arrayCondition = array('id = ' . (int)$objData->pk);
		$key = $objData->name;
		$objUpdate->$key = $objData->value;
			
		$tabela = $objData->table;

		$this->crud_model->update($objUpdate, $tabela, $arrayCondition);
	}

	public function remove_diferencial(){
		$this->user_model->logged_admin($this->router->class, $this->router->method);

		if(!$_POST)
			redirect('produto/list-produtos', 'refresh');

		$objData = new stdClass();
		$objData = (object)$_POST;

		$arrayCondition = array('id = ' . (int)$objData->id);
		$this->crud_model->delete('tabDiferencialImovel', $arrayCondition);

		header('Content-Type: application/json');
		echo json_encode(array("msg"=>$this->lang->line("remove_dados_success"), 'type'=>'success', 'icon'=>'fa fa-check'));
	}

    public function new_produto(){
    	$this->user_model->logged_admin($this->router->class, $this->router->method);
    	
    	if(!$_POST)
			redirect('produto/list-produtos', 'refresh');

		$objData = new stdClass();
		$objInsert = new stdClass();
		$objData = (object)$_POST;

		$this->form_validation->set_rules($this->_set_rules_produto());

		if ($this->form_validation->run() === FALSE):
			header('Content-Type: application/json');
			echo json_encode(array("msg" => validation_errors(), 'validate'=>false, 'time'=>3000, 'type'=>'danger'));
		
		else:
			$objInsert->idTipoProduto = $objData->idTipoProduto;
			$objInsert->txtTituloImovel = $objData->txtTituloImovel;
			$objInsert->txtDescricaoImovel = $objData->txtDescricaoImovel;
			$objInsert->txtBairro = $objData->txtBairro;
			$objInsert->txtEstado = $objData->txtEstado;
			$objInsert->txtMetragemPrivada = $objData->txtMetragemPrivada;
			if($objData->datLancamento == ''){
   				$objInsert->datLancamento = null;
   			}else{
				$objInsert->datLancamento = formataData($objData->datLancamento, true);
   			}
   			if($objData->datEntrega == ''){
   				$objInsert->datEntrega = null;
   			}else{
				$objInsert->datEntrega = formataData($objData->datEntrega, true);
   			}
			$objInsert->txtUrlAmigavel = $objData->txtUrlAmigavel;
			$objInsert->txtDescriptionSeo = $objData->txtDescriptionSeo;
			$objInsert->txtCampoLivre = $objData->txtCampoLivre;
			$objInsert = $this->crud_model->insert('tabImovel', $objInsert);

			$data['message'][1] = array(
	            'msg'       	=>  $this->lang->line('insert_dados_success'),
	            'type'      	=>  'success',
            	'notie_notify'	=>	true
	        );

	    	$this->session->set_userdata($data);

	    	header('Content-Type: application/json');
			echo json_encode(array("msg" => 'success', 'validate'=>true));
 		endif;
    }

    public function alter_produto(){
    	$this->user_model->logged_admin($this->router->class, $this->router->method);

		if(!$_POST)
			redirect('produto/list-produtos', 'refresh');

		$objData = new stdClass();
		$objUpdate = new stdClass();
		$objData = (object)$_POST;

		$this->form_validation->set_rules($this->_set_rules_produto($objData->id));

		if ($this->form_validation->run() === FALSE):
			header('Content-Type: application/json');
			echo json_encode(array("msg" => validation_errors(), 'validate'=>false, 'time'=>3000, 'type'=>'danger'));
		else:
			$arrayCondition = array('id = ' . (int)decode($objData->id));
			
			$objUpdate->idTipoProduto = $objData->idTipoProduto;
			$objUpdate->txtTituloImovel = $objData->txtTituloImovel;
			$objUpdate->txtDescricaoImovel = $objData->txtDescricaoImovel;
			$objUpdate->txtBairro = $objData->txtBairro;
			$objUpdate->txtEstado = $objData->txtEstado;
			$objUpdate->txtLatitude = $objData->txtLatitude;
			$objUpdate->txtLongitude = $objData->txtLongitude;
			$objUpdate->txtMetragemPrivada = $objData->txtMetragemPrivada;
			if($objData->datLancamento == ''){
   				$objUpdate->datLancamento = null;
   			}else{
				$objUpdate->datLancamento = formataData($objData->datLancamento, true);
   			}
   			if($objData->datEntrega == ''){
   				$objUpdate->datEntrega = null;
   			}else{
				$objUpdate->datEntrega = formataData($objData->datEntrega, true);
   			}
			$objUpdate->txtUrlAmigavel = $objData->txtUrlAmigavel;
			$objUpdate->txtDescriptionSeo = $objData->txtDescriptionSeo;
			$objUpdate->txtCampoLivre = $objData->txtCampoLivre;
			
			$query = $this->crud_model->update($objUpdate, 'tabImovel', $arrayCondition);

			$data['message'][1] = array(
	            'msg'       =>  $this->lang->line('alter_dados_success'),
	            'type'      =>  'success',
            	'notie_notify'	=>	true
	        );
    		
    		$this->session->set_userdata($data);
    	
			header('Content-Type: application/json');
			echo json_encode(array("msg" => 'success', 'validate'=>true));
		endif;
    }

    public function alter_status_produto(){
		$this->user_model->logged_admin($this->router->class, $this->router->method);
		
		if(!$_POST)
			redirect('dashboard','refresh');

		$objData = new stdClass();
		$objUpdate = new stdClass();
		$objData = (object)$_POST;

		$arrayCondition = array('id = ' . $objData->id);
		$objUpdate->bitAtivo = $objData->bitAtivo;
		$objQuery = $this->crud_model->update($objUpdate, 'tabImovel', $arrayCondition);

		header('Content-Type: application/json');
		echo json_encode(array("msg"=>$this->lang->line("alter_status_success"), 'type'=>'success', 'icon'=>'fa fa-check', 'bitAtivo'=>$objData->bitAtivo));
	}

	public function alter_capa(){

		$objData = new stdClass();
		$objUpdateImovel = new stdClass();
		$objData = (object)$_POST;

		$arrayCondition = array('id = ' . $objData->id);
		$objUpdateImovel->bitCapa = $objData->bitCapa;
		$query = $this->crud_model->update($objUpdateImovel, 'tabMedia', $arrayCondition);

		header('Content-Type: application/json');
		echo json_encode(array("msg"=>$this->lang->line("alter_status_success"), 'type'=>'success', 'icon'=>'fa fa-check', 'bitCapa'=>$objData->bitCapa));
	}

	public function file_upload(){
    	$objData = new stdClass();
		$objData = (object)$_POST;

    	$this->load->library('upload', $this->CONFIG_UPLOAD);

    	if($this->upload->do_upload('userfile')){

            $dataPdf = $this->upload->data();

            if($dataPdf != ''){
	        	$objData->txtPathDocumento = '/assets/documentos/'.$dataPdf['file_name'];
	        }else{
	        	$objData->txtPathDocumento = NULL;
	        }

	        unset($objData->userfile);

	        $arrayCondition = array('id = ' . (int)$objData->id);
			$query = $this->crud_model->update($objData, 'tabImovel', $arrayCondition);

			header('Content-Type:application/json');
	    	echo json_encode(array("msg" =>$this->lang->line("file_success"), "file"=>$dataPdf['file_name']));

        }else{

            header('Content-Type:application/json');
            echo json_encode(array("msg" => $this->upload->display_errors('<span>','</span>'), 'validate'=> FALSE, 'type'=>'danger', 'time'=>3000));
        }
    }

	public function new_especificacao(){
		$this->user_model->logged_admin($this->router->class, $this->router->method);
		
		if(!$_POST)
			redirect('dashboard','refresh');

		$objData = new stdClass();
		$objData = (object)$_POST;
		unset($objData->btnInsert, $objDataId);

		$objData->idImovel = (decode($objData->idImovel));

		$query = $this->crud_model->insert('tabLugaresProximos', $objData);

		$data['message'][1] = array(
            'msg'       =>  $this->lang->line('insert_dados_success'),
            'type'      =>  'success',
        	'icon'		=>	'fa fa-check'
        );
		
		$this->session->set_userdata($data);

		redirect('produto/list-all-especificacoes/'.encode($objData->idImovel),'refresh');
	}

	public function alter_especificacao(){
		$this->user_model->logged_admin($this->router->class, $this->router->method);
		
		if(!$_POST)
			redirect('dashboard','refresh');

		$objData = new stdClass();
		$objUpdate = new stdClass();
		$objData = (object)$_POST;
		
		$arrayCondition = array('id = ' . $objData->id);
		$objUpdate->txtLugarProximo = $objData->txtLugarProximo;
		$objUpdate->idProximidades = $objData->idProximidades;

		$query = $this->crud_model->update($objUpdate, 'tabLugaresProximos', $arrayCondition);

		$data['message'][1] = array(
            'msg'       =>  $this->lang->line('alter_dados_success'),
            'type'      =>  'success',
        	'icon'		=>	'fa fa-check'
        );
		
		$this->session->set_userdata($data);

		redirect('produto/list-all-especificacoes/'.encode($objData->idImovel),'refresh');
	}

	public function remove_especificacao(){
		$this->user_model->logged_admin($this->router->class, $this->router->method);

		if(!$_POST)
			redirect('produto/list-produtos', 'refresh');

		$objData = new stdClass();
		$objData = (object)$_POST;

		$arrayCondition = array('id = ' . (int)$objData->idEspecificacao);
		$this->crud_model->delete('tabLugaresProximos', $arrayCondition);

		header('Content-Type: application/json');
		echo json_encode(array("msg"=>$this->lang->line("remove_dados_success"), 'type'=>'success', 'icon'=>'fa fa-check'));
	}

	public function imoveis_relacionados($idImovel = 0){
		$this->user_model->logged_admin($this->router->class, $this->router->method);

		// if($idImovel == 0)
		// 	redirect('produto/list-produtos','refresh');

		$this->data['imovel'] = $this->imovel_model->get_imovel(decode($idImovel));
		
		if(!count($this->data['imovel']))
			redirect('produto/list-produtos','refresh');
		
		$this->data['all_imoveis'] = $this->imovel_model->get_all_imoveis();
		
		$this->data['relacionadas'] = explode(',', $this->data['imovel'][0]->idImoveisRelacionados);
		
		$this->template->showAdmin('imoveis-relacionados', $this->data, array());		
	}
	
	public function config_relacionados(){
		$this->user_model->logged_admin($this->router->class, $this->router->method);
		
		$objUpdate = new stdClass();

		if(!count($this->input->post('relacionadas'))){
			$objUpdate->idImoveisRelacionados = '';	
		}else{
			$objUpdate->idImoveisRelacionados = implode(',',$this->input->post('relacionadas'));	
		}
		
		$arrayCondition = array('id = '. (int)$this->input->post('id'));
		$this->crud_model->update($objUpdate, 'tabImovel', $arrayCondition);

		$data['message'][1] = array(
            'msg'       =>  $this->lang->line('alter_dados_success'),
            'hashTag'   =>  '#mensagens',
            'type'      =>  'success',
            'time'      =>  5
        );
        $this->session->set_userdata($data);

        redirect('produto/imoveis-relacionados/'.$this->input->post('id'), 'refresh');
	}


	private function _set_fields_produto(){
    	$fields = array(
			(object)array(
				'id'						=>'', 
				'idTipoProduto'				=>'',
				'txtTituloImovel'			=>'',
				'txtDescricaoImovel'		=>'',
				'txtBairro'					=>'',
				'txtEstado'					=>'',
				'txtMetragemPrivada'		=>'',
				'datLancamento'				=>date('d/m/Y'),
				'txtLatitude'				=>'',
				'txtLongitude'				=>'',
				'datEntrega'				=>date('d/m/Y'),
				'txtUrlAmigavel'			=>'',
				'txtDescriptionSeo'			=>'',
				'txtCampoLivre'				=>''
			));

		return $fields;
    }

    private function _set_fields_diferencial(){
    	$fields = array(
			(object)array(
				'id'					=>'', 
				'txtDescricao'			=>'',
				'txtPathIcone'			=>''
			));

		return $fields;
    }

    private function _set_rules_produto($idProduto = 0){
		$config = array(
			array(
				'field' => 'txtTituloImovel',
                'label' => 'Nome do produto',
                'rules' => 'trim|required|min_length[4]|max_length[255]'
			),
			array(
				'field' => 'txtUrlAmigavel',
	            'label' => 'Url Amigavel',
	            'rules' => 'trim|required|min_length[4]|max_length[255]|callback_check_url['.$idProduto.']'
			)
		);
		return $config;
	}

	public function check_url($txtUrlAmigavel = '', $idProduto = 0){
		$validaDuplicidadeUrl = $this->imovel_model->valida_duplicidade_urlAmigavel($txtUrlAmigavel, decode($idProduto));

		chrome_log(decode($idProduto));
		if($validaDuplicidadeUrl){
			$this->form_validation->set_message('check_url', 'A URL Amigável informada já está registrada em nosso sistema <br> Por favor informe outra');
			return FALSE;
		}
		return TRUE;
	}

}