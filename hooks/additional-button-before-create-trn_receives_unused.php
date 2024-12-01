<?php ob_start(); ?>

<a href="<?= routeTo('master/transactions/receives/create') ?>" class="btn btn-success btn-sm">
    <i class="fa-solid fa-plus"></i> <?= __('crud.label.create') ?>
</a>
<?php

return ob_get_clean();