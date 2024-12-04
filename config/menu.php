<?php

return [
    [
        'label' => 'master.menu.variant',
        'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-stream',
        'activeState' => [
            'master.mst_types',
            'master.mst_sizes',
            'master.mst_brands',
            'master.mst_motifs',
            'master.mst_colors',
        ],
        'items' => [
            [
                'label' => 'master.menu.types',
                'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-stream',
                'route' => routeTo('crud/index',['table' => 'mst_types']),
                'activeState' => 'master.mst_types'
            ],
            [
                'label' => 'master.menu.sizes',
                'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-compress-arrows-alt',
                'route' => routeTo('crud/index',['table' => 'mst_sizes']),
                'activeState' => 'master.mst_sizes'
            ],
            [
                'label' => 'master.menu.brands',
                'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-stamp',
                'route' => routeTo('crud/index',['table'=>'mst_brands']),
                'activeState' => 'master.mst_brands'
            ],
            [
                'label' => 'master.menu.motifs',
                'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-th-large',
                'route' => routeTo('crud/index',['table'=>'mst_motifs']),
                'activeState' => 'master.mst_motifs'
            ],
            [
                'label' => 'master.menu.colors',
                'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-fill-drip',
                'route' => routeTo('crud/index',['table'=>'mst_colors']),
                'activeState' => 'master.mst_colors'
            ],
        ]
    ],
    [
        'label' => 'master.menu.master',
        'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-cube',
        'activeState' => [
            'master.mst_channels',
            'master.mst_items',
            'master.mst_suppliers',
            'master.mst_customers',
        ],
        'items' => [
            [
                'label' => 'master.menu.channels',
                'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-fill-drip',
                'route' => routeTo('crud/index',['table'=>'mst_channels']),
                'activeState' => 'master.mst_channels'
            ],
            [
                'label' => 'master.menu.items',
                'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-box-open',
                'route' => routeTo('crud/index',['table'=>'mst_items']),
                'activeState' => 'master.mst_items'
            ],
            [
                'label' => 'master.menu.suppliers',
                'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-people-carry',
                'route' => routeTo('crud/index',['table'=>'mst_suppliers']),
                'activeState' => 'master.mst_suppliers'
            ],
            [
                'label' => 'master.menu.customers',
                'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-users',
                'route' => routeTo('crud/index',['table'=>'mst_customers']),
                'activeState' => 'master.mst_customers'
            ],
        ]
    ],
    [
        'label' => 'master.menu.transactions',
        'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-exchange-alt',
        'activeState' => [
            'master.trn_receives',
            'master.trn_receive_items',
            'master.trn_outgoings',
            'master.trn_outgoing_items',
            'master.trn_adjusts',
        ],
        'items' => [
            [
                'label' => 'master.menu.receives',
                'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-fill-drip',
                'route' => routeTo('crud/index',['table'=>'trn_receives']),
                'activeState' => [
                    'master.trn_receives',
                    'master.trn_receive_items',
                ]
            ],
            [
                'label' => 'master.menu.outgoings',
                'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-box-open',
                'route' => routeTo('crud/index',['table'=>'trn_outgoings']),
                'activeState' => [
                    'master.trn_outgoings',
                    'master.trn_outgoing_items',
                ]
            ],
            [
                'label' => 'master.menu.adjusts',
                'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-box-open',
                'route' => routeTo('crud/index',['table'=>'trn_adjusts']),
                'activeState' => 'master.trn_adjusts'
            ],
        ]
    ],
    [
        'label' => 'master.menu.reports',
        'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-print',
        'activeState' => [
            'master.reports',
            'master.reports.receives',
            'master.reports.outgoings',
            'master.reports.adjusts',
            'master.reports.stock',
            'master.reports.stock-card',
            'master.reports.void',
            'master.reports.search',
        ],
        'items' => [
            [
                'label' => 'master.menu.receives',
                'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-fill-drip',
                'route' => routeTo('master/reports/receives'),
                'activeState' => 'master.reports.receives'
            ],
            [
                'label' => 'master.menu.outgoings',
                'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-box-open',
                'route' => routeTo('master/reports/outgoings'),
                'activeState' => 'master.reports.outgoings'
            ],
            [
                'label' => 'master.menu.adjusts',
                'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-box-open',
                'route' => routeTo('master/reports/adjusts'),
                'activeState' => 'master.reports.adjusts'
            ],
            [
                'label' => 'master.menu.stock',
                'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-box-open',
                'route' => routeTo('master/reports/stock'),
                'activeState' => 'master.reports.stock'
            ],
            [
                'label' => 'master.menu.stock_card',
                'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-box-open',
                'route' => routeTo('master/reports/stock-card'),
                'activeState' => 'master.reports.stock-card'
            ],
            [
                'label' => 'master.menu.void',
                'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-box-open',
                'route' => routeTo('master/reports/void'),
                'activeState' => 'master.reports.void'
            ],
            [
                'label' => 'master.menu.search',
                'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-box-open',
                'route' => routeTo('master/reports/search'),
                'activeState' => 'master.reports.search'
            ],
        ]
    ],
];