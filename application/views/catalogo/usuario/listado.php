<div id="contenido">
    <?php echo form_open('catalogo/usuario/listado'); ?>
    <table class="tabla-filtros">
        <tr class="ui-widget-header">
            <td colspan="2" class="filtro-titulo">Filtros de búsqueda</td>
        </tr>
        <tr>
            <td class="filtro-nombre">Nombre:</td>
            <td class="filtro-dato"><input type="text" name="NAME" /></td>
        </tr>
        <tr>
            <td class="filtro-nombre">Rol:</td>
            <td class="filtro-dato">
                <select name="ROLEID">
                    <option value="">Todos</option>
                    <?php 
                    foreach($roles AS $rol){
                        ?>
                    <option value="<?php echo $rol->ID; ?>"><?php echo $rol->NAME; ?></option>
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
            <td style="width: 20%;">Usuario</td>
            <td style="width: 70%;">Roles</td>
            <td style="width: 10%;">&nbsp;</td>
        </tr>
        <?php
            foreach ($usuario as $row){
        ?>
        <tr>
            <td><?php echo $row->NAME; ?></td>
            <td><?php
            $roles = $this->usuario->get_roles($row->ID);
            foreach($roles AS $rol){
                echo ' | '.$rol->NAME; 
            }?></td>
            <td>
                <?php echo anchor('catalogo/usuarios/modifica/'.$row->ID, 'Modificar','class="button"'); ?>
            </td>
        </tr>
        <?php
            }
        ?>
    </table>
</div>
