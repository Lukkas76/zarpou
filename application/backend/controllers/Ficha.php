<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ficha extends CI_Controller {
	
	function __construct() {
        parent::__construct();

        // Library
		$this->load->library('form_validation');

		//	Model
        $this->load->model('ficha_model');
        $this->load->model('imovel_model');

    }

    public function index(){
    	redirect('dashboard','refresh');
    }

    public function list_ficha($idImovel = 0){
    	$this->user_model->logged_admin($this->router->class, $this->router->method);
    	// 
    	$this->data['nome'] = $this->imovel_model->get_imovel(decode($idImovel));

    	$this->data['idImovel'] = $idImovel;

    	$this->data['ficha'] = $this->ficha_model->get_all_fichatecnica(decode($idImovel));

  		$this->template->showAdmin('list-ficha', $this->data);

    }


    public function new_ficha(){
    	$this->user_model->logged_admin($this->router->class, $this->router->method);
    	
    	if(!$_POST)
			redirect('dashboard', 'refresh');

		$objData = new stdClass();
		$objInsertOp = new stdClass();
		$objData = (object)$_POST;
		unset($objData->btnInsert, $objDataId);

		$objInsertOp->idImovel = (decode($objData->idImovel));
		$objInsertOp->txtFichaTecnica = $objData->txtFichaTecnica;
		$objInsertOp->txtConteudo = $objData->txtConteudo;

		$query = $this->crud_model->insert('tabFichaTecnica', $objInsertOp);

		$data['message'][1] = array(
            'msg'       =>  $this->lang->line('insert_dados_success'),
            'type'      =>  'success',
        	'icon'		=>	'fa fa-check'
        );

	    $this->session->set_userdata($data);

		redirect('ficha/list-ficha/'.encode($objInsertOp->idImovel),'refresh');
    }


	public function alter_ficha(){
		$this->user_model->logged_admin($this->router->class, $this->router->method);
		
		if(!$_POST)
			redirect('dashboard','refresh');

		$objData = new stdClass();
		$objUpdateOp = new stdClass();
		$objData = (object)$_POST;
		
		$arrayCondition = array('id = ' . $objData->id);
		$objUpdateOp->txtFichaTecnica = $objData->txtFichaTecnica;
		$objUpdateOp->txtConteudo = $objData->txtConteudo;

		$query = $this->crud_model->update($objUpdateOp, 'tabFichaTecnica', $arrayCondition);

		$data['message'][1] = array(
            'msg'       =>  $this->lang->line('alter_dados_success'),
            'type'      =>  'success',
        	'icon'		=>	'fa fa-check'
        );
		
		$this->session->set_userdata($data);

		redirect('ficha/list-ficha/'.encode($objData->idImovel),'refresh');
	}

	public function remove_ficha(){
		$this->user_model->logged_admin($this->router->class, $this->router->method);

		if(!$_POST)
			redirect('dashboard', 'refresh');

		$objData = new stdClass();
		$objData = (object)$_POST;

		$arrayCondition = array('id = ' . (int)$objData->id);
		$this->crud_model->delete('tabFichaTecnica', $arrayCondition);

		header('Content-Type: application/json');
		echo json_encode(array("msg"=>$this->lang->line("remove_dados_success"), 'type'=>'success', 'icon'=>'fa fa-check'));
	}

}