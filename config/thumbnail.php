<?php

/* 
	Use "Intervention Image"
	http://image.intervention.io/
*/

/* 
	Exemple 
	'name-thumbnails' => [
		'filters' => [
			'fit' 	=>  [80,80],
			'max' 	=>  [180,168],
			'brightness' => [35],
			'greyscale' => [],
			'blur' => [5], // CAREFUL IT'S VERY LONG...
			'gamma' => [0.4],
			'pixelate' => [12],
			'watermark'	=> ['img/watermark.png', 'bottom-right', 10, 10]
		],
		'quality' => 100
	],
*/


return [

   
	'path'      => public_path().'/files',

	'quality'   => 80,

	'thumbnails' => [

		/* Admin */
		'wysiwyg' => [
			'filters' => [
				'max' 	=>  [1920,1080],
			],
			'quality' => 100
		],
		'filebrowser' => [
			'filters' => [
				'fit' 	=>  [80,80]
			],
			'quality' => 100
		],
		'edit' => [
			'filters' => [
				'max' 	=>  [180,168]
			]
		],
		'show' => [
			'filters' => [
				'max' 	=>  [600,400]
			]
		],

		/* Site */
		'background' => [
			'filters' => [
				'max' 	=>  [1920,1080],
			],
			'quality' => 80
		],
		'zoom' => [
			'filters' => [
				'max' 	=>  [1920,1080],
				'watermark'	=> ['img/watermark.png', 'center']
			],
			'quality' => 100
		],
		'portfolio' => [
			'filters' => [
				'max' 	=>  [400,600],
			]
		],
		'site' => [
			'filters' => [
				'max' 	=>  [60,40],
				'greyscale' => []
			]
		]
	],  


];
