<?php

class Manzana extends CI_Model {
    
	private $tbl_manzanas = 'Manzanas'; 

    function __construct() {
    	parent::__construct();
        $this->load->database();
    }

 	/**
 	* ***********************************************************************
 	* Cantidad de registros
 	* ***********************************************************************
 	*/
    function count_all($id_fraccionamiento) {
        $this->db->where('id_fraccionamiento', $id_fraccionamiento);
        return $this->db->count_all_results($this->tbl_manzanas);
    }

    /**
    * ***********************************************************************
    * Cantidad de registros por pagina
    * ***********************************************************************
    */
    function get_paged_list($id_fraccionamiento, $limit = null, $offset = 0) {
        $this->db->where('id_fraccionamiento', $id_fraccionamiento);
        $this->db->order_by('descripcion','asc');
        return $this->db->get($this->tbl_manzanas, $limit, $offset);
    }

    /**
     * ***********************************************************************
     * Obtener todos
     * ***********************************************************************
     */
    function get_all($id_fraccionamiento = null) {
    	if (!empty($id_fraccionamiento))
    		$this->db->where('id_fraccionamiento', $id_fraccionamiento);
    	$this->db->order_by('descripcion','asc');
    	return $this->db->get($this->tbl_manzanas);
    }
    
    /**
    * ***********************************************************************
    * Obtener manzana por id
    * ***********************************************************************
    */
    function get_by_id($id) {
        $this->db->where('id_manzana', $id);
        return $this->db->get($this->tbl_manzanas);
    }

    /**
    * ***********************************************************************
    * Alta de fraccionamiento
    * ***********************************************************************
    */
    function save($manzana) {
        $this->db->insert($this->tbl_manzanas, $manzana);
        return $this->db->insert_id();
    }

    /**
    * ***********************************************************************
    * Actualizar manzana por id
    * ***********************************************************************
    */
    function update($id, $manzana) {
        $this->db->where('id_manzana', $id);
        $this->db->update($this->tbl_manzanas, $manzana);
    }

    /**
    * ***********************************************************************
    * Eliminar manzana por id
    * ***********************************************************************
    */
    function delete($id) {
        $this->db->where('id_manzana', $id);
        $this->db->delete($this->tbl_manzanas);
    }

}

?>
