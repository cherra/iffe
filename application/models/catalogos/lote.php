<?php

class Lote extends CI_Model {
    
    private $tbl_lotes = 'Lotes'; 
    private $tbl_categorias = 'CategoriasLotes';

    function __construct() {
    	parent::__construct();
        $this->load->database();
    }

    /**
    * ***********************************************************************
    * Cantidad de registros
    * ***********************************************************************
    */
    function count_all($id_manzana) {
        $this->db->where('id_manzana', $id_manzana);
        return $this->db->count_all_results($this->tbl_lotes);
    }

    /**
    * ***********************************************************************
    * Cantidad de registros por pagina
    * ***********************************************************************
    */
    function get_paged_list($id_manzana, $limit = null, $offset = 0) {
        $this->db->select($this->tbl_lotes.'.*,'. $this->tbl_categorias.'.descripcion AS categoria,'. $this->tbl_categorias.'.precio_metro * '.$this->tbl_lotes.'.superficie AS precio');
        $this->db->join($this->tbl_categorias,$this->tbl_lotes.'.id_categoria = '.$this->tbl_categorias.'.id');
        $this->db->where('id_manzana', $id_manzana);
        $this->db->order_by('descripcion','asc');
        return $this->db->get($this->tbl_lotes, $limit, $offset);
    }
    
    /**
    * ***********************************************************************
    * Obtener todos los lotes disponibles por $id_manzana
    * ***********************************************************************
    */
    function get_disponibles($id_manzana){
        $this->db->select('Lotes.*, Apartados.id_lote AS apartado, Contratos.id_lote AS contrato');
        $this->db->join('Apartados','Lotes.id_lote = Apartados.id_lote','left');
        $this->db->join('Contratos','Lotes.id_lote = Contratos.id_lote','left');
        $this->db->where('Lotes.id_manzana', $id_manzana);
        $this->db->having('apartado IS NULL AND contrato IS NULL');
        $this->db->order_by('Lotes.descripcion');
        return $this->db->get($this->tbl_lotes);
    }
    
    function get_lotes_con_casa($id_manzana){
        $this->db->join('Casas', $this->tbl_lotes.'.id_lote = Casas.id_lote');
        $this->db->where($this->tbl_lotes.'.id_manzana',$id_manzana);
        return $this->db->get($this->tbl_lotes);
    }
    
    function get_lotes_sin_casa($id_manzana){
        $this->db->select('Lotes.*, Casas.id_lote AS casa_id_lote');
        $this->db->join('Casas', $this->tbl_lotes.'.id_lote = Casas.id_lote','left');
        $this->db->where($this->tbl_lotes.'.id_manzana',$id_manzana);
        $this->db->having('casa_id_lote IS NULL');
        return $this->db->get($this->tbl_lotes);
    }
    
    /**
    * ***********************************************************************
    * Obtener todos los lotes disponibles para una casa
    * ***********************************************************************
    */
    function get_disponibles_casa($update = false) {
        $sql = "select l.id_lote, a.id_lote as disponible, /* c.id_lote as lote_casa, */ upper(l.descripcion) as lote, 
                upper(m.descripcion) as manzana, 
                upper(f.descripcion) as fraccionamiento
                from Lotes l
                inner join Manzanas m on m.id_manzana = l.id_manzana
                inner join Fraccionamientos f on f.id_fraccionamiento = m.id_fraccionamiento
                left join Apartados a on a.id_lote = l.id_lote
                /* left join Casas c on c.id_lote = l.id_lote */
                having a.id_lote is null /* and c.id_lote = null */
                order by f.id_fraccionamiento, m.id_manzana, l.id_lote;";

        if ($update == true) {
            $sql = "select l.id_lote, a.id_lote as disponible, c.id_lote as lote_casa, upper(l.descripcion) as lote, 
                    upper(m.descripcion) as manzana, 
                    upper(f.descripcion) as fraccionamiento
                    from Lotes l
                    inner join Manzanas m on m.id_manzana = l.id_manzana
                    inner join Fraccionamientos f on f.id_fraccionamiento = m.id_fraccionamiento
                    left join Apartados a on a.id_lote = l.id_lote
                    left join Casas c on c.id_lote = l.id_lote
                    having a.id_lote is null and c.id_lote = null
                    order by f.id_fraccionamiento, m.id_manzana, l.id_lote;";
        }

        return $this->db->query($sql);
    }

    /**
    * ***********************************************************************
    * Obtener lote por id
    * ***********************************************************************
    */
    function get_by_id($id) {
        $this->db->select($this->tbl_lotes.'.*,'. $this->tbl_categorias.'.descripcion AS categoria,'. $this->tbl_categorias.'.precio_metro * '.$this->tbl_lotes.'.superficie AS precio');
        $this->db->join($this->tbl_categorias, $this->tbl_lotes.'.id_categoria = '.$this->tbl_categorias.'.id');
        $this->db->where('id_lote', $id);
        return $this->db->get($this->tbl_lotes);
    }

    /**
    * ***********************************************************************
    * Alta de lote
    * ***********************************************************************
    */
    function save($lote) {
        $this->db->insert($this->tbl_lotes, $lote);
        return $this->db->insert_id();
    }

    /**
    * ***********************************************************************
    * Actualizar lote por id
    * ***********************************************************************
    */
    function update($id, $lote) {
        $this->db->where('id_lote', $id);
        $this->db->update($this->tbl_lotes, $lote);
    }

    /**
    * ***********************************************************************
    * Eliminar lote por id
    * ***********************************************************************
    */
    function delete($id) {
        $this->db->where('id_lote', $id);
        $this->db->delete($this->tbl_lotes);
    }
    
    /*
     * CATEGORÍAS DE LOTES
     * 
     */
    
    /**
    * ***********************************************************************
    * Cantidad de registros
    * ***********************************************************************
    */
    function count_all_categorias($id_fraccionamiento) {
        $this->db->where('id_fraccionamiento', $id_fraccionamiento);
        return $this->db->count_all_results($this->tbl_categorias);
    }

    /**
    * ***********************************************************************
    * Cantidad de registros por pagina
    * ***********************************************************************
    */
    function get_paged_list_categorias( $id_fraccionamiento, $limit = null, $offset = 0 ) {
        $this->db->where('id_fraccionamiento', $id_fraccionamiento);
        $this->db->order_by('descripcion','asc');
        return $this->db->get($this->tbl_categorias, $limit, $offset);
    }
    
    /**
    * ***********************************************************************
    * Obtener lote por id
    * ***********************************************************************
    */
    function get_by_id_categoria($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->tbl_categorias);
    }

    /**
    * ***********************************************************************
    * Alta de lote
    * ***********************************************************************
    */
    function save_categoria($categoria) {
        $this->db->insert($this->tbl_categorias, $categoria);
        return $this->db->insert_id();
    }

    /**
    * ***********************************************************************
    * Actualizar lote por id
    * ***********************************************************************
    */
    function update_categoria($id, $categoria) {
        $this->db->where('id', $id);
        $this->db->update($this->tbl_categorias, $categoria);
        return $this->db->affected_rows();
    }

    /**
    * ***********************************************************************
    * Eliminar lote por id
    * ***********************************************************************
    */
    function delete_categoria($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->tbl_categorias);
    }

}

?>
