<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Admin Language Lines
    |--------------------------------------------------------------------------
    |
    |
    */

    'global' => [
        'application' => [
            'name'              => 'Abarth'
        ],
        'message' => [
            'upload_file_here'  => 'Glisser vos fichiers ici'
        ],
        'action' => [
            'close'             =>  'Fermer',
            'edit'              =>  'Éditer',
            'show'              =>  'Afficher',
            'save'              =>  'Enregistrer',
            'delete'            =>  'Supprimer',
        ]
    ],

    'users' => [
        'title' => [
            'login'             => "Se connecter",
        ],
        'action' => [
            'logout'            => "Déconnexion",
            'login'             => "Connexion",
        ],
        'message' => [
            'remember_me'        => "Se Souvenir De Moi",
        ],
        'field' => [
            'email'             => "Email",
            'content'           => "Contenu de page",
            'files'             => "Fichiers de la page",
            'pictures'          => "Photos de la page",
        ],
    ],

    'pages' => [
        'title' => [
            'index'             => "Liste des pages",
            'create'            => "Ajout d'une page",
            'edit'              => "Edition d'une page",
            'delete'            => "Suppression d'une page",
        ],
        'field' => [
            'name'              => "Nom de page",
            'content'           => "Contenu de page",
            'files'             => "Fichiers de la page",
            'pictures'          => "Photos de la page",
        ],
        'message' => [
            'nocontent'         => "Aucune page actuellement.",
        ],
        'action' => [
            'save'              => "Enregister cette page",
            'create'            => "Ajouter cette page",
        ]
    ],

    'files' => [
        'feedback' => [
            'update' => [
                'ok'            => 'Le fichier a bien été enregistré !',
                'error'         => 'Une erreur est survenue lors de l\'enregistrement du fichier !',
            ],
            'delete' => [
                'ok'            => 'Le fichier a bien été supprimé !',
                'error'         => 'Une erreur est survenue lors de la suppression de ce fichier !',
            ],
        ],
        'title' => [
            'edit'              => 'Édition du fichier',
            'delete'            => "Suppression d'un fichier",
            'upload'            => "Upload de fichiers",
        ],
        'message' => [
            'delete'            => "Êtes vous certain de vouloir supprimer ce fichier ?",
        ],
        'field' => [
            'name'              => "Nom du fichier",
            'legend'            => "Légende du fichier",
        ],
        'label' => [
            'status' => [
                'pending'       => 'En attente',
                'success'       => 'Transféré',
                'error'         => "Erreur",
                'unaccepted'    => 'Fichier invalide',
            ],
            'count' => [
                'short'         => "<span class=\"count-value\">:count</span> fichier(s)"
            ]
        ],
        'action' => [
            'save'              => "Enregister ce fichier",
            'upload'            => "Lancer le transfert des fichiers",
        ]
    ]
    
];
