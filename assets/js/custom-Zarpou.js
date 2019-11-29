(function($, window) {
	// Função que cria uma notificação para o usuário padrão
	/**
	 *  [notify_user 	Função utilizada para poder exibir uma notificação padrão para o usuário]
	 *  @method  notify_user
	 *
	 *  @author 	jribeirojr
	 *  @version 	1.0.0
	 *  @date    	2015-11-13
	 *  @param   	array    	options 	Recebe um array com todas as variáveis
	 *  @param   	string 		url_clear 	Url que chama o método para poder limpar a Session
	 */
	// $.fn.notify_user = function (options, url_clear){
 //        var $notify         = jQuery(this);
 //        var $notifyMsg      = options.msg;
 //        var $notifyType     = options.type ? options.type : 'info';
 //        var $notifyFrom     = options.from ? options.type : 'top';
 //        var $notifyAlign    = options.align ? options.align : 'center';
 //        var $notifyIcon     = options.icon ? options.icon : '';
 //        var $notifyUrl      = options.url ? options.url : '';
 //        var $notifyProgress = options.progress ? options.progress : false;
 //        var $notifyTime		= options.time ? options.time : 1000;

 //        jQuery.notify({
 //                icon: $notifyIcon,
 //                message: $notifyMsg,
 //                url: $notifyUrl
 //            },
 //            {
 //                element: 'body',
 //                type: $notifyType,
 //                allow_dismiss: true,
 //                newest_on_top: true,
 //                showProgressbar: $notifyProgress,
 //                placement: {
 //                    from: $notifyFrom,
 //                    align: $notifyAlign
 //                },
 //                offset: 80,
 //                spacing: 10,
 //                z_index: 1031,
 //                delay: 5000,
 //                timer: $notifyTime,
 //                animate: {
 //                    enter: 'animated fadeIn',
 //                    exit: 'animated fadeOutDown'
 //            }
 //        });

 //        if(typeof(url_clear) != "undefined" && url_clear !== null)
 //        	$.get(url_clear+'sessionClearNotification');
 //    };

    $.fn.notify_notie = function(options, url_clear){
    	var tipos_mensagens = {success:1, warning:2, danger:3, info:4};
    	var $notify         = jQuery(this);
        var $notifyMsg      = options.msg;
        var $notifyType     = options.type ? tipos_mensagens[options.type] : tipos_mensagens['success'];
        var $notifyTime		= options.time ? options.time : 3;
        
        notie.alert($notifyType, $notifyMsg, $notifyTime);

        if(typeof(url_clear) != "undefined" && url_clear !== null)
        	$.get(url_clear+'sessionClearNotification');
    }

	/**
	 *  Função para poder mostrar notifcações para o usuário, é necessário existir 
	 *  o arquivo Notifications como um Controller
	 */
	var url = window.location.href;
	if (url.indexOf('admin') > -1) {
		var url = '/admin/notifications/';
	}
	else{
		var url = '/notifications/';
	}
	$.get(url+'sessionNotification', function(json){
		if(json != null){
			$.each(json, function(key, value){
				$(value.hashTag).notify_notie(value, url);;
			});
		}
	});
})(jQuery, window);

(function(window){
	'use strict';
	window.objNormalize = function(obj){
		//Normaliza um objeto
		for(var key in obj){
			if((key.indexOf('id') == 0 || key.indexOf('int') == 0) && key.indexOf('idCriptografado') != 0){
				obj[key] = Number(obj[key]);
			}else if(key.indexOf('dat') == 0 && obj[key]){
				if(obj[key] != '31/12/1969'){
					var t = obj[key].split(/[- :]/);
				}else{
					obj[key] = '';
				}
				//obj[key] = new Date(t[0], t[1] - 1, t[2], t[3] || 0, t[4] || 0, t[5] || 0);
			}else if(key.indexOf('bit') == 0){
				obj[key] = Boolean(Number(obj[key]));
			}else if(key == 'txtLatitude' || key == 'txtLongitude' && obj[key]){
				obj[key] = parseFloat(obj[key]);
			}else if(key.indexOf('array') == 0 && obj[key]){
				obj[key] = obj[key].split(',');
				$.each(obj[key], function(index, val){
					if(key.indexOf('Id') == 5 || key.indexOf('Int') == 5){
						if(window[key.replace('arrayId', '').toLowerCase()]){
							obj[key][index] = $.map(window[key.replace('arrayId', '').toLowerCase()], function(val){
								return Number(val.id) == Number(obj[key][index])?val:null;
							})[0];
						}else{
							obj[key][index] = Number(obj[key][index]);
						}
					}else if(key.indexOf('Dat') == 0){
						var t = obj[key][index].split(/[- :]/);
						//obj[key][index] = new Date(t[0], t[1] - 1, t[2], t[3] || 0, t[4] || 0, t[5] || 0);
					}else if(key.indexOf('Bit') == 0){
						obj[key][index] = Boolean(Number(obj[key][index]));
					}
				});
				
			}else if(obj[key] instanceof Array){
				$.each(obj[key], function(index, val){
					objNormalize(obj[key][index]);
				});
			}else if(typeof obj[key] == 'object' && obj[key]){
				objNormalize(obj[key]);
			}
		}
		return obj;
	};

	// carregando os dados em dataSource
	var sources = (document.getElementById('dataSource'))?document.getElementById('dataSource').getElementsByTagName('img'):[];
	for(var key in sources){
		if(sources[key].src){
			window[sources[key].alt] = JSON.parse(decodeURIComponent(escape(atob(sources[key].src.replace('data:image/png;base64,','')))));
			//Normalizando os objetos encontrados
			if(window[sources[key].alt] instanceof Array){
				for(var i in window[sources[key].alt]){
					objNormalize(window[sources[key].alt][i]);
				}
			}else if(typeof window[sources[key].alt] == 'object'){
				objNormalize(window[sources[key].alt]);
			}
		}
	}
})(window);

(function($, window){
	$.fn.objParse = function(options) {
		var defaults = {};
		var settings = $.extend({}, defaults, options);

		return this.each(function(key, el){
			//Associa os objeto ao elemento pelo id
			var array = $(el).data('obj').split("#");
			var name = array[0];
			var id = array[array.length-1];
			var obj = window;
			for(var x in name.split('.')){
				obj = obj[name.split('.')[x]];
			}
			$(el).data('obj', $.map(obj, function(val){return Number(val.id) == Number(id)?val:null;})[0]);
			return $(el);
		});
	}
})(jQuery, window);

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
 				// $('.fileupload-preview.thumbnail', $(val).closest('[data-provides="fileupload"]')).html('<img src="/assets/images/'+value+'" />');
 				$(val).data('image', value);
 				// $(val).val(value);
 			}
 			else if(!$(val).is('.radio')) {
 				$(val).val(value);
 			}
 		}
 	});
 });

// Serve para podermos associar o OBJ ao DataSource
$(function($) {
	 "use strict";
	// suporte para data-* nos seletores ex: $(':obj') seleciona todos data-obj
	$.each(['obj', 'prop'], function(key, data){var obj = {};obj[data] = function(a) {return $(a).data(data);};$.extend($.expr[':'],obj);});
	$.extend($.expr[':'],{obj: function(a) {return $(a).data('obj');}, prop: function(a){return $(a).data('prop')}});
	// associando os dados com cada data-obj ao dataSource
	$(':obj').each(function(key, el){
		$(el).objParse();
	});
});

/**
 *  [description 		Código criado para ser utilizado em todas as telas onde é necessário ATIVAR ou DESATIVAR qualquer
 *  					tipo de registro, assim não é necessário inserir este código em todas as páginas que utilizem
 *  					esta funcionalidade]
 *  @method 			No link onde será criado o botão para a ação devemos ter dois DATAS, sendo eles
 *             			data-action		-> URL para onde a ação será submitada
 *             			data-table		-> tabela que irá sofrer o UPDATE
 *
 *  @author 			Jorge Ribeiro Junior
 *  @version 			[1.0.0]
 *  @date    			2015-08-05
  */
$(document).ready(function(){
    $('[data-status]').on('click',function(){
		var $el = $(this).closest(':obj');
		var $btn = $(this);
		var obj = $el.data('obj');
		var action = $(this).data('action');
		if( typeof obj.bitAtivo != 'undefined')
			obj.bitAtivo = Number(!Number(obj.bitAtivo));
		else
			obj.bitStatus = Number(!Number(obj.bitStatus));
		$(this).ajaxSubmit({
			type: 'post',
			url: action,
			async : true,
			data: obj,
			success: function(json){
				if(Number(json.bitAtivo == 0)){
					$('.label, .badge', $el).removeClass('label-success').addClass('label-danger').text('Inativo');
					$('.bg-city', $el).removeClass('bg-city').addClass('bg-success');
					$('.fa-power-off', $el).removeClass('fa-power-off').addClass('fa-check');
					$('.linha', $el).addClass('text-danger');
				}else{
					$('.label, .badge', $el).removeClass('label-danger').addClass('label-success').text('Ativo');
					$('.bg-success', $el).removeClass('bg-success').addClass('bg-city');
					$('.fa-check', $el).removeClass('fa-check').addClass('fa-power-off');
					$('.linha', $el).removeClass('text-danger');
				}
				$(this).notify_notie(json);
			},
			error: function(e){
				$(this).notify_notie({msg: e.responseText, type: 'danger'});
			}
		});
		return false;
	});
});

//////////////////////////////////////////////////////////////////////////////
// 	Função que não permite digitar determinados caracteres em um campo input //
// 		FORMA DE UTILIZAR
// 		$('[name="NOME_DO_INPUT"]').removeNot({ options: 'NOME_DO_OPTIONS'});
// 		EXEMPLO:
// 			$('[name="txtNome"]').removeNot({ options: 'alpha'});
//////////////////////////////////////////////////////////////////////////////
jQuery.fn.removeNot = function( settings ){
	var $this = jQuery( this );
	var defaults = {
		options: settings.options,
		replacement: ''
	}

	switch(defaults.options){
		case 'number':
			defaults.pattern = /[^0-9]+/g;
			break;
		case 'alpha':
			defaults.pattern = /[^a-zA-Zà-úÀ-Ú]+/gi;
			break;
		case 'alpha_number':
			defaults.pattern = /[^a-zA-Zà-úÀ-Ú0-9]+/g;
			break;
		case 'alpha_space':
			defaults.pattern = /[^a-zA-Zà-úÀ-Ú" "]+/g;
			break;
		case 'alpha_number_space':
			defaults.pattern = /[^a-zA-Zà-úÀ-Ú0-9" "]+/g;
			break;
	}

	settings = jQuery.extend(defaults, settings);

	$this.keyup(function(){
		setTimeout(function(){
			var new_value = $this.val().replace(settings.pattern, settings.replacement );
			$this.val( new_value );
		}, 300)
	});
	return $this;
}

function tiracento(strToReplace) {
	str_trocarIsso 	= "&àáâãäåçèéêëìíîïñòóôõöùüúÿÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÑÒÓÔÕÖOÙÜÚŸ _\/[]{},;:?!'@#$%¨¬*()+=§^~/|°<>.";
	str_porIsso 	= "eaaaaaaceeeeiiiinooooouuuyAAAAAACEEEEIIIINOOOOOOUUUY----------------------------------";
	str_nova = "";  
	for(i=0;i<strToReplace.length;i++) {
		if (str_trocarIsso.search(strToReplace.substr(i,1))>=0) {
			str_nova+=str_porIsso.substr(str_trocarIsso.search(strToReplace.substr(i,1)),1)
		}
		else {  
			str_nova+=strToReplace.substr(i,1)
		}
	}  
	return str_nova;
}