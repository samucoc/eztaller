<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Menues Hijo'), ['action' => 'edit', $menuesHijo->mhij_ncorr]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Menues Hijo'), ['action' => 'delete', $menuesHijo->mhij_ncorr], ['confirm' => __('Are you sure you want to delete # {0}?', $menuesHijo->mhij_ncorr)]) ?> </li>
        <li><?= $this->Html->link(__('List Menues Hijos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Menues Hijo'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="menuesHijos view large-10 medium-9 columns">
    <h2><?= h($menuesHijo->mhij_ncorr) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Mhij Desc') ?></h6>
            <p><?= h($menuesHijo->mhij_desc) ?></p>
            <h6 class="subheader"><?= __('Mhij Link') ?></h6>
            <p><?= h($menuesHijo->mhij_link) ?></p>
            <h6 class="subheader"><?= __('Mhij Mostrar') ?></h6>
            <p><?= h($menuesHijo->mhij_mostrar) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Mhij Ncorr') ?></h6>
            <p><?= $this->Number->format($menuesHijo->mhij_ncorr) ?></p>
            <h6 class="subheader"><?= __('Menu Ncorr') ?></h6>
            <p><?= $this->Number->format($menuesHijo->menu_ncorr) ?></p>
            <h6 class="subheader"><?= __('Menu Sub') ?></h6>
            <p><?= $this->Number->format($menuesHijo->menu_sub) ?></p>
            <h6 class="subheader"><?= __('Mhij Perfil') ?></h6>
            <p><?= $this->Number->format($menuesHijo->mhij_perfil) ?></p>
            <h6 class="subheader"><?= __('Mhij Orden') ?></h6>
            <p><?= $this->Number->format($menuesHijo->mhij_orden) ?></p>
        </div>
    </div>
</div>
