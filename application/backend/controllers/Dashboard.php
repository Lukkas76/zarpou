<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct() {
        parent::__construct();
    }

	public function index(){
		$this->user_model->logged_admin($this->router->class, $this->router->method);

		$this->data['dashboard'] = '';

		$arrayGrupoAcessoAdm = array(1,5,7);

		// if(in_array($this->session->userdata['user-adm']['idGroupAccess'], $arrayGrupoAcessoAdm)){

		// 	//	1	-	Buscar os dados de faturamento do dia
		// 	$this->data['new_orders'] = $this->crud_model->execute_procedure('CALL USP_count_order()');

		// 	//	2	-	Buscar os dados de aulas a serem realizadas no dia
		// 	$this->data['reservas'] = $this->crud_model->execute_procedure('CALL USP_count_reserva_day()');

		// 	// 3    -   Total de cadastros até hoje e no mês atual
		// 	$this->data['total_registros'] = $this->aluno_model->total_registros();
		// 	$this->data['total_registros_mes'] = $this->aluno_model->total_registro_periodo();
		// }

   		

  		$this->template->showAdmin('dashboard', $this->data);
	}

	/**
	 *  [acesso_negado 	Mostra mensagem de acesso negado a uma determinada página do administrativo]
	 *  @method  		acesso_negado
	 *
	 *  @author 		Jorge Ribeiro Junior
	 *  @version 		[1.0.0]
	 *  @date    		2015-04-03
	 *  @return  		[View]        [Página HTML]
	 */
	function acesso_negado(){
		$this->user_model->logged_admin();

		$this->template->showAdmin('acesso-negado');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */