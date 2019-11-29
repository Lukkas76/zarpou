<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Informacoes extends CI_Controller {
    
    function __construct() {
        parent::__construct();

        // Model
        $this->load->model('informacoes_model');
        $this->load->model('crud_model');
        $this->load->model('user_model');

        $this->load->library('form_validation');

    }

    public function index(){
        redirect('dashboard','refresh');
    }

    public function list_informacoes($datInicio = '', $datFinal = ''){
        $this->user_model->logged_admin($this->router->class, $this->router->method);

        if($datInicio == '')
            $datInicio = date('Y-m-d');

        if($datFinal == '')
            $datFinal = date('Y-m-d');

        $this->data['datInicio']                    = FormataData(str_replace('_', '-', $datInicio));
        $this->data['datFinal']                     = FormataData(str_replace('_', '-', $datFinal));
        $this->data['urlPost']                      = 'informacoes/list-informacoes/';
        $this->data['contato']                      = $this->informacoes_model->list_informacoes($datInicio, $datFinal);

        $this->template->showAdmin('list-informacoes', $this->data, array());
    }
}