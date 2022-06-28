<?php 
return [
  'backend' => [
    'access' => [
      'users' => 
      [
        'delete_user_confirm' => 'Opravdu chcete tohoto uživatele trvale smazat? Kdekoli v aplikaci, která odkazuje na toto ID uživatele, bude nejpravděpodobnější chyba. Pokračujte na vlastní riziko. To nelze provést.',
        'if_confirmed_off' => '(Pokud je potvrzeno vypnuto)',
        'restore_user_confirm' => 'Obnovit tohoto uživatele do původního stavu?',
      ],
    ],
    'dashboard' => [
      'title' => 'Administrativní panel SuperAdmin',
      'welcome' => 'Vítejte',
    ],
    'general' => [
      'all_rights_reserved' => 'Všechna práva vyhrazena.',
      'are_you_sure' => 'Opravdu to chcete udělat?',
      'boilerplate_link' => 'Rose Billing',
      'continue' => 'Pokračovat',
      'member_since' => 'Členem od',
      'minutes' => 'minut',
      'search_placeholder' => 'Vyhledávání...',
      'timeout' => 'Byli jste automaticky odhlášeni z bezpečnostních důvodů, protože jste neměli žádnou činnost',
      'see_all' => 
      [
        'messages' => 'Zobrazit všechny zprávy',
        'notifications' => 'Zobrazit vše',
        'tasks' => 'Zobrazit všechny úkoly',
      ],
      'status' => 
      [
        'online' => 'Online',
        'offline' => 'Offline',
      ],
      'you_have' => 
      [
        'messages' => '{0} Nemáte zprávy | {1} Máte 1 zprávu | [2, Inf] Máte: počet zpráv',
        'notifications' => '{0} Nemáte oznámení | {1} Máte 1 oznámení | [2, Inf] Máte: čísla oznámení',
        'tasks' => '{0} Nemáte úkoly | {1} Máte 1 úkol | [2, Inf] Máte: počet úkolů',
      ],
    ],
    'search' => [
      'empty' => 'Zadejte hledaný výraz.',
      'incomplete' => 'Pro tento systém musíte napsat vlastní logiku vyhledávání.',
      'title' => 'Výsledky vyhledávání',
      'results' => 'Výsledky hledání pro: dotaz',
    ],
    'welcome' => 'Vítejte',
  ],
  'emails' => [
    'auth' => [
      'error' => 'Jejda!',
      'greeting' => 'Ahoj!',
      'regards' => 'Pozdravy,',
      'trouble_clicking_button' => 'Pokud máte potíže s kliknutím na tlačítko „: action_text“, zkopírujte a vložte níže uvedenou adresu URL do svého webového prohlížeče:',
      'thank_you_for_using_app' => 'Děkujeme za použití naší aplikace!',
      'password_reset_subject' => 'Obnovit heslo',
      'password_cause_of_email' => 'Tento e-mail jste obdrželi, protože jsme obdrželi žádost o obnovení hesla pro váš účet.',
      'password_if_not_requested' => 'Pokud jste nepožádali o obnovení hesla, není nutná žádná další akce.',
      'reset_password' => 'Klikněte sem pro resetování hesla',
      'click_to_confirm' => 'Klikněte zde pro potvrzení vašeho účtu:',
    ],
  ],
  'frontend' => [
    'test' => 'Test',
    'tests' => [
      'based_on' => 
      [
        'permission' => 'Na základě povolení -',
        'role' => 'Role Based -',
      ],
      'js_injected_from_controller' => 'Javascript Injected from Controller',
      'using_blade_extensions' => 'Používání rozšíření čepele',
      'using_access_helper' => 
      [
        'array_permissions' => 'Používejte pomocníka přístupu s maticí oprávnění nebo ID, kde uživatel musí vlastnit všechny.',
        'array_permissions_not' => 'Používejte pomocníka přístupu s maticí oprávnění nebo ID, pokud uživatel nemusí vlastnit vše.',
        'array_roles' => 'Používejte pomocníka přístupu s maticí rolí nebo ID, kde uživatel musí vlastnit všechny.',
        'array_roles_not' => 'Používání nástroje Access Helper s polem jmen nebo ID rolí, kde uživatel nemusí vlastnit vše.',
        'permission_id' => 'Používání pomocníka přístupu s ID oprávnění',
        'permission_name' => 'Používání pomocníka pro přístup s názvem oprávnění',
        'role_id' => 'Používání nástroje Access Helper s ID role',
        'role_name' => 'Používání nástroje Access Helper s názvem role',
      ],
      'view_console_it_works' => 'Zobrazit konzolu, měli byste vidět "to funguje!" který pochází z FrontendController @ index',
      'you_can_see_because' => 'Můžete to vidět, protože máte roli „: role“!',
      'you_can_see_because_permission' => 'Můžete to vidět, protože máte povolení „: povolení“!',
    ],
    'user' => [
      'change_email_notice' => 'Pokud změníte svůj e-mail, budete odhlášeni, dokud nepotvrdíte svou novou e-mailovou adresu.',
      'email_changed_notice' => 'Než se budete moci znovu přihlásit, musíte potvrdit svou novou e-mailovou adresu.',
      'profile_updated' => 'Profil byl úspěšně aktualizován.',
      'password_updated' => 'Heslo bylo úspěšně aktualizováno.',
    ],
    'welcome_to' => 'Vítejte na: místo',
  ],
];