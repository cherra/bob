<div id="contenido">
    <?php echo form_open('informes/inventarios/existencias'); ?>
    <table class="tabla-filtros">
        <tr class="ui-widget-header">
            <td colspan="2" class="filtro-titulo">Filtros de búsqueda</td>
        </tr>
        <tr>
            <td class="filtro-nombre">Fecha:</td>
            <td class="filtro-dato"><input type="text" class="fecha" name="DATENEW" value="<?php echo isset($filtros['DATENEW']) ? $filtros['DATENEW'] : ''; ?>"/></td>
        </tr>
        <tr>
            <td class="filtro-nombre">Sucursal:</td>
            <td class="filtro-dato">
                <select name="LOCATION">
                    <option value="">Todos</option>
                    <?php 
                    foreach($sucursales AS $sucursal){
                        ?>
                    <option value="<?php echo $sucursal->ID; ?>" <?php if(isset($filtros['LOCATION'])){ echo $filtros['LOCATION'] == $sucursal->ID ? 'selected': ''; } ?>><?php echo $sucursal->NAME; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="filtro-nombre">Proveedor:</td>
            <td class="filtro-dato">
                <select name="SUPPLIER">
                    <option value="">Todos</option>
                    <?php 
                    foreach($proveedores AS $proveedor){
                        ?>
                    <option value="<?php echo $proveedor->ID; ?>" <?php if(isset($filtros['SUPPLIER'])){ echo $filtros['SUPPLIER'] == $proveedor->ID ? 'selected': ''; } ?>><?php echo $proveedor->NAME; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="filtro-nombre">Categoría:</td>
            <td class="filtro-dato">
                <select name="CATEGORY">
                    <option value="">Todas</option>
                    <?php 
                    foreach($categorias AS $categoria){
                        ?>
                    <option value="<?php echo $categoria->ID; ?>" <?php if(isset($filtros['CATEGORY'])){ echo $filtros['CATEGORY'] == $categoria->ID ? 'selected': ''; } ?>><?php echo $categoria->NAME; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="filtro-nombre">Producto:</td>
            <td class="filtro-dato"><input type="text" name="PRODUCT" value="<?php echo isset($filtros['PRODUCT']) ? $filtros['PRODUCT'] : ''; ?>"/></td>
        </tr>
        <tr>
            <td colspan="2"><button type="submit">Buscar</button></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
    <table class="tabla-listado">
        <tr class="ui-widget-header">
            <td style="width: 10%;">Código</td>
            <td style="width: 10%;">Referencia</td>
            <td style="width: 40%;">Producto</td>
            <td style="width: 10%;" align="right">Stock</td>
            <td style="width: 10%;" align="right">Precio</td>
            <td style="width: 10%;">&nbsp;</td>
        </tr>
        <?php
        if(!empty($stock)){
            $total_piezas = 0;
            $total_importe = 0;
            foreach ($stock as $existencia){
        ?>
        <tr>
            <td><?php echo $existencia->CODE; ?></td>
            <td><?php echo $existencia->REFERENCE; ?></td>
            <td><?php echo $existencia->NAME; ?></td>
            <td align="right"><?php echo number_format($existencia->STOCK,2); ?></td>
            <td align="right"><?php echo '$'.number_format($existencia->PRICESELL,2); ?></td>
            <td align="center">
                <?php echo anchor('ventas/informes/detalle/'.$existencia->ID, 'Ver','class="button"'); ?>
            </td>
        </tr>
        <?php
                $total_importe += $existencia->PRICESELL * $existencia->STOCK;
                $total_piezas += $existencia->STOCK;
            }
        ?>
        <tr>
            <td colspan="3" align="right">TOTAL</td>
            <td align="right" style="font-weight: bold;"><?php echo number_format($total_piezas,2); ?></td>
            <td align="right" style="font-weight: bold;"><?php echo '$'.number_format($total_importe,2); ?></td>
            <td>&nbsp;</td>
        </tr>
        <?php
        }
        ?>
    </table>
</div>
