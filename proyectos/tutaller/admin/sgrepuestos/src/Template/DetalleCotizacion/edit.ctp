<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $detalleCotizacion->codigoDetalle],
                ['confirm' => __('Are you sure you want to delete # {0}?', $detalleCotizacion->codigoDetalle)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Detalle Cotizacion'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="detalleCotizacion form large-10 medium-9 columns">
    <?= $this->Form->create($detalleCotizacion) ?>
    <fieldset>
        <legend><?= __('Edit Detalle Cotizacion') ?></legend>
        <?php
            echo $this->Form->input('codigoCotizacion');
            echo $this->Form->input('codigoSubfamilia');
            echo $this->Form->input('Cantidad');
            echo $this->Form->input('valorUnitario');
            echo $this->Form->input('IVA');
            echo $this->Form->input('valorNeto');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
