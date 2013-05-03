<?php

class Menu extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }

    public function getMetodos( $folder ){
        $this->db->where('folder', $folder);
        $this->db->where('menu', '1');
        $this->db->order_by('method');
        $query = $this->db->get('Permisos');
        return  $query->result();
    }
    
    public function getClases( $folder ){
        $this->db->where('LENGTH(folder) > 0');
        $this->db->where('menu', '1');
        $this->db->where('folder', $folder);
        $this->db->group_by('class');
        $this->db->order_by('class');
        $query = $this->db->get('Permisos');
        return  $query->result_array();
    }
    
    public function getFolders(){
        $this->db->select('folder');
        $this->db->where('LENGTH(folder) > 0');
        $this->db->where('menu', '1');
        $this->db->group_by('folder');
        $this->db->order_by('folder');
        $query = $this->db->get('Permisos');
        return  $query->result();
    }
}

?>
