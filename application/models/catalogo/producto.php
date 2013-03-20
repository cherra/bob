<?php
/**
 * Description of producto
 *
 * @author cherra
 */
class Producto extends CI_Model{
    
    public function get_por_id($id = 0){
        $this->db->where('ID', $id);
        $query = $this->db->get('PRODUCTS');
        return $query->row_array();
    }
    
    public function insert($data){
        $this->db->insert('PRODUCTS',$data);
        return $this->db->affected_rows();
    }
    
    public function genera_codigo($proveedor, $categoria){
        $this->db->where('ID', $proveedor);
        $query = $this->db->get('SUPPLIERS');
        if($query->num_rows() > 0){
            $row = $query->row();
            $barcode = $row->PREFIX;
        }else{
            return false;
        }
        
        $this->db->select('UPPER(LEFT(NAME,2)) AS CAT_PREFIX',false);
        $this->db->where('ID', $categoria);
        $query = $this->db->get('CATEGORIES');
        if($query->num_rows() > 0){
            $row = $query->row();
            $barcode .= $row->CAT_PREFIX;
        }else{
            return false;
        }
        
        $this->db->select('MAX(RIGHT(CODE,4)) AS CODIGO',false);
        $this->db->where('LEFT(CODE,4)',$barcode);
        $query = $this->db->get('PRODUCTS');
        if($query->num_rows() > 0){
            $row = $query->row();
            $barcode .= str_pad($row->CODIGO+1, 4, "0", STR_PAD_LEFT);
        }else{
            $barcode .= "0001";
        }
        
        return $barcode;
    }
}

?>
