<?php

class Inventarios extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function existencias(){
        $this->load->model('inventario/almacen');
        $this->load->model('catalogo/sucursal');
        $this->load->model('catalogo/proveedor');
        $this->load->model('catalogo/categoria');
        $datos_busqueda = $this->session->userdata('filtros');
        $data['stock'] = $this->almacen->stock($datos_busqueda);
        $data['filtros'] = $datos_busqueda;
        $data['sucursales'] = $this->sucursal->get_all();
        $data['proveedores'] = $this->proveedor->get_all();
        $data['categorias'] = $this->categoria->get_all();
        
        $this->load->view('informe/inventario/existencia',$data);
    }
}

?>
