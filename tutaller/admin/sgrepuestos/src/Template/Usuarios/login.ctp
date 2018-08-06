<?= $this->Html->css('base.css') ?>
<?= $this->Html->css('cake.css') ?>
<?= $this->Html->meta('icon') ?>
<title>Sistema de Repuestos</title>
<h2 style="text-indent: 15%; color: white; background-color:#447CAD;">Sistema de Repuestos</h2>
<img src="/sgbodegainsumos/webroot/img/yonley.jpg" style="margin-left: 35%;max-width: 25%;">
<div class="usuarios form" style="width: 50%; margin-left: 25%;">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Ingrese su nombre de usuario y contraseña') ?></legend>
        <?= $this->Form->input('usu_login',['label'=>'Nombre de Usuario']) ?>
        <?= $this->Form->input('usu_pass',['type'=>'password' , 'label'=>'Contraseña']) ?>

        <?= $this->Form->button(__('Ingresar'),['style'=>'float: left; width: 25%; padding: 0px; margin: 0px;']); ?>
    </fieldset>
    <?= $this->Form->end() ?>
</div>