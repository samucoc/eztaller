<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Menue'), ['action' => 'add']) ?></li>
    </ul>
</div>
<div class="menues index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('menu_ncorr') ?></th>
            <th><?= $this->Paginator->sort('menu_desc') ?></th>
            <th><?= $this->Paginator->sort('tper_ncorr') ?></th>
            <th><?= $this->Paginator->sort('menu_orden') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($menues as $menue): ?>
        <tr>
            <td><?= $this->Number->format($menue->menu_ncorr) ?></td>
            <td><?= h($menue->menu_desc) ?></td>
            <td><?= $this->Number->format($menue->tper_ncorr) ?></td>
            <td><?= $this->Number->format($menue->menu_orden) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $menue->menu_ncorr]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $menue->menu_ncorr]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $menue->menu_ncorr], ['confirm' => __('Are you sure you want to delete # {0}?', $menue->menu_ncorr)]) ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
