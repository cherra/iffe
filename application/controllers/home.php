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
            $data['plano50'] = base_url().$this->configuracion->get_valor('asset_path').$this->configuracion->get_valor('imagenes').$this->configuracion->get_valor('plano50');
            $data['plano75'] = base_url().$this->configuracion->get_valor('asset_path').$this->configuracion->get_valor('imagenes').$this->configuracion->get_valor('plano75');
            $data['plano'] = base_url().$this->configuracion->get_valor('asset_path').$this->configuracion->get_valor('imagenes').$this->configuracion->get_valor('plano');
            $this->load->view('home/index', $data);
	}

}

?>