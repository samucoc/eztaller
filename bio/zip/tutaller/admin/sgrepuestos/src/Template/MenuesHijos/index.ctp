<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Menues Hijo'), ['action' => 'add']) ?></li>
    </ul>
</div>
<div class="menuesHijos index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('mhij_ncorr') ?></th>
            <th><?= $this->Paginator->sort('menu_ncorr') ?></th>
            <th><?= $this->Paginator->sort('menu_sub') ?></th>
            <th><?= $this->Paginator->sort('mhij_desc') ?></th>
            <th><?= $this->Paginator->sort('mhij_link') ?></th>
            <th><?= $this->Paginator->sort('mhij_perfil') ?></th>
            <th><?= $this->Paginator->sort('mhij_orden') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($menuesHijos as $menuesHijo): ?>
        <tr>
            <td><?= $this->Number->format($menuesHijo->mhij_ncorr) ?></td>
            <td><?= $this->Number->format($menuesHijo->menu_ncorr) ?></td>
            <td><?= $this->Number->format($menuesHijo->menu_sub) ?></td>
            <td><?= h($menuesHijo->mhij_desc) ?></td>
            <td><?= h($menuesHijo->mhij_link) ?></td>
            <td><?= $this->Number->format($menuesHijo->mhij_perfil) ?></td>
            <td><?= $this->Number->format($menuesHijo->mhij_orden) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $menuesHijo->mhij_ncorr]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $menuesHijo->mhij_ncorr]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $menuesHijo->mhij_ncorr], ['confirm' => __('Are you sure you want to delete # {0}?', $menuesHijo->mhij_ncorr)]) ?>
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
