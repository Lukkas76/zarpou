<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notifications extends CI_Controller {
	function __construct() {
		parent::__construct();
	}

	public function index()
	{
		redirect('home', 'refresh');
	}

	/**
	 *  [sessionNotification 	Mostra a mensagem na tela do usuário]
	 *  @method  				sessionNotification
	 *
	 *  @author 				Jorge Ribeiro Junior
	 *  @version 				[1.0.0]
	 *  @date    				2015-04-03
	 */
	public function sessionNotification(){
		header('Content-Type: application/json');
		echo json_encode($this->session->userdata('message'));
		die();
	}

	/**
	 *  [sessionClearNotification 	Limpa o cache de notificações]
	 *  @method  					sessionClearNotification
	 *
	 *  @author 					Jorge Ribeiro Junior
	 *  @version 					[1.0.0]
	 *  @date    					2015-04-03
	 */
	public function sessionClearNotification(){
		$this->session->unset_userdata('message');
	}
}

/* End of file Notifications.php */
/* Location: ./application/controllers/Notifications.php */