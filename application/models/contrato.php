<?php
/**
 * Description of contrato
 *
 * @author cherra
 */
class Contrato extends CI_Model{
    
    private $tbl = 'Contratos'; 
    private $tbl_contrato_modulos = 'ContratoModulos'; 
    private $tbl_adjuntos_contrato = 'ContratoAdjuntos';
    private $tbl_adjuntos = 'Adjuntos';
    
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
        $this->db->select($this->tbl.".*, Calles.nombre AS calle, Modulos.numero AS modulo, 
            CONCAT(Clientes.nombre,' ',Clientes.apellido_paterno,' ',Clientes.apellido_materno) AS cliente ", false);
        $this->db->join($this->tbl_contrato_modulos,$this->tbl.'.id = '.$this->tbl_contrato_modulos.'.id_contrato');
        $this->db->join('Modulos', $this->tbl_contrato_modulos.'.id_modulo = Modulos.id');
        $this->db->join('Usuarios',$this->tbl.'.id_usuario = Usuarios.id_usuario');
        $this->db->join('Clientes',$this->tbl.'.id_cliente = Clientes.id');
        $this->db->join('Calles','Modulos.id_calle = Calles.id');
        
        $this->db->order_by('fecha','asc');
        return $this->db->get($this->tbl,$limit, $offset);
    }

    /**
    * ***********************************************************************
    * Obtener contrato por id
    * ***********************************************************************
    */
    function get_by_id($id) {
        $this->db->select("Co.*, Co.numero AS numero_contrato,
                F.descripcion AS fraccionamiento, F.ciudad, F.estado,
                M.descripcion AS manzana, 
                L.descripcion AS lote, L.calle, L.numero,
                Ca.precio_casa,
                CONCAT(C.nombre,' ',C.apellido_paterno,' ',C.apellido_materno) AS cliente, 
                U.nombre AS vendedor", false);
        $this->db->join('Usuarios U','Co.id_usuario = U.id_usuario');
        $this->db->join('Apartados A','Co.id_apartado = A.id_apartado','left');
        $this->db->join('Clientes C','Co.id_cliente = C.id_cliente');
        $this->db->join('Lotes L', 'Co.id_lote = L.id_lote');
        $this->db->join('Casas Ca', 'L.id_lote = Ca.id_lote');
        $this->db->join('Manzanas M','L.id_manzana = M.id_manzana');
        $this->db->join('Fraccionamientos F','M.id_fraccionamiento = F.id_fraccionamiento');
        $this->db->where('id_contrato', $id);
        return $this->db->get($this->tbl.' Co');
    }
    
    function get_last(){
        $this->db->order_by('id_contrato', 'desc');
        return $this->db->get($this->tbl, 1);
    }

    /**
    * ***********************************************************************
    * Alta de contrato
    * ***********************************************************************
    */
    function save( $contrato ) {
        if( $this->db->insert($this->tbl, $contrato) )
            return $this->db->insert_id();
        else
            return false;
    }

    /**
    * ***********************************************************************
    * Actualizar contrato por id
    * ***********************************************************************
    */
    function update( $id, $contrato ) {
        $this->db->where('id_contrato', $id);
        $this->db->update($this->tbl, $contrato);
    }

    /**
    * ***********************************************************************
    * Eliminar contrato por id
    * ***********************************************************************
    */
    function delete( $id ) {
        $this->db->where('id_contrato', $id);
        $this->db->delete($this->tbl);
    }
    /*
     * Adjuntos del contrato
     */
    function get_paged_list_adjuntos($id_contrato = null, $limit = null, $offset = 0){
        $this->db->join('Adjuntos',$this->tbl_adjuntos_contrato.'.id_adjunto = Adjuntos.id_adjunto');
        $this->db->where($this->tbl_adjuntos_contrato.'.id_contrato', $id_contrato);
        return $this->db->get('ContratoAdjuntos', $limit, $offset);
    }
    
    function get_by_id_adjunto( $id_adjunto ){
        $this->db->join('Adjuntos',$this->tbl_adjuntos_contrato.'.id_adjunto = Adjuntos.id_adjunto');
        $this->db->where($this->tbl_adjuntos_contrato.'.id_adjunto', $id_adjunto);
        return $this->db->get('ContratoAdjuntos');
    }
    
    function count_all_adjuntos( $id_contrato ) {
        $this->db->where('id_contrato', $id_contrato);
        return $this->db->count_all_results($this->tbl_adjuntos_contrato);
    }
    
    function save_adjunto( $adjunto, $id_contrato ){
        $this->db->insert('Adjuntos', $adjunto);
        $id_adjunto = $this->db->insert_id();
        $this->db->insert($this->tbl_adjuntos_contrato, array('id_adjunto' => $id_adjunto, 'id_contrato' => $id_contrato));
        return $this->db->insert_id();
    }
    
    function update_adjunto( $adjunto, $id_adjunto ) {
        $this->db->where('id_adjunto', $id_adjunto);
        $this->db->update($this->tbl_adjuntos, $adjunto);
    }
    
    function delete_adjunto( $id_adjunto, $id_contrato ){
        $this->db->trans_start();
        $this->db->delete('Adjuntos', array('id_adjunto' => $id_adjunto));
        $this->db->delete('ContratoAdjuntos', array('id_contrato' => $id_contrato, 'id_adjunto' => $id_adjunto));
        $this->db->trans_complete();
        if( $this->db->trans_status() === FALSE )
            return false;
        else
            return true;
    }

}

?>
