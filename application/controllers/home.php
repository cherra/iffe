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
            $modulos = $this->m->get_all()->result();
            $coordenadas = '';
            foreach($modulos as $modulo){
                // Si el módulo tiene coordenadas asignadas
                if(!empty($modulo->coordenadas))
                    $coordenadas .= '{'.$modulo->coordenadas.',numero: "'.$modulo->numero.'",id_calle: "'.$modulo->id_calle.'", calle: "'.$modulo->calle.'", id: "'.$modulo->id.'", cliente: "'. $modulo->cliente .'", giro: "'. $modulo->giro .'", disponible: "'.$modulo->disponible.'"},';
            }
            $data['coordenadas'] = '['.substr_replace($coordenadas ,"]",-1);
            $this->load->view('home/index', $data);
	}

}

?>