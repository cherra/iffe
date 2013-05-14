<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * Description of periodo
 *
 * @author cherra
 */
class Periodo_activo {
    
    function index(){
        $CI =& get_instance();
        
        $CI->load->model('periodo');
        $periodo = $CI->periodo->get_activo()->row();
        $CI->session->set_userdata('periodo', $periodo);
    }
}

?>
