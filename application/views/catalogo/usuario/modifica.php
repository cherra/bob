<div id="contenido">
    <br />
    <div style=" font-weight: bold;"><?php echo $usuario['NAME']; ?></div><br />
    <?php echo form_open('catalogo/usuarios/modifica/'.$usuario['ID']); ?>
    <input type="hidden" name="ID" value="<?php echo $usuario['ID']; ?>" />
    <table class="tabla-captura">
        <tr>
            <td style="width: 40%;"><label for="NAME">Nombre de usuario: </label></td>
            <td style="width: 60%;"><input type="text" name="NAME" id="NAME" value="<?php echo $usuario['NAME']; ?>" /></td>
        </tr>
        <tr>
            <td><label for="APPPASSWORD">Contraseña: </label></td>
            <td><input type="password" name="APPPASSWORD" id="APPPASSWORD" value="" /></td>
        </tr>
        <tr>
            <td><label for="ROLE">Rol principal: </label></td>
            <td>
                <select name="ROLE">
                    <?php 
                    foreach($roles AS $rol){
                    ?>
                    <option value="<?php echo $rol->ID; ?>" <?php if($rol->ID == $usuario['ROLE']) echo "selected"; ?>><?php echo $rol->NAME; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="VISIBLE">Activo?: </label></td>
            <td><input type="radio" name="VISIBLE" id="VISIBLE" value="1" <?php if(ord($usuario['VISIBLE']) == 1) echo "checked"; ?>/>Si<br />
              <input type="radio" name="VISIBLE" id="VISIBLE" value="0" <?php if(ord($usuario['VISIBLE']) == 0) echo "checked"; ?>/>No</td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="acordion">
                    <h3><a href="#">Roles:</a></h3>
                    <div>
                        <?php
                        foreach($roles AS $rol){
                        ?>
                        <input type="checkbox" name="PEOPLEROLES[]" value="<?php echo $rol->ID; ?>" <?php
                        foreach($userRoles AS $userRol){
                            if($rol->ID == $userRol->ID)
                                echo "checked";
                        }
                        ?>/><?php echo $rol->NAME; ?><br />
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </td>
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
                            <p><?php echo ucwords($perm->CLASS); ?></p>
                        <?php
                            }
                        ?>
                        <input type="checkbox" name="PEOPLEPERMS[]" value="<?php echo $perm->ID; ?>" <?php
                        foreach($userPerms AS $userPerm){
                            if($perm->ID == $userPerm->PERMID)
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