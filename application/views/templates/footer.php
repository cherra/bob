<?php
    //$uri = $this->uri->segment_array();
    
?>
<script>
    $.widget( "ui.timespinner", $.ui.spinner, {
        options: {
            // seconds
            step: 600 * 1000,
            // hours
            page: 60
        },
 
        _parse: function( value ) {
            if ( typeof value === "string" ) {
                // already a timestamp
                if ( Number( value ) == value ) {
                    return Number( value );
                }
                return +Globalize.parseDate( value );
            }
            return value;
        },
 
        _format: function( value ) {
            return Globalize.format( new Date(value), "t" );
        }
    });
    
    $(document).ready(function(){
        
        // Funciones de jQuery UI
        // Aplica el estilo a los botones y el calendario a los input de clase fecha.
        $('button,input[type="submit"],input[type="button"],.button,.submenu div a').button();
        $('.fecha').datepicker({ dateFormat: "yy-mm-dd" });
        Globalize.culture( 'es-MX' );
        $('.hora').timespinner();
        
        // Función para validar los campos de los formularios
        // Solo valida los formularios que no tengan la clase "ajax" (ej. class="ajax")
        $('form:not(.ajax)').validate();
        
        // Se verifica si el menú debe estar visible o no
        $.ajax({
                url: "<?php echo site_url().'/catalogo/ajax/session_obten_valor/menu_visible'; ?>",
                type: 'post',
                dataType: 'text'
            }).done(function(resultado){
                if(resultado == 1){
                    $('#menu-visible').attr('checked','checked');
                    $('#contenido,#top').css('margin-left','138px');
                }else{
                    $('#menu').css('margin-left','-140px');
                    $('#contenido,#top').css('margin-left','0px');
                    /*$('#menu').stop().animate({'marginLeft':'-140px'},200);
                    $('#contenido,#top').stop().animate({'marginLeft':'0px'},200);*/
                }
            }).fail(function(){
                alert("Error al cambiar el estado del menú!");
            });

        // Botón que muestra y oculta el menú
        $('#botonMenu').click(
            function () {
                if($('#menu').css('margin-left') == '-140px'){
                    $('#menu').show();
                    $('#menu').stop().animate({'marginLeft':'-2px'},200);
                    $('#contenido,#top').stop().animate({'marginLeft':'138px'},200);
                    //$('#top').stop().animate({'marginLeft':'98px'},200);
                }else{
                    $('#menu').stop().animate({'marginLeft':'-140px'},200);
                    $('#contenido,#top').stop().animate({'marginLeft':'0px'},200,function(){
                        $('#menu').hide();
                    });
                }

            }
        );
        
        /* Menu
            navigationFilter activa la opción del menú que corresponda a la URL en el navegador,
            la función php substr_count se utiliza para cortar la cadena hasta el método, eliminando
            los parametros en caso de que existan.
        */
        $('.menu,.submenu').accordion({head:'h3', collapsible: true, active: true, autoHeight: false, container: false, navigation: true, 
            navigationFilter: function(){
                return this.href.toLowerCase() == '<?php echo site_url().'/'; echo substr_count(uri_string(),'/') > 2 ? substr(uri_string(),0, strrpos(uri_string(),'/')) : uri_string(); ?>';
            }
        });
        $('.submenu div a[href="<?php echo site_url().'/'; echo substr_count(uri_string(),'/') > 2 ? substr(uri_string(),0, strrpos(uri_string(),'/')) : uri_string(); ?>"]').addClass('ui-state-active');
        
        $('.acordion').accordion({head:'h3', collapsible: true, active: false});
        
        // Checkbox para cambiar el estado del menú: visible/oculto
        $('#menu-visible').click(function(){
            var visible = 0;
            if($(this).attr('checked')){
                visible = 1;
            }
            $.ajax({
                url: "<?php echo site_url().'/catalogo/ajax/session_registra_valor'; ?>",
                type: 'post',
                dataType: 'text',
                data: {'menu_visible': visible}
            }).fail(function(){
                alert("Error al cambiar el estado del menú!");
            });
        });
        
        // Para resaltar la fila cuando el mouse pasa sobre ella.
        // Solo para class="tabla-listado"
        var fila = 0;
        $('.tabla-listado tr').each(function(){
            if(fila % 2 == 0){
                $(this).addClass('fila-alterna');
            }
            fila++;
        });
    });
</script>
</body>
</html>