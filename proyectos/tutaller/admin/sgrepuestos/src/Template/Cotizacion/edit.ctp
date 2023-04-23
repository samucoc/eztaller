<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $cotizacion->codigoCotizacion],
                ['confirm' => __('Are you sure you want to delete # {0}?', $cotizacion->codigoCotizacion)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Cotizacion'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="cotizacion form large-10 medium-9 columns">
    <?= $this->Form->create($cotizacion) ?>
    <fieldset>
        <legend><?= __('Edit Cotizacion') ?></legend>
        <?php
            echo $this->Form->input('codigoComprante');
            echo $this->Form->input('codigoEmpresa');
            echo $this->Form->input('fechaCotizacion');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
