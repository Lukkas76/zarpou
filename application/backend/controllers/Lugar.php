<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lugar extends CI_Controller {
	
	function __construct() {
        parent::__construct();

        // Library
		$this->load->library('form_validation');

		//	Model
        $this->load->model('lugar_model');

    }

    public function index(){
    	redirect('dashboard','refresh');
    }

    public function list_tipo_lugar(){
    	$this->user_model->logged_admin($this->router->class, $this->router->method);

    	$this->data['tipo'] = $this->lugar_model->get_all_tipo_lugar();

  		$this->template->showAdmin('list-tipo-lugar', $this->data);

    }


    public function new_tipo(){
    	$this->user_model->logged_admin($this->router->class, $this->router->method);
    	
    	if(!$_POST)
			redirect('dashboard', 'refresh');

		$objData = new stdClass();
		$objInsertOp = new stdClass();
		$objData = (object)$_POST;
		unset($objData->btnInsert, $objDataId);
		
		$objInsertOp->txtProximidade = $objData->txtProximidade;

		$query = $this->crud_model->insert('tabProximidades', $objInsertOp);

		$data['message'][1] = array(
            'msg'       =>  $this->lang->line('insert_dados_success'),
            'type'      =>  'success',
        	'icon'		=>	'fa fa-check'
        );

	    $this->session->set_userdata($data);

		redirect('lugar/list-tipo-lugar','refresh');
    }


	public function alter_tipo(){
		$this->user_model->logged_admin($this->router->class, $this->router->method);
		
		if(!$_POST)
			redirect('dashboard','refresh');

		$objData = new stdClass();
		$objUpdateOp = new stdClass();
		$objData = (object)$_POST;
		
		$arrayCondition = array('id = ' . $objData->id);
		$objUpdateOp->txtProximidade = $objData->txtProximidade;

		$query = $this->crud_model->update($objUpdateOp, 'tabProximidades', $arrayCondition);

		$data['message'][1] = array(
            'msg'       =>  $this->lang->line('alter_dados_success'),
            'type'      =>  'success',
        	'icon'		=>	'fa fa-check'
        );
		
		$this->session->set_userdata($data);

		redirect('lugar/list-tipo-lugar','refresh');
	}

	public function remove_tipo(){
		$this->user_model->logged_admin($this->router->class, $this->router->method);

		if(!$_POST)
			redirect('dashboard', 'refresh');

		$objData = new stdClass();
		$objData = (object)$_POST;

		$arrayCondition = array('id = ' . (int)$objData->id);
		$this->crud_model->delete('tabProximidades', $arrayCondition);

		header('Content-Type: application/json');
		echo json_encode(array("msg"=>$this->lang->line("remove_dados_success"), 'type'=>'success', 'icon'=>'fa fa-check'));
	}

}