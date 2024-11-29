<?php

return [
    [
        'label' => 'master.menu.types',
        'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-stream',
        'route' => routeTo('crud/index',['table' => 'mst_types']),
        'activeState' => 'default.mst_types'
    ],
    [
        'label' => 'master.menu.sizes',
        'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-compress-arrows-alt',
        'route' => routeTo('crud/index',['table' => 'mst_sizes']),
        'activeState' => 'default.mst_sizes'
    ],
    [
        'label' => 'master.menu.brands',
        'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-stamp',
        'route' => routeTo('crud/index',['table'=>'mst_brands']),
        'activeState' => 'default.mst_brands'
    ],
    [
        'label' => 'master.menu.motifs',
        'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-th-large',
        'route' => routeTo('crud/index',['table'=>'mst_motifs']),
        'activeState' => 'default.mst_motifs'
    ],
    [
        'label' => 'master.menu.colors',
        'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-fill-drip',
        'route' => routeTo('crud/index',['table'=>'mst_colors']),
        'activeState' => 'default.mst_colors'
    ],
    [
        'label' => 'master.menu.items',
        'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-box-open',
        'route' => routeTo('crud/index',['table'=>'mst_items']),
        'activeState' => 'default.mst_items'
    ],
    [
        'label' => 'master.menu.suppliers',
        'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-people-carry',
        'route' => routeTo('crud/index',['table'=>'mst_suppliers']),
        'activeState' => 'default.mst_suppliers'
    ],
    [
        'label' => 'master.menu.customers',
        'icon'  => 'fa-fw fa-lg me-2 fa-solid fa-users',
        'route' => routeTo('crud/index',['table'=>'mst_customers']),
        'activeState' => 'default.mst_customers'
    ],
];