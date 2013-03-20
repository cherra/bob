<div id="contenido">
    <div style="float: right;">
        <button id="nuevo">Nuevo</button>
    </div>
    <div style="clear: both; position: relative; margin-bottom: 4em;">
        <form class="ajax" action="#" id="datos" method="post">
            <div>
                <div style="float: left; width: 50%;">
                    <label class="label" for="DATE">Fecha: </label>
                    <input type="text" class="fecha" name="DATE" id="DATE" required="required" />
                </div>
                <div style="float: left; width: 50%;">
                    <label class="label" for="TIME">Hora: </label>
                    <input type="text" class="hora" name="TIME" id="TIME" value="09:00 a.m." required="required" />
                </div>
            </div>
            <div style="clear: both;">
                <div style="float: left; width: 50%;">
                    <label class="label" for="LOCATIONFROM">Salida de: </label>
                    <select name="LOCATIONFROM" id="LOCATIONFROM">
                        <?php
                        foreach($almacenes as $almacen){
                        ?>
                        <option value="<?php echo $almacen->ID; ?>"><?php echo $almacen->NAME;  ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div style="float: left; width: 50%;">
                    <label class="label" for="LOCATIONTO">Entrada a: </label>
                    <select name="LOCATIONTO" id="LOCATIONTO">
                        <?php
                        foreach($almacenes as $almacen){
                        ?>
                        <option value="<?php echo $almacen->ID; ?>"><?php echo $almacen->NAME;  ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div style="text-align: center; position: absolute; left: 45%; top: 49em;">
                <button type="submit" id="guardar">Guardar</button>
            </div>
        </form>
    </div>
    <div style="clear: both; height: 45em;">
        <div style="clear: both;">
            <h4>Filtros de busqueda:</h4>
        </div>
        <div style="float: left; width: 50%;">
            <label class="label" for="SUPPLIER">Proveedor: </label>
            <select name="SUPPLIER" id="SUPPLIER">
                <option value="">- - -</option>
                <?php
                foreach($proveedores as $proveedor){
                ?>
                <option value="<?php echo $proveedor->ID; ?>"><?php echo $proveedor->NAME;  ?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <div style="float: left; width: 40%;">
            <label class="label" for="CATEGORY">Categoría: </label>
            <select name="CATEGORY" id="CATEGORY">
                <option value="">- - -</option>
                <?php
                foreach($categorias as $categoria){
                ?>
                <option value="<?php echo $categoria->ID; ?>"><?php echo $categoria->NAME;  ?></option>
                <?php
                }
                ?>
            </select>
            
        </div>
        <!-- <div style="clear: both; float: left; width: 50%;">
            <label class="label" for="DATENEW">Fecha de compra: </label>
            <input type="text" class="fecha" name="DATENEW" id="DATENEW" />
        </div> -->
        <div style="clear: both; float: left; width: 50%; margin-bottom: 1em;">
            <label class="label" for="PURCHASE">Folio: </label>
            <select name="PURCHASE" id="PURCHASE">
                <option value="">- - -</option>
            </select>
        </div>
        <div style="float:left; width: 40%;">
            <label class="label" for="REFERENCE">Codigo del artículo: </label>
            <input type="text" name="REFERENCE" id="REFERENCE" size="10"/>
        </div>
        
        <div style="clear: both; float: left; width: 50%;">
            <div>
                <h4>Artículos disponibles</h4>
            </div>
            <div class="ui-widget-content" style="height: 30em; overflow-y: auto;">
                <table id="disponibles" style="font: 85% sans-serif;">
                    
                </table>
            </div>
            <div style="float: right; width: 50%; text-align: right; margin-top: 1em;">
                <h5>Total: <label id="totaldisponible"></label></h5>
            </div>
        </div>

        <div style="float: left; position: relative; top: 35%; width: 10%; text-align: center;">
            <div><button id="agregar">>></button></div>
            <div style="font: 75% sans-serif;"><p>(Click para agregar)</p></div>
        </div>

        <div style="float: right; width: 40%;">
            <div>
                <h4>Artículos a transferir</h4>
            </div>
            <div class="ui-widget-content" style="height: 30em; overflow-y: auto;">
                <table id="entradas" style="font: 85% sans-serif;">
                    <tr class="ui-widget-header">
                        <td style="width: 15%;">Ref.</td>
                        <td style="width: 15%;">Código</td>
                        <td style="width: 65%;">Artículo</td>
                        <td style="width: 10%;">Cant.</td>
                    </tr>
                </table>
            </div>
            <div style="float: left; width: 50%; text-align: left; margin-top: 1em;">
                <button id="quitar" disabled>Quitar</button>
            </div>
            <div style="float: right; width: 50%; text-align: right; margin-top: 1em;">
                <h5>Total: <label id="total"></label></h5>
            </div>
        </div>
    </div>
    
</div>

<script type="text/javascript">
    $(document).ready(function(){
        
        function obtener_stock(){
            var fila = 0;
            $.ajax({
                url: "<?php echo site_url().'/inventario/almacenes/stock' ?>",
                type: "post",
                data: {'SUPPLIER': $('#SUPPLIER').val(), 'PURCHASE': $('#PURCHASE').val(), 'CATEGORY': $('#CATEGORY').val(), 'REFERENCE': $('#REFERENCE').val(), 'LOCATION': $('#LOCATIONFROM').val()},
                dataType: 'json'
            }).done(function(datos){
                
                // Calculo de total de artículos a transferir
                // Se formatean las filas
                // Se guarda el contenido de la tabla en localStorage
                var fila = 0;
                var total = 0;
                $('#entradas tr').each(function(){
                    if($(this).attr('cantidad'))
                        total += Number($(this).attr('cantidad'));
                    if(fila % 2 == 0){
                        $(this).addClass('fila-alterna');
                    }
                    fila++;
                });
                $('#total').html(total);
                localStorage.setItem("inventario/almacenes/traspaso/entradas",$('#entradas').html());
            
                // Se calcula el stock y se le restan las cantidades ya agregadas para transferir
                $('#disponibles').empty();
                $('#disponibles').append('<tr class="ui-widget-header">'+
                                        '<td style="width: 10%;">Ref.</td>'+
                                        '<td style="width: 10%;">Código</td>'+
                                        '<td style="width: 60%;">Artículo</td>'+
                                        '<td style="width: 10%;">Stock</td>'+
                                        '<td style="width: 10%;">Transf.</td>'+
                                        '</tr>');
                var disponible = Number(0);
                total = 0;
                $.each(datos, function(key, val){
                    disponible = Number(val.STOCK)
                    if($('#entradas tr[producto="'+val.ID+'"]').attr('cantidad'))
                        disponible -= Number($('#entradas tr[producto="'+val.ID+'"]').attr('cantidad'));
                    
                    $('#disponibles').append('<tr referencia="'+val.REFERENCE+'" codigo="'+val.CODE+'" producto="'+val.ID+'" nombre="'+val.NAME+'" stock="'+disponible+'">'+
                                            '<td tipo="referencia">'+val.REFERENCE+'</td>'+
                                            '<td tipo="codigo">'+val.CODE+'</td>'+
                                            '<td tipo="nombre">'+val.NAME+'</td>'+
                                            '<td tipo="stock">'+disponible+'</td>'+
                                            '<td tipo="transferir"><input type="text" id="'+val.ID+'" value="0" size="2" style="height: 8px; font-size: 0.9em;" /></td>'+
                                            '</tr>');
                    if(disponible <= 0)
                        $('#disponibles tr td input[id="'+val.ID+'"]').attr('disabled','disabled');
                    else
                        total += Number(disponible);
                });
                
                $('#totaldisponible').html(total);
                
                $('#disponibles tr').each(function(){
                    if(fila % 2 == 0){
                        $(this).addClass('fila-alterna');
                    }
                    fila++;
                    
                });
            }).fail(function(){
                alert("Error al obtener el stock!");
            });
        }
        
        if(localStorage.getItem("inventario/almacenes/traspaso/entradas"))
            $('#entradas').html(localStorage.getItem("inventario/almacenes/traspaso/entradas"));
        obtener_stock();
        
        $('#SUPPLIER').change(function(){
            $.ajax({
                url: "<?php echo site_url().'/compras/facturas/listado'; ?>",
                type: 'post',
                data: {'SUPPLIER': $(this).val(), 'LOCATION': $('#LOCATIONFROM').val()},
                dataType: 'json'
            }).done(function(datos){
                obtener_stock();
                $('#PURCHASE').empty();
                $('#PURCHASE').append('<option value="">- - -</option>');
                $.each(datos, function(key, val){
                    $('#PURCHASE').append('<option value="'+val.ID+'">'+val.NUMBER+'</option>');
                });
            }).fail(function(){
                    alert("Error al intentar guardar la compra");
            });
        });
        
        $('#PURCHASE').change(function(){
            obtener_stock();
        });
        
        $('#CATEGORY').change(function(){
            obtener_stock();
        });
        
        $('#LOCATIONFROM').change(function(){
            obtener_stock();
        });
    
        $('#DATENEW').change(function(){
            obtener_stock();
        });
        
        $('#REFERENCE').keyup(function(){
            obtener_stock();
        });
        
        // Cuando se pasa el mouse sobre el listado de artículos, se resalta la fila para indicar que se puede seleccionar.
        $("#entradas").on("mouseover","tr",function(event){
            if($(this).attr("producto").length > 0){
                $(this).css("cursor","pointer");
                $(this).addClass("ui-state-hover");
            }
        });
        $("#entradas").on("mouseout","tr",function(event){
            if($(this).attr("seleccionado") != "true"){
                $(this).removeClass("ui-state-hover");
            }
        });
        
        // Cuando se da click en algún artículo del pedido se puede seleccionar para borrarlo.
        $("#entradas").on("click","tr",function(event){
            var seleccionados = false;
            if($(this).attr("producto").length > 0){
                if($(this).attr("seleccionado") != "true"){
                    $(this).attr("seleccionado",true);
                }else
                    $(this).removeAttr("seleccionado");
            }

            $("#entradas tr").each(function(fila){
                if($(this).attr("seleccionado") == "true")
                    seleccionados = true;
            });
            if(seleccionados){
                $("#quitar").button("option", "disabled", false);
            }else{
                $("#quitar").button("option", "disabled", true);
            }
        });
        
        $('#disponibles').on('keyup','input',function(){
            var id = $(this).attr('id');
            if(Number($(this).val()) > Number($('#disponibles tr[producto="'+id+'"]').attr('stock'))){
                $(this).val($('#disponibles tr[producto="'+id+'"]').attr('stock'));
            }
        });

//            Evento para quitar artículos de la lista.
        $("#quitar").click(function(){
            $(this).button("option", "disabled", true);
            $("#entradas tr").each(function(fila){
                if($(this).attr("seleccionado") == "true"){
                    $(this).remove();
                }
            });
            obtener_stock();
        });
        
        $('#agregar').click(function(){
            $('#disponibles tr').each(function(){
                if($('input[id="'+$(this).attr('producto')+'"]').val() > 0){
                    if($('#entradas tr[producto="'+$(this).attr('producto')+'"]').attr('cantidad') > 0){
                        $('#entradas tr[producto="'+$(this).attr('producto')+'"] td[tipo="cantidad"]').text(Number($('input[id="'+$(this).attr('producto')+'"]').val())+Number($('#entradas tr[producto="'+$(this).attr('producto')+'"]').attr('cantidad')));
                        $('#entradas tr[producto="'+$(this).attr('producto')+'"]').attr('cantidad',Number($('#entradas tr[producto="'+$(this).attr('producto')+'"]').attr('cantidad'))+Number($('input[id="'+$(this).attr('producto')+'"]').val()));
                    }else{
                        $('#entradas').append('<tr producto="'+$(this).attr('producto')+'" cantidad="'+$('input[id="'+$(this).attr('producto')+'"]').val()+'">'+
                                    '<td>'+$(this).attr('referencia')+'</td>'+
                                    '<td>'+$(this).attr('codigo')+'</td>'+
                                    '<td>'+$(this).attr('nombre')+'</td>'+
                                    '<td tipo="cantidad">'+$('input[id="'+$(this).attr('producto')+'"]').val()+'</td>'+
                                    '</tr>');
                    }
                }
            });
            obtener_stock();
        });
        
        $("#nuevo").click(function(){
            var r = confirm('¿Deseas borrar la captura actual?');
            if(r == true){
                localStorage.removeItem("inventario/almacenes/traspaso/entradas");
                window.location.reload();
            }
        });
        
        $('#datos').submit(function(event){
            event.preventDefault();
            var r = confirm('¿Deseas guardar el traspaso?');
            if(r == true){
                var articulos = [];
                var i = new Number(0);

                $("#entradas tr").each(function(){
                    if($(this).attr("producto")){
                        articulos[i] = new Array(2);
                        articulos[i][0] = $(this).attr("producto");
                        articulos[i][1] = $(this).attr("cantidad");
                        i++;
                    }
                });
                
                $.ajax({
                    url: "<?php echo site_url().'/inventario/almacenes/traspaso'; ?>",
                    type: 'post',
                    data: {DATENEW: $('#DATE').val()+" "+$('#TIME').val(), LOCATIONFROM: $('#LOCATIONFROM').val(), LOCATIONTO: $('#LOCATIONTO').val(),
                            PRODUCTS: articulos},
                    dataType: 'text'
                }).done(function(respuesta){
                    //alert(respuesta);
                    if(respuesta == 'OK'){
                        localStorage.removeItem("inventario/almacenes/traspaso/entradas");
                        window.location.reload();
                    }
                }).fail(function(){
                        alert("Error al intentar guardar el traspaso");
                });
                
                //$('#nuevo').click();
            }
        });
    });
</script>