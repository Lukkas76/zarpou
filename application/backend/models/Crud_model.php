<?php
class Crud_model extends CI_Model {

	/**
	 *  [delete 	Apaga o registro conforme a condição informada]
	 *  @method  	delete
	 *  @author 	Jorge Ribeiro Junior
	 *  @version 	[1.0.0]
	 *  @date    	2015-03-27
	 *  @param   	string     $table          	[Nome da tabela]
	 *  @param   	array      $arrayCondition 	[Array contendo a condição para poder apagar o registro]
	 */
	public function delete($table = '', $arrayCondition = array()){
		for($w=0;$w<count($arrayCondition);$w++)
			$this->db->where($arrayCondition[$w]);
			$this->db->delete($table);
	}

	/**
     *  [insert 	inserção dos dados no banco de dados]
     *  @method  	insert
     *  @author 	Jorge Ribeiro Junior
     *  @version 	1.0.0
     *  @date    	2014-09-05
     *  @param   	[string] 	$table   	[nome da tabela]
     *  @param   	[Object]    $objData 	[objeto contendo todos os dados que serão inseridos]
     *  @return  	[Object]				[objeto atualizado com os dados inseridos]
     */
    public function insert($table = '', $objData){
		$this->db->insert($table, $objData);

		try {
			$objData->id = $this->db->insert_id();
    		if(!$objData->id)
        		throw new Exception($this->db->_error_message());

        	return $objData;
        	
		} catch (Exception $e) {
			return $e->getMessage();
		}
    }
    
    /**
     *  [update - realiza o update do registro no banco de dados]
     *  @method  update
     *  This is a cool function
     *  @author 	Jorge Ribeiro Junior
     *  @version 	1.0.0
     *  @date    	2014-09-08
     *  @param   	[Object]	$objData        [objeto contendo os campos e valores que serão atualizados]
     *  @param   	[string]	$table          [nome da tabela que será atualizada]
     *  @param   	[array]		$arrayCondition [aray contendo as condições para determinar qual registro será atualizado]
     *  @return  	[Object]					[objeto contendo os dados atualizados]
     */
    public function update($objData, $table = '', $arrayCondition = array()){

    	for($w=0;$w<count($arrayCondition);$w++)
            $this->db->where($arrayCondition[$w]);
        
        try {
    		$query = $this->db->update($table, $objData);
    		if(!$query)
        		throw new Exception($this->db->_error_message());

        	return $objData;
        	
		} catch (Exception $e) {
			return $e->getMessage();
		}
    }

    public function execute_procedure($procedure = ''){
    	$get = $this->db->query($procedure);
       	
       	if($get->num_rows() > 0)
			return $get->result();
		
		return array();
    }

    public function execute_procedure_param($procedure = '', $param = array()){
		$get = $this->db->query($procedure, $param);
       	if($get->num_rows >= 1) 
       		return $get->result();
       	
        return array();
    }

    /**
     * Serve para poder realizar uma inserção em lote no banco de dados
     * @method  insert_batch
     *
     * @author 	JRJ
     * @version 1.0.1
     * @date    2016-08-29
     * @param   string       $table   		Nome da tabela
     * @param   array       $objData 		Array contendo os dados a serem inseridos
     * @return  array]                		Array contendo os dados que foram inseridos
     */
    public function insert_batch($table = '', $objData){
		$this->db->insert_batch($table, $objData);

		try {
        	return $objData;
        	
		} catch (Exception $e) {
			return $e->getMessage();
		}
    }
}
