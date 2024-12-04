<?php

unset($fields['receive_id']);
unset($fields['created_at']);
unset($fields['created_by']);
unset($fields['updated_at']);
unset($fields['updated_by']);

$fields['unit']['attr'] = [
    'readonly' => 'readonly'
];
$fields['item_id']['type'] = 'options-obj:mst_items,id,name|status,ACTIVE';
return $fields;