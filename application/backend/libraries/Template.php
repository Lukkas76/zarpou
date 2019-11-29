<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template{
	var $template_data = array();

	public  $name               = '',
            $version            = '',
            $author             = '',
            $robots             = '',
            $title              = '',
            $description        = '',
            $assets_folder      = '',
            $body_bg            = '',
            $main_nav_active    = '',
            $theme              = '',
            $cookies = false,
            $l_sidebar_position = 'left',
            $l_sidebar_mini = true,
            $l_sidebar_visible_desktop = true,
            $l_sidebar_visible_mobile = false,
            $l_side_overlay_hoverable = false,
            $l_side_overlay_visible = false,
            $l_side_scroll = true,
            $l_header_fixed = true,
            $l_header_transparent,
            $inc_side_overlay = false,
            $inc_sidebar = true,
            $inc_header = true;

    private $nav_html           = '',
            $page_classes       = '';

    /**
     * Class constructor
     */
    public function __construct($name = '', $version = '', $assets_folder = '') {
        // Set Template's name, version and assets folder
        $this->name                 = $name;
        $this->version              = $version;
        $this->assets_folder        = $assets_folder;
    }

    function showAdmin($view, $data = array(), $meta_tags = array()){
		// Get current CI Instance
		$CI = & get_instance();

		// Library
		$CI->load->library('parser');

		// Load template views
		
		$CI->parser->parse('template/template_head_start', array());
		$CI->load->view($view, $data);
	}

	function showTemplate($item, $data = array()){
		// Get current CI Instance
		$CI = & get_instance();

		// Load menu template
		$CI->load->view($item, $data);
	}

    /**
     * Builds #page-container classes
     *
     * @param   boolean $print True to print the classes and False to return them
     *
     * @return  string  Returns the classes if $print is set to false
     */
    public function page_classes($print = true) {
        // Build page classes
        if ($this->cookies) {
            $this->page_classes .= ' enable-cookies';
        }

        if ($this->l_sidebar_position == 'left') {
            $this->page_classes .= ' sidebar-l';
        } else if ($this->l_sidebar_position == 'right') {
            $this->page_classes .= ' sidebar-r';
        }

        if ($this->l_sidebar_mini) {
            $this->page_classes .= ' sidebar-mini';
        }

        if ($this->l_sidebar_visible_desktop) {
            $this->page_classes .= ' sidebar-o';
        }

        if ($this->l_sidebar_visible_mobile) {
            $this->page_classes .= ' sidebar-o-xs';
        }

        if ($this->l_side_overlay_hoverable) {
            $this->page_classes .= ' side-overlay-hover';
        }

        if ($this->l_side_overlay_visible) {
            $this->page_classes .= ' side-overlay-o';
        }

        if ($this->l_side_scroll) {
            $this->page_classes .= ' side-scroll';
        }

        if ($this->l_header_fixed) {
            $this->page_classes .= ' header-navbar-fixed';
        }

        if ($this->l_header_transparent) {
            $this->page_classes .= ' header-navbar-transparent';
        }

        // Print or return page classes
        if ($this->page_classes) {
            if ($print) {
                echo ' class="'. trim($this->page_classes) .'"';
            } else {
                return trim($this->page_classes);
            }
        } else {
            return false;
        }
    }

    /**
     * Builds main navigation
     *
     * @param   boolean     $print True to print the navigation and False to return it
     *
     * @return  string      Returns the navigation if $print is set to false
     */
    public function build_nav($print = true) {
        // Build navigation
        $this->build_nav_array($this->carrega_arquivo_xml());

        // Print or return navigation
        if ($print) {
            echo $this->nav_html;
        } else {
            return $this->nav_html;
        }
    }

    /**
     * Build navigation helper - Builds main navigation one level at a time
     *
     * @param string    $nav_array A multi dimensional array with menu/submenus links
     */
    private function build_nav_array($nav_array) {
        foreach ($nav_array as $node) {
        	
        	// Determinar em qual menu será colocada a classe active
        	$this->main_nav_active = str_replace('/admin/', '', $_SERVER['REQUEST_URI']);
        	$capturarClasseMetodo = explode('/', $this->main_nav_active);
        	if(!isset($capturarClasseMetodo[1]))
        		$this->main_nav_active = $capturarClasseMetodo[0];
        	else
        		$this->main_nav_active = $capturarClasseMetodo[0] . '/' . $capturarClasseMetodo[1];
       		
            // Get all vital link info
            $link_name      = isset($node['name']) ? $node['name'] : '';
            $link_icon      = isset($node['icon']) ? '<i class="' . $node['icon'] . '"></i>' : '';
            $link_url       = isset($node['url']) ? $node['url'] : '#';
            $link_sub       = isset($node['sub']) && is_array($node['sub']) ? true : false;
            $link_type      = isset($node['type']) ? isset($node['type']) : '';
            $sub_active     = false;
            $link_active    = $link_url == $this->main_nav_active ? true : false;

            // If link type is a header
            if ($link_type == 'heading') {
                $this->nav_html .= "<li class=\"nav-main-heading\">$link_name</li>\n";
            } else {
                // If it is a submenu search for an active link in all sub links
                if ($link_sub) {
                    $sub_active = $this->build_nav_array_search($node['sub']) ? true : false;
                }

                // Set menu properties
                $li_prop        = $sub_active ? ' class="open"' : '';
                $link_prop      = $link_sub ? ' class="nav-submenu' . ($link_active ? ' active' : '') . '" data-toggle="nav-submenu"' : ($link_active ? ' class="active"' : '');

                // Add the link
                $this->nav_html .= "<li$li_prop>\n";
                $this->nav_html .= '<a ' . $link_prop . ' href="' . base_url($link_url) . '">' . $link_icon . $link_name . '</a>';

                // If it is a submenu, call the function again
                if ($link_sub) {
                    $this->nav_html .= "<ul>\n";
                    $this->build_nav_array($node['sub']);
                    $this->nav_html .= "</ul>\n";
                }
                $this->nav_html .= "</li>\n";
            }
        }
    }

    /**
     * Build navigation helper - Search navigation array for active menu links
     *
     * @param   string      $nav_array A multi dimensional array with menu/submenus links
     *
     * @return  boolean     Returns true if an active link is found
     */
    private function build_nav_array_search($nav_array) {
        foreach ($nav_array as $node) {
            if (isset($node['url']) && ($node['url'] == $this->main_nav_active)) {
                return true;
            } else if (isset($node['sub']) && is_array($node['sub'])) {
                if ($this->build_nav_array_search($node['sub'])) {
                    return true;
                }
            }
        }
    }

    /**
     * Prints a random label
     *
     * @param boolean $print True to print the generated label and False to return it
     *
     * @return string  Returns the generated label if $print is set to false
     */
    public function get_label($value, $print = true) {
        // Label seed data
        $data   = array(
            '0' => array('class' => 'danger', 'text'  => 'Inativo'),
            '1' => array('class' => 'success', 'text'  => 'Ativo')
            // '1' => array('class' => 'info', 'text'  => 'Business'),
            // '2' => array('class' => 'primary', 'text'  => 'Personal'),
            // '3' => array('class' => 'warning', 'text'  => 'Trial'),
        );

        // Generate label
        $label  = '<span class="label label-' . $data[$value]['class'] . '">' . $data[$value]['text'] . '</span>'. "\n";

        // Print or return generated label
        if ($print) {
            echo $label;
        } else {
            return $label;
        }
    }

    public function get_icon_action($value) {
        // Label seed data
        $data   = array(
            '0' => array('icon' => 'fa fa-check', 'text'  => 'Habilitar', 'style' => 'bg-success'),
            '1' => array('icon' => 'fa fa-power-off', 'text'  => 'Desabilitar', 'style' => 'bg-city')
        );

        // Generate icon
        $icon = array('icon' => '<i class="' . $data[$value]['icon'] . '"></i>', 'style' => $data[$value]['style']);

        return $icon;
    }

    /**
     * Monta o array com as permissões que o usuário possui para os botões da página
     * @method  array_permissao_button
     *
     * @author 		JRJ
     * @version 	1.0.0
     * @date    	2016-01-30
     * @param   	string 			$txtPermissoes 		Uma string serializada com o array de permissões que o usuário possui
     * @param   	array  			$data 				Nome do array que as permissões deverão ser salvas para serem utilizadas na página
     * @return 		array 								Retorna um array com o resultado das permissões da página
     */
    function array_permissao_button($txtPermissoes = array()){
		$CI = & get_instance();
		$CI->data['permissao'] = array();

		foreach ($txtPermissoes as $key => $value) {
			$direitos = explode('|', $value->txtPermissoes);
			if($direitos[0] != ''){
				for ($dir=0; $dir < count($direitos); $dir++) { 
					$permissao = explode(';', $direitos[$dir]);
					$CI->data['permissao'][$permissao[1]] = $permissao[2];
				}
			}
		}
		return $CI->data['permissao'];
	}

    private function carrega_arquivo_xml(){
    	$ci = & get_instance();

    	$CHANGETHIS_TO_XML_HTTP_PATH = assets_url('menu/' . $ci->session->userdata['user-adm']['txtMenuFile'] . '.xml');
    	// $arquivo_xml = simplexml_load_file(assets_url('menu/jorge.xml'));

    	// $CHANGETHIS_TO_XML_HTTP_PATH = assets_url('menu/jorge.xml');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $CHANGETHIS_TO_XML_HTTP_PATH);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
		// $xml = simplexml_load_file(base_url('assets/menu/' . $ci->session->userdata['user-adm']['txtMenuFile'] . '.xml'));
		$xml = simplexml_load_string($output);

		$main_nav_xml = array();
		foreach ($xml->link as $link) {
			if((string)$link->type == 'menu'){
				if(isset($link->attributes()->class)){
					$arrayNivel02 = array();
					foreach($link->sublink->link as $nivel02){
						if(isset($nivel02->attributes()->class)){
							$arrayNivel03 = array();
							foreach ($nivel02->sublink->link as $nivel03) {
								$arrayMenuNivel03 = array(
										'name'=>(string)$nivel03->menu,
										'url'=>(string)$nivel03->url);

								array_push($arrayNivel03, $arrayMenuNivel03);
							}

							$arrayMenuNivel02 = array(
								'name'=>(string)$nivel02->menu, 
								'sub'=>$arrayNivel03);
						}
						else{
							$arrayMenuNivel02 = array(
											'name'=>(string)$nivel02->menu,
											'url'=>(string)$nivel02->url);
						}
						array_push($arrayNivel02, $arrayMenuNivel02);
					}					

					$arrayMenu = array(
								'name'=>'<span class="sidebar-mini-hide">' . (string)$link->menu .'</span>', 
								'icon'=>(string)$link->icone,
								'sub'=>$arrayNivel02);
				}
				else{
					$arrayMenu = array(
								'name'=>'<span class="sidebar-mini-hide">' . (string)$link->menu .'</span>', 
								'icon'=>(string)$link->icone, 
								'url'=>(string)$link->url);
				}
			}
			else if((string)$link->type == 'heading'){
				$arrayMenu = array(
							'name'=>'<span class="sidebar-mini-hide">' . (string)$link->menu .'</span>', 
							'type'=>(string)$link->type);
			}
			array_push($main_nav_xml, $arrayMenu);
        }

        return $main_nav_xml;
    }

    /**
	 *  [geraArquivoMenuXml 	Gera o arquivo XML conforme o Array de Menus que é passado]
	 *  @method  				geraArquivoMenuXml
	 *  @author 				Jorge Ribeiro Junior
	 *  @version 				[1.0.0]
	 *  @date    				2015-03-19
	 *  @param   [Integer]   	$idPesquisar 		[0 quanto é um menu do tipo Pai e diferente de 0 quando é um menu do tipo filho]
	 *  @param   [Array]      	$arrayMenus  		[Array contendo os menus que serão utilizados para montar o XML]
	 *  @param   [Integer]  	$nivel       		[Código inteiro apenas para poder utilizar na tabulação dos dados]
	 *  @return  [XMLS]                          	[Arquivo XML com toda a estrutura para ser criado o menu]
	 */
	public function gera_arquivo_menu_xml($idPesquisar, $arrayMenus, $nivel){
		$arrayEstururaMenu = array();
		$menu = '';

		if($idPesquisar == 0):
			$menu .= '<?xml version="1.0" encoding="UTF-8"?>';
			$menu .= "\n" . str_repeat( "\t" , $nivel ) . '<menu>';
		else:
			$menu .=  "\n" . str_repeat( "\t" , $nivel ) . '<sublink>';
		endif;

		foreach ($arrayMenus[$idPesquisar] as $idMenu => $menuItem) {
			array_push($arrayEstururaMenu, $menuItem);

			if(isset($arrayMenus[$idMenu])){
				$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 1) ) . '<link class="dropdown">';
				if((int)$menuItem['bitCabecalho'] == 0)
					$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 2)) . '<type><![CDATA[menu]]></type>';
				else
					$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 2)) . '<type><![CDATA[heading]]></type>';
				$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 2)) . '<class><![CDATA[sidebar-mini-hide]]></class>';
				$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 2)) . '<url>' . $menuItem['txtUrl'] . '</url>';
				$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 2)) . '<menu><![CDATA[' . $menuItem['txtMenu'] . ']]></menu>';
				$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 2)) . '<icone><![CDATA[' . $menuItem['txtIcone'] . ']]></icone>';
				$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 2)) . '<idmenu><![CDATA[' . $menuItem['txtIdMenu'] . ']]></idmenu>';
				
				$menu .= $this->gera_arquivo_menu_xml($idMenu, $arrayMenus , $nivel + 2);

			}
			else{
				$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 1)) . '<link>';
				if((int)$menuItem['bitCabecalho'] == 0)
					$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 2)) . '<type><![CDATA[menu]]></type>';
				else
					$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 2)) . '<type><![CDATA[heading]]></type>';

				$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 2)) . '<class><![CDATA[sidebar-mini-hide]]></class>';
				$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 2)) . '<url>' . $menuItem['txtUrl'] . '</url>';
				$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 2)) .  '<menu><![CDATA[' . $menuItem['txtMenu'] . ']]></menu>';
				$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 2)) .  '<icone><![CDATA[' . $menuItem['txtIcone'] . ']]></icone>';
				$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 2)) .  '<idmenu><![CDATA[' . $menuItem['txtIdMenu'] . ']]></idmenu>';
			}

			$menu .=  "\n" . str_repeat( "\t" , ((int)$nivel + 1 )) . '</link>';
		}
		if($idPesquisar == 0){
			$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 1)) . '<link>';
			$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 2)) . '<type><![CDATA[menu]]></type>';
			$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 2)) . '<class><![CDATA[sidebar-mini-hide]]></class>';
			$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 2)) . '<url>logout</url>';
			$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 2)) .  '<menu><![CDATA[Sair]]></menu>';
			$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 2)) .  '<icone><![CDATA[si si-logout]]></icone>';
			$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 2)) .  '<idmenu><![CDATA[logout]]></idmenu>';
			$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 1)) . '</link>';

			$menu .= "\n" . str_repeat( "\t" , $nivel ) . '</menu>';
		}
		else{
			$menu .= "\n" . str_repeat( "\t" , $nivel ) . '</sublink>';
		}
		
		return $menu;
	}

	/**
	 * Monta a estrutura de Tree View que será mostrada na área administrativa, par ser alterada conforme a necessidade e direitos dos usuários
	 * @method  layout_admin_group_access
	 *
	 * @author 		JRJ
	 * @version 	2.0.0
	 * @date    	2016-01-30
	 * @param   	integer 			$idPesquisar 		ID que deverá ser utilizada para pesquisa, quando o método chama ele mesmo, para criar 
	 *                                     					o sub item do menu
	 * @param   	array 				$arrayMenus 		Array com todos os menus registrados dentro do sistema
	 * @param   	integer 			$nivel  			Serve apenas para podermos identar o código HTML no momento da impressão
	 * @param   	integer 			$idGroup 			Código do grupo que está sendo impresso neste momento
	 * @param   	array 				$menuLiberados 		Contem um array com todos os códigos de menu que estão liberados para este grupo
	 * @param   	array 				$permissaoButton 	Os menus podem ter botões de ação em suas páginas, esta variável informa quais os botões o grupo
	 *                                       				possui habilitado
	 * @return  	atring 									Retorna uma string contendo todo o código HTML do Tree View do menu que será impresso na página
	 */
	public function layout_admin_group_access($idPesquisar, $arrayMenus, $nivel, $idGroup = 0, $menuLiberados = array(), $permissaoButton = array()){
		$arrayEstururaMenu = array();
		$menu = '';

		if($idPesquisar == 0):
			$menu .= '<ul class="tree-Zarpou" id="menuItem_' . $idGroup . '">';
		else:
			$menu .=  "\n" . str_repeat( "\t" , $nivel ) . '<li>';
		endif;

		foreach ($arrayMenus[$idPesquisar] as $idMenu => $menuItem) {
			array_push($arrayEstururaMenu, $menuItem);

			if(isset($arrayMenus[$idMenu]) && (int)$menuItem['bitCabecalho'] == 0){
				$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 1) ) . '<li>';
				$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 1) ) . '<label>';
				if (in_array($menuItem['id'], $menuLiberados, true))
					$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 1) ) . '<input checked="checked" type="checkbox" name="menuAcesso[]" value="' . $menuItem['id'] .'" />';
				else
					$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 1) ) . '<input type="checkbox" name="menuAcesso[]" value="' . $menuItem['id'] .'" />';

				$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 1) ) . $menuItem['txtMenu'];
				$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 1) ) . '</label>';
				$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 1) ) . '<ul>';
				$menu .= $this->layout_admin_group_access($idMenu, $arrayMenus , $nivel + 2, 0, $menuLiberados, $permissaoButton);
			}
			else{
				if((int)$menuItem['bitCabecalho'] == 0){
					$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 1) ) . '<li><label>';
					if (in_array($menuItem['id'], $menuLiberados, true))
						$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 1) ) . '<input checked="checked" type="checkbox" name="menuAcesso[]" value="' . $menuItem['id'] .'" />';
					else
						$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 1) ) . '<input type="checkbox" name="menuAcesso[]" value="' . $menuItem['id'] .'" />';
					
					$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 1) ) . $menuItem['txtMenu'] . '</label>';

					// Se possuir botões relacionados a direito do usuário para ações na página, chama o método que cria estes botões, com base
					// nos botões existentes para o menu e os botões que já estão liberados para o usuário
					if($menuItem['txtMenuButtonAction'] != ''){
						$menu .= $this->_cria_button_action($menuItem['id'], $permissaoButton, $menuItem['txtMenuButtonAction']);
					}
				}
				else{
					$menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 1) ) . '<li class="cabecalho-menus">' . $menuItem['txtMenu'] . '</li>';	
				}
			}

			$menu .=  "\n" . str_repeat( "\t" , ((int)$nivel + 1 )) . '</li>';
		}
		if($idPesquisar == 0){
			$menu .= "\n" . str_repeat( "\t" , $nivel ) . '</li>';
		}
		else{
			$menu .= "\n" . str_repeat( "\t" , $nivel ) . '</ul>';
		}
		
		return $menu;
	}

	/**
	 * Realizar a impressão dos botões de direitos a funções da página, verificar quais os botões a página possui e cruza com os botões que o usuário
	 * já possui acesso, desta maneira imprimi os botões que ele já possui acesso checado e os outros botões que ele não possui acesso sem o check
	 * @method  _cria_button_action
	 *
	 * @author 		JRJ
	 * @version 	1.0.0
	 * @date    	2016-01-30
	 * @param   	integer 		$idMenu  				Código do menu que estamos realizando a impressão dos botões de acesso
	 * @param   	array 			$permissaoButton 		Botões que o usuário já possui acesso, este valor pode ser nulo, caso o usuário não tenha nenhum botão habilitado
	 * @param   	array 			$txtMenuButtonAction 	Grupo de botões de ação que a página possui, para serem utilizados pelos usuários
	 * @return  	string 									Retorna o código HTML com o conjunto de botões criado
	 */
	private function _cria_button_action($idMenu = 0, $permissaoButton = array(), $txtMenuButtonAction = array()){
		$nivel = 2;
		$arrayBotoesImpressos = array();
		$sub_menu = '';
		$sub_menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 1) ) . "<ol>";
		$arrayBotoesImpressos = array();
		//	1	-	Looping de todos os botões que o usuário possui accesso, validando com o menu que está sendo impresso
		for ($pb=0; $pb < count($permissaoButton); $pb++) {
			if($idMenu == $permissaoButton[$pb][1]){
				//	2	-	Looping de todos os botões que o menu possui, cruzando com o botão que está sendo analisado do grupo, se forem iguais imprimi checado
				for ($perm=0; $perm < count($txtMenuButtonAction); $perm++) { 
					if($permissaoButton[$pb][3] == $txtMenuButtonAction[$perm][1]){
						$valuButton = $idMenu . '||' . $txtMenuButtonAction[$perm][0] . '||' . $txtMenuButtonAction[$perm][1];
						$sub_menu .= '<li><label>';
						$sub_menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 1) ) . '<input checked="checked" type="checkbox" name="txtPermissaoButton[]" value="' . $valuButton .'" />';
						$sub_menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 1) ) . $txtMenuButtonAction[$perm][0] . '</li>';
						array_push($arrayBotoesImpressos, $txtMenuButtonAction[$perm][1]);
					}
				}
			}
		}
		//	3	-	Imprimir os botões que o usuário não possui acesso
		for ($imp=0; $imp < count($txtMenuButtonAction); $imp++) { 
			if (!in_array($txtMenuButtonAction[$imp][1], $arrayBotoesImpressos)){
				$valuButton = $idMenu . '||' . $txtMenuButtonAction[$imp][0] . '||' . $txtMenuButtonAction[$imp][1];
				$sub_menu .= '<li><label>';
				$sub_menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 1) ) . '<input type="checkbox" name="txtPermissaoButton[]" value="' . $valuButton .'" />';
				$sub_menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 1) ) . $txtMenuButtonAction[$imp][0] . '</li>';
			}
		}
		$sub_menu .= "\n" . str_repeat( "\t" , ((int)$nivel + 1) ) . "</ol>";
		return $sub_menu;
	}

    public function get_icon_destaque($value) {
        // Label seed data
        $data   = array(
            '0' => array('icon' => 'fa fa-bookmark-o', 'text'  => 'Habilitar'),
            '1' => array('icon' => 'fa fa-bookmark', 'text'  => 'Desabilitar')
        );

        // Generate icon
        $icon = '<i class="' . $data[$value]['icon'] . '"></i>';
        return $icon;
    }
}

/* End of file Template.php */
/* Location: ./system/application/libraries/Template.php */