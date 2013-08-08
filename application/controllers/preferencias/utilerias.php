<?php

/**
 * Description of utilerias
 *
 * @author cherra
 */
class Utilerias extends CI_Controller {
    
    private $folder = 'preferencias/';
    private $clase = 'utilerias/';
    
    function __construct() {
        parent::__construct();
    }
    
    public function respaldo(){
        $data['titulo'] = "Respaldo de base de datos";

        if($this->input->post('respaldo')){
            $this->load->dbutil();
            $respaldo = & $this->dbutil->backup(array('format' => 'zip', 'filename' => 'respaldo.zip'));
            
            $this->load->helper('download');
            force_download('respaldo.zip', $respaldo);
        }
        $this->load->view('preferencias/utilerias/respaldo', $data);
    }
}
?>
