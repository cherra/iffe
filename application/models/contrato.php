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
        $this->db->select('c.*, CONCAT(cl.nombre," ",cl.apellido_paterno," ",cl.apellido_materno) AS cliente', FALSE);
        $this->db->join('Clientes cl','c.id_cliente = cl.id');
        $this->db->order_by('numero','desc');
        return $this->db->get($this->tbl.' c',$limit, $offset);
    }
    
    function get_modulos( $id, $limit = null, $offset = 0 ){
        $this->db->select('c.nombre as calle, m.id as id_modulo, m.numero as modulo, m.categoria, m.tipo, cm.importe');
        $this->db->join('Modulos m','cm.id_modulo = m.id');
        $this->db->join('Calles c','m.id_calle = c.id');
        $this->db->where('cm.id_contrato',$id);
        $this->db->order_by('c.nombre, m.numero');
        return $this->db->get($this->tbl_contrato_modulos.' cm', $limit, $offset);
    }
    
    function get_importe( $id ){
        $this->db->select('SUM(cm.importe) as importe', FALSE);
        $this->db->join('Modulos m','cm.id_modulo = m.id');
        $this->db->where('cm.id_contrato',$id);
        $this->db->group_by('cm.id_contrato');
        $query = $this->db->get($this->tbl_contrato_modulos.' cm');
        if($query->num_rows() > 0)
            return $query->row()->importe;
        else
            return 0;
    }

    /**
    * ***********************************************************************
    * Obtener contrato por id
    * ***********************************************************************
    */
    function get_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->tbl);
    }
    
    function get_last(){
        $this->db->order_by('id', 'desc');
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
    
    function save_modulo( $modulo ) {
        if( $this->db->insert($this->tbl_contrato_modulos, $modulo) )
            return $this->db->insert_id();
        else
            return false;
    }
    
    function delete_modulo($id_modulo){
        $this->db->delete($this->tbl_contrato_modulos, array('id_modulo' => $id_modulo));
    }

    /**
    * ***********************************************************************
    * Actualizar contrato por id
    * ***********************************************************************
    */
    function update( $id, $contrato ) {
        $this->db->where('id', $id);
        $this->db->update($this->tbl, $contrato);
    }

    /**
    * ***********************************************************************
    * Autorizar
    * ***********************************************************************
    */
    function autorizar( $id, $documento ) {
        if(!empty($id) && !empty($documento)){
            $this->db->where('id', $id);
            $this->db->update($this->tbl, array('estado' => 'autorizado', 'documento' => $documento));
        }
    }
    
    /**
    * ***********************************************************************
    * Cancelar
    * ***********************************************************************
    */
    function cancelar( $id ) {
        $this->db->where('id', $id);
        $this->db->update($this->tbl, array('estado' => 'cancelado'));
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
