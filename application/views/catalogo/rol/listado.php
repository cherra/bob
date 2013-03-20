<div id="contenido">
    <?php echo form_open('catalogo/roles/listado'); ?>
    <table class="tabla-filtros">
        <tr class="ui-widget-header">
            <td colspan="2" class="filtro-titulo">Filtros de búsqueda</td>
        </tr>
        <tr>
            <td class="filtro-nombre">Nombre:</td>
            <td class="filtro-dato"><input type="text" name="NAME" /></td>
        </tr>
        <tr>
            <td colspan="2"><button type="submit">Buscar</button></td>
        </tr>
    </table>
    <?php echo form_close(); ?>
    <table class="tabla-listado">
        <tr class="ui-widget-header">
            <td style="width: 20%;">Nombre del Rol</td>
            <td style="width: 70%;">Descripción</td>
            <td style="width: 10%">&nbsp;</td>
        </tr>
        <?php
            foreach ($roles as $rol){
        ?>
        <tr>
            <td><?php echo $rol->NAME; ?></td>
            <td><?php echo $rol->DESCRIPTION; ?></td>
            <td>
                <?php echo anchor('catalogo/roles/modifica/'.$rol->ID, 'Modificar', 'class="button"'); ?>
            </td>
        </tr>
        <?php
            }
        ?>
    </table>
</div>
