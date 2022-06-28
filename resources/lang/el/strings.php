<?php 
return [
  'backend' => [
    'access' => [
      'users' => 
      [
        'delete_user_confirm' => 'Möchten Sie diesen Benutzer wirklich dauerhaft löschen? Überall in der Anwendung, die auf die ID dieses Benutzers verweist, tritt höchstwahrscheinlich ein Fehler auf. Fahren Sie auf eigenes Risiko fort. Dies kann nicht rückgängig gemacht werden.',
        'if_confirmed_off' => '(Wenn bestätigt ist aus)',
        'restore_user_confirm' => 'Diesen Benutzer in seinen ursprünglichen Zustand zurückversetzen?',
      ],
    ],
    'dashboard' => [
      'title' => 'SuperAdmin Administrative Dashboard',
      'welcome' => 'Herzlich willkommen',
    ],
    'general' => [
      'all_rights_reserved' => 'Alle Rechte vorbehalten.',
      'are_you_sure' => 'Sind Sie sicher, dass Sie dies tun möchten?',
      'boilerplate_link' => 'Rose Billing',
      'continue' => 'Fortsetzen',
      'member_since' => 'Mitglied seit',
      'minutes' => 'Protokoll',
      'search_placeholder' => 'Suche...',
      'timeout' => 'Sie wurden aus Sicherheitsgründen automatisch abgemeldet, da Sie keine Aktivität hatten',
      'see_all' => 
      [
        'messages' => 'Alle Nachrichten anzeigen',
        'notifications' => 'Alle ansehen',
        'tasks' => 'Alle Aufgaben anzeigen',
      ],
      'status' => 
      [
        'online' => 'Online',
        'offline' => 'Offline',
      ],
      'you_have' => 
      [
        'messages' => '{0} Sie haben keine Nachrichten | {1} Sie haben 1 Nachricht | [2, Inf] Sie haben: Nummer Nachrichten',
        'notifications' => '{0} Sie haben keine Benachrichtigungen | {1} Sie haben 1 Benachrichtigung | [2, Inf] Sie haben: Nummernbenachrichtigungen',
        'tasks' => '{0} Sie haben keine Aufgaben | {1} Sie haben 1 Aufgabe | [2, Inf] Sie haben: Anzahl Aufgaben',
      ],
    ],
    'search' => [
      'empty' => 'Bitte geben Sie einen Suchbegriff ein.',
      'incomplete' => 'Sie müssen Ihre eigene Suchlogik für dieses System schreiben.',
      'title' => 'Suchergebnisse',
      'results' => 'Suchergebnisse für: Abfrage',
    ],
    'welcome' => 'Herzlich willkommen',
  ],
  'emails' => [
    'auth' => [
      'error' => 'Hoppla!',
      'greeting' => 'Hallo!',
      'regards' => 'Grüße,',
      'trouble_clicking_button' => 'Wenn Sie Probleme beim Klicken auf die Schaltfläche ": action_text" haben, kopieren Sie die folgende URL und fügen Sie sie in Ihren Webbrowser ein:',
      'thank_you_for_using_app' => 'Vielen Dank, dass Sie unsere Anwendung verwenden!',
      'password_reset_subject' => 'Passwort zurücksetzen',
      'password_cause_of_email' => 'Sie erhalten diese E-Mail, weil wir eine Anfrage zum Zurücksetzen des Passworts für Ihr Konto erhalten haben.',
      'password_if_not_requested' => 'Wenn Sie kein Zurücksetzen des Kennworts angefordert haben, sind keine weiteren Maßnahmen erforderlich.',
      'reset_password' => 'Klicken Sie hier, um Ihr Passwort zurückzusetzen',
      'click_to_confirm' => 'Klicken Sie hier, um Ihr Konto zu bestätigen:',
    ],
  ],
  'frontend' => [
    'test' => 'Prüfung',
    'tests' => [
      'based_on' => 
      [
        'permission' => 'Berechtigungsbasiert -',
        'role' => 'Rollenbasiert -',
      ],
      'js_injected_from_controller' => 'Von einem Controller injiziertes Javascript',
      'using_blade_extensions' => 'Verwenden von Blade-Erweiterungen',
      'using_access_helper' => 
      [
        'array_permissions' => 'Verwenden von Access Helper mit einem Array von Berechtigungsnamen oder IDs, bei denen der Benutzer alle besitzen muss.',
        'array_permissions_not' => 'Verwenden von Access Helper mit einem Array von Berechtigungsnamen oder IDs, bei denen der Benutzer nicht alle besitzen muss.',
        'array_roles' => 'Verwenden von Access Helper mit einer Reihe von Rollennamen oder IDs, bei denen der Benutzer alle besitzen muss.',
        'array_roles_not' => 'Verwenden von Access Helper mit einer Reihe von Rollennamen oder IDs, bei denen der Benutzer nicht alle besitzen muss.',
        'permission_id' => 'Verwenden von Access Helper mit Berechtigungs-ID',
        'permission_name' => 'Verwenden von Access Helper mit Berechtigungsname',
        'role_id' => 'Verwenden von Access Helper mit Rollen-ID',
        'role_name' => 'Verwenden von Access Helper mit Rollennamen',
      ],
      'view_console_it_works' => 'Konsole anzeigen, sollten Sie sehen "es funktioniert!" welches vom FrontendController @ index kommt',
      'you_can_see_because' => 'Sie können dies sehen, weil Sie die Rolle ": Rolle" haben!',
      'you_can_see_because_permission' => 'Sie können dies sehen, weil Sie die Erlaubnis ": Erlaubnis" haben!',
    ],
    'user' => [
      'change_email_notice' => 'Wenn Sie Ihre E-Mail-Adresse ändern, werden Sie abgemeldet, bis Sie Ihre neue E-Mail-Adresse bestätigen.',
      'email_changed_notice' => 'Sie müssen Ihre neue E-Mail-Adresse bestätigen, bevor Sie sich erneut anmelden können.',
      'profile_updated' => 'Profil erfolgreich aktualisiert.',
      'password_updated' => 'Passwort erfolgreich aktualisiert.',
    ],
    'welcome_to' => 'Willkommen bei: Ort',
  ],
];