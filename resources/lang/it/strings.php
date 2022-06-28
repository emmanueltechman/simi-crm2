<?php 
return [
  'backend' => [
    'access' => [
      'users' => 
      [
        'delete_user_confirm' => 'Sei sicuro di voler eliminare definitivamente questo utente? Ovunque nell"applicazione che fa riferimento all"ID di questo utente molto probabilmente si verificherà un errore. Procedere a proprio rischio. Questo non può essere fatto.',
        'if_confirmed_off' => '(Se confermato è disattivato)',
        'restore_user_confirm' => 'Ripristinare questo utente al suo stato originale?',
      ],
    ],
    'dashboard' => [
      'title' => 'Dashboard amministrativo di SuperAdmin',
      'welcome' => 'benvenuto',
    ],
    'general' => [
      'all_rights_reserved' => 'Tutti i diritti riservati.',
      'are_you_sure' => 'Sei sicuro di volerlo fare?',
      'boilerplate_link' => 'Fatturazione alla rosa',
      'continue' => 'Continua',
      'member_since' => 'Membro da',
      'minutes' => 'minuti',
      'search_placeholder' => 'Ricerca...',
      'timeout' => 'Sei stato disconnesso automaticamente per motivi di sicurezza poiché non hai avuto attività',
      'see_all' => 
      [
        'messages' => 'Vedi tutti i messaggi',
        'notifications' => 'Mostra tutto',
        'tasks' => 'Visualizza tutte le attività',
      ],
      'status' => 
      [
        'online' => 'in linea',
        'offline' => 'disconnesso',
      ],
      'you_have' => 
      [
        'messages' => '{0} Non hai messaggi | {1} Hai 1 messaggio | [2, Inf] Hai: numeri di messaggi',
        'notifications' => '{0} Non hai notifiche | {1} Hai 1 notifica | [2, Inf] Hai: notifiche numero',
        'tasks' => '{0} Non hai compiti | {1} Hai 1 compito | [2, Inf] Hai: numeri compiti',
      ],
    ],
    'search' => [
      'empty' => 'Si prega di inserire un termine di ricerca.',
      'incomplete' => 'È necessario scrivere la propria logica di ricerca per questo sistema.',
      'title' => 'risultati di ricerca',
      'results' => 'Risultati della ricerca per: query',
    ],
    'welcome' => 'benvenuto',
  ],
  'emails' => [
    'auth' => [
      'error' => 'Ops!',
      'greeting' => 'Ciao!',
      'regards' => 'Saluti,',
      'trouble_clicking_button' => 'Se riscontri problemi nel fare clic sul pulsante ": action_text", copia e incolla l"URL seguente nel browser Web:',
      'thank_you_for_using_app' => 'Grazie per aver utilizzato la nostra applicazione!',
      'password_reset_subject' => 'Resetta la password',
      'password_cause_of_email' => 'Ricevi questa email perché abbiamo ricevuto una richiesta di reimpostazione della password per il tuo account.',
      'password_if_not_requested' => 'Se non è stata richiesta la reimpostazione della password, non sono necessarie ulteriori azioni.',
      'reset_password' => 'Fai clic qui per reimpostare la password',
      'click_to_confirm' => 'Clicca qui per confermare il tuo account:',
    ],
  ],
  'frontend' => [
    'test' => 'Test',
    'tests' => [
      'based_on' => 
      [
        'permission' => 'Basato su autorizzazione -',
        'role' => 'Basato sul ruolo -',
      ],
      'js_injected_from_controller' => 'Javascript iniettato da un controller',
      'using_blade_extensions' => 'Utilizzo delle estensioni della lama',
      'using_access_helper' => 
      [
        'array_permissions' => 'Utilizzo di Access Helper con array di nomi di autorizzazione o ID in cui l"utente deve possedere tutto.',
        'array_permissions_not' => 'Utilizzo di Access Helper con array di nomi di autorizzazioni o ID in cui l"utente non deve possedere tutto.',
        'array_roles' => 'Utilizzo di Access Helper con array di nomi di ruoli o ID in cui l"utente deve possedere tutto.',
        'array_roles_not' => 'Utilizzo di Access Helper con array di nomi di ruoli o ID in cui l"utente non deve possedere tutto.',
        'permission_id' => 'Utilizzo di Access Helper con ID autorizzazione',
        'permission_name' => 'Utilizzo di Access Helper con Nome autorizzazione',
        'role_id' => 'Utilizzo di Access Helper con ID ruolo',
        'role_name' => 'Utilizzo di Access Helper con nome ruolo',
      ],
      'view_console_it_works' => 'Visualizza console, dovresti vedere "funziona!" che proviene da FrontendController @ index',
      'you_can_see_because' => 'Puoi vederlo perché hai il ruolo di ": ruolo"!',
      'you_can_see_because_permission' => 'Puoi vederlo perché hai il permesso di ": permesso"!',
    ],
    'user' => [
      'change_email_notice' => 'Se si modifica l"e-mail, si verrà disconnessi fino a quando non si conferma il nuovo indirizzo e-mail.',
      'email_changed_notice' => 'Devi confermare il tuo nuovo indirizzo e-mail prima di poter accedere di nuovo.',
      'profile_updated' => 'Profilo aggiornato correttamente.',
      'password_updated' => 'Password aggiornata correttamente.',
    ],
    'welcome_to' => 'Benvenuti a: posto',
  ],
];