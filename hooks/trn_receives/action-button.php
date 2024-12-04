<?php ob_start(); ?>

<a href="<?= routeTo('crud/index',['table'=>'trn_receive_items','filter'=>['receive_id' => $data->id]]) ?>" class="btn btn-success btn-sm">
    <i class="fa-solid fa-eye"></i> Detail
</a>

<?php if($data->status == 'NEW'): ?>
    <?php if(is_allowed('master/transactions/receives/approve', auth()->id)): ?>
<a href="<?= routeTo('master/transactions/receives/approve', ['id' => $data->id]) ?>" class="btn btn-primary btn-sm" onclick="if(confirm('Apakah anda yakin approve data ini ?')){return true}else{return false}">
    <i class="fa-solid fa-check"></i> Approve
</a>
<?php endif ?>
<?php if(is_allowed('master/transactions/receives/cancel', auth()->id)): ?>
<a href="<?= routeTo('master/transactions/receives/cancel', ['id' => $data->id]) ?>" class="btn btn-danger btn-sm" onclick="if(confirm('Apakah anda yakin cancel data ini ?')){return true}else{return false}">
    <i class="fa-solid fa-time"></i> Cancel
</a>
<?php endif ?>
<?php endif ?>
<?php

return ob_get_clean();