<?php



session_set_cookie_params('18000'); // 5 HORAS

session_start();



include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

include "../includes/php/validaciones.php"; 



if (!isset($_SESSION['alycar_usuario'])){

	?>

	<script>top.location.href='sg_index.php'</script>

	<?php

}





?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML>

	<HEAD>

		<title>Sistema Gesti�n 2.0</title>

		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

		<meta charset='utf-8' />	

		<style type="text/css">

			.titulo{

					background: #F2F2F2;

				    margin-bottom: 5px;

				    padding: 5px 20px;

				    color: #1B4978;

				    font-size: 11px;

				    font-weight: bold;

				}

			a:link {

			    text-decoration: none;

			}



			a:visited {

			    text-decoration: none;

			}



			a:hover {

			    text-decoration: underline;

			}



			a:active {

			    text-decoration: underline;

			}

		</style>

	</HEAD>

	<body bgcolor="#ffffff">

		<form id="Form1" name="Form1" method="post" runat="server" action='sg_alumnos_imprimir_contrato.php'>

			<table>

				<tr>

					<td colspan="2" style="text-align: left" class="titulo">CONFIRMACION DATOS APODERADO FINANCIERO</td>

				</tr>

				<?php 

					$anio_vigente = $_SESSION['sige_anio_escolar_vigente'];

					$sql_apoderado = "select concat(NombresApoderado,' ', PaternoApoderado,' ',MaternoApoderado) as nombre,

												NumeroRutApoderado, EMailApoderado, TelefonoParticularApoderado,

												DireccionParticularApoderado, Ciudad

									from gescolcl_arcoiris_administracion.Apoderados

										inner join gescolcl_arcoiris_administracion.Ciudades 

											on Apoderados.CiudadParticularApoderado = Ciudades.CodigoCiudad

									where NumeroRutApoderado in (select NumeroRutApoderado

																	from gescolcl_arcoiris_administracion.alumnos".$anio_vigente."

																	where NumeroRutAlumno = '".$_GET['rut_alumno']."')";

					$res_apoderado = mysql_query($sql_apoderado,$conexion) or die(mysql_error());

					$row_apoderado = mysql_fetch_array($res_apoderado);

					

					$rut_apoderado = $row_apoderado['NumeroRutApoderado'].'-'.dv($row_apoderado['NumeroRutApoderado']);

					$nombre_apoderado = $row_apoderado['nombre'];

					$direccion_apoderado = $row_apoderado['DireccionParticularApoderado'];

					$ciudad_apoderado = $row_apoderado['Ciudad'];

				?>

				<tr>

					<td style="text-align: left" class="titulo">RUT</td>

					<td style="text-align: left">

						<input type="text" name="rut_apoderado" id="rut_apoderado" value="<?php echo $rut_apoderado?>">

						<input type="hidden" name="rut_alumno" id="rut_alumno" value="<?php echo $_GET['rut_alumno']?>" size="50" width="50">

					</td>

				</tr>

				<tr>

					<td style="text-align: left" class="titulo">Nombre Completo</td>

					<td style="text-align: left">

						<input type="text" name="nombre_apo" id="nombre_apo" value="<?php echo $nombre_apoderado?>" size="50" width="50">

					</td>

				</tr>

				<tr>

					<td style="text-align: left" class="titulo">Direccion</td>

					<td style="text-align: left">

						<input type="text" name="direccion_apo" id="direccion_apo" value="<?php echo $direccion_apoderado?>" size="50" width="50">

					</td>

				</tr>

				<tr>

					<td style="text-align: left" class="titulo">Ciudad</td>

					<td style="text-align: left">

						<input type="text" name="ciudad_apo" id="ciudad_apo" value="<?php echo $ciudad_apoderado?>" size="50" width="50">

					</td>

				</tr>

<!-- 				<tr>

					<td style="text-align: left" class="titulo">Fecha de Inicio de Contrato</td>

					<td style="text-align: left">

						<select name="mes_ini" id="mes_ini">

							<option value="1">Enero</option>

							<option value="2">Febrero</option>

							<option value="3">Marzo</option>

							<option value="4">Abril</option>

							<option value="5">Mayo</option>

							<option value="6">Junio</option>

							<option value="7">Julio</option>

							<option value="8">Agosto</option>

							<option value="9">Septiembre</option>

							<option value="10">Octubre</option>

							<option value="11">Noviembre</option>

							<option value="12">Diciembre</option>

						</select>

					</td>

				</tr>

				<tr>

					<td style="text-align: left" class="titulo">Cantidad de Cuotas</td>

					<td style="text-align: left">

						<input type="text" name="cant_cuotas" id="cant_cuotas" value="" size="50" width="50">

					</td>

				</tr>

 -->				

			</table>

			<input type="submit" name="btnGuardar" id="btnGuardar" value="Imprimir">

		</form>

	</body>

</HTML>