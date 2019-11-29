$(document).ready(function(){
	//	Form de inserção do código de acesso para a avaliação
	if ($("#form_login").length){
		var $form_login = $('#form_login');
		$form_login.data('validator').settings.submitHandler = function() {
		    App.blocks('#block-form', 'state_loading');
			$form_login.ajaxSubmit({
				dataType : "json",
				type : 'post',
				url : $(this).action,
				success : function(json) {
					if(json.valid){
						window.location.assign('/admin/dashboard');
					}
					else{
						$(this).notify_notie({msg: json.mensagem, type: 'danger', time: 5});
						$('[name="txtLogin"]').val('').focus();
						$('[name="txtSenha"]').val('');
						setTimeout(function(){
							App.blocks('#block-form', 'state_normal');
						}, 500);
					}
				},
				error : function(e) {
					$(this).notify_notie({msg: e, type: 'danger', time: 10});
				}
			});
			return false;
		};
	}
});