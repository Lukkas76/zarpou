<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contato extends CI_Controller {
    
    function __construct() {
        parent::__construct();

        // Model
        $this->load->model('contato_model');
        $this->load->model('crud_model');
        $this->load->model('user_model');

        $this->load->library('form_validation');

    }

    public function index(){
        redirect('dashboard','refresh');
    }

    public function list_tipo_contato(){
    	$this->user_model->logged_admin($this->router->class, $this->router->method);

    	$this->data['tipo_contato'] = $this->contato_model->get_all_tipo_contato();

  		$this->template->showAdmin('list-all-tipo-contato', $this->data);

    }

    public function list_contato_site($datInicio = '', $datFinal = ''){
        $this->user_model->logged_admin($this->router->class, $this->router->method);

        if($datInicio == '')
            $datInicio = date('Y-m-d');

        if($datFinal == '')
            $datFinal = date('Y-m-d');

        $this->data['datInicio']                    = FormataData(str_replace('_', '-', $datInicio));
        $this->data['datFinal']                     = FormataData(str_replace('_', '-', $datFinal));
        $this->data['urlPost']                      = 'contato/list-contato-site/';
        $this->data['contato']                     = $this->contato_model->get_contatos_site($datInicio, $datFinal);

        $this->template->showAdmin('list-contato-site', $this->data, array());
    }

    function alter_dados_contato(){
    
        $objData = new stdClass();
        $objUpdate = new stdClass();
        $objData = (object)$_POST;

        $arrayCondition = array('id = ' . (int)$objData->pk);
        $key = $objData->name;
        $objUpdate->$key = $objData->value;
            
        $tabela = 'tab' . $objData->table;

        $this->crud_model->update($objUpdate, $tabela, $arrayCondition);
    }
}