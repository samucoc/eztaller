    $("#save_line").click(function(){
        var str_codigo = $("#codigo").val();
        var str_desc = $("#descripcion").val();
        var str_cant = $("#cantidad").val();

        var arr_fila = $("#arr_fila").val();
        var arr_codigo = $("#arr_codigo").val();
        var arr_desc = $("#arr_descripcion").val();
        var arr_cant = $("#arr_cantidad").val();

        var tmp = Math.round(Math.random()*100);

        var str = '<div id="fila_'+tmp+'"><div class="col-md-2 col-sm-2 col-xs-2">'+str_codigo+'</div><div class="col-md-6 col-sm-6 col-xs-6">'+str_desc+'</div><div class="col-md-2 col-sm-2 col-xs-2">'+str_cant+'</div><div class="col-md-2 col-sm-2 col-xs-2"><button id="delete_line" type="button" onclick="elimina('+tmp+')" class="btn btn-danger">+</button></div><div class="clearfix"></div></div>'
        $("#resultados").append(str)

        var arr_fila = arr_fila+','+tmp;
        var arr_codigo = arr_codigo+','+str_codigo;
        var arr_desc = arr_desc+','+str_desc;
        var arr_cant = arr_cant+','+str_cant;

        $("#arr_fila").val(arr_fila);
        $("#arr_codigo").val(arr_codigo);
        $("#arr_descripcion").val(arr_desc);
        $("#arr_cantidad").val(arr_cant);

        $("#codigo").val('');
        $("#descripcion").val('');
        $("#cantidad").val('');

    });
    function elimina(id){
        $("#fila_"+id).remove();

        var filas = $("#arr_fila").val();
        var codigos = $("#arr_codigo").val();
        var descrs = $("#arr_descripcion").val();
        var cantidad = $("#arr_cantidad").val();

        var arr_fila = filas.split(',');
        var indice = arr_fila.indexOf(id); 
        arr_fila.splice(indice, 1);
        var str_fila = arr_fila.join();

        var arr_codigo = codigos.split(',');
        arr_codigo.splice(indice, 1);
        var str_codigo = arr_codigo.join();

        var arr_desc = descrs.split(',');
        arr_desc.splice(indice, 1);
        var str_desc = arr_desc.join();

        var arr_cant = cantidad.split(',');
        arr_cant.splice(indice, 1);
        var str_cant = arr_cant.join();


        $("#arr_fila").val(str_fila);
        $("#arr_codigo").val(str_codigo);
        $("#arr_descripcion").val(str_desc);
        $("#arr_cantidad").val(str_cant);
    }

        $('#fecha').daterangepicker({
                                        singleDatePicker: true,
                                        showDropdowns: true,
                                        minYear: 1901,
                                        maxYear: parseInt(moment().format('YYYY'),10),
                                        locale: {
                                            format: 'DD-MM-YYYY'
                                            }
                                      });