/*
 *  Document   : base_forms_validation.js
 *  Author     : jribeirojr
 *  Description: Custom JS code used in Form Validation Page. 
 *  			 Valida todos os campos que estiverem com o atributo required, inserindo a mensagem padrão
 */
var BaseFormValidation = function() {
    // Init Material Forms Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationDefault = function(){
        jQuery('.js-validation-default').validate({
            errorClass: 'help-block text-right animated fadeInDown',
            errorElement: 'div',
            errorPlacement: function(error, e) {
                jQuery(e).parents('.form-group > div').append(error);
            },
            highlight: function(e) {
                jQuery(e).closest('.form-control').removeClass('has-error').addClass('has-error');
                jQuery(e).closest('.help-block').remove();
            },
            success: function(e) {
                jQuery(e).closest('.form-control').removeClass('has-error');
                jQuery(e).closest('.help-block').remove();
            },
        });
    };

    return {
        init: function () {
            // Init Meterial Forms Validation
            initValidationDefault();
        }
    };
}();

// Initialize when page loads
jQuery(function(){ BaseFormValidation.init(); });

/*
 *  Document   : base_pages_login.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Login Page
 */
var BasePagesLogin = function() {
    // Init Login Form Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationLogin = function(){
        jQuery('.js-validation-login').validate({
            errorClass: 'help-block text-right animated fadeInDown',
            errorElement: 'div',
            errorPlacement: function(error, e) {
                jQuery(e).parents('.form-group > div').append(error);
            },
            highlight: function(e) {
                jQuery(e).closest('.form-group').removeClass('has-error').addClass('has-error');
                jQuery(e).closest('.help-block').remove();
            },
            success: function(e) {
                jQuery(e).closest('.form-group').removeClass('has-error');
                jQuery(e).closest('.help-block').remove();
            },
            rules: {
                'txtSenha': {
                    required: true,
                    minlength: 5
                },
                'txtLogin': {
                    required: true,
                    minlength: 4
                }
            },
            messages: {
                'txtSenha': {
                    required: 'Digite uma senha válida',
                    minlength: 'Sua senha deve conter no mínimo 5 caracteres'
                },
                'txtLogin': {
                    required: 'Digite seu email ou login registrado',
                    minlength: 'O login deve conter pelo menor 4 caracteres'
                }
            }
        });
    };

    return {
        init: function () {
            // Init Login Form Validation
            initValidationLogin();
        }
    };
}();

// Initialize when page loads
jQuery(function(){ BasePagesLogin.init(); });

/*
*	Função para poder validar todos os tipos de formulários
*	é utilizada como uma segunda contingência de dados
*/
$(function($) {
	 "use strict";
	/**
	 * Validação de formulários em geral
	 */
	 $('form').not('.no-validate').each(function(key, form) {
	 	$(form).data('validator', $(form).validate({
	 		ignore : "",
	 		errorElement : false,
	 		highlight : function(field) {
	 			$(field).closest('.form-control').addClass('has-error').removeClass('has-success');
	 		},
	 		unhighlight : function(field) {
	 			$(field).closest('.form-control').removeClass("has-error");
	 		},
	 		errorPlacement : function() {
	 		}
	 	}));
	 });

	 $('[data-rules]').each(function(key, el){
	 	$(el).rules('add', $(el).data('rules'));
	 });

	 /**
	 * Edição básica / Envia dados de um objeto para o formulário
	 */
	 $('[data-edit]').click(function() {
	 	var $el = $(this).closest('[data-' + $(this).data('edit') + ']');
	 	var object = $el.data($(this).data('edit'));
	 	$('[name]', $(this).data('form')).each(function(key, val) {
	 		var value = object[$(val).attr('name')];
	 		if (value) {
	 			if ($(val).is('.txtKeywords')) {
	 				$(val).select2({
	 					tags : [value],
	 					tokenSeparators : [',', ' '],
	 				});
	 				$(val).select2("val", [value]);
	 			} else if ($(val).is('.ckeditor')) {
	 				$(val).ckeditorGet().setData(value);
	 			} else if ($(val).is('.input-file')) {
    				$('#imageFake').html('<img src="/assets/images/'+value+'" />');
	 				$(val).data('image', value);
	 			}
	 			else if(!$(val).is('.radio')) {
	 				$(val).val(value);
	 			}
	 		}
	 	});
	 });
});

/**
 *  [required 	Variável criada para poder realizar a tradução nativa do Jquery Validate]
 *  @type {String}
 */
$.extend($.validator.messages, {
	required: "Campo obrigatório.",
	remote: "Por favor, corrija este campo.",
	email: "Por favor, forne&ccedil;a um endere&ccedil;o de email v&aacute;lido.",
	url: "Por favor, forne&ccedil;a uma URL v&aacute;lida.",
	date: "Por favor, forne&ccedil;a uma data v&aacute;lida.",
	dateISO: "Por favor, forne&ccedil;a uma data v&aacute;lida (ISO).",
	number: "Por favor, forne&ccedil;a um n&uacute;mero v&aacute;lido.",
	digits: "Por favor, forne&ccedil;a somente d&iacute;gitos.",
	creditcard: "Por favor, forne&ccedil;a um cart&atilde;o de cr&eacute;dito v&aacute;lido.",
	equalTo: "Por favor, forne&ccedil;a o mesmo valor novamente.",
	extension: "Por favor, forne&ccedil;a um valor com uma extens&atilde;o v&aacute;lida.",
	maxlength: $.validator.format("Por favor, forne&ccedil;a n&atilde;o mais que {0} caracteres."),
	minlength: $.validator.format("Por favor, forne&ccedil;a ao menos {0} caracteres."),
	rangelength: $.validator.format("Por favor, forne&ccedil;a um valor entre {0} e {1} caracteres de comprimento."),
	range: $.validator.format("Por favor, forne&ccedil;a um valor entre {0} e {1}."),
	max: $.validator.format("Por favor, forne&ccedil;a um valor menor ou igual a {0}."),
	min: $.validator.format("Por favor, forne&ccedil;a um valor maior ou igual a {0}."),
	nifES: "Por favor, forne&ccedil;a um NIF v&aacute;lido.",
	nieES: "Por favor, forne&ccedil;a um NIE v&aacute;lido.",
	cifEE: "Por favor, forne&ccedil;a um CIF v&aacute;lido.",
	postalcodeBR: "Por favor, forne&ccedil;a um CEP v&aacute;lido.",
	cpfBR: "Por favor, forne&ccedil;a um CPF v&aacute;lido."
});