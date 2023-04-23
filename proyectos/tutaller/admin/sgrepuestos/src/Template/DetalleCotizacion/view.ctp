<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Detalle Cotizacion'), ['action' => 'edit', $detalleCotizacion->codigoDetalle]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Detalle Cotizacion'), ['action' => 'delete', $detalleCotizacion->codigoDetalle], ['confirm' => __('Are you sure you want to delete # {0}?', $detalleCotizacion->codigoDetalle)]) ?> </li>
        <li><?= $this->Html->link(__('List Detalle Cotizacion'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Detalle Cotizacion'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="detalleCotizacion view large-10 medium-9 columns">
    <h2><?= h($detalleCotizacion->codigoDetalle) ?></h2>
    <div class="row">
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('CodigoDetalle') ?></h6>
            <p><?= $this->Number->format($detalleCotizacion->codigoDetalle) ?></p>
            <h6 class="subheader"><?= __('CodigoCotizacion') ?></h6>
            <p><?= $this->Number->format($detalleCotizacion->codigoCotizacion) ?></p>
            <h6 class="subheader"><?= __('CodigoSubfamilia') ?></h6>
            <p><?= $this->Number->format($detalleCotizacion->codigoSubfamilia) ?></p>
            <h6 class="subheader"><?= __('Cantidad') ?></h6>
            <p><?= $this->Number->format($detalleCotizacion->Cantidad) ?></p>
            <h6 class="subheader"><?= __('ValorUnitario') ?></h6>
            <p><?= $this->Number->format($detalleCotizacion->valorUnitario) ?></p>
            <h6 class="subheader"><?= __('IVA') ?></h6>
            <p><?= $this->Number->format($detalleCotizacion->IVA) ?></p>
            <h6 class="subheader"><?= __('ValorNeto') ?></h6>
            <p><?= $this->Number->format($detalleCotizacion->valorNeto) ?></p>
        </div>
    </div>
</div>
