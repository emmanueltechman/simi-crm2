<?php 
return [
  'backend' => [
    'access' => [
      'users' => 
      [
        'delete_user_confirm' => 'Anda yakin ingin menghapus pengguna ini secara permanen? Di mana saja di aplikasi yang mereferensikan id pengguna ini kemungkinan besar akan kesalahan. Lanjutkan dengan risiko Anda sendiri. Ini tidak dapat dilakukan.',
        'if_confirmed_off' => '(Jika dikonfirmasi tidak aktif)',
        'restore_user_confirm' => 'Pulihkan pengguna ini ke keadaan semula?',
      ],
    ],
    'dashboard' => [
      'title' => 'Dasbor Administratif SuperAdmin',
      'welcome' => 'Selamat datang',
    ],
    'general' => [
      'all_rights_reserved' => 'Seluruh hak cipta.',
      'are_you_sure' => 'Anda yakin ingin melakukan ini?',
      'boilerplate_link' => 'Penagihan Mawar',
      'continue' => 'Terus',
      'member_since' => 'Anggota Sejak',
      'minutes' => 'menit',
      'search_placeholder' => 'Cari...',
      'timeout' => 'Anda secara otomatis keluar karena alasan keamanan karena Anda tidak memiliki aktivitas di',
      'see_all' => 
      [
        'messages' => 'Lihat semua pesan',
        'notifications' => 'Lihat semua',
        'tasks' => 'Lihat semua tugas',
      ],
      'status' => 
      [
        'online' => 'On line',
        'offline' => 'Offline',
      ],
      'you_have' => 
      [
        'messages' => '{0} Anda tidak punya pesan | {1} Anda punya 1 pesan | [2, Inf] Anda punya: nomor pesan',
        'notifications' => '{0} Anda tidak punya notifikasi | {1} Anda punya 1 notifikasi | [2, Inf] Anda punya: notifikasi nomor',
        'tasks' => '{0} Anda tidak punya tugas | {1} Anda punya 1 tugas | [2, Inf] Anda punya: tugas nomor',
      ],
    ],
    'search' => [
      'empty' => 'Silakan masukkan istilah pencarian.',
      'incomplete' => 'Anda harus menulis logika pencarian Anda sendiri untuk sistem ini.',
      'title' => 'Hasil Pencarian',
      'results' => 'Hasil Pencarian untuk: permintaan',
    ],
    'welcome' => 'Selamat datang',
  ],
  'emails' => [
    'auth' => [
      'error' => 'Aduh!',
      'greeting' => 'Halo!',
      'regards' => 'Salam,',
      'trouble_clicking_button' => 'Jika Anda mengalami kesulitan mengklik tombol ": action_text", salin dan tempel URL di bawah ini ke browser web Anda:',
      'thank_you_for_using_app' => 'Terima kasih telah menggunakan aplikasi kami!',
      'password_reset_subject' => 'Setel Ulang Kata Sandi',
      'password_cause_of_email' => 'Anda menerima email ini karena kami menerima permintaan pengaturan ulang kata sandi untuk akun Anda.',
      'password_if_not_requested' => 'Jika Anda tidak meminta pengaturan ulang kata sandi, tidak ada tindakan lebih lanjut yang diperlukan.',
      'reset_password' => 'Klik di sini untuk mengatur ulang kata sandi Anda',
      'click_to_confirm' => 'Klik di sini untuk mengonfirmasi akun Anda:',
    ],
  ],
  'frontend' => [
    'test' => 'Uji',
    'tests' => [
      'based_on' => 
      [
        'permission' => 'Berbasis Izin -',
        'role' => 'Berbasis Peran -',
      ],
      'js_injected_from_controller' => 'Javascript Disuntikkan dari Controller',
      'using_blade_extensions' => 'Menggunakan Ekstensi Blade',
      'using_access_helper' => 
      [
        'array_permissions' => 'Menggunakan Access Helper dengan Array Nama Izin atau ID di mana pengguna harus memiliki semuanya.',
        'array_permissions_not' => 'Menggunakan Access Helper dengan Array Nama Izin atau ID di mana pengguna tidak harus memiliki semuanya.',
        'array_roles' => 'Menggunakan Access Helper dengan Array of Role Names atau ID "s di mana pengguna harus memiliki semuanya.',
        'array_roles_not' => 'Menggunakan Access Helper dengan Array of Role Names atau ID "s di mana pengguna tidak harus memiliki semuanya.',
        'permission_id' => 'Menggunakan Access Helper dengan ID Izin',
        'permission_name' => 'Menggunakan Access Helper dengan Nama Izin',
        'role_id' => 'Menggunakan Access Helper dengan Peran ID',
        'role_name' => 'Menggunakan Access Helper dengan Nama Peran',
      ],
      'view_console_it_works' => 'Lihat konsol, Anda akan melihat "itu berfungsi!" yang berasal dari FrontendController @ index',
      'you_can_see_because' => 'Anda dapat melihat ini karena Anda memiliki peran ": peran"!',
      'you_can_see_because_permission' => 'Anda dapat melihat ini karena Anda memiliki izin ": izin"!',
    ],
    'user' => [
      'change_email_notice' => 'Jika Anda mengubah email Anda, Anda akan keluar sampai Anda mengkonfirmasi alamat email baru Anda.',
      'email_changed_notice' => 'Anda harus mengkonfirmasi alamat email baru Anda sebelum dapat masuk lagi.',
      'profile_updated' => 'Profil berhasil diperbarui.',
      'password_updated' => 'Kata sandi berhasil diperbarui.',
    ],
    'welcome_to' => 'Selamat datang di: place',
  ],
];