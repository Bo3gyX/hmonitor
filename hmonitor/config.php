<?php

$config = array(

    'layout' => array(
        'name' => 'main',
    ),

    'pages' => array(

        'index' => array(
            'go' => 'host/add'
        ),

        'host/add' => array(
            'blocks' => array(
                array(
                    'controller' => 'Host',
                    'method' => 'add',
                    'view' => 'host_add',
                    'place' => 'center'
                ),

                array(
                    'controller' => 'Host',
                    'method' => 'show',
                    'view' => 'host_show',
                    'place' => 'center'
                ),

                array(
                    'controller' => 'Host',
                    'method' => 'search',
                    'view' => 'host_search',
                    'place' => 'center'
                ),
            )
        ),

        '404' => array(
            'blocks' => array(
                array(
                    'controller' => 'Errors',
                    'method' => 'show',
                    'view' => 'errors',
                    'place' => 'center',
                    'params' => [404],
                ),
            )
        ),

    )
);
