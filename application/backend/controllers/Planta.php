<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Planta extends CI_Controller {
	
	function __construct() {
        parent::__construct();

        // Library
		$this->load->library('form_validation');

		//	Model
        $this->load->model('planta_model');

    }

    public function index(){
    	redirect('dashboard','refresh');
    }

    public function list_planta(){
    	$this->user_model->logged_admin($this->router->class, $this->router->method);

    	$this->data['planta'] = $this->planta_model->get_all_tipo_planta();

  		$this->template->showAdmin('list-plantas', $this->data);

    }


    public function new_planta(){
    	
    	if(!$_POST)
			redirect('dashboard', 'refresh');

		$objData = new stdClass();
		$objInsertOp = new stdClass();
		$objData = (object)$_POST;
		unset($objData->btnInsert, $objDataId);
		
		$objInsertOp->txtPlanta = $objData->txtPlanta;

		$query = $this->crud_model->insert('tabPlanta', $objInsertOp);

		$data['message'][1] = array(
            'msg'       =>  $this->lang->line('insert_dados_success'),
            'type'      =>  'success',
        	'icon'		=>	'fa fa-check'
        );

	    $this->session->set_userdata($data);

		redirect('planta/list-planta','refresh');
    }


	public function alter_planta(){
		
		if(!$_POST)
			redirect('dashboard','refresh');

		$objData = new stdClass();
		$objUpdateOp = new stdClass();
		$objData = (object)$_POST;
		
		$arrayCondition = array('id = ' . $objData->id);
		$objUpdateOp->txtPlanta = $objData->txtPlanta;

		$query = $this->crud_model->update($objUpdateOp, 'tabPlanta', $arrayCondition);

		$data['message'][1] = array(
            'msg'       =>  $this->lang->line('alter_dados_success'),
            'type'      =>  'success',
        	'icon'		=>	'fa fa-check'
        );
		
		$this->session->set_userdata($data);

		redirect('planta/list-planta','refresh');
	}

	public function remove_planta(){

		if(!$_POST)
			redirect('dashboard', 'refresh');

		$objData = new stdClass();
		$objData = (object)$_POST;

		$arrayCondition = array('id = ' . (int)$objData->id);
		$this->crud_model->delete('tabPlanta', $arrayCondition);

		header('Content-Type: application/json');
		echo json_encode(array("msg"=>$this->lang->line("remove_dados_success"), 'type'=>'success', 'icon'=>'fa fa-check'));
	}

}