<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * Description of periodo
 *
 * @author cherra
 */
class Periodo_activo {
    
    private $CI;
    
    function index(){
        $this->CI =& get_instance();
        
        $this->CI->load->model('periodo','p');
        $periodo = $this->CI->p->get_activo()->row();
        $this->CI->session->set_userdata('periodo', $periodo);
    }
}

?>
