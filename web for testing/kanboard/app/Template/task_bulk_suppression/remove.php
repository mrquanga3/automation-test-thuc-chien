<div class="page-header">
    <h2><?= t('Remove selected tasks') ?></h2>
</div>

<div class="confirm">
    <p class="alert alert-info">
        <?= t('Do you really want to remove these tasks?') ?>
    </p>

    <?= $this->modal->confirmButtons(
        'TaskBulkSuppressionController',
        'remove',
        array('project_id' => $project['id'], 'task_ids' => $task_ids)
    ) ?>
</div>
