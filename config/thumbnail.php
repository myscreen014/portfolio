<?php

/* 
	Use "Intervention Image"
	http://image.intervention.io/
*/


return [

   
	'path'      => public_path().'/files',

	'quality'   => 80,

	'thumbnails' => [

		/* Admin */
		'filebrowser' => [
			'filters' => [
				'fit' =>  [80,80]
			],
			'quality' => 100
		],
		'edit' => [
			'filters' => [
				'max' =>  [180,168]
			]
		],
		'show' => [
			'filters' => [
				'max' =>  [600,400]
			]
		],

		/* Site */
		'site' => [
			'filters' => [
				'max' =>  [60,40],
				'greyscale' => []
			]
		]
	],  


];
