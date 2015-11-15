<?php

/* 
	Use "Intervention Image"
	http://image.intervention.io/
*/


return [

   
	'path'      => public_path().'/files',

	'quality'   => 80,

	'thumbnails' => [

		'filebrowser' => [
			'filters' => [
				'fit' =>  [80,80]
			],
			'quality' => 100
		],

		'small'       => [
			'filters' => [
				'fit' =>  [40,40]
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
