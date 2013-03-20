<div id="contenido">
    <?php echo form_open('catalogo/usuarios/alta'); ?>
    <div class="label"><label for="NAME">Nombre: </label></div>
    <input type="text" name="NAME" id="NAME" /> <br />
    <div class="label"><label for="APPPASSWORD">Contraseña: </label></div>
    <input type="password" name="APPPASSWORD" id="APPPASSWORD" /> <br />
    <div class="label"><label for="ROLE">Rol principal: </label></div>
    <select name="ROLE">
        <?php 
        foreach($roles AS $rol){
        ?>
        <option value="<?php echo $rol->ID; ?>"><?php echo $rol->NAME; ?></option>
        <?php
        }
        ?>
    </select> <br />
    <div class="acordion">
        <h3><a href="#">Roles:</a></h3>
        <div>
            <?php
            foreach($roles AS $rol){
            ?>
            <input type="checkbox" name="PEOPLEROLES[]" value="<?php echo $rol->ID; ?>"/><?php echo $rol->NAME; ?><br />
            <?php
            }
            ?>
        </div>
    </div>
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
            <input type="checkbox" name="PEOPLEPERMS[]" value="<?php echo $perm->ID; ?>"/><?php echo $perm->PERMNAME; ?><br />
            <?php
                $class = $perm->CLASS;
                $folder = $perm->FOLDER;
            }
            ?>
        </div>
    </div>
    <input type="submit" value="Guardar" />
   
    <?php echo form_close(); ?>
</div>