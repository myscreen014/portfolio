<?php

/* 
	Use "Intervention Image"
	http://image.intervention.io/
*/


return [

   
   	'path'      => '/thumbnails',

    'quality'   => 80,

    'thumbnails' => [

        'filebrowser' => [
            'filters' => [
                'fit' =>  [80,80]
            ],
            'quality' => 40
        ],

        'modal' => [
            'filters' => [
                'max' =>  [600,400]
            ]
        ]
    ],  


];
