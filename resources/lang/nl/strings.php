<?php 
return [
  'backend' => [
    'access' => [
      'users' => 
      [
        'delete_user_confirm' => 'Weet u zeker dat u deze gebruiker definitief wilt verwijderen? Overal in de toepassing die naar het ID van deze gebruiker verwijst, zal hoogstwaarschijnlijk een fout optreden. Ga op eigen risico. Dit kan niet ongedaan worden gemaakt.',
        'if_confirmed_off' => '(Indien bevestigd is uitgeschakeld)',
        'restore_user_confirm' => 'Deze gebruiker herstellen naar de oorspronkelijke staat?',
      ],
    ],
    'dashboard' => [
      'title' => 'SuperAdmin Administratief Dashboard',
      'welcome' => 'Welkom',
    ],
    'general' => [
      'all_rights_reserved' => 'Alle rechten voorbehouden.',
      'are_you_sure' => 'Weet je zeker dat je dit wilt doen?',
      'boilerplate_link' => 'Rose Billing',
      'continue' => 'Doorgaan met',
      'member_since' => 'Lid sinds',
      'minutes' => 'minuten',
      'search_placeholder' => 'Zoeken...',
      'timeout' => 'U bent om veiligheidsredenen automatisch uitgelogd omdat u geen activiteit had',
      'see_all' => 
      [
        'messages' => 'Zie alle berichten',
        'notifications' => 'Bekijk alles',
        'tasks' => 'Bekijk alle taken',
      ],
      'status' => 
      [
        'online' => 'Online',
        'offline' => 'Offline',
      ],
      'you_have' => 
      [
        'messages' => '{0} Je hebt geen berichten | {1} Je hebt één bericht | [2, Inf] Je hebt: nummerberichten',
        'notifications' => '{0} Je hebt geen meldingen | {1} Je hebt één melding | [2, Inf] Je hebt: aantal meldingen',
        'tasks' => '{0} Je hebt geen taken | {1} Je hebt één taak | [2, Inf] Je hebt: nummertaken',
      ],
    ],
    'search' => [
      'empty' => 'Voer een zoekterm in.',
      'incomplete' => 'Voor dit systeem moet u uw eigen zoeklogica schrijven.',
      'title' => 'Zoekresultaten',
      'results' => 'Zoekresultaten voor: query',
    ],
    'welcome' => 'Welkom',
  ],
  'emails' => [
    'auth' => [
      'error' => 'Oeps!',
      'greeting' => 'Hallo!',
      'regards' => 'Vriendelijke groeten,',
      'trouble_clicking_button' => 'Als u problemen ondervindt bij het klikken op de knop ": action_text", kopieert en plakt u de onderstaande URL in uw webbrowser:',
      'thank_you_for_using_app' => 'Bedankt voor het gebruiken van onze applicatie!',
      'password_reset_subject' => 'Wachtwoord opnieuw instellen',
      'password_cause_of_email' => 'U ontvangt deze e-mail omdat we een verzoek voor het opnieuw instellen van uw wachtwoord voor uw account hebben ontvangen.',
      'password_if_not_requested' => 'Als u geen wachtwoordherstel hebt aangevraagd, is er geen verdere actie vereist.',
      'reset_password' => 'Klik hier om uw wachtwoord opnieuw in te stellen',
      'click_to_confirm' => 'Klik hier om uw account te bevestigen:',
    ],
  ],
  'frontend' => [
    'test' => 'Test',
    'tests' => [
      'based_on' => 
      [
        'permission' => 'Op basis van toestemming -',
        'role' => 'Rol gebaseerd -',
      ],
      'js_injected_from_controller' => 'Javascript geïnjecteerd vanaf een controller',
      'using_blade_extensions' => 'Blade Extensions gebruiken',
      'using_access_helper' => 
      [
        'array_permissions' => 'Access Helper gebruiken met Array of Permission Names of ID"s waarbij de gebruiker alles moet bezitten.',
        'array_permissions_not' => 'Access Helper gebruiken met Array of Permission Names of ID"s waarbij de gebruiker niet alles hoeft te bezitten.',
        'array_roles' => 'Access Helper gebruiken met een reeks rolnamen of ID"s waarbij de gebruiker alles moet bezitten.',
        'array_roles_not' => 'Access Helper gebruiken met een reeks rolnamen of ID"s waarbij de gebruiker niet alles hoeft te bezitten.',
        'permission_id' => 'Access Helper gebruiken met machtigings-ID',
        'permission_name' => 'Access Helper gebruiken met permissienaam',
        'role_id' => 'Access Helper gebruiken met rol-ID',
        'role_name' => 'Access Helper gebruiken met rolnaam',
      ],
      'view_console_it_works' => 'Bekijk console, je zou moeten zien "het werkt!" die afkomstig is van FrontendController @ index',
      'you_can_see_because' => 'Je kunt dit zien omdat je de rol van ": rol" hebt!',
      'you_can_see_because_permission' => 'Je kunt dit zien omdat je de toestemming hebt van ": permissie"!',
    ],
    'user' => [
      'change_email_notice' => 'Als u uw e-mailadres wijzigt, wordt u uitgelogd totdat u uw nieuwe e-mailadres bevestigt.',
      'email_changed_notice' => 'U moet uw nieuwe e-mailadres bevestigen voordat u opnieuw kunt inloggen.',
      'profile_updated' => 'Profiel succesvol bijgewerkt.',
      'password_updated' => 'Wachtwoord succesvol bijgewerkt.',
    ],
    'welcome_to' => 'Welkom bij: place',
  ],
];