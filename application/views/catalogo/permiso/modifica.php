<div id="contenido">
    <br />
    <div style=" font-weight: bold;"><?php echo $permiso['PERMNAME']; ?></div><br />
    <?php echo form_open('catalogo/permisos/modifica/'.$permiso['ID']); ?>
    <input type="hidden" name="ID" value="<?php echo $permiso['ID']; ?>"/>
    <table class="tabla-captura">
        <tr>
            <td style="width: 40%;"><label for="PERMNAME">Nombre del permiso: </label></td>
            <td style="width: 60%;"><input type="text" name="PERMNAME" id="PERMNAME" value="<?php echo $permiso['PERMNAME']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="MENU">En el menú?: </label></td>
            <td><input type="checkbox" name="MENU" id="MENU" value="1" <?php if($permiso['MENU'] == '1'){ echo "checked"; } ?> /></td>
        </tr>
        <tr>
            <td><label for="SUBMENU">Submenu: </label></td>
            <td><input type="text" name="SUBMENU" id="SUBMENU" value="<?php echo $permiso['SUBMENU']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="RUTA">Ruta: </label></td>
            <td><input type="text" name="RUTA" id="RUTA" value="<?php echo $permiso['FOLDER'].'/'.$permiso['CLASS'].'/'.$permiso['METHOD']; ?>" disabled /></td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="Guardar" />
            </td>
        </tr>
    </table>
   
    <?php echo form_close(); ?>
    
</div>