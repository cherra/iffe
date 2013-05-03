<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of menu
 *
 * @author cherra
 */
class menu {
    
    var $ci;
    var $routing;
	
    function __construct() {
        $this->ci = &get_instance();
        $this->routing =& load_class('Router');
        //$this->ci->load->model('menu');
    }
    
    function getMetodos( $folder ){
        $this->ci->db->where('folder', $folder);
        $this->ci->db->where('menu', '1');
        $this->ci->db->order_by('class, method');
        $query = $this->ci->db->get('Permisos');
        return  $query->result();
    }
    
    function getClases( $folder ){
        $this->ci->db->where('LENGTH(folder) > 0');
        $this->ci->db->where('menu', '1');
        $this->ci->db->where('folder', $folder);
        $this->ci->db->group_by('class');
        $this->ci->db->order_by('class');
        $query = $this->ci->db->get('Permisos');
        return  $query->result_array();
    }
    
    function getFolders(){
        $this->ci->db->select('folder');
        $this->ci->db->where('LENGTH(folder) > 0');
        $this->ci->db->where('menu', '1');
        $this->ci->db->group_by('folder');
        $this->ci->db->order_by('folder');
        $query = $this->ci->db->get('Permisos');
        return  $query->result();
    }
        
    function menuOptions(){
        
        $folders = $this->getFolders();

        $folder = $this->ci->uri->segment(1);  // Se obtiene el directorio
        
        // Obtiene todos los métodos de los controladores que están dentro del directorio
        $submenu = $this->getMetodos($folder); 

        // Se registran los dos menús en la sesión del usuario
        // folders -> topbar
        // submenu -> leftbar
        $this->ci->session->set_userdata('folders',$folders);
        $this->ci->session->set_userdata('submenu', $submenu );
    }
}

?>
