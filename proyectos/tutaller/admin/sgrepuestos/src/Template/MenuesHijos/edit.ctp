<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $menuesHijo->mhij_ncorr],
                ['confirm' => __('Are you sure you want to delete # {0}?', $menuesHijo->mhij_ncorr)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Menues Hijos'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="menuesHijos form large-10 medium-9 columns">
    <?= $this->Form->create($menuesHijo) ?>
    <fieldset>
        <legend><?= __('Edit Menues Hijo') ?></legend>
        <?php
            echo $this->Form->input('menu_ncorr');
            echo $this->Form->input('menu_sub');
            echo $this->Form->input('mhij_desc');
            echo $this->Form->input('mhij_link');
            echo $this->Form->input('mhij_perfil');
            echo $this->Form->input('mhij_orden');
            echo $this->Form->input('mhij_mostrar');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
