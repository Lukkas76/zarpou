<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banner extends CI_Controller {
	
	function __construct() {
		parent::__construct();

		// Model
		$this->load->model('banner_model');
		$this->load->model('crud_model');
		$this->load->model('user_model');

	}
	
	/**
	 * Redireciona para o dashboard
	 *
	 * @author lucas
	 * @version 1.0.0
	 * @date    2016-02-18
	 * @return  type     description
	 */
	
	public function index(){
		redirect('dashboard','refresh');
	}

	/**
	 * função para abrir página config-banner
	 *
	 * @author lucas
	 * @version 1.0.0
	 * @date    2016-02-18
	 * @param   integer    $idPagina description
	 * @return  type               description
	 */
	
	public function config_banner(){
		$this->user_model->logged_admin($this->router->class, $this->router->method);

		$this->data['banners'] = $this->banner_model->list_all_banner();
		
		$this->template->showAdmin('config-banner', $this->data);
	}

	/**
	 * abre página que lista os banners list_banner 
	 *
	 * @author lucas
	 * @version 1.0.0
	 * @date    2016-02-18
	 * @return  type     description
	 */
	
	public function list_banner(){
		$this->user_model->logged_admin($this->router->class, $this->router->method);

		$this->data['paginas'] = $this->banner_model->list_paginas();

		$this->template->showAdmin('list-paginas', $this->data);
	}

	/**
	 * função para listar as imagens
	 *
	 * @author lucas
	 * @version 1.0.0
	 * @date    2016-02-18
	 * @param   string     $referencia description
	 * @param   string     $name       description
	 * @return  type                 description
	 */
	
	public function list_image($referencia = '', $name = ''){
		$this->data['name'] = str_replace('%20', ' ', $name);
		$referencia = explode('_',$referencia);

		if($referencia == '' || count($referencia) < 2 || count($referencia) > 2 || $referencia[1] == '')
			redirect('dashboard', 'refresh');

		$this->data['referencia'] = $referencia;
		$this->data['arquivos'] = $this->crud_model->execute_procedure('CALL USP_list_image('.$referencia[0].', \'tab'.ucfirst($referencia[1]).'\')');

		$this->template->showAdmin('config-media-file', $this->data);
	}

	/**
	 * função para fazer o upload de um banner
	 *
	 * @author lucas
	 * @version 1.0.0
	 * @date    2016-02-18
	 * @return  type     description
	 */
	
	public function do_upload(){
		$this->load->helper('text');
		$config['upload_path'] = str_replace('admin/', '', getcwd() . '/assets/img/site');
		$config['allowed_types'] = 'jpg|jpeg|png|gif';
		$config['overwrite']       	= FALSE;
		$config['max_size'] = '300000000';
		$config['encrypt_name']		= TRUE;
		 
		$this->load->library('upload', $config);
	 
		if (!$this->upload->do_upload('file')){
			chrome_log($this->upload->display_errors());

		}
		else{
			$objData = new stdClass();
			$objData = (object)$_POST;
			$data = $this->upload->data();

			$config = array();
			$config['image_library'] = 'gd2';
			$config['source_image'] = $data['full_path'];
			$config['create_thumb'] = TRUE;
			$config['new_image'] = $data['file_path'] . 'thumbs/';
			$config['maintain_ratio'] = TRUE;
			$config['thumb_marker'] = '';
			$config['width'] = 400;
			// $config['height'] = 50;
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			$info = new StdClass;
			$info->name = $data['file_name'];
			$info->size = $data['file_size'] * 1024;
			$info->type = $data['file_type'];
			$info->url = $upload_path_url . $data['file_name'];
			$info->thumbnailUrl = $upload_path_url . 'thumbs/' . $data['file_name'];
			$info->deleteUrl = base_url() . 'upload/deleteImage/' . $data['file_name'];
			$info->deleteType = 'DELETE';
			$info->error = null;

			$files[] = $info;
			for ($img=0; $img < count($files); $img++) { 
				$referencia = explode('-', $objData->txtReferencia);
				$objImagem->idReferencia = $referencia[0];
				$objImagem->txtReferencia = 'tab'.ucfirst($referencia[1]);
				$objImagem->txtTipo = 'image';
				$objImagem->txtFileName = $files[$img]->name;
				$objImagem->txtPath = 'img/site/' . $files[$img]->name;
				$objImagem->txtTitle = $files[$img]->name;

				// $queryImg = $this->crud_model->insert('tabMedia', $objImagem);  

				if($objData->txtAreaImagem == 'type-banner'){
					$objImagem->idPagina = $objData->idPagina;
					unset($objImagem->idReferencia, $objImagem->txtReferencia, $objImagem->txtTipo);
					$queryImg = $this->crud_model->insert('tabBanner', $objImagem);
				}
				// else{
				// 	// $queryImg = $this->crud_model->insert('tabMedia', $objImagem);
				// }

				$files[$img]->id = $queryImg->id;
				unset($queryImg->id);
			}
			echo json_encode(array("msg"=>$this->lang->line("alter_status_success"), 'type'=>'success', 'icon'=>'fa fa-check'));
		}
	}

	/**
	 * Função para deletar um banner
	 *
	 * @author lucas
	 * @version 1.0.0
	 * @date    2016-02-18
	 * @return  type     description
	 */
	
	public function remove_reference(){
		$objData = new stdClass();
		$objData = (object)$_POST;

		$table = 'tab'.$objData->table;

		$arrayCondition = array('id = ' . (int)$objData->remove);
		$this->crud_model->delete($table, $arrayCondition);

		$success = unlink(str_replace('admin/', '', FCPATH) . 'assets/img/site/' . $objData->image);


		header('Content-Type: application/json');
		echo json_encode(array("msg"=>$this->lang->line("remove_file"), 'type'=>'success', 'icon'=>'fa fa-check'));
	}

	/**
	 * função para alterar dados in-line
	 *
	 * @author lucas
	 * @version 1.0.0
	 * @date    2016-02-18
	 * @return  type     description
	 */
	
	public function alter_dados_media(){
		if(!$_POST)
			redirect('dashboard', 'refresh');
	
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