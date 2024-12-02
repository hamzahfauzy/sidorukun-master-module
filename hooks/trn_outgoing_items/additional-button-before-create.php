<?php ob_start(); ?>

<a href="<?= routeTo('crud/index', ['table'=>'trn_outgoings']) ?>" class="btn btn-warning btn-sm">
    <i class="fa-solid fa-arrow-left"></i> <?= __('crud.label.back') ?>
</a>
<?php

return ob_get_clean();