<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Site Language Lines
	|--------------------------------------------------------------------------
	|
	|
	*/

	'global' => [
		'name' 					=> "Aline Photo",
		'copyright'				=> "Copyright © :year :name",
		'action' => [
            'back'              =>  'Retour',
            'close'             =>  'Fermer',
            'edit'              =>  'Éditer',
            'show'              =>  'Afficher',
            'save'              =>  'Enregistrer',
            'delete'            =>  'Supprimer',
        ],
        'title' => [
        	'404' => '404 : Page non trouvée'
        ],
        'message' => [
        	'404' => "Cette page n'éxiste pas !",
        	'503' => "Site en maintenance"
        ]
	],

	'galleries' => [
		'message' => [
        	'nocontent'         => "Aucune galerie actuellement dans cette catégorie."
        ]
	],

	'lightbox' => [
		'action' => [
			'close' 			=> 'Fermer',
			'next' 				=> 'Suivant',
			'prev' 				=> 'Précédent',
		]
	],

	'users' => [
		'message' => [
			'need_confirmation' 	=> "Votre inscription à bien été pris en compte. Merci de cliquer sur le lien dans l'email que vous avez reçu.",
			'confirmation'			=> [
				'ok'				=> "Votre compte est à présent confirmé."
			],
		],
		'action' => [
			'goto_login'			=> "Je souhaite me connecter"
		]
	],

	
];
