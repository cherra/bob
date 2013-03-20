<?php
$folder = '';
$submenu = '';
$class = '';
?>

<div id="menu">
    <div class="menu">
        <?php foreach ($menu AS $opcion){ ?>
                <?php if( strlen($class) > 0 && $class != $opcion->CLASS){ ?>
                </div>
                <?php } ?>
            <?php if( strlen($submenu) > 0 && $submenu != $opcion->SUBMENU ) { ?>
            </div>
            <?php }?>
        <?php if(strlen($folder) > 0 && $folder != $opcion->FOLDER){ ?>
        </div>
        <?php } ?>
                    
        <?php if($folder != $opcion->FOLDER){ ?>
        <h3><a href="#"><?php echo ucwords($opcion->FOLDER); ?></a></h3>
        <div class="submenu">
        <?php
        }
        ?>
            <?php if( $submenu != $opcion->SUBMENU && strlen($opcion->SUBMENU) > 0 ){ ?>
            <h3><a href="#"><?php echo substr(ucwords($opcion->SUBMENU),0,16); ?></a></h3>
            <div class="submenu">
            <?php }?>
                <?php if($class != $opcion->CLASS){ ?>
                <h3><a href="#"><?php echo substr(ucwords(str_replace('_',' ',$opcion->CLASS)),0,16); ?></a></h3>
                <div>
                <?php
                }
                ?>
                    <div style="<?php if($opcion->MENU != '1') echo "display: none;"; ?>"><?php echo anchor($opcion->FOLDER.'/'.$opcion->CLASS.'/'.$opcion->METHOD,$opcion->PERMNAME); ?></div>
        <?php
        $folder = $opcion->FOLDER;
        $submenu = $opcion->SUBMENU;
        $class = $opcion->CLASS;
        } 
        ?>
                </div>
            </div>
        </div>

    <div style="float: left;"><input type="checkbox" name="menu-visible" id="menu-visible" value="s"/><label for="menu-visible">Mantener visible</label></div>
</div>