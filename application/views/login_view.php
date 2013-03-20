<?php echo $header; ?>
    <body lang="es">
        <div class="ui-widget-header" style="height: 30px;"></div>
        <div id="login_form" class="ui-widget-content" style="margin-left: auto; margin-right: auto; top: -15px; width: 80%; border: solid 2px #ccc; border-radius: 5px;">
            <?php 
            $atributos = array('name'=>'process');
            echo form_open('login/process',$atributos); 
            ?>
            <form action="<?php echo base_url('login/process');?>" method="post" name="process">
                <h3>Intranet 2.0</h3>
                <?php if(! is_null($msg)) echo $msg;?>
                <div style="height: 90px; width: 50%; margin-left: auto; margin-right: auto;">
                    <div style="height: 45px;">
                        <label for="NAME">Usuario</label><br/>
                        <?php echo form_input('NAME','','size="15" id="NAME"'); ?>
                    </div>
                    <div style="height: 45px;">
                        <label for="APPPASSWORD">Contraseña</label>
                        <br />
                        <input type="password" name="APPPASSWORD" id='APPPASSWORD' size="15" />
                    </div>
                </div>
                <div style="height: 40px;">
                    <input type="Submit" value="Entrar" />
                </div>
            </form>
        </div>
    </body>
</html>