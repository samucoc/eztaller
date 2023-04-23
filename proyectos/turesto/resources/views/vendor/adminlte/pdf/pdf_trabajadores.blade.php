<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Trabajadores Yonley</title>
    
</head>
<body>
<div class="container">
    <h1>Y<strong>onley</strong></h1>
    <a class="btn btn-primary" href="{{ route('htmltopdfview',['download'=>'pdf']) }}" title="Imprimir listado"> Descargar PDF</a>
    <div class="row">
        <div class="table-bordered">
            <table class="" border="1">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                       
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trabajadores as $trabajador)
                        <tr>
                            <th>{{$trabajador->nombres}}</th>
                            <th>{{$trabajador->apellido_pat.''. $trabajador->apellido_mat}}</th>
                            
                                @if ($trabajador->estado == 1)
                                <th>Activo</th>
                                @else
                                <th>Inactivo</th>
                                @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>    
</div>

</body>
</html>
