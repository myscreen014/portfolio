<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Administration configurations
    |--------------------------------------------------------------------------
    |
    */

    'components' => [
        'pages' => [
            'routes'        =>  [
                'index'     => 'admin.pages.index'
            ],
            'icon'          => 'fa-file'
        ],
        'galleries'         => [
            'routes'        =>  [
                'index'     => 'admin.galleries.index',
                'children'  => [
                    'galleries'             => 'admin.galleries.index',
                    'galleriescategories'    => 'admin.galleries.categories.index',
                ]
            ],
            'icon' => 'fa-picture-o'
        ],
        'administrators'    => [
            'routes'        =>  [
                'index'     => 'admin.administrators.index'
            ],
            'icon' => 'fa-users'
        ]
    ]
]
?>