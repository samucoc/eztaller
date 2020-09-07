    $("#save_line").click(function(){
        var fecha1 = $("#fecha1").val();
        var fecha2 = $("#fecha2").val();
        var codigo = $("#codigo").val();
        $.ajax({
            type: "GET",
            url: "action/detalle_toma_inventario.php?fecha1="+fecha1+"&fecha2="+fecha2+"&codigo="+codigo,
        }).done(function(e){
            $("#resultados").html(e);
        });

    });
    
    function buscarDescripcion(){
        var codigo = $("#codigo").val();
        $.ajax({
            type: "GET",
            url: "action/find_descripcion.php?codigo="+codigo,
        }).done(function(e){
            $("#descripcion").val(e);
            $("#save_data").focus();
        });
    }


    $('#fecha1, #fecha2').daterangepicker({
                                    singleDatePicker: true,
                                    showDropdowns: true,
                                    minYear: 1901,
                                    maxYear: parseInt(moment().format('YYYY'),10),
                                    locale: {
                                        format: 'DD-MM-YYYY'
                                        }
                                  });