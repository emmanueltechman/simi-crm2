<?php 
return [
  'backend' => [
    'access' => [
      'users' => 
      [
        'delete_user_confirm' => 'Är du säker på att du vill ta bort den här användaren permanent? Överallt i applikationen som hänvisar till den här användarens ID kommer troligtvis fel. Fortsätt på din egen risk. Det går inte att göra det.',
        'if_confirmed_off' => '(Om bekräftelse är avstängd)',
        'restore_user_confirm' => 'Vill du återställa den här användaren till sitt ursprungliga tillstånd?',
      ],
    ],
    'dashboard' => [
      'title' => 'SuperAdmin administrativ instrumentpanel',
      'welcome' => 'Välkommen',
    ],
    'general' => [
      'all_rights_reserved' => 'Alla rättigheter förbehållna.',
      'are_you_sure' => 'Är du säker på att du vill göra det här?',
      'boilerplate_link' => 'Rose Billing',
      'continue' => 'Fortsätta',
      'member_since' => 'Medlem sedan',
      'minutes' => 'minuter',
      'search_placeholder' => 'Sök...',
      'timeout' => 'Du loggades automatiskt ut av säkerhetsskäl eftersom du inte hade någon aktivitet i',
      'see_all' => 
      [
        'messages' => 'Se alla meddelanden',
        'notifications' => 'Visa alla',
        'tasks' => 'Visa alla uppgifter',
      ],
      'status' => 
      [
        'online' => 'Uppkopplad',
        'offline' => 'Off-line',
      ],
      'you_have' => 
      [
        'messages' => '{0} Du har inga meddelanden | {1} Du har 1 meddelande | [2, Inf] Du har: nummermeddelanden',
        'notifications' => '{0} Du har inte aviseringar | {1} Du har 1 meddelande | [2, Inf] Du har: numret aviseringar',
        'tasks' => '{0} Du har inte uppgifter | {1} Du har 1 uppgift | [2, Inf] Du har: nummeruppgifter',
      ],
    ],
    'search' => [
      'empty' => 'Ange ett sökord.',
      'incomplete' => 'Du måste skriva din egen söklogik för det här systemet.',
      'title' => 'sökresultat',
      'results' => 'Sökresultat för: fråga',
    ],
    'welcome' => 'Välkommen',
  ],
  'emails' => [
    'auth' => [
      'error' => 'Oj då!',
      'greeting' => 'Hej!',
      'regards' => 'Hälsningar,',
      'trouble_clicking_button' => 'Om du har problem med att klicka på knappen ": action_text", kopiera och klistra in webbadressen nedan i din webbläsare:',
      'thank_you_for_using_app' => 'Tack för att du använder vår applikation!',
      'password_reset_subject' => 'Återställ lösenord',
      'password_cause_of_email' => 'Du får det här e-postmeddelandet eftersom vi fick en begäran om återställning av lösenord för ditt konto.',
      'password_if_not_requested' => 'Om du inte begärde återställning av lösenord krävs ingen ytterligare åtgärd.',
      'reset_password' => 'Klicka här för att återställa ditt lösenord',
      'click_to_confirm' => 'Klicka här för att bekräfta ditt konto:',
    ],
  ],
  'frontend' => [
    'test' => 'Testa',
    'tests' => [
      'based_on' => 
      [
        'permission' => 'Tillstånd baserat -',
        'role' => 'Rollbaserad -',
      ],
      'js_injected_from_controller' => 'Javascript injicerat från en kontroller',
      'using_blade_extensions' => 'Använda bladförlängningar',
      'using_access_helper' => 
      [
        'array_permissions' => 'Använda åtkomsthjälpare med array av tillståndsnamn eller ID: er där användaren måste ha allt.',
        'array_permissions_not' => 'Använda åtkomsthjälpare med array av tillståndsnamn eller ID: er där användaren inte behöver ha alla.',
        'array_roles' => 'Använda Access Helper med Array of Role Names eller ID där användaren måste ha allt.',
        'array_roles_not' => 'Använda Access Helper med Array of Role Names eller ID: er där användaren inte behöver ha allt.',
        'permission_id' => 'Använda åtkomsthjälpare med behörighets-ID',
        'permission_name' => 'Använda åtkomsthjälpare med behörighetsnamn',
        'role_id' => 'Använda Access Helper med roll-ID',
        'role_name' => 'Använda Access Helper med rollnamn',
      ],
      'view_console_it_works' => 'Visa konsol, du bör se "det fungerar!" som kommer från FrontendController @ index',
      'you_can_see_because' => 'Du kan se detta eftersom du har rollen ": roll"!',
      'you_can_see_because_permission' => 'Du kan se detta eftersom du har tillstånd från ": permission"!',
    ],
    'user' => [
      'change_email_notice' => 'Om du ändrar din e-post kommer du att loggas ut tills du bekräftar din nya e-postadress.',
      'email_changed_notice' => 'Du måste bekräfta din nya e-postadress innan du kan logga in igen.',
      'profile_updated' => 'Profilen har uppdaterats.',
      'password_updated' => 'Lösenordet har uppdaterats.',
    ],
    'welcome_to' => 'Välkommen till: plats',
  ],
];