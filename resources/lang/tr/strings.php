<?php 
return [
  'backend' => [
    'access' => [
      'users' => 
      [
        'delete_user_confirm' => 'Bu kullanıcıyı kalıcı olarak silmek istediğinizden emin misiniz? Uygulamada bu kullanıcının kimliğine başvuru yapan herhangi bir yerde büyük olasılıkla hata olacaktır. Kendi sorumluluğunuzda ilerleyin.',
        'if_confirmed_off' => '(Onaylandığında kapalıysa)',
        'restore_user_confirm' => 'Bu kullanıcı orijinal durumuna geri yüklensin mi?',
      ],
    ],
    'dashboard' => [
      'title' => 'SuperAdmin Yönetim Panosu',
      'welcome' => 'Hoşgeldiniz',
    ],
    'general' => [
      'all_rights_reserved' => 'Tüm hakları Saklıdır.',
      'are_you_sure' => 'Bunu yapmak istediğinizden emin misiniz?',
      'boilerplate_link' => 'Gül Faturalandırma',
      'continue' => 'Devam et',
      'member_since' => 'Den beri üye',
      'minutes' => 'dakika',
      'search_placeholder' => 'Arama...',
      'timeout' => 'Güvenlik etkinliğiniz olmadığı için güvenlik nedeniyle otomatik olarak çıkış yaptınız',
      'see_all' => 
      [
        'messages' => 'Tüm mesajları görün',
        'notifications' => 'Hepsini gör',
        'tasks' => 'Tüm görevleri görüntüle',
      ],
      'status' => 
      [
        'online' => 'İnternet üzerinden',
        'offline' => 'Çevrim',
      ],
      'you_have' => 
      [
        'messages' => '{0} Mesajınız yok | {1} 1 mesajınız var | [2, Inf] Var: sayı mesajları',
        'notifications' => '{0} Bildiriminiz yok | {1} 1 bildiriminiz var | [2, Inf] Sahip olduğunuz: sayı bildirimleri',
        'tasks' => '{0} Görevleriniz yok | {1} 1 göreviniz var | [2, Inf] Sahip olduğunuz: sayı görevleri',
      ],
    ],
    'search' => [
      'empty' => 'Lütfen bir arama terimi girin.',
      'incomplete' => 'Bu sistem için kendi arama mantığınızı yazmalısınız.',
      'title' => 'Arama Sonuçları',
      'results' => 'İçin arama sonuçları: sorgu',
    ],
    'welcome' => 'Hoşgeldiniz',
  ],
  'emails' => [
    'auth' => [
      'error' => 'Tüh!',
      'greeting' => 'Merhaba!',
      'regards' => 'Saygılarımızla,',
      'trouble_clicking_button' => '": Action_text" düğmesini tıklamakta sorun yaşıyorsanız, aşağıdaki URL"yi kopyalayıp web tarayıcınıza yapıştırın:',
      'thank_you_for_using_app' => 'Uygulamamızı kullandığınız için teşekkür ederiz!',
      'password_reset_subject' => 'Şifreyi yenile',
      'password_cause_of_email' => 'Hesabınız için bir şifre sıfırlama isteği aldığımız için bu e-postayı alıyorsunuz.',
      'password_if_not_requested' => 'Şifre sıfırlama talebinde bulunmadıysanız, başka bir işlem yapmanız gerekmez.',
      'reset_password' => 'Şifrenizi sıfırlamak için buraya tıklayın',
      'click_to_confirm' => 'Hesabınızı onaylamak için burayı tıklayın:',
    ],
  ],
  'frontend' => [
    'test' => 'Ölçek',
    'tests' => [
      'based_on' => 
      [
        'permission' => 'İzne Dayalı -',
        'role' => 'Rol Tabanlı -',
      ],
      'js_injected_from_controller' => 'Bir Denetleyiciden Javascript Eklendi',
      'using_blade_extensions' => 'Blade Uzantılarını Kullanma',
      'using_access_helper' => 
      [
        'array_permissions' => 'Kullanıcının hepsine sahip olması gereken Erişim Adları Dizisi veya Kimlik Dizileriyle Erişim Yardımcısı"nı kullanma.',
        'array_permissions_not' => 'Kullanıcının hepsine sahip olması gerekmeyen Erişim Adları Dizisi veya Kimlik Dizileriyle Erişim Yardımcısı"nı kullanma.',
        'array_roles' => 'Erişim Yardımcısı"nı kullanıcının her şeye sahip olması gereken Rol Adları Dizisi veya Kimlikleri ile kullanma.',
        'array_roles_not' => 'Kullanıcının herkese sahip olması gerekmediğinde Erişim Yardımcısını Rol Adları Dizisi veya Kimlikleriyle kullanma.',
        'permission_id' => 'Erişim Yardımcısını İzin Kimliği ile Kullanma',
        'permission_name' => 'Erişim Yardımcısını İzin Adıyla Kullanma',
        'role_id' => 'Rol Kimliği ile Erişim Yardımcısını Kullanma',
        'role_name' => 'Rol Adıyla Access Helper"ı Kullanma',
      ],
      'view_console_it_works' => 'Görünüm konsolu, "işe yarıyor!" FrontendController @ dizininden geliyor',
      'you_can_see_because' => 'Bunu görebilirsiniz, çünkü ": role" rolüne sahipsiniz!',
      'you_can_see_because_permission' => 'Bunu görebilirsiniz: ": izin" izniniz var!',
    ],
    'user' => [
      'change_email_notice' => 'E-postanızı değiştirirseniz, yeni e-posta adresinizi onaylayana kadar çıkış yaparsınız.',
      'email_changed_notice' => 'Tekrar giriş yapabilmeniz için yeni e-posta adresinizi onaylamanız gerekir.',
      'profile_updated' => 'Profil başarıyla güncellendi.',
      'password_updated' => 'Şifre başarıyla güncellendi.',
    ],
    'welcome_to' => 'Hoşgeldiniz: yer',
  ],
];