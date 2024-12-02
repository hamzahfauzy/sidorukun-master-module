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
    'mst_channels' => [
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
            'attr'  => [
                'class' => 'form-control select2-search__field'
            ]
        ],
        'address_2' => [
            'label' => 'Alamat 2',
            'type'  => 'textarea',
            'attr'  => [
                'class' => 'form-control select2-search__field'
            ]
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
            'attr'  => [
                'class' => 'form-control select2-search__field'
            ]
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
            'attr'  => [
                'class' => 'form-control select2-search__field'
            ]
        ],
        'address_2' => [
            'label' => 'Alamat 2',
            'type'  => 'textarea',
            'attr'  => [
                'class' => 'form-control select2-search__field'
            ]
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
            'attr'  => [
                'class' => 'form-control select2-search__field'
            ]
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
    'trn_receives' => [
        'code' => [
            'label' => 'No. Terima',
            'type' => 'text'
        ],
        'receive_date' => [
            'label' => 'Tgl. Terima',
            'type' => 'date',
        ],
        'supplier_name' => [
            'label' => 'Supplier',
            'type' => 'text'
        ],
        'total_items' => [
            'label' => 'Total Item',
            'type' => 'number'
        ],
        'total_qty' => [
            'label' => 'Qty',
            'type' => 'number'
        ],
        'status' => [
            'label' => 'Status',
            'type' => 'options:NEW|APPROVE|CANCEL'
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
    'trn_receive_items' => [
        'receive_id' => [
            'label' => 'No. Terima',
            'type' => 'options-obj:trn_receives,id,code'
        ],
        'item_id' => [
            'label' => 'Nama Barang',
            'type' => 'options-obj:mst_items,id,name'
        ],
        'qty' => [
            'label' => 'QTY',
            'type' => 'number',
        ],
        'unit' => [
            'label' => 'Satuan',
            'type' => 'text'
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
    'trn_outgoings' => [
        'code' => [
            'label' => 'No. Keluar',
            'type' => 'text'
        ],
        'outgoing_date' => [
            'label' => 'Tgl. Keluar',
            'type' => 'date',
        ],
        'customer_name' => [
            'label' => 'Kustomer',
            'type' => 'text'
        ],
        'channel_name' => [
            'label' => 'Channel',
            'type' => 'text'
        ],
        'order_code' => [
            'label' => 'No Pesanan',
            'type' => 'text'
        ],
        'receipt_code' => [
            'label' => 'No Resi',
            'type' => 'text'
        ],
        'outgoing_type' => [
            'label' => 'Jenis',
            'type' => 'options:CARGO|INSTANT|HEMAT|REG'
        ],
        'total_items' => [
            'label' => 'Total Item',
            'type' => 'number'
        ],
        'total_qty' => [
            'label' => 'Qty',
            'type' => 'number'
        ],
        'status' => [
            'label' => 'Status',
            'type' => 'options:NEW|APPROVE|CANCEL'
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
    'trn_outgoing_items' => [
        'item_id' => [
            'label' => 'Nama Barang',
            'type' => 'options-obj:mst_items,id,name'
        ],
        'qty' => [
            'label' => 'QTY',
            'type' => 'number',
        ],
        'unit' => [
            'label' => 'Satuan',
            'type' => 'text'
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
    'trn_adjusts' => [
        'code' => [
            'label' => 'No. Penyesuaian',
            'type' => 'text'
        ],
        'adjust_date' => [
            'label' => 'Tgl. Penyesuaian',
            'type' => 'date',
        ],
        'item_id' => [
            'label' => 'Nama Barang',
            'type' => 'options-obj:mst_items,id,name'
        ],
        'qty' => [
            'label' => 'Qty',
            'type' => 'number'
        ],
        'unit' => [
            'label' => 'Satuan',
            'type' => 'text'
        ],
        'description' => [
            'label' => 'Deskripsi',
            'type' => 'textarea'
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
    ]
];