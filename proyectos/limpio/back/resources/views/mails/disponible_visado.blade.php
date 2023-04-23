<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="time" content="{{microtime()}}">

    <title>Ministerio de Desarrollo Social</title>
</head>
<body>
<p>
    Estimado(a)<br>
    Asistente Técnico FOSIS
</p>
<p>
    El proyecto asociado a la convocatoria,
</p>
<p>
    <b>Año :</b> {{$anio}}<br>
    <b>Región :</b> {{$comunas->first()->getRegion()['nom_reg']}}<br>
    <b>Comuna(s) :</b> {{implode(", ",array_map(function ($comuna){return $comuna['nom_com'];},$comunas->toArray()))}}
</p>
<p>
    se encuentra disponible para ser VISADO.
</p>
<p>Este es un mensaje automático, por favor no lo responda.</p>
<p>Sistema de Habitabilidad</p>
</body>
</html>

