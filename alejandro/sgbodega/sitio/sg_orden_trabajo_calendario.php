<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8' />
	<script src="https://cdn.jsdelivr.net/combine/npm/fullcalendar@5.3.2,npm/fullcalendar@5.3.2/locales-all.js,npm/fullcalendar@5.3.2/locales-all.min.js,npm/fullcalendar@5.3.2/main.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/combine/npm/fullcalendar@5.3.2/main.css,npm/fullcalendar@5.3.2/main.min.css">
    <script>

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          firstDay : '1',
          locale: 'es',
          events: [
    				<?php 
    					include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
   						global $conexion;

						$sql = "select movim_fecha_ingreso, movim_fecha_egreso, movim_obs from orden_trabajo where movim_estado = 'FINALIZADO'" ;
						$res = mysql_query($sql,$conexion) or die(mysql_error($conexion));
						while($row = mysql_fetch_array($res)){


    				?>
    				{
				      title  : '<?php echo $row["movim_obs"]; ?>',
				      start  : '<?php echo $row["movim_fecha_ingreso"]; ?>',
				      end    : '<?php echo $row["movim_fecha_egreso"]; ?>',
				    },
				    <?php }?>
				  ]
        });
        calendar.render();
      });

    </script>
  </head>
  <body>
    <div id='calendar'></div>
  </body>
</html>

