<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public $layout = 'home_backend';

	/*
	* *****************************************************************
	* url: /Home/index
	* *****************************************************************
	* landing page del backend aka "Home Backend"
	*
	*/
	public function index( $folder = null) {
            $data['plano'] = base_url().$this->configuracion->get_valor('asset_path').$this->configuracion->get_valor('imagenes').$this->configuracion->get_valor('plano');
            
            // Se obtienen todos los módulos
            $this->load->model('modulo','m');
            $modulos = $this->m->get_all_vigentes()->result();
            $coordenadas = '';
            foreach($modulos as $modulo){
                // Se obtiene la disponiblidad del módulo
                $disponible = $this->m->disponible($modulo->id);
                // Si el módulo tiene coordenadas asignadas
                if(!empty($modulo->coordenadas))
                    if(strpos($modulo->coordenadas,'x') && strpos($modulo->coordenadas,'y')) // Se valida que el campo coordenadas contenga los caracteres 'x' y 'y'
                        $coordenadas .= '{'.$modulo->coordenadas.',numero: "'.$modulo->numero.'",id_calle: "'.$modulo->id_calle.'", calle: "'.$modulo->calle.'", id: "'.$modulo->id.'", cliente: "'. $modulo->cliente .'", giro: "'. $modulo->giro .'", disponible: "'.$disponible.'"},';
            }
            $data['coordenadas'] = '['.substr_replace($coordenadas ,"]",-1);
            $this->load->view('home/index', $data);
	}

}

?>