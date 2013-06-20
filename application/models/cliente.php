<?php

class Cliente extends CI_Model {
    
    private $tbl_clientes = 'Clientes'; 

 	/**
 	* ***********************************************************************
 	* Cantidad de registros
 	* ***********************************************************************
 	*/
   
    function count_all($filtro = null) {
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $this->db->or_like('apellido_paterno',$f);
                $this->db->or_like('apellido_materno',$f);
                $this->db->or_like('nombre',$f);
                $this->db->or_like('razon_social',$f);
            }
        }
        $query = $this->db->get($this->tbl_clientes);
        return $query->num_rows();
    }

    /**
    * ***********************************************************************
 	* Cantidad de registros por pagina
 	* ***********************************************************************
 	*/
    
    function get_paged_list($limit = null, $offset = 0, $filtro = null) {
        if(!empty($filtro)){
            $filtro = explode(' ', $filtro);
            foreach($filtro as $f){
                $this->db->or_like('apellido_paterno',$f);
                $this->db->or_like('apellido_materno',$f);
                $this->db->or_like('nombre',$f);
                $this->db->or_like('razon_social',$f);
            }
        }
        $this->db->order_by('razon_social, apellido_paterno, apellido_materno, nombre','asc');
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
        $sql = "SELECT id, IF(tipo = 'moral', razon_social, concat(nombre, ' ', apellido_paterno, ' ', apellido_materno)) as nombre 
                FROM Clientes 
                WHERE concat(nombre, ' ', apellido_paterno, ' ', apellido_materno) like '%" . $query . "%' OR razon_social like '%" . $query . "%'
                GROUP BY id";
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
