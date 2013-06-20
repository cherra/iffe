<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * Description of busqueda
 *
 * @author cherra
 */
class Busqueda {
    
    private $CI;
    
    function index(){
        $this->CI =& get_instance();
        
        $busqueda = $this->CI->input->post('filtro');
        
        if($busqueda !== false){
            $this->CI->session->set_userdata('filtro', $busqueda);
            $this->CI->session->set_userdata('filtro_metodo', $this->CI->uri->segment(2).'/'.$this->CI->uri->segment(3));
        }
        
        if (($this->CI->session->userdata('filtro_metodo'))){
            if($this->CI->session->userdata('filtro_metodo') != $this->CI->uri->segment(2).'/'.$this->CI->uri->segment(3)){
                $this->CI->session->unset_userdata('filtro');
                $this->CI->session->unset_userdata('filtro_metodo');
            }
        }
    }
}

?>
