<div class="actions columns large-2 medium-3">
    <h3><?= __('Opciones') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Cerrar Sesion'), ['action' => 'logout']) ?></li>
    </ul>
</div>
<div class="usuarios form large-10 medium-9 columns">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Cambiar Contraseña') ?></legend>
        <?php
        echo $this->Form->input('usu_pass',['type'=>'password','label'=>'Ingrese la contraseña Actual']);
        echo $this->Form->input('nuevaPass',['type'=>'password','label'=>'Ingrese la nueva contraseña']);
        
        ?>
    </fieldset>
    <?= $this->Form->button(__('Aceptar')) ?>
    <?= $this->Form->end() ?>
</div>
