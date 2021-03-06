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
            'name'              => 'Administration'
        ],
        'component' => [
            'root'              => [
                'index'         => 'Accueil',
            ],
            'pages'             => [
                'index'         => 'Pages',
            ],
            'galleries'         => [
                'index'                 => 'Galeries',
                'galleries'             => 'Gestion des galeries',
                'galleriescategories'   => 'Gestion des catégories'
            ],
            'administrators'    => [
                'index'         => 'Administrateurs',
            ]
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
        'title' => [
            'error' => 'Erreur'
        ],
        'message' => [
            'upload_file_here'  => 'Glisser vos fichiers ici',
            'error'             => 'Une erreur est survenu, si le problème persiste veuillez contacter le webmaster.'
        ],
        'action' => [
            'back'              =>  'Retour',
            'close'             =>  'Fermer',
            'edit'              =>  'Éditer',
            'show'              =>  'Afficher',
            'save'              =>  'Enregistrer',
            'delete'            =>  'Supprimer',
            'goto_website'      =>  'Afficher le site',
        ],
        'label' => [
            'never'             => 'Jamais',
            'publish'           => 'Publié',
            'draft'             => 'Brouillon'
        ]
    ],

     /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    |
    */

    'administrator' => [
        'field' => [
            'name'              => "Nom",
            'last_login'        => "Dernière connexion",
        ],
        'title' => [
            'changepwd'         => "Modifier votre mot de passe",
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
            'changepwd'         => "Modifier mon mot de passe"
        ],
        'message'=> [
            'delete'            => "Êtes-vous certain de vouloir supprimer cet administrateur ?",
        ],
        'feedback' => [
            'delete' => [
                'suicide'         => "Impossible de supprimer votre propre compte !!  (Tapez suicide dans Google ;-))",
            ],
        ],
    ],

    'user' => [
        'field' => [
            'name'              => "Nom",
            'email'             => "Email",
            'password'          => "Mot de passe",
            'password_confirmation'  => "Confirmation du mot de passe",
            'password_new'      => "Nouveau mot de passe",
            'password_new_confirmation'      => "Confirmation du nouveau mot de passe",
        ],
        'title' => [
            'login'             => "Se connecter",
            'register'          => "Inscription",
        ],
        'action' => [
            'change_password'   => "Modifier mon mot de passe",
            'profile'           => "Mon profil",
            'logout'            => "Déconnexion",
            'login'             => "Connexion",
            'register'          => "Inscription",
        ],
        'message' => [
            'remember_me'        => "Se souvenir de moi",
        ],
        
    ],

    'page' => [
        'field' => [
            'menu'              => "Menu de la page",
            'controller'        => "Type de page",
            'name'              => "Nom de la page",
            'content'           => "Contenu de page",
            'files'             => "Fichiers de la page",
            'pictures'          => "Photos de la page",
            'meta-title'        => "Meta title",
            'meta-description'  => "Meta description",
        ],
        'form' => [
            'group' => [
                'metadatas'     => "Informations de référencement de la page"
            ],
            'help' => [
                'meta-title'    => "Merci de saisir un texte d'environ 60 caractères.",
                'meta-description' => "Merci de saisir un texte d'environ 160 caractères.",
            ]
        ],
        'option'                => [
            'menu'        => [
                'primary'       => "Menu principal",
                'secondary'     => "Menu secondaire",
            ],
            'controller'        => [
                'pages'         => "Page classique",
                'galleries'     => "Page galerie",
            ],
        ],
        'title' => [
            'index'             => "Liste des pages",
            'create'            => "Ajout d'une page",
            'edit'              => "Edition d'une page",
            'delete'            => "Suppression d'une page",
        ],
        'action' => [
            'add'               => "Ajouter une page",
            'delete'            => "Supprimer cette page",
            'save'              => "Enregister cette page",
            'create'            => "Ajouter cette page",
        ],
        'message' => [
            'nocontent'         => "Aucune page actuellement.",
            'delete'            => "Êtes-vous certain de vouloir supprimer cette page ?",
        ],
        
    ],

    'gallery' => [
        'field' => [
            'category'          => "Catégory de la galerie",
            'name'              => "Nom de la galerie",
            'description'       => "Description de la galerie",
            'pictures'          => "Photos de la galerie",
        ],
        'label' => [
            'category' => [
                'select'        => "== Sélectionner une catégorie =="
            ]
        ],
        'title' => [
            'index'             => "Liste des galeries",
            'create'            => "Ajout d'une galerie",
            'edit'              => "Edition d'une galerie",
            'delete'            => "Suppression d'une galerie",
        ],
        'action' => [
            'add'               => "Ajouter une galerie",
            'delete'            => "Supprimer cette galerie",
            'save'              => "Enregister cette galerie",
            'create'            => "Ajouter cette galerie",
        ],
        'message' => [
            'nocontent'         => "Aucune galerie actuellement.",
            'delete'            => "Êtes-vous certain de vouloir supprimer cette galerie ?",
        ],
    ],

    'galleriescategory' => [
        'field' => [
            'name'              => "Nom de la categorie",
            'description'       => "Description de la categorie",
            'pictures'          => "Photos de la catégorie",
        ],
        'title' => [
            'index'             => "Liste des catégories",
            'create'            => "Ajout d'une catégorie",
            'edit'              => "Edition d'une catégorie",
            'delete'            => "Suppression d'une catégorie",
        ],
        'action' => [
            'add'               => "Ajouter une catégorie",
            'delete'            => "Supprimer cette catégorie",
            'save'              => "Enregister cette catégorie",
            'create'            => "Ajouter une catégorie",
        ],
        'message' => [
            'nocontent'         => "Aucune catégorie actuellement.",
            'delete'            => "Êtes-vous certain de vouloir supprimer cette catégorie ?",
        ],
    ],

    'file' => [
        'field' => [
            'name'              => "Nom du fichier",
            'title'             => "Titre du fichier",
            'legend'            => "Légende du fichier",
        ],
        'title' => [
            'index'             => "Liste des fichiers",
            'edit'              => 'Édition du fichier',
            'delete'            => "Suppression d'un fichier",
            'upload'            => "Upload de fichiers",
        ],
        'label' => [
            'preview'           => "Aperçu",
            'thead' => [
                'thumbnail'     => "Miniature",
                'name_legend'   => "Nom et légende"
            ],
            'status' => [
                'pending'       => 'En attente',
                'success'       => 'Transféré',
                'error'         => "Erreur",
                'tobig'         => "Fichier trop lourd",
                'unaccepted'    => 'Fichier invalide',
            ],
            'count' => [
                'short'         => '<span class=\'count-value\'>:count</span> fichier(s)'
            ]
        ],
        'action' => [
            'add'               => "Ajouter un fichier",
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
