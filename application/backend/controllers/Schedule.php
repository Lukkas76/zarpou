<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule extends CI_Controller {

	function __construct() {
        parent::__construct();

        //	Model
        $this->load->model('client_model');

        // Helper
		$this->load->helper('security');
    }

    public function importa_cliente(){
    	$clients = $this->client_model->get_table_import();

    	// foreach ($clients as $key => $cli) {
    	// 	$objInsert = new stdClass();

    	// 	if($cli->Grupo == 'Comumm')
	    // 		$objInsert->idGrupoClient = 1;
	    // 	else if($cli->Grupo == 'Plano Arrojado')
	    // 		$objInsert->idGrupoClient = 2;
	    // 	else if($cli->Grupo == 'Plano Classico')
	    // 		$objInsert->idGrupoClient = 3;
	    // 	else
	    // 		$objInsert->idGrupoClient = 4;

    	// 	//	1	-	Adicionar o cliente no sistema
	    // 	$objInsert->txtNomeClient = $cli->Nome;
	    // 	$objInsert->txtCpf = 0;
	    // 	$objInsert->txtTelefone = $cli->Telefone;
	    // 	$objInsert->txtEmail = strtolower($cli->Email);
	    // 	$objInsert->txtSenha = do_hash(do_hash(123123, 'md5'));
	    // 	$objInsert->bitRegistroImportado = 1;
	    // 	$objInsert->datCreate =  formataData(substr($cli->Desde, 0, 10), true) . ' ' . substr($cli->Desde, 11, 8);
	    // 	$objInsert->idPlataformaMagento =  $cli->ID;

	    // 	$objInsert = $this->crud_model->insert('tabClient', $objInsert);

    	// 	//	2	-	Adicionar o endereço do cliente no sistema
	    // 	$objInsertEndereco = new stdClass();
	    // 	$objInsertEndereco->idClient = $objInsert->id;
	    // 	$objInsertEndereco->idTipoEndereco = 1;
	    // 	$objInsertEndereco->txtCep = $cli->CEP;
	    // 	$objInsertEndereco->txtEstado = $cli->Estado;
	    // 	$objInsertEndereco->txtTituloEndereco = 'Padrão';

	    // 	$objInsertEndereco = $this->crud_model->insert('tabEndereco', $objInsertEndereco);

	    // 	echo $cli->Nome . '<br />';
    	// }
    }
}