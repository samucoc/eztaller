<?php

session_set_cookie_params('18000'); // 5 HORAS
session_start();

include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

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
		<form id="Form1" name="Form1" method="post" runat="server" action='sg_comprobante_recibo_dinero.php'>
			<table>
				<tr>
					<td colspan="2" style="text-align: left" class="titulo">Recibo Dinero Apoderado de Postulante</td>
				</tr>
				<tr>
					<td style="text-align: left" class="titulo">Apoderado</td>
					<td style="text-align: left">
						<?php 
							global $conexion;
							$sql = "select 	NumeroRutApoderado,
											concat(PaternoApoderado,' ',MaternoApoderado,', ',NombresApoderado)  as alumno
									from Apoderados 
									where NumeroRutApoderado in (select ApoderadoPostulante 
																from Postulantes 
																where NumeroRutAlumno = '".$_GET['rut_alumno']."')";
							$res = mysql_query($sql,$conexion);
							$row = mysql_fetch_array($res);

							$rut_apo = $row['NumeroRutApoderado'];
							$alumno = $rut_apo!='0' ? $row['alumno'] : 'No existe apoderado';
							echo $alumno;

						?>
					</td>
				</tr>
				<tr>
					<td style="text-align: left" class="titulo">Alumno</td>
					<td style="text-align: left">
						<?php 
							global $conexion;
							$sql = "select concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno)  as alumno
									from Postulantes where NumeroRutAlumno = '".$_GET['rut_alumno']."'";
							$res = mysql_query($sql,$conexion);
							$row = mysql_fetch_array($res);

							echo $alumno = $row['alumno'];
						?>
						<input type="hidden" name="rut_alumno" id="rut_alumno" value="<?php echo $_GET['rut_alumno']?>">
					</td>
				</tr>
				<tr>
					<td style="text-align: left" class="titulo">Periodo</td>
					<td style="text-align: left">
						<input type="text" name="periodo" id="periodo" value="<?php echo $_GET['periodo']?>" readonly="readonly">
					</td>
				</tr>
				<?php 
					$sql_ve = "select  
									ValorIncorporacion, ValorColegiatura
								from Aranceles
								where CodigoNivel in (select CodigoNivel
														from Cursos
														where CodigoCurso in (
																				select CodigoCurso
																				from Postulantes
																				where NumeroRutAlumno = '".$_GET['rut_alumno']."'  and 
																					AnioPeriodo = '".$_GET['periodo']."'
																			)
													)
									";
					$res_ve = mysql_query($sql_ve,$conexion) or die(mysql_error());
					$total_col = 0;
					$total_colegiatura =0;
					$line_ve = mysql_fetch_array($res_ve);
					$incorporacion = $line_ve['ValorIncorporacion'];
					$colegiatura = $line_ve['ValorColegiatura'];
				?>
				<tr>
					<td style="text-align: left" class="titulo">Cuota Inicial</td>
					<td style="text-align: left">
						<input type="text" name="incorporacion" id="incorporacion" value="<?php echo $incorporacion?>"></td>
				</tr>
			</table>
			<input type="submit" name="btnGuardar" id="btnGuardar" value="Imprimir">
		</form>
	</body>
</HTML>