<?php
/**
 * Description of almacen
 *
 * @author cherra
 */
class Almacen extends CI_Model{
    
    public function get_all(){
        $this->db->order_by('NAME');
        $query = $this->db->get('LOCATIONS');
        return $query->result();
    }
    
    public function get_por_id($id = 0){
        $this->db->where('ID', $id);
        $query = $this->db->get('LOCATIONS');
        return $query->row_array();
    }
    
    public function movimiento($data){
        $this->db->insert('STOCKDIARY',$data);
        return $this->db->affected_rows();
    }
    
    public function traspaso($data){
        $this->db->insert('STOCKTRANSFERS',$data);
        return $this->db->affected_rows();
    }
    
    public function stock($filtros = null){
        $this->db->select('PRODUCTS.*, SUM(STOCKDIARY.UNITS) AS STOCK, COUNT(STOCKDIARY.PRODUCT) AS MOVIMIENTOS, LOCATIONS.NAME AS LOCATION, CATEGORIES.NAME AS CATEGORYNAME', FALSE);
        $this->db->from('STOCKDIARY');
        $this->db->join('PRODUCTS', 'STOCKDIARY.PRODUCT = PRODUCTS.ID');
        $this->db->join('LOCATIONS','STOCKDIARY.LOCATION = LOCATIONS.ID');
        $this->db->join('CATEGORIES', 'PRODUCTS.CATEGORY = CATEGORIES.ID');
        $this->db->join('PURCHASELINE','PRODUCTS.ID = PURCHASELINE.PRODUCT','left');
        $this->db->join('PURCHASE','PURCHASELINE.PURCHASE = PURCHASE.ID','left');
        //$this->db->join('STOCKINITIAL', 'PRODUCTS.ID = STOCKINITIAL.PRODUCT AND LOCATIONS.ID = STOCKINITIAL.LOCATION', 'left');
        if(!is_null($filtros)){
            if(!empty($filtros['PRODUCT']))
                $this->db->like('PRODUCTS.NAME', $filtros['PRODUCT']);
            if(!empty($filtros['SUPPLIER']))
                $this->db->where('PRODUCTS.SUPPLIER', $filtros['SUPPLIER']);
            if(!empty($filtros['PURCHASE']))
                $this->db->where('PURCHASE.ID', $filtros['PURCHASE']);
            if(!empty($filtros['CATEGORY']))
                $this->db->where('PRODUCTS.CATEGORY', $filtros['CATEGORY']);
            if(!empty($filtros['REFERENCE']))
                $this->db->where("(PRODUCTS.REFERENCE = '".$filtros['REFERENCE']."' OR PRODUCTS.CODE = '".$filtros['REFERENCE']."')");
            if(!empty($filtros['LOCATION']) || $filtros['LOCATION'] == '0')
                $this->db->where('STOCKDIARY.LOCATION', $filtros['LOCATION']);
            if(!empty($filtros['DATENEW'])){
                $this->db->where('STOCKDIARY.DATENEW <=',$filtros['DATENEW']);
            }
        }
        $this->db->group_by('PRODUCTS.ID');
        $this->db->having('STOCK > 0');
        if(!empty($filtros['PURCHASE']))
            $this->db->order_by('PURCHASELINE.LINE');
        $this->db->order_by('CATEGORIES.NAME, PRODUCTS.CODE');
        $query = $this->db->get();
        return $query->result();
    }
}

?>
