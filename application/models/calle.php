<?php

class Calle extends CI_Model {
    
	private $tbl = 'Calles'; 

    function __construct() {
    	parent::__construct();
        $this->load->database();
    }

 	/**
 	* ***********************************************************************
 	* Cantidad de registros
 	* ***********************************************************************
 	*/
    function count_all() {
        return $this->db->count_all_results($this->tbl);
    }

    /**
    * ***********************************************************************
    * Cantidad de registros por pagina
    * ***********************************************************************
    */
    function get_paged_list($limit = null, $offset = 0) {
        $this->db->select('c.*, COUNT(m.id) as modulos');
        $this->db->join('Modulos m','c.id = m.id_calle','left');
        $this->db->group_by('c.id');
        $this->db->order_by('c.nombre','asc');
        return $this->db->get($this->tbl.' c', $limit, $offset);
    }

    /**
     * ***********************************************************************
     * Obtener todos
     * ***********************************************************************
     */
    function get_all() {
    	$this->db->order_by('nombre','asc');
    	return $this->db->get($this->tbl);
    }
    
    /**
    * ***********************************************************************
    * Obtener manzana por id
    * ***********************************************************************
    */
    function get_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->tbl);
    }

    /**
    * ***********************************************************************
    * Alta de fraccionamiento
    * ***********************************************************************
    */
    function save($datos) {
        $this->db->insert($this->tbl, $datos);
        return $this->db->insert_id();
    }

    /**
    * ***********************************************************************
    * Actualizar manzana por id
    * ***********************************************************************
    */
    function update($id, $datos) {
        $this->db->where('id', $id);
        $this->db->update($this->tbl, $datos);
    }

    /**
    * ***********************************************************************
    * Eliminar manzana por id
    * ***********************************************************************
    */
    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->tbl);
    }

}

?>
