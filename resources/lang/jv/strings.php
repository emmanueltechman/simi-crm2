<?php 
return [
  'backend' => [
    'access' => [
      'users' => 
      [
        'delete_user_confirm' => 'Apa sampeyan pengin mbusak pangguna iki kanthi permanen? Nang endi wae ing aplikasi sing ngubungake id pangguna iki bakal paling gampang kesalahan. Terusake kanthi resiko dhewe, iki ora bisa rampung.',
        'if_confirmed_off' => '(Yen dikonfirmasi mati)',
        'restore_user_confirm' => 'Mulihake pangguna iki kanggo negara asline?',
      ],
    ],
    'dashboard' => [
      'title' => 'Dashboard Administratif SuperAdmin',
      'welcome' => 'Sugeng rawuh',
    ],
    'general' => [
      'all_rights_reserved' => 'Kabeh hak dilindhungi undhang-undhang.',
      'are_you_sure' => 'Apa sampeyan pengin nggawe iki?',
      'boilerplate_link' => 'Rose Billing',
      'continue' => 'Terusake',
      'member_since' => 'Anggota wiwit',
      'minutes' => 'menit',
      'search_placeholder' => 'Nggoleki ...',
      'timeout' => 'Sampeyan kanthi otomatis mlebu amarga alasan keamanan amarga sampeyan durung aktif',
      'see_all' => 
      [
        'messages' => 'Deleng kabeh pesen',
        'notifications' => 'Deleng kabeh',
        'tasks' => 'Ndeleng kabeh tugas',
      ],
      'status' => 
      [
        'online' => 'Nyambung',
        'offline' => 'Offline',
      ],
      'you_have' => 
      [
        'messages' => '{0} Sampeyan ora duwe pesen | {1} Sampeyan duwe 1 pesen | [2, Inf] Sampeyan duwe: pesen nomer',
        'notifications' => '{0} Sampeyan ora duwe kabar | {1} Sampeyan duwe 1 kabar | [2, Inf] Sampeyan duwe: notifikasi nomer',
        'tasks' => '{0} Sampeyan ora duwe tugas | {1} Sampeyan duwe 1 tugas | [2, Inf] Sampeyan duwe: tugas nomer',
      ],
    ],
    'search' => [
      'empty' => 'Mangga ketik istilah telusuran.',
      'incomplete' => 'Sampeyan kudu nulis logika telusuran dhewe kanggo sistem iki.',
      'title' => 'Asil Panelusuran',
      'results' => 'Asil Panelusuran kanggo: pitakon',
    ],
    'welcome' => 'Sugeng rawuh',
  ],
  'emails' => [
    'auth' => [
      'error' => 'Sapa!',
      'greeting' => 'Halo!',
      'regards' => 'Salam,',
      'trouble_clicking_button' => 'Yen sampeyan nemoni masalah ngeklik tombol ": action_text", nyalin lan nempel URL ing ngisor iki menyang browser web sampeyan:',
      'thank_you_for_using_app' => 'Matur nuwun kanggo nggunakake aplikasi kita!',
      'password_reset_subject' => 'Reset Pangguna Sandi',
      'password_cause_of_email' => 'Sampeyan nampa email iki amarga kita nampa panjalukan tembung sandhi kanggo akun sampeyan.',
      'password_if_not_requested' => 'Yen sampeyan ora njaluk ngreset sandhi, ora ana sing dibutuhake.',
      'reset_password' => 'Klik ing kene kanggo ngreset sandhi',
      'click_to_confirm' => 'Klik ing kene kanggo konfirmasi akun:',
    ],
  ],
  'frontend' => [
    'test' => 'Tes',
    'tests' => [
      'based_on' => 
      [
        'permission' => 'Ijin adhedhasar -',
        'role' => 'Dhasar Peranan -',
      ],
      'js_injected_from_controller' => 'Javascript Disuntik saka Controller',
      'using_blade_extensions' => 'Nggunakake Ekstensi Blade',
      'using_access_helper' => 
      [
        'array_permissions' => 'Nggunakake Akses Helper nganggo Jeneng Panggilan Ijin utawa ID ing endi pangguna kudu duwe.',
        'array_permissions_not' => 'Nggunakake Akses Helper nganggo Jeneng Panggilan Ijin utawa ID ing endi pangguna ora duwe kabeh.',
        'array_roles' => 'Nggunakake Akses Helper nganggo Array of Role Names utawa ID ing endi pangguna kudu duwe.',
        'array_roles_not' => 'Nggunakake Akses Helper nganggo Array of Role Names utawa ID ing endi pangguna ora duwe kabeh.',
        'permission_id' => 'Nggunakake Akses Helper nganggo ID Ijin',
        'permission_name' => 'Nggunakake Akses Helper kanthi Jeneng Ijin',
        'role_id' => 'Nggunakake Akses Helper nganggo ID Peran',
        'role_name' => 'Nggunakake Akses Helper kanthi Jeneng Peran',
      ],
      'view_console_it_works' => 'Ndeleng konsol, sampeyan kudu ndeleng "kerjane!" sing teka saka FrontendController @ indeks',
      'you_can_see_because' => 'Sampeyan bisa ndeleng iki amarga sampeyan duwe peran ": peran"!',
      'you_can_see_because_permission' => 'Sampeyan bisa ndeleng iki amarga sampeyan duwe ijin ": ijin"!',
    ],
    'user' => [
      'change_email_notice' => 'Yen sampeyan ngganti email, sampeyan bakal mlebu nganti sampeyan konfirmasi alamat e-mail anyar.',
      'email_changed_notice' => 'Sampeyan kudu konfirmasi alamat e-mail anyar sampeyan sadurunge bisa mlebu maneh.',
      'profile_updated' => 'Profil sukses karo nganyari.',
      'password_updated' => 'Sandi sandi wis nganyari.',
    ],
    'welcome_to' => 'Sugeng rawuh: papan',
  ],
];