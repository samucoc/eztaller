<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Menues'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="menues form large-10 medium-9 columns">
    <?= $this->Form->create($menue) ?>
    <fieldset>
        <legend><?= __('Add Menue') ?></legend>
        <?php
            echo $this->Form->input('menu_desc');
            echo $this->Form->input('tper_ncorr');
            echo $this->Form->input('menu_orden');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
