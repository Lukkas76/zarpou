<!-- Alert Modal Action -->
<div class="modal fade" id="modal-alter-password-administrativo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popin">
        <div class="modal-content">
            <?php
                echo form_open('user/alter-password-user/json', array('class'=>'form-horizontal push-10-t','id'=>'formPassword','method'=>'post'));
                    echo form_hidden(array('idUser' => ''));
            ?>
	                <div class="block block-themed block-transparent remove-margin-b" id="bloco-password">
	                    <div class="block-header bg-primary-dark">
	                        <ul class="block-options">
	                            <li><button data-dismiss="modal" type="button"><i class="si si-close"></i></button></li>
	                        </ul>
	                        <h3 class="modal-title block-title">Alterar a senha do usuário</h3>
	                    </div>
	                    <div class="block-content">
	                        <p>Informe a nova senha do usuário para poder realizar o acesso a área administrativa.</p>
							<div class="row">
								<div class="col-xs-6">
			                        <div class="form-group">
	                                    <label class="col-sm-12">Senha</label>
			                            <div class="col-xs-12">
		                                    <?php echo form_input(array('name'=> 'txtSenha', 'required'=>'required', 'id'=>'txtSenha', 'class'=>'form-control', 'type'=>'password', 'autocomplete' => 'off', 'placeholder'=>'Digite a sua senha ..')); ?>
			                            </div>
			                        </div>
								</div>
								<div class="col-xs-6">
			                        <div class="form-group">
	                                    <label class="col-sm-12">Confirme a senha</label>
			                            <div class="col-xs-12">
		                                    <input type="password" name="txtConfirmaSenha" id="txtConfirmaSenha" class="form-control" required="required" maxlength="14" autocomplete="off" data-rules='{"equalTo":"#txtSenha"}' placeholder=".. Confirme a senha">
			                            </div>
			                        </div>
		                        </div>
							</div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cancelar</button>
	                    <button class="btn btn-sm btn-success btn-action" type="submit" name="btnAlterarPass" ><i class="fa fa-check"></i> Confirmar</button>
	                </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>