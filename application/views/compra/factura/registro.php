<div id="contenido" style="position: relative;">
    <div style="float: right;">
        <button id="nuevo">Nuevo</button>
    </div>
    <div style="clear: both; position: relative; margin-bottom: 5em;">
        <form class="ajax" action="#" id="datos">
            <div>
                <div style="float: left; width: 50%;">
                    <label class="label" for="DATE">Fecha: </label>
                    <input type="text" class="fecha" name="DATE" id="DATE" required="required"/>
                </div>
                <div style="float: left; width: 50%;">
                    <label class="label" for="TIME">Hora: </label>
                    <input type="text" class="hora" name="TIME" id="TIME" value="09:00 a.m." required="required" />
                </div>
            </div>
            <div style="clear: both;">
                <div style="float: left; width: 50%;">
                    <label class="label" for="LOCATION">Entrada a: </label>
                    <select name="LOCATION" id="LOCATION">
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
                    <label class="label" for="SUPPLIER">Proveedor: </label>
                    <select name="SUPPLIER" id="SUPPLIER">
                        <?php
                        foreach($proveedores as $proveedor){
                        ?>
                        <option value="<?php echo $proveedor->ID; ?>"><?php echo $proveedor->NAME;  ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div style="clear: both;">
                <div style="float: left; width: 50%;">
                    <label class="label" for="NUMBER">Folio:</label>
                    <input type="text" name="NUMBER" id="NUMBER" style="width: 6.5em;" required="required"/>
                </div>
                    <label class="label" for="CONDITIONS">Condiciones: </label>
                    <select name="CONDITIONS" id="CONDITIONS">
                        <option value="CONTADO">Contado</option>
                        <option value="CREDITO">Crédito</option>
                    </select>
            </div>
            <div style="clear: both;">
                <div style="float: left; width: 50%;">
                    <div><label class="label" for="UTILIDAD">Margen de utilidad (%)</label></div>
                    <div><input type="text" name="UTILIDAD" id="UTILIDAD" size="3" value="50" required="required"/></div>
                </div>
                <div style="float: right; width: 50%;">
                    <label class="label" for="DUEDATE">Vencimiento: </label>
                    <input type="text" class="fecha" name="DUEDATE" id="DUEDATE" disabled />
                </div>
            </div>
            <div style="text-align: center; position: absolute; left: 45%; top: 50em;">
                <button id="guardar">Guardar</button>
            </div>
        </form>
    </div>
    <div style="clear: both;">
        <form class="ajax" action="#" id="registro">
                <div style="margin-bottom: 0.5em; margin-top: 1em;">
                    <h3>Productos</h3>
                </div>
                <div style="float: left; margin-right: 1em;">
                    <input type="hidden" id="linea" />
                    <div><label for="categoria">Categoría</label></div>
                    <div>
                        <select name="categoria" id="categoria" required="required">
                            <?php
                            foreach($categorias as $categoria){
                                ?>
                            <option value="<?php echo $categoria->ID; ?>"><?php echo $categoria->NAME; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div style="float: left; margin-right: 1em;">
                    <div><label for="cantidad">Cant.</label></div>
                    <div><input type="text" name="cantidad" id="cantidad" size="3" required="required" /></div>
                </div>
                <div style="float: left; margin-right: 1em;">
                    <div><label for="codigo">Código</label></div>
                    <div><input type="text" name="codigo" id="codigo" size="6" required="required"/></div>
                </div>
                <div style="float: left; margin-right: 1em;">
                    <div><label for="descripcion">Descripción</label></div>
                    <div><input type="text" name="descripcion" id="descripcion" size="16" required="required"/></div>
                </div>
                <div style="float: left; margin-right: 1em;">
                    <div><label for="precio">Precio</label></div>
                    <div><input type="text" name="precio" id="precio" size="5" required="required"/></div>
                </div>
                <div style="float: left; margin-right: 1em;">
                    <div><label for="descuento">Desc.(%)</label></div>
                    <div><input type="text" name="descuento" id="descuento" size="3" value="0" required="required"/></div>
                </div>
                <div style="float: left;">
                    <div><label for="precio_venta">Precio V.</label></div>
                    <div><input type="text" name="precio_venta" id="precio_venta" size="5" value="0" required="required"/></div>
                </div>
                <div style="float: left; position: relative; top: 0.5em; left: 1em; padding-top: .8em;">
                    <button type="submit" id="agregar">Agregar</button>
                </div>
        </form>
    </div>
   
    <div id="listado" class="ui-widget-content" style="clear: both; position: relative; top: 1em; height: 25em; overflow-x: hidden; overflow-y: auto;">
        <table class="tabla-listado" style="width: 100%; margin-bottom: 0; font: 85% sans-serif;">
            <tr class="ui-widget-header">
                <td style="width: 3%;">L</td>
                <td style="width: 6%;">Cant.</td>
                <td style="width: 8%;">Código</td>
                <td style="width: 8%;">Tipo</td>
                <td style="width: 31%;">Descripción</td>
                <td style="width: 9%;">Precio</td>
                <td style="width: 7%;">Desc.</td>
                <td style="width: 9%;">P/D</td>
                <td style="width: 10%;">Importe</td>
                <td style="width: 9%;" class="ui-state-disabled">Precio V.</td>
            </tr>
        </table>
        <table class="tabla-listado" id="productos" style="width: 100%; font: 85% sans-serif;">
            <tr>
                <td style="width: 3%;"></td>
                <td style="width: 6%;"></td>
                <td style="width: 8%;"></td>
                <td style="width: 8%;"></td>
                <td style="width: 31%;"></td>
                <td style="width: 9%;"></td>
                <td style="width: 7%;"></td>
                <td style="width: 9%;"></td>
                <td style="width: 10%;"></td>
                <td style="width: 9%;"></td>
            </tr>
        </table>
    </div>
    <div style="position: relative; float: left; top: 2em;">
        <div style="float: left;"><input type="button" id="quitar" value="Quitar" disabled /></div>
    </div>
    <div id="totales" style="float: right; position: relative; top: 2em;">
        <input type="hidden" id="subtotal" value="0" />
        <input type="hidden" id="totaldescuento" value="0" />
        <input type="hidden" id="total" value="0" />
        
        <div style="float: right; width: 5em; text-align: right; margin-left: 2em;"><h5><label id="lblsubtotal"></label></h5></div>
        <div style="float: right;"><h5>Subtotal:</h5></div>
        <div style="clear: both; float: right; width: 5em; text-align: right; margin-left: 2em;"><h5><label id="lbltotaldescuento"></label></h5></div>
        <div style="float: right;"><h5>Descuento:</h5></div>
        <div style="clear: both; float: right; width: 5em; text-align: right; margin-left: 2em;"><h4><label id="lbltotal"></label></h4></div>
        <div style="float: right;"><h4>Total:</h4></div>
    </div>
</div>

<script type="text/javascript">
    
//        Función para calcular totales cuando se hace un cambio en el listado.
    function calcula_totales(){
        var descuento = new Number(0);
        var total = new Number(0);
        var subtotal = new Number(0);
        var linea = new Number(1);

        $("#productos tr").each(function(fila){
            if(fila > 0){
                subtotal += Number($(this).attr("precio")) * Number($(this).attr("cantidad"));
                total += Number($(this).attr("preciodescuento")) * Number($(this).attr("cantidad"));
                descuento += (Number($(this).attr("precio")) - Number($(this).attr("preciodescuento"))) * Number($(this).attr("cantidad"));

                $(this).removeClass("fila-alterna");
                if(Number(fila) % 2 == 0)
                    $(this).addClass("fila-alterna");
                linea++;
            }
        });
        
        $('#listado').scrollTop($('#productos').height());
        
        $("#linea").val(linea);
        
        $('#precio_venta').val(Math.round((Number($('#precio').val()) / (1- Number($('#UTILIDAD').val()) / 100)).toFixed(2)));
        
        $("#subtotal").val(subtotal.toFixed(2));
        $("#lblsubtotal").text(Globalize.format(subtotal, 'n'));
        
        $("#total").val(total.toFixed(2));
        $("#lbltotal").text(Globalize.format(total, 'n'));

        $("#totaldescuento").val(descuento.toFixed(2));
        $("#lbltotaldescuento").text(Globalize.format(descuento, 'n'));
        
        $("#productos tr").each(function(fila){
            $(this).removeAttr("seleccionado");
        });
        
        localStorage.setItem("compras/facturas/registro/productos",$('#productos').html());
    }
    
    $(document).ready(function(){
        
        if(localStorage.getItem("compras/facturas/registro/productos"))
            $('#productos').html(localStorage.getItem("compras/facturas/registro/productos"));
        calcula_totales();
        
        $('#CONDITIONS').change(function(){
            if($(this).val() == 'CREDITO'){
                $('#DUEDATE').removeAttr('disabled');
                $('#DUEDATE').focus();
            }else{
                $('#DUEDATE').attr('disabled', 'disabled');
                $('#DUEDATE').val('');
            }
        });
        
        $('#precio').keyup(function(){
            $('#precio_venta').val(Math.round((Number($(this).val()) / (1 - Number($('#UTILIDAD').val()) / 100)).toFixed(2)));
        });
        
        $('#UTILIDAD').keyup(function(){
            $('#precio_venta').val((Number($('#precio').val()) / (1- Number($(this).val()) / 100)).toFixed(2));
        });
        
        $('#registro').submit(function(event){
            event.preventDefault();
            
            var total = new Number(0);
            var importe = new Number(0);
            var precio = new Number(0);
            var fila_seleccionada;

            precio = ($('#precio').val()-($('#precio').val()*($('#descuento').val()/100)));
            importe = precio * $('#cantidad').val();
            //total = Number($('#total').val())+importe;

            if($.isNumeric($('#cantidad').val()) && $.isNumeric($('#precio').val()) && $.isNumeric($('#descuento').val())){
                var linea = '<tr linea="'+$('#linea').val()+'" codigo="'+$('#codigo').val()+'" cantidad="'+$('#cantidad').val()+'" descripcion="'+$('#descripcion').val()+'" categoria="'+$('#categoria option:selected').val()+'" precio="'+$('#precio').val()+'" descuento="'+$('#descuento').val()+'" preciodescuento="'+precio+'" precioventa="'+$('#precio_venta').val()+'">'+
                                        '<td style="text-align: center;">'+$('#linea').val()+'</td>'+
                                        '<td tipo="cantidad" style="text-align: center;">'+$('#cantidad').val()+'</td>'+
                                        '<td tipo="codigo" style="text-align: center;">'+$('#codigo').val()+'</td>'+
                                        '<td>'+$('#categoria option:selected').text()+'</td>'+
                                        '<td>'+$('#descripcion').val()+'</td>'+
                                        '<td style="text-align: right;">'+Globalize.format($('#precio').val(),'n')+'</td>'+
                                        '<td style="text-align: right;">'+Globalize.format($('#descuento').val(),'n')+'%</td>'+
                                        '<td style="text-align: right;">'+Globalize.format(precio,'n')+'</td>'+
                                        '<td style="text-align: right;">'+Globalize.format(importe,'n')+'</td>'+
                                        '<td style="text-align: right;" class="ui-state-disabled">'+Globalize.format($('#precio_venta').val(),'n')+'</td>'+
                                        '</tr>';
                $("#productos tr").each(function(fila){
                    if($(this).attr("seleccionado") == "true")
                        fila_seleccionada = true;
                });
                if(fila_seleccionada){ // Si se está editando una linea
                    $('#productos tr[linea="'+$('#linea').val()+'"]').replaceWith(linea);
                }else{ // Agrega linea nueva
                    $('#productos').append(linea);
                }
                $('#cantidad').val('');
                $('#codigo').val('');
                $('#descripcion').val('');
                $('#precio').val('');
                $('#precio_venta').val('');
                $('#cantidad').focus();
                
                calcula_totales();
            }else{
                alert("Datos incorrectos!");
            }
        });
        
        // Cuando se pasa el mouse sobre el listado de artículos, se resalta la fila para indicar que se puede seleccionar.
        $("#productos").on("mouseover","tr",function(event){
            if($(this).attr("codigo").length > 0){
                $(this).css("cursor","pointer");
                $(this).addClass("ui-state-hover");
            }
        });
        $("#productos").on("mouseout","tr",function(event){
            if($(this).attr("seleccionado") != "true"){
                $(this).removeClass("ui-state-hover");
            }
        });

        // Cuando se da click en algún artículo del pedido se puede seleccionar para borrarlo.
        $("#productos").on("click","tr",function(event){
            var seleccionados = false;
            if($(this).attr("codigo").length > 0){
                if($(this).attr("seleccionado") != "true"){
                    $(this).attr("seleccionado",true);
                    // Llena los campos para editar la linea
                    $('#linea').val($(this).attr('linea'));
                    $('#categoria').val($(this).attr('categoria'));
                    $('#cantidad').val($(this).attr('cantidad'));
                    $('#codigo').val($(this).attr('codigo'));
                    $('#descripcion').val($(this).attr('descripcion'));
                    $('#precio').val($(this).attr('precio'));
                    $('#descuento').val($(this).attr('descuento'));
                    $('#precio_venta').val($(this).attr('precioventa'));
                }else{
                    //$('#linea').val('');
                    $('#categoria').val('');
                    $('#cantidad').val('');
                    $('#codigo').val('');
                    $('#descripcion').val('');
                    $('#precio').val('');
                    $('#descuento').val('');
                    $('#precio_venta').val('');
                    $(this).removeAttr("seleccionado");
                    calcula_totales();
                }
            }

            $("#productos tr").each(function(fila){
                if($(this).attr("seleccionado") == "true")
                    seleccionados = true;
            });
            if(seleccionados){
                $("#quitar").button("option", "disabled", false);
            }else{
                $("#quitar").button("option", "disabled", true);
            }
        });

//            Evento para quitar artículos de la lista.
        $("#quitar").click(function(){
            $(this).button("option", "disabled", true);
            $("#productos tr").each(function(fila){
                if($(this).attr("seleccionado") == "true"){
                    $(this).remove();
                }
            });
            calcula_totales();
            $("#cantidad").focus();
        });
        
        $("#nuevo").click(function(){
            var r = confirm('¿Deseas borrar la captura actual?');
            if(r == true){
                $('#linea').val('');
                localStorage.removeItem("compras/facturas/registro/productos");
                window.location.reload();
            }
        });
        
        $('#datos').submit(function(event){
            event.preventDefault();
            
            var r = confirm("¿Deseas guardar la compra?");
            if(r == true){
                var articulos = [];
                var i = new Number(0);

                $("#productos tr").each(function(){
                    if($(this).attr("codigo")){
                        articulos[i] = new Array(7);
                        articulos[i][0] = $(this).attr("cantidad");
                        articulos[i][1] = $(this).attr("codigo");
                        articulos[i][2] = $(this).attr("categoria");
                        articulos[i][3] = $(this).attr("descripcion");
                        articulos[i][4] = $(this).attr("precio");
                        articulos[i][5] = $(this).attr("descuento");
                        articulos[i][6] = $(this).attr("preciodescuento");
                        articulos[i][7] = $(this).attr("precioventa");
                        articulos[i][8] = $(this).attr("linea");
                        i++;
                    }
                });

                $.ajax({
                    url: "<?php echo site_url().'/compras/facturas/registro'; ?>",
                    type: 'post',
                    data: {DATENEW: $('#DATE').val()+" "+$('#TIME').val(), LOCATION: $('#LOCATION').val(), SUPPLIER: $('#SUPPLIER').val(), 
                            NUMBER: $('#NUMBER').val(), CONDITIONS: $('#CONDITIONS').val(), DUEDATE: $('#DUEDATE').val(), 
                            SUBTOTAL: $('#subtotal').val(), DISCOUNT: $('#totaldescuento').val(), TOTAL: $('#total').val(),
                            PRODUCTS: articulos},
                    dataType: 'text'
                }).done(function(respuesta){
                    //alert(clientes);
                    if(respuesta == 'OK'){
                        localStorage.removeItem("compras/facturas/registro/productos");
                        window.location.reload();
                    }
                }).fail(function(){
                        alert("Error al intentar guardar la compra");
                });
            }
        });
    });
</script>