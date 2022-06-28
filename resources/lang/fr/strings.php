<?php 
return [
  'backend' => [
    'access' => [
      'users' => 
      [
        'delete_user_confirm' => 'Voulez-vous vraiment supprimer définitivement cet utilisateur? N"importe où dans l"application qui fait référence à l"ID de cet utilisateur sera très probablement une erreur. Procédez à vos risques et périls. Cela ne peut pas être annulé.',
        'if_confirmed_off' => '(Si confirmé est désactivé)',
        'restore_user_confirm' => 'Restaurer cet utilisateur à son état d"origine?',
      ],
    ],
    'dashboard' => [
      'title' => 'Tableau de bord administratif SuperAdmin',
      'welcome' => 'Bienvenue',
    ],
    'general' => [
      'all_rights_reserved' => 'Tous les droits sont réservés.',
      'are_you_sure' => 'Es-tu sûr de vouloir faire ça?',
      'boilerplate_link' => 'Facturation des roses',
      'continue' => 'Continuer',
      'member_since' => 'Membre depuis',
      'minutes' => 'minutes',
      'search_placeholder' => 'Chercher...',
      'timeout' => 'Vous avez été automatiquement déconnecté pour des raisons de sécurité, car vous n"aviez aucune activité sur',
      'see_all' => 
      [
        'messages' => 'Voir tous les messages',
        'notifications' => 'Voir tout',
        'tasks' => 'Afficher toutes les tâches',
      ],
      'status' => 
      [
        'online' => 'En ligne',
        'offline' => 'Hors ligne',
      ],
      'you_have' => 
      [
        'messages' => '{0} Vous n"avez pas de message | {1} Vous avez 1 message | [2, Inf] Vous avez: nombre de messages',
        'notifications' => '{0} Vous n"avez pas de notifications | {1} Vous avez 1 notification | [2, Inf] Vous avez: nombre de notifications',
        'tasks' => '{0} Vous n"avez pas de tâches | {1} Vous avez 1 tâche | [2, Inf] Vous avez: nombre de tâches',
      ],
    ],
    'search' => [
      'empty' => 'Veuillez saisir un terme de recherche.',
      'incomplete' => 'Vous devez écrire votre propre logique de recherche pour ce système.',
      'title' => 'Résultats de recherche',
      'results' => 'Résultats de la recherche pour: requête',
    ],
    'welcome' => 'Bienvenue',
  ],
  'emails' => [
    'auth' => [
      'error' => 'Oups!',
      'greeting' => 'salut!',
      'regards' => 'Cordialement,',
      'trouble_clicking_button' => 'Si vous ne parvenez pas à cliquer sur le bouton ": action_text", copiez et collez l"URL ci-dessous dans votre navigateur Web:',
      'thank_you_for_using_app' => 'Merci d"utiliser notre application!',
      'password_reset_subject' => 'réinitialiser le mot de passe',
      'password_cause_of_email' => 'Vous recevez cet e-mail, car nous avons reçu une demande de réinitialisation du mot de passe pour votre compte.',
      'password_if_not_requested' => 'Si vous n"avez pas demandé de réinitialisation du mot de passe, aucune autre action n"est requise.',
      'reset_password' => 'Cliquez ici pour réinitialiser votre mot de passe',
      'click_to_confirm' => 'Cliquez ici pour confirmer votre compte:',
    ],
  ],
  'frontend' => [
    'test' => 'Tester',
    'tests' => [
      'based_on' => 
      [
        'permission' => 'Basé sur les autorisations -',
        'role' => 'Basé sur le rôle -',
      ],
      'js_injected_from_controller' => 'Javascript injecté depuis un contrôleur',
      'using_blade_extensions' => 'Utilisation des extensions de lame',
      'using_access_helper' => 
      [
        'array_permissions' => 'Utiliser Access Helper avec un tableau de noms ou d’ID d’autorisations où l’utilisateur doit tout posséder.',
        'array_permissions_not' => 'Utilisation d’Aide Helper avec un tableau de noms ou d’ID d’autorisation où l’utilisateur n’a pas à tout posséder.',
        'array_roles' => 'Utilisation d’Aide Helper avec un tableau de noms de rôle ou d’ID où l’utilisateur doit tout posséder.',
        'array_roles_not' => 'Utilisation d’Aide Helper avec un tableau de noms de rôle ou d’ID où l’utilisateur n’a pas à tout posséder.',
        'permission_id' => 'Utilisation d"Access Helper avec l"ID d"autorisation',
        'permission_name' => 'Utilisation d"Access Helper avec le nom d"autorisation',
        'role_id' => 'Utilisation d"Access Helper avec l"ID de rôle',
        'role_name' => 'Utilisation d"Access Helper avec le nom de rôle',
      ],
      'view_console_it_works' => 'Voir la console, vous devriez voir "ça marche!" qui vient de FrontendController @ index',
      'you_can_see_because' => 'Vous pouvez le voir parce que vous avez le rôle de ": role"!',
      'you_can_see_because_permission' => 'Vous pouvez le voir car vous avez l"autorisation de ": permission"!',
    ],
    'user' => [
      'change_email_notice' => 'Si vous changez votre e-mail, vous serez déconnecté jusqu"à ce que vous confirmiez votre nouvelle adresse e-mail.',
      'email_changed_notice' => 'Vous devez confirmer votre nouvelle adresse e-mail avant de pouvoir vous reconnecter.',
      'profile_updated' => 'Profil mis à jour avec succès.',
      'password_updated' => 'Le mot de passe a été mis à jour avec succès.',
    ],
    'welcome_to' => 'Bienvenue sur: place',
  ],
];