<div id="contenido">
    <?php echo form_open('inventario/compras/listado'); ?>
    <table class="tabla-filtros">
        <tr class="ui-widget-header">
            <td colspan="2" class="filtro-titulo">Filtros de búsqueda</td>
        </tr>
        <tr>
            <td class="filtro-nombre">Fecha:</td>
            <td class="filtro-dato"><input type="text" class="fecha" name="DATENEW" value="<?php echo isset($filtros['DATENEW']) ? $filtros['DATENEW'] : ''; ?>"/></td>
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
            <td colspan="2"><button type="submit">Buscar</button></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
    <table class="tabla-listado">
        <tr class="ui-widget-header">
            <td style="width: 20%;">Fecha</td>
            <td style="width: 40%;">Proveedor</td>
            <td style="width: 10%;">Folio</td>
            <td style="width: 15%;">Total</td>
            <td style="width: 15%;">&nbsp;</td>
        </tr>
        <?php
        $total = 0;
            foreach ($compras as $compra){
        ?>
        <tr>
            <td><?php echo $compra->DATENEW; ?></td>
            <td><?php echo $compra->SUPPLIERNAME; ?></td>
            <td><?php echo $compra->NUMBER; ?></td>
            <td align="right"><?php echo '$'.number_format($compra->TOTAL,2); ?></td>
            <td align="center">
                <?php echo anchor('inventario/compras/detalle/'.$compra->ID, 'Ver','class="button"'); ?>
            </td>
        </tr>
        <?php
        $total += $compra->TOTAL;
            }
        ?>
        <tr>
            <td colspan="3" align="right">TOTAL</td>
            <td align="right" style="font-weight: bold;"><?php echo '$'.number_format($total,2); ?></td>
            <td>&nbsp;</td>
        </tr>
    </table>
</div>
