<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class MY_Router extends CI_Router {
 
    function __construct()
    {
        parent::__construct();
    }

    function _set_request($seg = array()) {
        // The str_replace() below goes through all our segments
        // and replaces the hyphens with underscores making it
        // possible to use hyphens in controllers, folder names and
        // function names
        parent::_set_request(str_replace('-', '_', $seg));
    }
 
    function _validate_request($segments)
    {
        if (count($segments) == 0)
        {
            return $segments;
        }
 
        // O controller requisitado existe no diretório raiz?
        if (file_exists(APPPATH.'controllers/' . ucfirst($segments[0]).'.php'))
        {
            return $segments;
        }
 
        // O controller está num subdiretório?
        if (is_dir(APPPATH . 'controllers/' . ucfirst($segments[0])))
        {
            // Set the directory and remove it from the segment array
            $this->set_directory(ucfirst($segments[0]));
            $segments = array_slice($segments, 1);
 
            while (count($segments) > 0 && is_dir(APPPATH . 'controllers/' . $this->directory . ucfirst($segments[0])))
            {
                // Set the directory and remove it from the segment array
                $this->set_directory($this->directory . ucfirst($segments[0]));
                $segments = array_slice($segments, 1);
            }
 
            if (count($segments) > 0)
            {
                // O controlle requisitado existe em um subdiretório?
                if ( ! file_exists(APPPATH . 'controllers/' . $this->fetch_directory() . ucfirst($segments[0]) . '.php'))
                {
                    if ( ! empty($this->routes['404_override']))
                    {
                        $x = explode('/', $this->routes['404_override']);
 
                        $this->set_directory('');
                        $this->set_class(ucfirst($x[0]));
                        $this->set_method(isset($x[1]) ? $x[1] : 'index');
 
                        return $x;
                    }
                    else
                    {
                        show_404($this->fetch_directory() . ucfirst($segments[0]));
                    }
                }
            }
            else
            {
                // O método foi especificado na rota?
                if (strpos($this->default_controller, '/') !== FALSE)
                {
                    $x = explode('/', $this->default_controller);
 
                    $this->set_class(ucfirst($x[0]));
                    $this->set_method($x[1]);
                }
                else
                {
                    $this->set_class(ucfirst($this->default_controller));
                    $this->set_method('index');
                }
 
                // O controller padrão existe no subdiretório?
                if ( ! file_exists(APPPATH . 'controllers/' . $this->fetch_directory() . ucfirst($this->default_controller) . '.php'))
                {
                    $this->directory = '';
                    return array();
                }
 
            }
 
            return $segments;
        }
 
 
        // Se o fluxo chegou até aqui, significa que o URI solicitado não se 
        // correlaciona a alguma classe de controller válida. Agora, é preciso 
        // testar se há o roteamento "404_override" para erros personalizados.  
        if ( ! empty($this->routes['404_override']))
        {
            $x = explode('/', $this->routes['404_override']);
 
            $this->set_class(ucfirst($x[0]));
            $this->set_method(isset($x[1]) ? $x[1] : 'index');
 
            return $x;
        }
 
 
        // Nada mais a fazer neste ponto a não ser mostrar um erro 404.
        show_404(ucfirst($segments[0]));
    }
 
    function _set_directory($dir)
    {
        // Permite barra, mas não ponto.
        $this->directory = str_replace('.', '', $dir) . '/';
    }
 
}
 
/* End of file MY_Router.php */
/* Location: ./application/core/MY_Router.php */