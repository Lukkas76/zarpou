<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sobre extends CI_Controller {
    
    function __construct() {
        parent::__construct();

        // Model
        $this->load->model('sobre_model');
        $this->load->model('crud_model');
        $this->load->model('user_model');

        $this->load->library('form_validation');

    }

    public function index(){
        redirect('dashboard','refresh');
    }

    public function list_sobre(){
    	$this->user_model->logged_admin($this->router->class, $this->router->method);

    	$this->data['sobre'] = $this->sobre_model->get_sobre_site();

  		$this->template->showAdmin('list-sobre', $this->data);

    }

    public function action_sobre($idSobre = ''){
        $this->user_model->logged_admin($this->router->class, $this->router->method);

        $this->data['sobre'] = $this->sobre_model->get_sobre($idSobre);
        $this->data['breadcrumb'] = 'Editar';
        $this->data['action'] = 'sobre/alter-sobre';

        $this->template->showAdmin('config-sobre', $this->data);

    }

    public function alter_sobre(){
        $this->user_model->logged_admin($this->router->class, $this->router->method);

        if(!$_POST)
            redirect('sobre/list-sobre', 'refresh');

        $objData = new stdClass();
        $objUpdate = new stdClass();
        $objData = (object)$_POST;

        $this->form_validation->set_rules($this->_set_rules_sobre());

        if ($this->form_validation->run() === FALSE):
            header('Content-Type: application/json');
            echo json_encode(array("msg" => validation_errors(), 'validate'=>false, 'time'=>3000, 'type'=>'danger'));
        else:
            $arrayCondition = array('id = ' . (int)$objData->id);
            
            $objUpdate->txtTitulo = $objData->txtTitulo;
            $objUpdate->txtDescricao = $objData->txtDescricao;
            
            $query = $this->crud_model->update($objUpdate, 'tabSobre', $arrayCondition);

            $data['message'][1] = array(
                'msg'       =>  $this->lang->line('alter_dados_success'),
                'type'      =>  'success',
                'notie_notify'  =>  true
            );
            
            $this->session->set_userdata($data);
        
            header('Content-Type: application/json');
            echo json_encode(array("msg" => 'success', 'validate'=>true));
        endif;
    }

    private function _set_rules_sobre(){
        $config = array(
            array(
                'field' => 'txtTitulo',
                'label' => 'Título',
                'rules' => 'trim|required|min_length[4]|max_length[255]'
            ),
            array(
                'field' => 'txtDescricao',
                'label' => 'Descrição',
                'rules' => 'trim|required|min_length[4]'
            )
        );
        return $config;
    }
}