<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Files extends CI_Controller {

	function __construct() {
        parent::__construct();

        $this->load->model('planta_model');
	}
	
	public function index(){
		redirect('dashboard','refresh');
	}

	public function upload_foto_user_admin(){
		$upload_path_url 			= assets_url() . 'img/avatars/';
		$config['upload_path'] 		= str_replace('admin/', '', FCPATH) . 'assets/img/avatars/';
		$config['allowed_types'] 	= 'jpg|jpeg|png|gif';
		$config['overwrite']       	= FALSE;
		$config['max_size'] 		= '20000';
		$config['encrypt_name']		= TRUE;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload()) {
				
		} 
		else {
			$objData = new stdClass();
			$objImagem = new stdClass();
			$objData = (object)$_POST;
			$data = $this->upload->data();

			if (file_exists(str_replace('admin/', 'assets/', FCPATH) . $objData->txtAvatarAnterior) && $objData->txtAvatarAnterior != 'img/avatars/default.jpg')
				unlink(str_replace('admin/', 'assets/', FCPATH) . $objData->txtAvatarAnterior);

			$config = array();
			$config['image_library'] = 'gd2';
			$config['source_image'] = $data['full_path'];
			$config['create_thumb'] = TRUE;
			$config['new_image'] = $data['file_path'];
			$config['maintain_ratio'] = TRUE;
			$config['thumb_marker'] = '';
			$config['width'] = 180;
			$config['width'] = 180;
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			$info = new StdClass;
			$info->name = $data['file_name'];
			$info->size = $data['file_size'] * 1024;
			$info->type = $data['file_type'];
			$info->url = $upload_path_url . $data['file_name'];
			$info->path = $upload_path_url . $data['file_name'];
			$info->deleteType = 'DELETE';
			$info->error = null;

			$files[] = $info;

			for ($img=0; $img < count($files); $img++) { 
				$arrayCondition = array('id = ' . (int)$this->session->userdata['user-adm']['id']);
				$objImagem->txtPathAvatar = 'img/avatars/' . $files[$img]->name;
				$result = $this->crud_model->update($objImagem, 'tabUsuarioAdministrativo', $arrayCondition);
			}
			
			$this->session->userdata['user-adm']['txtPathAvatar'] = $objImagem->txtPathAvatar;

			header('Content-Type: application/json');
			echo json_encode(array("retorno" => $files));
		}
	}

	public function simple_file_upload(){
		$upload_path_url 			= assets_url() . 'img/site/';
		$config['upload_path'] 		= str_replace('admin/', '', FCPATH) . 'assets/img/site/';
		$config['allowed_types'] 	= 'jpg|jpeg|png|gif';
		$config['overwrite']       	= FALSE;
		$config['max_size'] 		= '20000';
		$config['encrypt_name']		= TRUE;
		
	 
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload()) {
				
		} 
		else {
			$objData = new stdClass();
			$objImagem = new stdClass();
			$objData = (object)$_POST;
			$data = $this->upload->data();

			$config = array();
			$config['image_library'] = 'gd2';
			$config['source_image'] = $data['full_path'];
			$config['create_thumb'] = TRUE;
			$config['new_image'] = $data['file_path'];
			$config['maintain_ratio'] = TRUE;
			$config['thumb_marker'] = '';
			$config['width'] = 180;
			$config['width'] = 180;
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			$info = new StdClass;
			$info->name = $data['file_name'];
			$info->size = $data['file_size'] * 1024;
			$info->type = $data['file_type'];
			$info->url = $upload_path_url . $data['file_name'];
			$info->path = $upload_path_url . $data['file_name'];
			$info->deleteType = 'DELETE';
			$info->error = null;

			$files[] = $info;

			header('Content-Type: application/json');
			echo json_encode(array($files[0]));
		}
	}


	public function upload_avatar_produto(){
		$upload_path_url 			= assets_url() . 'img/site/';
		$config['upload_path'] 		= str_replace('admin/', '', FCPATH) . 'assets/img/site/';
		$config['allowed_types'] 	= 'jpg|jpeg|png|gif';
		$config['overwrite']       	= FALSE;
		$config['max_size'] 		= '20000';
		$config['encrypt_name']		= TRUE;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload()) {
			
		} 
		else {
			$objData = new stdClass();
			$objImagem = new stdClass();
			$objData = (object)$_POST;
			$data = $this->upload->data();

			if (file_exists(str_replace('admin/', 'assets/', FCPATH) . $objData->txtImagemAnterior) && $objData->txtImagemAnterior != '' && $objData->txtImagemAnterior != 'img/avatars/default_papababa.jpg')
				unlink(str_replace('admin/', 'assets/', FCPATH) . $objData->txtImagemAnterior);

			$config = array();
			$config['image_library'] = 'gd2';
			$config['source_image'] = $data['full_path'];
			$config['create_thumb'] = TRUE;
			$config['new_image'] = $data['file_path'];
			$config['maintain_ratio'] = TRUE;
			$config['thumb_marker'] = '';
			// $config['width'] = 180;
			// $config['width'] = 180;
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			$info = new StdClass;
			$info->name = $data['file_name'];
			$info->size = $data['file_size'] * 1024;
			$info->type = $data['file_type'];
			$info->url = $upload_path_url . $data['file_name'];
			$info->path = $upload_path_url . $data['file_name'];
			$info->deleteType = 'DELETE';
			$info->error = null;

			$files[] = $info;

			for ($img=0; $img < count($files); $img++) { 
				$arrayCondition = array('id = ' . (int)$objData->idProduto);
				$objImagem->txtPathIcone = 'img/site/' . $files[$img]->name;
				$result = $this->crud_model->update($objImagem, 'tabDiferencialImovel', $arrayCondition);
			}
			
			header('Content-Type: application/json');
			echo json_encode(array("retorno" => $files));
		}
	}

	public function list_image($referencia = '', $name = ''){
		$this->user_model->logged_admin($this->router->class, $this->router->method);
		$this->data['name'] = str_replace('_', ' ', str_replace('%20', ' ', $name));
		$referencia = explode('_',$referencia);


		if($referencia == '' || count($referencia) < 2 || count($referencia) > 2 || $referencia[1] == '')
			redirect('dashboard', 'refresh');

		$this->data['referencia'] = $referencia;

		$this->data['arquivos'] = $this->crud_model->execute_procedure('CALL USP_list_image('.$referencia[0].', \'tab'.ucfirst($referencia[1]).'\')');
		$this->db->reconnect();
		
		$this->data['plantas'] = array();

		$plantaValor = $this->planta_model->get_all_tipo_planta();
		for($i=0; $i<count($plantaValor); $i++){
			$objSubCategorias = new stdClass();
			$objSubCategorias->value = $plantaValor[$i]->txtPlanta;
			$objSubCategorias->text = $plantaValor[$i]->txtPlanta;
			array_push($this->data['plantas'], $objSubCategorias);
			unset($objSubCategorias);
		}
		
		$this->data['plantas']  = str_replace(array('"value"', '"text"', '"'), array('value', 'text', '\''), json_encode($this->data['plantas']));

		if($referencia[1] =="Planta"){
			$this->template->showAdmin('config-media-planta', $this->data);
		}else{
			$this->template->showAdmin('config-media-file', $this->data);
		}

	}

	public function upload_avatar_capa(){
		$upload_path_url 			= assets_url() . 'img/site/';
		$config['upload_path'] 		= str_replace('admin/', '', FCPATH) . 'assets/img/site';
		$config['allowed_types'] 	= 'jpg|jpeg|png|gif';
		$config['overwrite']       	= FALSE;
		$config['max_size'] 		= '20000';
		$config['encrypt_name']		= TRUE;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload()) {
			
		} 
		else {
			$objData = new stdClass();
			$objImagem = new stdClass();
			$objData = (object)$_POST;
			$data = $this->upload->data();

			if (file_exists(str_replace('admin/', 'assets/', FCPATH) . $objData->txtImagemAnterior) && $objData->txtImagemAnterior != '' && $objData->txtImagemAnterior != 'img/avatars/default_olho.jpg')
				unlink(str_replace('admin/', 'assets/', FCPATH) . $objData->txtImagemAnterior);

			$config = array();
			$config['image_library'] = 'gd2';
			$config['source_image'] = $data['full_path'];
			$config['create_thumb'] = TRUE;
			$config['new_image'] = $data['file_path'];
			$config['maintain_ratio'] = TRUE;
			$config['thumb_marker'] = '';
			// $config['width'] = 180;
			// $config['width'] = 180;
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			$info = new StdClass;
			$info->name = $data['file_name'];
			$info->size = $data['file_size'] * 1024;
			$info->type = $data['file_type'];

			$info->url = $upload_path_url . $data['file_name'];
			$info->path = $upload_path_url . $data['file_name'];
			$info->deleteType = 'DELETE';
			$info->error = null;

			$files[] = $info;

			for ($img=0; $img < count($files); $img++) { 
				$arrayCondition = array('id = ' . (int)$objData->idImagem);
				$objImagem->txtIcone = 'img/site/' . $files[$img]->name;
				$result = $this->crud_model->update($objImagem, 'tabBanner', $arrayCondition);
			}
			
			header('Content-Type: application/json');
			echo json_encode(array("retorno" => $files));
		}
	}

	public function do_upload(){
		$upload_path_url 			= assets_url() . 'img/site/';
		$config['upload_path'] 		= str_replace('admin/', '', getcwd() . '/assets/img/site/');
		$config['allowed_types'] 	= 'jpg|jpeg|png|gif';
		$config['overwrite']       	= FALSE;
		$config['max_size'] 		= '300000';
		$config['encrypt_name']		= TRUE;
		 
		$this->load->library('upload', $config);

	 
		if (!$this->upload->do_upload('file')){
			// $this->data['message'][1] = array(
			// 				'msg'       =>  'jorge',
			// 				'hashTag'   =>  '#mensagens',
			// 				'type'      =>  'danger',
			// 				'time'      =>  5
			// );

			// $this->session->set_userdata($this->data);
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
			$objImagem = new stdClass();
			for ($img=0; $img < count($files); $img++) { 
				$referencia = explode('-', $objData->txtReferencia);
				$objImagem->idReferencia = $referencia[0];
				$objImagem->txtReferencia = 'tab'.ucfirst($referencia[1]);
				$objImagem->txtFileName = $files[$img]->name;
				$objImagem->txtPath = 'img/site/' . $files[$img]->name;
				$objImagem->txtTitle = $files[$img]->name;

				// if($objData->txtAreaImagem == 'all-type'){
					$queryImg = $this->crud_model->insert('tabMedia', $objImagem);
				// }
				// else{
				// 	$objImagem->idPagina = $objData->idPagina;
				// 	$queryImg = $this->crud_model->insert('tabBanner', $objImagem);
				// }
				
				$files[$img]->id = $queryImg->id;
				unset($queryImg->id);
			}
			echo json_encode(array("msg"=>$this->lang->line("alter_status_success"), 'type'=>'success', 'icon'=>'fa fa-check'));
		}
	}

	public function remove_reference(){
		$objData = new stdClass();
		$objData = (object)$_POST;

		$arrayCondition = array('id = ' . (int)$objData->remove);
		$this->crud_model->delete('tabMedia', $arrayCondition);

		$success = unlink(str_replace('admin/', '', FCPATH) . 'assets/img/site/' . $objData->image);
        $success = unlink(str_replace('admin/', '', FCPATH) . 'assets/img/site/thumbs/' . $objData->image);

		header('Content-Type: application/json');
		echo json_encode(array("msg"=>$this->lang->line("remove_file_success"), 'type'=>'success', 'icon'=>'fa fa-check'));
	}

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












