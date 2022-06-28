<?php 
return [
  'backend' => [
    'access' => [
      'users' => 
      [
        'delete_user_confirm' => 'Sigurado ka bang nais mong tanggalin nang permanente ang gumagamit na ito? Saanman sa application na tumutukoy sa id ng gumagamit na ito ay pinaka-malamang na error. Magpatuloy sa iyong sariling peligro. Hindi ito maaaring tapos na.',
        'if_confirmed_off' => '(Kung nakumpirma na naka-off)',
        'restore_user_confirm' => 'Ibalik ang gumagamit na ito sa orihinal na estado nito?',
      ],
    ],
    'dashboard' => [
      'title' => 'SuperAdmin Administrative Dashboard',
      'welcome' => 'Maligayang pagdating',
    ],
    'general' => [
      'all_rights_reserved' => 'Nakalaan ang Lahat ng Karapatan',
      'are_you_sure' => 'Sigurado ka bang nais mong gawin ito?',
      'boilerplate_link' => 'Rose Billing',
      'continue' => 'Magpatuloy',
      'member_since' => 'Miyembro mula noong',
      'minutes' => 'minuto',
      'search_placeholder' => 'Paghahanap ...',
      'timeout' => 'Awtomatikong naka-log out ka para sa mga kadahilanang pangseguridad dahil wala kang aktibidad',
      'see_all' => 
      [
        'messages' => 'Tingnan ang lahat ng mga mensahe',
        'notifications' => 'Tingnan lahat',
        'tasks' => 'Tingnan ang lahat ng mga gawain',
      ],
      'status' => 
      [
        'online' => 'Online',
        'offline' => 'Offline',
      ],
      'you_have' => 
      [
        'messages' => '{0} Wala kang mga mensahe | {1} Mayroon kang 1 mensahe | [2, Inf] Mayroon kang: mga mensahe ng numero',
        'notifications' => '{0} Wala kang mga abiso | {1} Mayroon kang isang abiso | [2, Inf] Mayroon kang: bilang mga abiso',
        'tasks' => '{0} Wala kang mga gawain | {1} Mayroon kang 1 gawain | [2, Inf] Mayroon kang: bilang ng mga gawain',
      ],
    ],
    'search' => [
      'empty' => 'Mangyaring magpasok ng term sa paghahanap.',
      'incomplete' => 'Dapat mong isulat ang iyong sariling lohika sa paghahanap para sa sistemang ito.',
      'title' => 'Mga Resulta ng Paghahanap',
      'results' => 'Mga Resulta sa Paghahanap para sa: query',
    ],
    'welcome' => 'Maligayang pagdating',
  ],
  'emails' => [
    'auth' => [
      'error' => 'Sinong!',
      'greeting' => 'Kamusta!',
      'regards' => 'Regards,',
      'trouble_clicking_button' => 'Kung nahihirapan kang mag-click sa pindutan ng ": action_text", kopyahin at ilagay ang URL sa ibaba sa iyong web browser:',
      'thank_you_for_using_app' => 'Salamat sa paggamit ng aming application!',
      'password_reset_subject' => 'I-reset ang Password',
      'password_cause_of_email' => 'Natatanggap mo ang email na ito dahil nakatanggap kami ng kahilingan sa pag-reset ng password para sa iyong account.',
      'password_if_not_requested' => 'Kung hindi ka humiling ng pag-reset ng password, hindi kinakailangan ang karagdagang pagkilos.',
      'reset_password' => 'Mag-click dito upang i-reset ang iyong password',
      'click_to_confirm' => 'Mag-click dito upang kumpirmahin ang iyong account:',
    ],
  ],
  'frontend' => [
    'test' => 'Pagsusulit',
    'tests' => [
      'based_on' => 
      [
        'permission' => 'Batay sa Pahintulot -',
        'role' => 'Batay sa Batay -',
      ],
      'js_injected_from_controller' => 'Ang Javascript Injected mula sa isang Controller',
      'using_blade_extensions' => 'Paggamit ng Mga Extension ng Blade',
      'using_access_helper' => 
      [
        'array_permissions' => 'Paggamit ng Access Helper na may Array ng Mga Pangalan ng Pahintulot o ID kung saan ang gumagamit ay kailangang magkaroon ng lahat.',
        'array_permissions_not' => 'Paggamit ng Access Helper na may Array ng Mga Pangalan ng Pahintulot o ID kung saan ang gumagamit ay hindi kailangang magkaroon ng lahat.',
        'array_roles' => 'Paggamit ng Access Helper na may Array ng Role Names o ID kung saan ang gumagamit ay kailangang magkaroon ng lahat.',
        'array_roles_not' => 'Paggamit ng Access Helper na may Array ng Role Names o ID kung saan ang gumagamit ay hindi kailangang magkaroon ng lahat.',
        'permission_id' => 'Paggamit ng Access Helper na may Pahintulot na ID',
        'permission_name' => 'Paggamit ng Access Helper na may Pangalan ng Pahintulot',
        'role_id' => 'Paggamit ng Access Helper na may Role ID',
        'role_name' => 'Paggamit ng Access Helper na may Pangalan ng Papel',
      ],
      'view_console_it_works' => 'Tingnan ang console, dapat mong makita ang "gumagana ito!" na nagmumula sa FrontendController @ index',
      'you_can_see_because' => 'Makikita mo ito dahil mayroon kang papel na ": role"!',
      'you_can_see_because_permission' => 'Maaari mong makita ito dahil mayroon kang pahintulot ng ": pahintulot"!',
    ],
    'user' => [
      'change_email_notice' => 'Kung binago mo ang iyong e-mail ay mai-log out ka hanggang sa kumpirmahin mo ang iyong bagong e-mail address.',
      'email_changed_notice' => 'Dapat mong kumpirmahin ang iyong bagong e-mail address bago ka makapag-log in muli.',
      'profile_updated' => 'Matagumpay na na-update ang profile.',
      'password_updated' => 'Matagumpay na na-update ang password.',
    ],
    'welcome_to' => 'Maligayang pagdating sa: lugar',
  ],
];