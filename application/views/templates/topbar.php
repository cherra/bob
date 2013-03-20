<div id="top" style="position: relative; height: 75px; border: 0;" >
    <div id="topbar" style="height: 35px;"  class="ui-widget-header">
        <div style="float: left; margin-left: 10px;"><button id="botonMenu" class="ui-state-default ui-corner-all">Menu</button></div>
        <div style="float: right; margin-right: 10px; margin-top: 10px;" class="ui-state-default ui-corner-all"><a href="<?php echo site_url('home'); ?>" class="ui-icon ui-icon-home"></a></div>
    </div>
    <?php
     if($this->load->get_var('mensaje')){
    ?>
    <div id="mensaje" class="ui-widget">
        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
            <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
            <?php
            echo $this->load->get_var('mensaje');
            ?>
            </p>
        </div>
    </div>
    <?php
     }
    ?>
    <div id="breadcrumb" style="height: 10px;">
        <?php
            echo ucwords(str_replace('/',' > ',uri_string()));
        ?>
    </div>
    <div id="title" style="height: 25px;">
        <h1><?php echo $this->load->get_var('title'); ?></h1>
    </div>
</div>