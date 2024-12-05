<?php

unset($fields['total_items']);
unset($fields['status']);
unset($fields['total_qty']);
unset($fields['customer_name']);
unset($fields['channel_name']);
unset($fields['created_at']);
unset($fields['created_by']);
unset($fields['updated_at']);
unset($fields['updated_by']);

$fields['customer_id'] = [
    'label' => 'customer',
    'type' => 'options-obj:mst_customers,id,name|status,ACTIVE'
];

$fields['channel_id'] = [
    'label' => 'channel',
    'type' => 'options-obj:mst_channels,id,name'
];

$fields['description'] = [
    'label' => 'Deskripsi',
    'type' => 'textarea',
    'attr' => [
        'class' => 'form-control select2-search__field'
    ]
];

$fields['code']['attr']['readonly'] = 'readonly';

return $fields;