<?php

return [
    [
        'label' => 'master.menu.master',
        'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-cube',
        'activeState' => [
            'master.mst_types',
            'master.mst_sizes',
            'master.mst_brands',
            'master.mst_motifs',
            'master.mst_colors',
            'master.mst_items',
            'master.mst_suppliers',
            'master.mst_customers',
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
];