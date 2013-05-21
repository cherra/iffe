<?php
/**
 * Description of giros
 *
 * @author cherra
 */
class Giro extends CI_Model{
    
    private $tbl = "Giros";
    
    
    /**
    * ***********************************************************************
    * Obtener por id
    * ***********************************************************************
    */
    function get_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->tbl);
    }
    
    /**
     * *********************************************************************
     * Listado
     * *******************************************************************
     */
    
    function get_paged_list($limit = null, $offset = 0) {
        $this->db->order_by('nombre','asc');
        return $this->db->get($this->tbl, $limit, $offset);
    }
    
    /**
    * ***********************************************************************
    * Obtener todos
    * ***********************************************************************
    */
    function get_all() {
        $this->db->order_by('nombre');
        return $this->db->get($this->tbl);
    }
    
    /**
    * ***********************************************************************
    * Cantidad de registros
    * ***********************************************************************
    */
    function count_all() {
        return $this->db->count_all($this->tbl);
    }
    
    /**
    * ***********************************************************************
    * Nuevo registro
    * ***********************************************************************
    */
    function save($datos) {
        $this->db->insert($this->tbl, $datos);
        return $this->db->insert_id();
    }
    
    /**
    * ***********************************************************************
    * Actualizar
    * ***********************************************************************
    */
    function update($id, $datos) {
        $this->db->where('id', $id);
        $this->db->update($this->tbl, $datos);
    }
    
    /**
    * ***********************************************************************
    * Eliminar
    * ***********************************************************************
    */
    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->tbl);
    }
}

?>
