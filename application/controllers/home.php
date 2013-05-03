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
            $this->load->library('jpgraph');
            $ydata = array(11,3,8,12,5,1);
            $leyendas = array('Ene','Feb','Mar','Abr','May','Jun');

            $data['grafico_lineas'] = $this->jpgraph->grafico_lineas($ydata,350,200);
            $data['grafico_barras'] = $this->jpgraph->grafico_barras($ydata,600,250);
            $data['grafico_pastel'] = $this->jpgraph->grafico_pastel($ydata,350,250,$leyendas);
            $data['grafico_pastel_3d'] = $this->jpgraph->grafico_pastel_3d($ydata,350,200,$leyendas);
            $data['grafico_gantt'] = $this->jpgraph->grafico_gantt($ydata,800,200);
            //$actividades=
            
            $this->load->view('home/index', $data);
	}

}

?>