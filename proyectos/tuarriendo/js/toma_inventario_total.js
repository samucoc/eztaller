    $("#save_line").click(function(){
        var codigo = $("#codigo").val();
        $.ajax({
            type: "GET",
            url: "action/toma_inventario_total.php?codigo="+codigo,
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
