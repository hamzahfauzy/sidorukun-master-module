<?php 

return [
    'mst_types' => [
        'name' => [
            'label' => 'Nama',
            'type'  => 'text',
        ],
        'created_at' => [
            'label' => 'Dibuat Pada',
            'type'  => 'text',
        ],
        'created_by' => [
            'label' => 'Dibuat Oleh',
            'type'  => 'options-obj:users,id,name',
        ],
        'updated_at' => [
            'label' => 'Diubah Pada',
            'type'  => 'text',
        ],
        'updated_by' => [
            'label' => 'Diubah Oleh',
            'type'  => 'options-obj:users,id,name',
        ],
    ],
    'mst_sizes' => [
        'name' => [
            'label' => 'Nama',
            'type'  => 'text',
        ],
        'created_at' => [
            'label' => 'Dibuat Pada',
            'type'  => 'text',
        ],
        'created_by' => [
            'label' => 'Dibuat Oleh',
            'type'  => 'options-obj:users,id,name',
        ],
        'updated_at' => [
            'label' => 'Diubah Pada',
            'type'  => 'text',
        ],
        'updated_by' => [
            'label' => 'Diubah Oleh',
            'type'  => 'options-obj:users,id,name',
        ],
    ],
    
    'mst_brands' => [
        'name' => [
            'label' => 'Nama',
            'type'  => 'text',
        ],
        'created_at' => [
            'label' => 'Dibuat Pada',
            'type'  => 'text',
        ],
        'created_by' => [
            'label' => 'Dibuat Oleh',
            'type'  => 'options-obj:users,id,name',
        ],
        'updated_at' => [
            'label' => 'Diubah Pada',
            'type'  => 'text',
        ],
        'updated_by' => [
            'label' => 'Diubah Oleh',
            'type'  => 'options-obj:users,id,name',
        ],
    ],
    'mst_motifs' => [
        'name' => [
            'label' => 'Nama',
            'type'  => 'text',
        ],
        'created_at' => [
            'label' => 'Dibuat Pada',
            'type'  => 'text',
        ],
        'created_by' => [
            'label' => 'Dibuat Oleh',
            'type'  => 'options-obj:users,id,name',
        ],
        'updated_at' => [
            'label' => 'Diubah Pada',
            'type'  => 'text',
        ],
        'updated_by' => [
            'label' => 'Diubah Oleh',
            'type'  => 'options-obj:users,id,name',
        ],
    ],
    'mst_colors' => [
        'name' => [
            'label' => 'Nama',
            'type'  => 'text',
        ],
        'created_at' => [
            'label' => 'Dibuat Pada',
            'type'  => 'text',
        ],
        'created_by' => [
            'label' => 'Dibuat Oleh',
            'type'  => 'options-obj:users,id,name',
        ],
        'updated_at' => [
            'label' => 'Diubah Pada',
            'type'  => 'text',
        ],
        'updated_by' => [
            'label' => 'Diubah Oleh',
            'type'  => 'options-obj:users,id,name',
        ],
    ],
    'mst_suppliers' => [
        'name' => [
            'label' => 'Nama',
            'type'  => 'text',
        ],
        'address' => [
            'label' => 'Alamat',
            'type'  => 'textarea',
        ],
        'address_2' => [
            'label' => 'Alamat 2',
            'type'  => 'textarea',
        ],
        'city' => [
            'label' => 'Kota',
            'type'  => 'text',
        ],
        'phone' => [
            'label' => 'No. HP',
            'type'  => 'text',
        ],
        'description' => [
            'label' => 'Keterangan',
            'type'  => 'textarea',
        ],
        'status' => [
            'label' => 'Status',
            'type'  => 'options:ACTIVE|INACTIVE',
        ],
        'created_at' => [
            'label' => 'Dibuat Pada',
            'type'  => 'text',
        ],
        'created_by' => [
            'label' => 'Dibuat Oleh',
            'type'  => 'options-obj:users,id,name',
        ],
        'updated_at' => [
            'label' => 'Diubah Pada',
            'type'  => 'text',
        ],
        'updated_by' => [
            'label' => 'Diubah Oleh',
            'type'  => 'options-obj:users,id,name',
        ],
    ],
    'mst_customers' => [
        'name' => [
            'label' => 'Nama',
            'type'  => 'text',
        ],
        'address' => [
            'label' => 'Alamat',
            'type'  => 'textarea',
        ],
        'address_2' => [
            'label' => 'Alamat 2',
            'type'  => 'textarea',
        ],
        'city' => [
            'label' => 'Kota',
            'type'  => 'text',
        ],
        'phone' => [
            'label' => 'No. HP',
            'type'  => 'text',
        ],
        'description' => [
            'label' => 'Keterangan',
            'type'  => 'textarea',
        ],
        'status' => [
            'label' => 'Status',
            'type'  => 'options:ACTIVE|INACTIVE',
        ],
        'created_at' => [
            'label' => 'Dibuat Pada',
            'type'  => 'text',
        ],
        'created_by' => [
            'label' => 'Dibuat Oleh',
            'type'  => 'options-obj:users,id,name',
        ],
        'updated_at' => [
            'label' => 'Diubah Pada',
            'type'  => 'text',
        ],
        'updated_by' => [
            'label' => 'Diubah Oleh',
            'type'  => 'options-obj:users,id,name',
        ],
    ],
    'mst_items' => [
        'type_id' => [
            'label' => 'Tipe',
            'type'  => 'options-obj:mst_types,id,name',
        ],
        'size_id' => [
            'label' => 'Ukuran',
            'type'  => 'options-obj:mst_sizes,id,name',
        ],
        'brand_id' => [
            'label' => 'Merk',
            'type'  => 'options-obj:mst_brands,id,name',
        ],
        'motif_id' => [
            'label' => 'Motif',
            'type'  => 'options-obj:mst_motifs,id,name',
        ],
        'color_id' => [
            'label' => 'Warna',
            'type'  => 'options-obj:mst_colors,id,name',
        ],
        'name' => [
            'label' => 'Nama',
            'type'  => 'text',
        ],
        'unit' => [
            'label' => 'Satuan',
            'type'  => 'text',
        ],
        'status' => [
            'label' => 'Status',
            'type'  => 'options:ACTIVE|INACTIVE',
        ],
        'created_at' => [
            'label' => 'Dibuat Pada',
            'type'  => 'text',
        ],
        'created_by' => [
            'label' => 'Dibuat Oleh',
            'type'  => 'options-obj:users,id,name',
        ],
        'updated_at' => [
            'label' => 'Diubah Pada',
            'type'  => 'text',
        ],
        'updated_by' => [
            'label' => 'Diubah Oleh',
            'type'  => 'options-obj:users,id,name',
        ],
    ],
];