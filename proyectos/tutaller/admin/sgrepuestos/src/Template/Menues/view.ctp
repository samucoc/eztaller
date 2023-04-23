<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Menue'), ['action' => 'edit', $menue->menu_ncorr]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Menue'), ['action' => 'delete', $menue->menu_ncorr], ['confirm' => __('Are you sure you want to delete # {0}?', $menue->menu_ncorr)]) ?> </li>
        <li><?= $this->Html->link(__('List Menues'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Menue'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="menues view large-10 medium-9 columns">
    <h2><?= h($menue->menu_ncorr) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Menu Desc') ?></h6>
            <p><?= h($menue->menu_desc) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Menu Ncorr') ?></h6>
            <p><?= $this->Number->format($menue->menu_ncorr) ?></p>
            <h6 class="subheader"><?= __('Tper Ncorr') ?></h6>
            <p><?= $this->Number->format($menue->tper_ncorr) ?></p>
            <h6 class="subheader"><?= __('Menu Orden') ?></h6>
            <p><?= $this->Number->format($menue->menu_orden) ?></p>
        </div>
    </div>
</div>
