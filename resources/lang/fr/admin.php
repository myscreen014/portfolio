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
        'component' => [
            'root'              => 'Accueil',
            'pages'             => 'Pages',
            'administrators'    => 'Administrateurs',
        ],
        'feedback' => [
            'update' => [
                'ok'            => 'Les modifications ont bien été enregistrée !',
                'error'         => 'Une erreur est survenue lors de l\'enregistrement des modifications !',
            ],
            'delete' => [
                'ok'            => 'La suppression à bien été effectuée !',
                'error'         => 'Une erreur est survenue lors de la suppression !',
            ],
        ],
        'message' => [
            'upload_file_here'  => 'Glisser vos fichiers ici'
        ],
        'action' => [
            'back'              =>  'Retour',
            'close'             =>  'Fermer',
            'edit'              =>  'Éditer',
            'show'              =>  'Afficher',
            'save'              =>  'Enregistrer',
            'delete'            =>  'Supprimer',
        ]
    ],

    'administrators' => [
        'field' => [
            'name'              => "Nom",
            'last_login'        => "Dernière connexion",
        ],
        'title' => [
            'index'             => "Liste des administrateurs",
            'create'            => "Ajout d'un administrateur",
            'edit'              => "Edition d'un administrateur",
            'delete'            => "Suppression d'un administrateur",
        ],
        'action' => [
            'add'               => "Ajouter un administrateur",
            'create'            => "Ajouter cet administrateur",
            'update'            => "Enregistrer cet administrateur",
            'delete'            => "Supprimer cet administrateur",
        ],
        'message'=> [
            'delete'            => "Êtes-vous certain de vouloir supprimer cet administrateur ?",
        ],
        'feedback' => [
            'delete' => [
                'suicide'         => "Impossible de supprimer votre propre compte !!  (Tapez suicide dan Google ;-))",
            ],
        ],
    ],

    'users' => [
        'field' => [
            'name'              => "Nom",
            'email'             => "Email",
            'password'          => "Mot de passe",
            'password_confirmation'  => "Confirmation du mot de passe",
        ],
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
        
    ],

    'pages' => [
        'field' => [
            'name'              => "Nom de page",
            'content'           => "Contenu de page",
            'files'             => "Fichiers de la page",
            'pictures'          => "Photos de la page",
        ],
        'title' => [
            'index'             => "Liste des pages",
            'create'            => "Ajout d'une page",
            'edit'              => "Edition d'une page",
            'delete'            => "Suppression d'une page",
        ],
        'action' => [
            'save'              => "Enregister cette page",
            'create'            => "Ajouter cette page",
        ],
        'message' => [
            'nocontent'         => "Aucune page actuellement.",
            'delete'            => "Êtes-vous certain de vouloir supprimer cette page ?",
        ],
        
    ],

    'files' => [
        'field' => [
            'name'              => "Nom du fichier",
            'legend'            => "Légende du fichier",
        ],
        'title' => [
            'edit'              => 'Édition du fichier',
            'delete'            => "Suppression d'un fichier",
            'upload'            => "Upload de fichiers",
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
        ],
        'message' => [
            'delete'            => "Êtes vous certain de vouloir supprimer ce fichier ?",
        ],
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
        
        
        
    ]
    
];
