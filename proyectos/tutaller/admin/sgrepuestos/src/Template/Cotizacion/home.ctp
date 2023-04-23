<div class="actions columns large-2 medium-3">
	<h3><?= __('Opciones') ?></h3>
	<ul class="side-nav">
		<li><?= $this->Html->link(__('Listado de Cotizaciones'), ['action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('Filtrado de Cotizaciones'), ['controller'=>'DetalleCotizacion' ,'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('Busqueda de Cotizaciones'), ['action' => 'busqueda']) ?></li>
		<li><?= $this->Html->link(__('Nueva Cotizacion'), ['action' => 'add']) ?></li>

	</ul>
</div>
<div class="articulos index large-10 medium-9 columns">
	<img src="http://192.168.1.102/backup/sgrepuestos/webroot/img/yonley.jpg" style="padding-top: 5%">
</div>
