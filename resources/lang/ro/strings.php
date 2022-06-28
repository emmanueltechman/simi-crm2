<?php 
return [
  'backend' => [
    'access' => [
      'users' => 
      [
        'delete_user_confirm' => 'Sigur doriți să ștergeți definitiv acest utilizator? Oriunde în aplicația care face referire la ID-ul acestui utilizator, va fi cea mai probabilă eroare.',
        'if_confirmed_off' => '(Dacă confirmarea este oprită)',
        'restore_user_confirm' => 'Restabiliți acest utilizator la starea inițială?',
      ],
    ],
    'dashboard' => [
      'title' => 'Tabloul de bord administrativ SuperAdmin',
      'welcome' => 'Bine ati venit',
    ],
    'general' => [
      'all_rights_reserved' => 'Toate drepturile rezervate.',
      'are_you_sure' => 'Ești sigur că vrei să faci asta?',
      'boilerplate_link' => 'Rose Billing',
      'continue' => 'Continua',
      'member_since' => 'Membru din',
      'minutes' => 'minute',
      'search_placeholder' => 'Căutare...',
      'timeout' => 'Ai fost deconectat automat din motive de securitate, deoarece nu ai activat',
      'see_all' => 
      [
        'messages' => 'Vedeți toate mesajele',
        'notifications' => 'A vedea tot',
        'tasks' => 'Vizualizați toate sarcinile',
      ],
      'status' => 
      [
        'online' => 'Pe net',
        'offline' => 'Deconectat',
      ],
      'you_have' => 
      [
        'messages' => '{0} Nu aveți mesaje | {1} Aveți 1 mesaj | [2, Inf] Aveți: mesaje cu număr',
        'notifications' => '{0} Nu aveți notificări | {1} Aveți o notificare | [2, Inf] Aveți: notificări de număr',
        'tasks' => '{0} Nu aveți sarcini | {1} Aveți o sarcină | [2, Inf] Aveți: sarcini de număr',
      ],
    ],
    'search' => [
      'empty' => 'Vă rugăm să introduceți un termen de căutare.',
      'incomplete' => 'Trebuie să scrieți propria logică de căutare pentru acest sistem.',
      'title' => 'rezultatele cautarii',
      'results' => 'Rezultatele căutării pentru: interogare',
    ],
    'welcome' => 'Bine ati venit',
  ],
  'emails' => [
    'auth' => [
      'error' => 'Hopa!',
      'greeting' => 'Salut!',
      'regards' => 'Salutari,',
      'trouble_clicking_button' => 'Dacă aveți probleme să faceți clic pe butonul ": action_text", copiați și inserați adresa URL de mai jos în browserul dvs. Web:',
      'thank_you_for_using_app' => 'Vă mulțumim pentru utilizarea aplicației noastre!',
      'password_reset_subject' => 'Reseteaza parola',
      'password_cause_of_email' => 'Primești acest e-mail deoarece am primit o solicitare de resetare a parolei pentru contul tău.',
      'password_if_not_requested' => 'Dacă nu ați solicitat o resetare a parolei, nu este necesară nicio acțiune suplimentară.',
      'reset_password' => 'Faceți clic aici pentru a reseta parola',
      'click_to_confirm' => 'Faceți clic aici pentru a confirma contul dvs.:',
    ],
  ],
  'frontend' => [
    'test' => 'Test',
    'tests' => [
      'based_on' => 
      [
        'permission' => 'Bazat pe permis -',
        'role' => 'Bazat pe rol -',
      ],
      'js_injected_from_controller' => 'Javascript injectat de la un controler',
      'using_blade_extensions' => 'Utilizarea extensiilor de lamă',
      'using_access_helper' => 
      [
        'array_permissions' => 'Utilizarea Access Helper cu Array of Permission Names sau ID-uri unde utilizatorul trebuie să dețină toate.',
        'array_permissions_not' => 'Utilizarea Access Helper cu Array of Permission Names sau ID-uri în care utilizatorul nu trebuie să dețină toate.',
        'array_roles' => 'Folosind Access Helper cu Array of Nume Role sau ID-uri unde utilizatorul trebuie să dețină toate.',
        'array_roles_not' => 'Utilizarea Access Helper cu Array of Nume Role sau ID-uri în care utilizatorul nu trebuie să dețină toate.',
        'permission_id' => 'Utilizarea Access Helper cu permis de identificare',
        'permission_name' => 'Utilizarea Access Helper cu numele permisiunii',
        'role_id' => 'Utilizarea Access Helper cu rolul ID',
        'role_name' => 'Utilizarea Access Helper cu numele rolului',
      ],
      'view_console_it_works' => 'Vizualizați consola, ar trebui să vedeți „funcționează!” care provine din indexul FrontendController @',
      'you_can_see_because' => 'Puteți vedea acest lucru pentru că aveți rolul de „: rol”!',
      'you_can_see_because_permission' => 'Puteți vedea acest lucru deoarece aveți permisiunea „: permission”!',
    ],
    'user' => [
      'change_email_notice' => 'Dacă vă schimbați e-mailul, veți fi deconectat până când veți confirma noua dvs. adresă de e-mail.',
      'email_changed_notice' => 'Trebuie să confirmați noua dvs. adresă de e-mail înainte de a vă putea autentifica din nou.',
      'profile_updated' => 'Profilul a fost actualizat cu succes.',
      'password_updated' => 'Parola a fost actualizată cu succes.',
    ],
    'welcome_to' => 'Bine ați venit la: loc',
  ],
];