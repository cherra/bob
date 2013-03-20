<div id="contenido">
    <br />
    <div style=" font-weight: bold;"><?php echo $rol['NAME']; ?></div><br />
    <?php echo form_open('catalogo/roles/modifica/'.$rol['ID']); ?>
    <input type="hidden" name="ID" value="<?php echo $rol['ID']; ?>"/>
    <table class="tabla-captura">
        <tr>
            <td style="width: 40%;"><label for="NAME">Nombre del rol: </label></td>
            <td style="width: 60%;"><input type="text" name="NAME" id="NAME" value="<?php echo $rol['NAME']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="DESCRIPTION">Descripción: </label></td>
            <td><input type="text" name="DESCRIPTION" id="DESCRIPTION" value="<?php echo $rol['DESCRIPTION']; ?>" /></td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="acordion">
                    <h3><a href="#">Permisos:</a></h3>
                    <div>
                        <?php
                        $class = '';
                        $folder = '';
                        foreach($perms AS $perm){
                            if($folder != $perm->FOLDER){
                         ?>
                            <br />
                            <p style="font-weight: bold;"><?php echo ucwords($perm->FOLDER); ?></p>
                        <?php
                            }
                            if($class != $perm->CLASS){
                        ?>
                            <p style="margin-top: 0.5em;">- <?php echo ucwords($perm->CLASS); ?> -</p>
                        <?php
                            }
                        ?>
                        <input type="checkbox" name="ROLEPERMS[]" value="<?php echo $perm->ID; ?>" <?php
                        foreach($role_perms AS $role_perm){
                            if($perm->ID == $role_perm->PERMID)
                                echo "checked";
                        }
                        ?>/><?php echo $perm->PERMNAME; ?><br />
                        <?php
                            $class = $perm->CLASS;
                            $folder = $perm->FOLDER;
                        }
                        ?>
                    </div>
                </div>
            </td>
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