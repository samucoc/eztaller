{{-- copie y pegue el siguiente codigo en cada una de sus paginas

		favor solo modifique la seccion de htmlheader_title en el apartado trans
		y la session main-content.
--}}

{{-- aqui le decimos a la pagina que sera una extension de la pagina app.blade.php --}}
@extends('adminlte::layouts.app') 
@section('mi-css')
<style type="text/css">
	[contenteditable="true"]{
		border: 1px dotted transparent;
		background: #fff7c3;
	}
</style>
@endsection
{{-- aqui escribimos el texto que tendra nuestra pagina --}}
@section('htmlheader_title')
	Trabajadores
@endsection

@section('contentheader_title')

@endsection

@section('contentheader_description')
<a class="btn btn-info" href="{{ URL('fichas/fichaglobal') }}"><i class="fa fa-angle-left" aria-hidden="true"></i> back</a>
@endsection
{{-- aqui escribiremos todo el codigo para cada pagina,
	 la cual se mostrara en el @yield('main-content')
	 de la pagina app.blade.php
--}}
@section('main-content')
	<div class="container-fluid spark-screen" >
		<h2>Edición de <small> Trabajadores</small></h2>
		<div class="row">
			@if ($errors->any())
				<div class="alert alert-danger alert-dismissible" role="alert">
				 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<p>Corriga lo siguiente: </p>
				<ul>
					@foreach($errors->all() as $error)
						<li>{{$error}}</li>
					@endforeach
				</ul>
				</div>
			@endif

			@if (Session::get('notice') !='')
			<div class="alert alert-info" role="alert"><p> <strong> {{ Session::get('notice') }} </strong> </p></div>
			@endif
		</div>
		<div class="table-responsive">
		@foreach ($trabajador as $banco)
			<form action="{{url('fichas/fichaglobal/crear')}}" method="POST" role="form"  data-toggle="validator" id="form-trabajador">
						<div class="col-lg-12">
							<h5 class="modal-title">Ficha Personal</h5>
							<div class="form-group">
								<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
								<input type="hidden" name="trabajador_id" value="{{$banco->trabajador_id}}" />
								<input type="hidden" name="tl_ncorr" value="{{$banco->ttl->tl_ncorr}}" />
								<input type="hidden" name="tp_ncorr" value="{{$banco->ttp->tp_ncorr}}" />
								<label for="trabajador_nombres"><i class="fa fa-id-card-o" aria-hidden="true"></i> Nombre</label>
								<input type="text" class="form-control" name="trabajador_nombres" placeholder="{{$banco->trabajador_nombres}}" value="{{$banco->trabajador_nombres}}" required>
							</div>
							<div class="form-group">
								
								<label for="trabajador_ap"><i class="fa fa-id-card-o" aria-hidden="true"></i> Apellido Paterno</label>
								<input type="text" class="form-control" name="trabajador_ap" placeholder="{{$banco->trabajador_ap}}" value="{{$banco->trabajador_ap}}" required>
							</div>
							<div class="form-group">
								
								<label for="trabajador_am"><i class="fa fa-id-card-o" aria-hidden="true"></i> Apellido Materno</label>
								<input type="text" class="form-control" name="trabajador_am" placeholder="{{$banco->trabajador_am}}" value="{{$banco->trabajador_am}}" required>
							</div>
							<div class="form-group">
								
								<label for="trabajador_rut"><i class="fa fa-id-card-o" aria-hidden="true"></i> Rut Trabajador</label>
								<input type="text" class="form-control" name="trabajador_rut" placeholder="{{$banco->trabajador_rut}}" value="{{$banco->trabajador_rut}}" required>
							</div>
							<div class="form-group">
								
								<label for="trabajador_sexo"><i class="fa fa-id-card-o" aria-hidden="true"></i> Sexo</label>
								<select class="form-control" name="trabajador_sexo" >
								@foreach ($sexo as $tp)
								  	<option value="{{$tp->sexo_ncorr}}" @if($banco->sexo_ncorr == $tp->sexo_ncorr)  selected="selected" @endif >{{$tp->nombre}}</option>
								@endforeach
								</select>
							</div>
							<div class="form-group">
								
								<label for="trabajador_direccion"><i class="fa fa-id-card-o" aria-hidden="true"></i> Dirección</label>
								<input type="text" class="form-control" name="trabajador_direccion" placeholder="{{$banco->trabajador_direccion}}" value="{{$banco->trabajador_direccion}}">
							</div>
							<div class="form-group">
								
								<label for="trabajador_celular"><i class="fa fa-id-card-o" aria-hidden="true"></i> Celular</label>
								<input type="number" class="form-control" name="trabajador_celular" placeholder="{{$banco->trabajador_celular}}" value="{{$banco->trabajador_celular}}">
							</div>
							<div class="form-group">
								
								<label for="trabajador_fecha_nace"><i class="fa fa-id-card-o" aria-hidden="true"></i> Fecha Nacimiento</label>
								<input type="text" class="form-control" name="trabajador_fecha_nace" id="trabajador_fecha_nace" placeholder="{{$banco->trabajador_fecha_nace}}" value="{{$banco->trabajador_fecha_nace}}" required>
							</div>
							<div class="form-group">
								<label for="comuna_id"><i class="fa fa-id-card-o" aria-hidden="true"></i> Comuna</label>
								<select class="form-control" name="comuna_id">
									@foreach ($comuna as $tp)
								  		<option value="{{$tp->comuna_id}}" @if($banco->comuna_id == $tp->comuna_id)  selected="selected" @endif >{{$tp->comuna_nombre}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label for="tp_id"><i class="fa fa-id-card-o" aria-hidden="true"></i> Tipo Perfil</label>
								<select class="form-control" name="tp_id">
									@foreach ($tipo_perfil as $tp)
								  		<option value="{{$tp->tp_id}}" @if($banco->tp_id == $tp->tp_id)  selected="selected" @endif >{{$tp->tp_descripcion}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-lg-12">
							<h5 class="modal-title">Ficha Laboral</h5>
							<div class="form-group">
								<label for="ttl_cargo"><i class="fa fa-id-card-o" aria-hidden="true"></i> Cargo</label>
								<input type="text" class="form-control" name="ttl_cargo" placeholder="{{$banco->ttl->cargo}}" value="{{$banco->ttl->cargo}}">
							</div>
							<div class="form-group">
								<label for="ttl_area"><i class="fa fa-id-card-o" aria-hidden="true"></i> Área</label>
								<select class="form-control" name="ttl_area">
									@foreach ($area as $tp)
								  		<option value="{{$tp->area_ncorr}}" @if($banco->ttl->area == $tp->area_ncorr)  selected="selected" @endif >{{$tp->nombre}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label for="ttl_empresa"><i class="fa fa-id-card-o" aria-hidden="true"></i> Empresa</label>
								<select class="form-control" name="ttl_empresa">
									@foreach ($empresa as $tp)
								  		<option value="{{$tp->empresa_id}}" @if($banco->ttl->empresa == $tp->empresa_id)  selected="selected" @endif >{{$tp->empresa_nombre}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label for="ttl_fecha_ingreso"><i class="fa fa-id-card-o" aria-hidden="true"></i> Fecha Ingreso</label>
								<input type="text" class="form-control" name="ttl_fecha_ingreso" id="ttl_fecha_ingreso" placeholder="{{$banco->ttl->fecha_ingreso}}" value="{{$banco->ttl->fecha_ingreso}}">
							</div>
							<div class="form-group">
								
								<label for="ttl_fecha_contrato"><i class="fa fa-id-card-o" aria-hidden="true"></i> Fecha Contrato</label>
								<input type="text" class="form-control" name="ttl_fecha_contrato"  id="ttl_fecha_contrato" placeholder="{{$banco->ttl->fecha_contrato}}" value="{{$banco->ttl->fecha_contrato}}">
							</div>
							<div class="form-group">
								
								<label for="ttl_cant_vacaciones_prog"><i class="fa fa-id-card-o" aria-hidden="true"></i> Cantidad días vacaciones progresivas</label>
								<input type="text" class="form-control" name="ttl_cant_vacaciones_prog" placeholder="{{$banco->ttl->cant_vacaciones_prog}}" value="{{$banco->ttl->cant_vacaciones_prog}}">
							</div>
							<div class="form-group">
								
								<label for="ttl_fecha_finiquito"><i class="fa fa-id-card-o" aria-hidden="true"></i> Fecha Finiquito</label>
								<input type="text" class="form-control" name="ttl_fecha_finiquito" id="ttl_fecha_finiquito" placeholder="{{$banco->ttl->fecha_finiquito}}" value="{{$banco->ttl->fecha_finiquito}}">
							</div>
							<div class="form-group">
								
								<label for="ttl_causa_finiquito"><i class="fa fa-id-card-o" aria-hidden="true"></i> Causa Finiquito</label>
								<input type="text" class="form-control" name="ttl_causa_finiquito" placeholder="{{$banco->ttl->causa_finiquito}}" value="{{$banco->ttl->causa_finiquito}}">
							</div>
							<div class="form-group">
								
								<label for="ttl_estado_empleado"><i class="fa fa-id-card-o" aria-hidden="true"></i> Estado Empleado</label>
								<select class="form-control" name="ttl_estado_empleado">
									@foreach ($estado_empleado as $tp)
								  		<option value="{{$tp->ee_ncorr}}" @if($banco->ttl->estado_empleado == $tp->ee_ncorr)  selected="selected" @endif >{{$tp->nombre}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								
								<label for="ttl_nro_cuenta"><i class="fa fa-id-card-o" aria-hidden="true"></i> Nro Cuenta</label>
								<input type="text" class="form-control" name="ttl_nro_cuenta" placeholder="{{$banco->ttl->nro_cuenta}}" value="{{$banco->ttl->nro_cuenta}}">
							</div>
							<div class="form-group">
								
								<label for="ttl_tipo_cuenta"><i class="fa fa-id-card-o" aria-hidden="true"></i> Tipo Cuenta</label>
								<select class="form-control" name="ttl_tipo_cuenta">
									@foreach ($tipo_cuenta as $tp)
								  		<option value="{{$tp->tc_ncorr}}" @if($banco->ttl->tipo_cuenta == $tp->tc_ncorr)  selected="selected" @endif >{{$tp->nombre}}</option>
									@endforeach
								</select>							
							</div>
							<div class="form-group">
								
								<label for="ttl_banco"><i class="fa fa-id-card-o" aria-hidden="true"></i> Banco</label>
								<select class="form-control" name="ttl_banco">
									@foreach ($banco as $tp)
								  		<option value="{{$tp->banco_id}}" @if($banco->ttl->banco == $tp->banco_id)  selected="selected" @endif >{{$tp->banco_descripcion}}</option>
									@endforeach
								</select>							
							</div>
							<div class="form-group">
								
								<label for="ttl_asignacion_materiales"><i class="fa fa-id-card-o" aria-hidden="true"></i> Asignación Materiales</label>
								<input type="text" class="form-control" name="ttl_asignacion_materiales" placeholder="{{$banco->ttl->asignacion_materiales}}" value="{{$banco->ttl->asignacion_materiales}}">
							</div>
							<div class="checkbox">
							  	<label><input type="checkbox" value="on" name="ttl_celular" placeholder=""
							  			 @if($banco->celular == 'on')  checked="checked" @endif 
							  		 ><i class="fa fa-id-card-o" aria-hidden="true"></i> Celular</label>
							</div>
							<div class="checkbox">
							  	<label><input type="checkbox" value="on" name="ttl_auto" placeholder=""
							  			 @if($banco->ttl->auto == 'on')  checked="checked" @endif 
							  		  ><i class="fa fa-id-card-o" aria-hidden="true"></i> Auto</label>
							</div>
							<div class="checkbox">
							  	<label><input type="checkbox" value="on" name="ttl_moto" placeholder=""
							  			 @if($banco->ttl->moto == 'on')  checked="checked" @endif 
							  		  ><i class="fa fa-id-card-o" aria-hidden="true"></i> Moto</label>
							</div>
							<div class="checkbox">
							  	<label><input type="checkbox" value="on" name="ttl_asig_caja" placeholder=""
							  			 @if($banco->ttl->asig_caja == 'on')  checked="checked" @endif 
							  		   ><i class="fa fa-id-card-o" aria-hidden="true"></i> Asignación Caja</label>
							</div>
							<div class="form-group">
								<label for="ttl_monto_asig_caja"><i class="fa fa-id-card-o" aria-hidden="true"></i> Monto Asignación Caja</label>
								<input type="text" class="form-control" name="ttl_monto_asig_caja" placeholder="{{$banco->ttl->monto_asig_caja}}" value="{{$banco->ttl->monto_asig_caja}}">
							</div>
							<div class="form-group">
								<label for="ttl_monto_asig_locomocion"><i class="fa fa-id-card-o" aria-hidden="true"></i> Monto Asignación Locomoción</label>
								<input type="text" class="form-control" name="ttl_monto_asig_locomocion" placeholder="{{$banco->ttl->monto_asig_locomocion}}" value="{{$banco->ttl->monto_asig_locomocion}}">
							</div>
							<div class="form-group">
								<label for="ttl_monto_asig_fxr"><i class="fa fa-id-card-o" aria-hidden="true"></i> Monto Asignación FxR</label>
								<input type="text" class="form-control" name="ttl_monto_asig_fxr" placeholder="{{$banco->ttl->monto_asig_fxr}}" value="{{$banco->ttl->monto_asig_fxr}}">
							</div>
							<div class="form-group">
								<label for="ttl_anticipo"><i class="fa fa-id-card-o" aria-hidden="true"></i> Anticipo</label>
								<input type="text" class="form-control" name="ttl_anticipo" placeholder="{{$banco->ttl->anticipo}}" value="{{$banco->ttl->anticipo}}">
							</div>
							<div class="form-group">
								<label for="ttl_gratificacion"><i class="fa fa-id-card-o" aria-hidden="true"></i> Gratificación</label>
								<input type="text" class="form-control" name="ttl_gratificacion" placeholder="{{$banco->ttl->gratificacion}}" value="{{$banco->ttl->gratificacion}}">
							</div>
							<div class="checkbox">
							  	<label><input type="checkbox" value="on" name="ttl_indefinido" placeholder="" 
							  			 @if($banco->ttl->indefinido == 'on')  checked="checked" @endif 
							  		   ><i class="fa fa-id-card-o" aria-hidden="true"></i> Indefinido</label>
							</div>
							<div class="checkbox">
							  	<label><input type="checkbox" value="on" name="ttl_mayor_once" placeholder="" 
							  			 @if($banco->ttl->mayor_once == 'on')  checked="checked" @endif 
							  		   ><i class="fa fa-id-card-o" aria-hidden="true"></i> Mayor Once</label>
							</div>
						</div>
						<div class="col-lg-12">
							<h5 class="modal-title">Ficha Previsional</h5>
							<div class="form-group">
								<label for="ttp_afp"><i class="fa fa-id-card-o" aria-hidden="true"></i> Afp</label>
								<input type="text" class="form-control" name="nombre_afp" id="nombre_afp" placeholder="{{$banco->trabajador_direccion}}" value="{{$banco->trabajador_direccion}}">
								<input type="hidden" class="form-control" name="ttp_afp"  id="ttp_afp" placeholder="{{$banco->ttp->afp}}" value="{{$banco->ttp->afp}}">
								<input type="hidden" class="form-control" name="ttp_porc_cotizacion"  id="ttp_porc_cotizacion" placeholder="{{$banco->ttp->porc_cotizacion}}" value="{{$banco->ttp->porc_cotizacion}}">
							</div>
							<div class="form-group">
								<label for="ttp_ips"><i class="fa fa-id-card-o" aria-hidden="true"></i> Ips</label>
								<input type="text" class="form-control" name="nombre_ips"  id="nombre_ips" placeholder="{{$banco->trabajador_direccion}}" value="{{$banco->trabajador_direccion}}">
								<input type="hidden" class="form-control" name="ttp_ips" id="ttp_ips" placeholder="{{$banco->ttp->ips}}" value="{{$banco->ttp->ips}}">
								<input type="hidden" class="form-control" name="ttp_porc_cotizacion_ips" id="ttp_porc_cotizacion_ips" placeholder="{{$banco->ttp->porc_cotizacion_ips}}" value="{{$banco->ttp->porc_cotizacion_ips}}">
							</div>
							<div class="form-group">
								<label for="ttp_porc_adicional"><i class="fa fa-id-card-o" aria-hidden="true"></i> Porcentaje Adicional</label>
								<input type="text" class="form-control" name="ttp_porc_adicional" placeholder="{{$banco->trabajador_direccion}}" value="{{$banco->trabajador_direccion}}">
							</div>
							<div class="form-group">
								<label for="ttp_monto_cotizacion"><i class="fa fa-id-card-o" aria-hidden="true"></i> Monto Cotizacion</label>
								<input type="text" class="form-control" name="ttp_monto_cotizacion" placeholder="{{$banco->ttp->porc_adicional}}" value="{{$banco->ttp->porc_adicional}}">
							</div>
							<div class="form-group">
								
								<label for="ttp_tipo_monto_cotizacion"><i class="fa fa-id-card-o" aria-hidden="true"></i> Tipo Monto Cotizacion</label>
								<input type="text" class="form-control" name="ttp_tipo_monto_cotizacion" placeholder="{{$banco->ttp->tipo_monto_cotizacion}}" value="{{$banco->ttp->tipo_monto_cotizacion}}">
							</div>
							<div class="form-group">
								
								<label for="ttp_salud"><i class="fa fa-id-card-o" aria-hidden="true"></i> Salud</label>
								<select class="form-control" name="ttp_salud">
									@foreach ($salud as $tp)
								  		<option value="{{$tp->salud_ncorr}}" @if($banco->ttp->salud == $tp->salud_ncorr)  selected="selected" @endif >{{$tp->nombre}}</option>
									@endforeach
								</select>	
							</div>
							<div class="form-group">
								
								<label for="ttp_ahorro_vol"><i class="fa fa-id-card-o" aria-hidden="true"></i> Ahorro Voluntario</label>
								<input type="text" class="form-control" name="ttp_ahorro_vol" placeholder="{{$banco->ttp->ahorro_vol}}" value="{{$banco->ttp->ahorro_vol}}">
							</div>
							<div class="form-group">
								
								<label for="ttp_ints_ahorro_vol"><i class="fa fa-id-card-o" aria-hidden="true"></i> Instirución Ahorro Voluntario</label>
								<select class="form-control" name="ttp_ints_ahorro_vol">
									<option value="0">Seleccione..</option>
									@foreach ($ints_ahorro_vol as $tp)
								  		<option value="{{$tp->inst_apv_ncorr}}" @if($banco->ttp->ints_ahorro_vol == $tp->inst_apv_ncorr)  selected="selected" @endif >{{$tp->nombre}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label for="ttp_fecha_ahorro_vol"><i class="fa fa-id-card-o" aria-hidden="true"></i> Fecha Ahorro Voluntario</label>
								<input type="text" class="form-control" name="ttp_fecha_ahorro_vol" placeholder="{{$banco->ttp->fecha_ahorro_vol}}" value="{{$banco->ttp->fecha_ahorro_vol}}">
							</div>
							<div class="form-group">
								<label for="ttp_ahorro_full_caja"><i class="fa fa-id-card-o" aria-hidden="true"></i> Ahorro Full Caja</label>
								<input type="text" class="form-control" name="ttp_ahorro_full_caja" placeholder="{{$banco->ttp->ahorro_full_caja}}" value="{{$banco->ttp->ahorro_full_caja}}">
							</div>
							<div class="form-group">
								<label for="ttp_plan_uf"><i class="fa fa-id-card-o" aria-hidden="true"></i> Plan UF</label>
								<input type="text" class="form-control" name="ttp_plan_uf" placeholder="{{$banco->ttp->plan_uf}}" value="{{$banco->ttp->plan_uf}}">
							</div>
							<div class="form-group">
								<label for="ttp_plan_pesos"><i class="fa fa-id-card-o" aria-hidden="true"></i> Plan Pesos</label>
								<input type="text" class="form-control" name="ttp_plan_pesos" placeholder="{{$banco->ttp->plan_pesos}}" value="{{$banco->ttp->plan_pesos}}">
							</div>
							<div class="form-group">
								<label for="ttp_seguro_cesantia"><i class="fa fa-id-card-o" aria-hidden="true"></i> Seguro Cesantía</label>
								<input type="text" class="form-control" name="ttp_seguro_cesantia" placeholder="{{$banco->ttp->seguro_cesantia}}" value="{{$banco->ttp->seguro_cesantia}}">
							</div>
							<div class="form-group">
								<label for="ttp_sueldo_base"><i class="fa fa-id-card-o" aria-hidden="true"></i> Sueldo Base</label>
								<input type="text" class="form-control" name="ttp_sueldo_base" placeholder="{{$banco->ttp->sueldo_base}}" value="{{$banco->ttp->sueldo_base}}">
							</div>
							<div class="form-group">
								<label for="ttp_sueldo_base_1"><i class="fa fa-id-card-o" aria-hidden="true"></i> Sueldo Base 2</label>
								<input type="text" class="form-control" name="ttp_sueldo_base_1" placeholder="{{$banco->ttp->sueldo_base_1}}" value="{{$banco->ttp->sueldo_base_1}}">
							</div>
							<div class="form-group">
								<label for="ttp_tramo"><i class="fa fa-id-card-o" aria-hidden="true"></i> Tramo</label>
								<select class="form-control" name="ttp_tramo">
									<option value="{{$banco->ttp->tramo}}">Tramo {{$banco->ttp->tramo}}</option>
									<option value="A">Tramo A</option>
									<option value="B">Tramo B</option>
									<option value="C">Tramo C</option>
									<option value="D">Tramo D</option>
								</select>
							</div>
						</div>
					<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
					</form>
			@endforeach
		</div>
	</div>

@endsection

@section('mi-script')
<script type="text/javascript">

$(document).ready(function() {

	$('#form-trabajador').validator();

	$("#nombre_afp").autocomplete({
            source: '{{url ("buscar_afp")}}',
            select: function(event, ui) {
                $('#ttp_afp').val(ui.item.id);
                $('#ttp_porc_cotizacion').val(ui.item.porc_cot);
                }
        });  
    $("#nombre_ips").autocomplete({
            source: '{{url ("buscar_ips")}}',
            select: function(event, ui) {
                $('#ttp_ips').val(ui.item.id);
                $('#ttp_porc_cotizacion_ips').val(ui.item.porc_cot);
                }
        });        
    $( "#nombre_afp, #nombre_ips" ).autocomplete( "option", "appendTo", "#agregar-fichaglobal" );      
    
	$.datepicker.regional['es'] = {
         closeText: 'Cerrar',
         prevText: '< Ant',
         nextText: 'Sig >',
         currentText: 'Hoy',
         monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
         monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
         dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
         dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
         dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
         weekHeader: 'Sm',
         dateFormat: 'dd/mm/yy',
         firstDay: 1,
         isRTL: false,
         showMonthAfterYear: false,
         yearSuffix: ''
         };
    $.datepicker.setDefaults($.datepicker.regional['es']);    
    $('#trabajador_fecha_nace, #ttl_fecha_ingreso, #ttl_fecha_contrato, #ttl_fecha_finiquito, #ttp_fecha_ahorro_vol').datepicker({
        dateFormat:"dd/mm/yy"
    });

	function dv(rut) {
			// type check
			if (!rut || !rut.length || typeof rut !== 'string') {
				return -1;
			}
			// serie numerica
			var secuencia = [2,3,4,5,6,7,2,3];
			var sum = 0;
			//
			for (var i=rut.length - 1; i >=0; i--) {
				var d = rut.charAt(i)
				sum += new Number(d)*secuencia[rut.length - (i + 1)];
			};
			// sum mod 11
			var rest = 11 - (sum % 11);
			// si es 11, retorna 0, sino si es 10 retorna K,
			// en caso contrario retorna el numero
			return rest === 11 ? 0 : rest === 10 ? "K" : rest;
		}


	
});
</script>
@endsection
