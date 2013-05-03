<?php
/**
 * Description of apartados
 *
 * @author cherra
 */
class Apartados extends CI_Controller{
    
    function __construct() {
        parent::__construct();
    }
    
    public function vencidos(){
        $this->load->view('informes/apartados/vencidos');
    }
    
    public function por_vendedor(){
        $this->load->view('informes/apartados/por_vendedor');
    }
    
    public function por_fraccionamiento(){
        $this->load->view('informes/apartados/por_fraccionamiento');
    }
}

?>
