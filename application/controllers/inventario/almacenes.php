<?php
/**
 * Description of almacenes
 *
 * @author cherra
 */
class Almacenes extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('inventario/almacen');
    }
    
    public function traspaso(){
        $this->load->model('catalogo/proveedor');
        $this->load->model('catalogo/categoria');
        $this->load->model('compra/factura');
        if($this->input->is_ajax_request()){
            $this->load->model('catalogo/producto');
            $data = $this->input->post();
            if($data){
                $this->load->library('etiqueta'); // Clase para generar la etiqueta del producto
                $this->db->trans_start(); // Inicio de transacción en la base de datos
                $id = $this->uuid->v4();  // Generamos el ID del traspaso
                $traspaso = array(
                    'ID' => $id,
                    'DATENEW' => $data['DATENEW'],
                    'LOCATIONFROM' => $data['LOCATIONFROM'],
                    'LOCATIONTO' => $data['LOCATIONTO']
                );
                if($this->almacen->traspaso($traspaso) > 0){  //Registramos el traspaso
                    foreach($data['PRODUCTS'] as $producto){
                        $id_stockdiary = $this->uuid->v4();
                        $datos = array(
                            'ID' => $id_stockdiary,
                            'DATENEW' => $data['DATENEW'],
                            'REASON' => '-2',
                            'LOCATION' => $data['LOCATIONFROM'],
                            'PRODUCT' => $producto[0],
                            'UNITS' => -$producto[1],
                            'STOCKTRANSFER' => $id
                        );
                        if($this->almacen->movimiento($datos) > 0){  // Registramos la salida
                            $id_stockdiary = $this->uuid->v4();
                            $datos = array(
                                'ID' => $id_stockdiary,
                                'DATENEW' => $data['DATENEW'],
                                'REASON' => '2',
                                'LOCATION' => $data['LOCATIONTO'],
                                'PRODUCT' => $producto[0],
                                'UNITS' => $producto[1],
                                'STOCKTRANSFER' => $id
                            );
                            if($this->almacen->movimiento($datos) > 0){  // Registramos la entrada
                                $articulo = $this->producto->get_por_id($producto[0]);
                                $almacen = $this->almacen->get_por_id($data['LOCATIONTO']);
                                // Generamos la etiqueta del producto
                                //echo $this->config->item('label_format');
                                if($almacen['PRINTLABELS'] == '1'){
                                    $etiqueta = $this->etiqueta->genera($this->config->item('label_format'), $articulo['NAME'], $articulo['PRICESELL'], $articulo['CODE'], $almacen['NAME'], $producto[1], $articulo['REFERENCE']);
                                    if($etiqueta){
                                        write_file('labels/'.$this->config->item('label_file'), $etiqueta);
                                        exec('lp -d '.$this->config->item('label_printer').' -h '.$this->config->item('label_host').' -o raw labels/'.$this->config->item('label_file'));
                                    }else{
                                        echo "Error al generar la etiqueta";
                                    }
                                }
                            }else
                                echo "ERROR";
                        }else
                            echo "ERROR";
                    }
                    echo "OK";
                }
                $this->db->trans_complete();
            }
        }else{
            $data['almacenes'] = $this->almacen->get_all();
            $data['proveedores'] = $this->proveedor->get_all();
            $data['categorias'] = $this->categoria->get_all();
            $data['compras'] = $this->factura->get_all();
            $this->load->view('inventario/almacen/traspaso',$data);
        }
    }
    
    public function stock(){
        if($this->input->is_ajax_request()){
            $filtros = $this->input->post();
            if($filtros){
                $data = $this->almacen->stock($filtros);
                echo json_encode($data, JSON_FORCE_OBJECT);
            }
        }
    }
    
    public function existencias(){
        $this->load->model('catalogo/proveedor');
        $this->load->model('catalogo/categoria');
        $filtros = $this->session->userdata('filtros');
        $data['almacenes'] = $this->almacen->get_all();
        $data['existencias'] = $this->almacen->stock($filtros);
        $data['categorias'] = $this->categoria->get_all();
        $data['proveedores'] = $this->proveedor->get_all();
        $data['filtros'] = $filtros;
        $this->load->view('inventario/almacen/existencia',$data);
    }
}

?>
