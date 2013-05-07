<?php
/**
 * Description of permiso
 *
 * @author cherra
 */
class Permiso extends CI_Model {
    
    private $tbl = "Permisos";
    
    function count_all() {
        return $this->db->count_all($this->tbl);
    }
    
    /**
    * ***********************************************************************
    * Cantidad de registros por pagina
    * ***********************************************************************
    */
    function get_paged_list($limit = null, $offset = 0) {
        $this->db->order_by('folder, class, method','asc');
        return $this->db->get($this->tbl, $limit, $offset);
    }
    
    /**
    * ***********************************************************************
    * Obtener permiso por id
    * ***********************************************************************
    */
    function get_by_id($id) {
        $this->db->where('id_permiso', $id);
        return $this->db->get($this->tbl);
    }
    
    /**
    * ***********************************************************************
    * Obtener permisos
    * ***********************************************************************
    */
    function get_all() {
        $this->db->order_by('folder, class, method');
        return $this->db->get($this->tbl);
    }
    
    /**
    * ***********************************************************************
    * Alta de permiso
    * ***********************************************************************
    */
    function save($rol) {
        $this->db->insert($this->tbl, $rol);
        return $this->db->insert_id();
    }

    /**
    * ***********************************************************************
    * Actualizar permiso por id
    * ***********************************************************************
    */
    function update($id, $rol) {
        $this->db->where('id_permiso', $id);
        $this->db->update($this->tbl, $rol);
    }

    /**
    * ***********************************************************************
    * Eliminar permiso por id
    * ***********************************************************************
    */
    function delete($id) {
        $this->db->where('id_permiso', $id);
        $this->db->delete($this->tbl);
    }
}

?>
