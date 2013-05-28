<?php

class Periodo extends CI_Model {
    
	private $tbl = 'Periodos'; 

    function __construct() {
    	parent::__construct();
        //$this->load->database();
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
    * Obtener el período activo
    * ***********************************************************************
    */
    function get_activo() {
        $this->db->where('activo', '1');
        $this->db->order_by('id','desc');
        return $this->db->get($this->tbl,1);
    }
    
    function set_activo( $id ) {
        $this->db->update($this->tbl, array('activo' => '0'));
        
        $this->db->where('id', $id);
        $this->db->update($this->tbl, array('activo' => '1'));
        return $this->db->affected_rows();
    }

    /**
    * ***********************************************************************
    * Alta de fraccionamiento
    * ***********************************************************************
    */
    function save($datos) {
        $this->db->update($this->tbl, array('activo' => '0'));
        $this->db->insert($this->tbl, $datos);
        return $this->db->insert_id();
    }

    /**
    * ***********************************************************************
    * Actualizar manzana por id
    * ***********************************************************************
    */
    function update($id, $datos) {
        if($datos['activo'] == '1'){
            $this->db->update($this->tbl, array('activo' => '0'));
        }
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
        
        // Pone el último período como activo si todos están desactivados
        $this->db->where('activo','1'); // Busca si hay algún período activo
        $query = $this->db->get($this->tbl);
        if($query->num_rows() <= 0){ // Si todos los registros están desactivados
            $this->db->order_by('id','desc');
            $query = $this->db->get($this->tbl,1);  // Obtiene el último ID (la última feria)
            if($query->num_rows() > 0){
                $row = $query->row();
                $this->db->update($this->tbl, array('activo' => '1'), array('id' => $row->id)); // La activa
            }
        }
    }

}

?>
