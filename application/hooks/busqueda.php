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
        
        if($this->CI->input->post('filtro')){
            $this->CI->session->set_userdata('filtro', $this->CI->input->post('filtro'));
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
