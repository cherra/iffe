<?php

class Cliente extends CI_Model {
    
    private $tbl_clientes = 'Clientes'; 

 	/**
 	* ***********************************************************************
 	* Cantidad de registros
 	* ***********************************************************************
 	*/
    function count_all() {
        return $this->db->count_all($this->tbl_clientes);
    }

    /**
    * ***********************************************************************
 	* Cantidad de registros por pagina
 	* ***********************************************************************
 	*/
    function get_paged_list($limit = null, $offset = 0) {
        $this->db->order_by('id','desc');
        return $this->db->get($this->tbl_clientes, $limit, $offset);
    }

    /**
    * ***********************************************************************
    * Obtener cliente por id
    * ***********************************************************************
    */
    function get_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->tbl_clientes);
    }

    /**
    * ***********************************************************************
    * Obtener todos los clientes
    * ***********************************************************************
    */
    function get_all() {
        $this->db->order_by('apellido_paterno, apellido_materno, nombre');
        return $this->db->get($this->tbl_clientes);
    }

    /**
    * ***********************************************************************
    * Alta de Clientes
    * ***********************************************************************
    */
    function save($cliente) {
        $this->db->insert($this->tbl_clientes, $cliente);
        return $this->db->insert_id();
    }

    /**
    * ***********************************************************************
    * Actualizar cliente por id
    * ***********************************************************************
    */
    function update($id, $cliente) {
        $this->db->where('id', $id);
        $this->db->update($this->tbl_clientes, $cliente);
    }

    /**
    * ***********************************************************************
    * Eliminar cliente por id
    * ***********************************************************************
    */
    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->tbl_clientes);
    }

    /**
    * ***********************************************************************
    * servicio autocompletar
    * ***********************************************************************
    */
    function get_by_query($query) {
        $sql = "SELECT id, concat(nombre, ' ', apellido_paterno, ' ', apellido_materno) as nombre 
                FROM Clientes 
                WHERE concat(nombre, ' ', apellido_paterno, ' ', apellido_materno) like '%" . $query . "%';";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        if ($num > 0) {
            return $query->result();
        } 
        else {
            return false;
        }    
    }
    
}

?>
