<?php 
return [
  'backend' => [
    'access' => [
      'users' => 
      [
        'delete_user_confirm' => 'Czy na pewno chcesz trwale usunąć tego użytkownika? W dowolnym miejscu aplikacji, która odwołuje się do identyfikatora tego użytkownika, najprawdopodobniej wystąpi błąd. Kontynuuj na własne ryzyko. Nie można tego zrobić.',
        'if_confirmed_off' => '(Jeśli potwierdzenie jest wyłączone)',
        'restore_user_confirm' => 'Przywrócić tego użytkownika do pierwotnego stanu?',
      ],
    ],
    'dashboard' => [
      'title' => 'Pulpit administracyjny SuperAdmin',
      'welcome' => 'Witamy',
    ],
    'general' => [
      'all_rights_reserved' => 'Wszelkie prawa zastrzeżone.',
      'are_you_sure' => 'Czy na pewno chcesz to zrobić?',
      'boilerplate_link' => 'Rose Billing',
      'continue' => 'Kontyntynuj',
      'member_since' => 'Członek od',
      'minutes' => 'minuty',
      'search_placeholder' => 'Szukaj...',
      'timeout' => 'Zostałeś automatycznie wylogowany ze względów bezpieczeństwa, ponieważ nie prowadziłeś żadnej działalności',
      'see_all' => 
      [
        'messages' => 'Zobacz wszystkie wiadomości',
        'notifications' => 'Pokaż wszystkie',
        'tasks' => 'Wyświetl wszystkie zadania',
      ],
      'status' => 
      [
        'online' => 'online',
        'offline' => 'Offline',
      ],
      'you_have' => 
      [
        'messages' => '{0} Nie masz wiadomości | {1} Masz 1 wiadomość | [2, Inf] Masz: numer wiadomości',
        'notifications' => '{0} Nie masz powiadomień | {1} Masz 1 powiadomienie | [2, Inf] Masz: numer powiadomień',
        'tasks' => '{0} Nie masz zadań | {1} Masz 1 zadanie | [2, Inf] Masz: liczbę zadań',
      ],
    ],
    'search' => [
      'empty' => 'Wpisz wyszukiwane hasło.',
      'incomplete' => 'Musisz napisać własną logikę wyszukiwania dla tego systemu.',
      'title' => 'Wyniki wyszukiwania',
      'results' => 'Wyniki wyszukiwania dla: zapytanie',
    ],
    'welcome' => 'Witamy',
  ],
  'emails' => [
    'auth' => [
      'error' => 'Ups!',
      'greeting' => 'Cześć!',
      'regards' => 'Pozdrowienia,',
      'trouble_clicking_button' => 'Jeśli masz problem z kliknięciem przycisku „: action_text”, skopiuj i wklej poniższy adres URL do przeglądarki internetowej:',
      'thank_you_for_using_app' => 'Dziękujemy za skorzystanie z naszej aplikacji!',
      'password_reset_subject' => 'Zresetuj hasło',
      'password_cause_of_email' => 'Otrzymujesz tego e-maila, ponieważ otrzymaliśmy prośbę o zresetowanie hasła do Twojego konta.',
      'password_if_not_requested' => 'Jeśli nie zażądałeś resetowania hasła, nie musisz podejmować żadnych dalszych działań.',
      'reset_password' => 'Kliknij tutaj, aby zresetować hasło',
      'click_to_confirm' => 'Kliknij tutaj, aby potwierdzić swoje konto:',
    ],
  ],
  'frontend' => [
    'test' => 'Test',
    'tests' => [
      'based_on' => 
      [
        'permission' => 'Na podstawie uprawnień -',
        'role' => 'Na podstawie ról -',
      ],
      'js_injected_from_controller' => 'JavaScript wstrzykiwany z kontrolera',
      'using_blade_extensions' => 'Korzystanie z rozszerzeń ostrzy',
      'using_access_helper' => 
      [
        'array_permissions' => 'Używanie Access Helper z tablicą nazw uprawnień lub identyfikatorów, w których użytkownik musi posiadać wszystko.',
        'array_permissions_not' => 'Korzystanie z Access Helper z tablicą nazw uprawnień lub identyfikatorów, w których użytkownik nie musi posiadać wszystkich.',
        'array_roles' => 'Korzystanie z Access Helper z tablicą nazw ról lub identyfikatorów, w których użytkownik musi posiadać wszystko.',
        'array_roles_not' => 'Korzystanie z Access Helper z tablicą nazw ról lub identyfikatorów, w których użytkownik nie musi posiadać wszystkich.',
        'permission_id' => 'Korzystanie z Access Helper z identyfikatorem uprawnień',
        'permission_name' => 'Korzystanie z Access Helper z nazwą uprawnienia',
        'role_id' => 'Korzystanie z Access Helper z identyfikatorem roli',
        'role_name' => 'Używanie programu Access Helper z nazwą roli',
      ],
      'view_console_it_works' => 'Wyświetl konsolę, powinieneś zobaczyć „to działa!” który pochodzi z FrontendController @ index',
      'you_can_see_because' => 'Możesz to zobaczyć, ponieważ masz rolę „: rola”!',
      'you_can_see_because_permission' => 'Możesz to zobaczyć, ponieważ masz pozwolenie „: pozwolenie”!',
    ],
    'user' => [
      'change_email_notice' => 'Jeśli zmienisz swój adres e-mail, będziesz wylogowany do momentu potwierdzenia nowego adresu e-mail.',
      'email_changed_notice' => 'Musisz potwierdzić swój nowy adres e-mail, aby móc się ponownie zalogować.',
      'profile_updated' => 'Profil pomyślnie zaktualizowany.',
      'password_updated' => 'Hasło zostało pomyślnie zaktualizowane.',
    ],
    'welcome_to' => 'Witamy w: miejscu',
  ],
];