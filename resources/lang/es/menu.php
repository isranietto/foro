<?php

return [

    'main' => [
        'list' => [
            'title' => 'Ver posts',
            'route' => 'post.index',
        ],
        'create' => [
            'title' => 'Crear post',
            'route' => 'post.create',
        ],
    ],

    'filters' => [
        'all' => [
            'title' => 'Posts',
            'route' => 'post.index',
        ],
        'pending' => [
            'title' => 'Posts pendientes',
            'route' => 'post.pending',
        ],
        'completed' => [
            'title' => 'Posts completados',
            'route' => 'post.completed',
        ],
        'mine' => [
            'title' => 'Mis posts',
            'route' => 'post.mine',
            'logged' => true
         ],
    ],

];