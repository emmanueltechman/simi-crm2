<?php 
return [
  'backend' => [
    'access' => [
      'users' => 
      [
        'delete_user_confirm' => 'このユーザーを完全に削除してもよろしいですか？このユーザーのIDを参照するアプリケーションのどこでも、エラーが発生する可能性が高くなります。ご自身の責任で進めてください。これは元に戻せません。',
        'if_confirmed_off' => '（確認済みがオフの場合）',
        'restore_user_confirm' => 'このユーザーを元の状態に復元しますか？',
      ],
    ],
    'dashboard' => [
      'title' => 'SuperAdmin管理ダッシュボード',
      'welcome' => 'ようこそ',
    ],
    'general' => [
      'all_rights_reserved' => '全著作権所有。',
      'are_you_sure' => 'これを実行してもよろしいですか？',
      'boilerplate_link' => 'ローズビリング',
      'continue' => '継続する',
      'member_since' => '以来のメンバー',
      'minutes' => '数分',
      'search_placeholder' => '探す...',
      'timeout' => 'でアクティビティがなかったため、セキュリティ上の理由で自動的にログアウトされました',
      'see_all' => 
      [
        'messages' => 'すべてのメッセージを見る',
        'notifications' => 'すべて見る',
        'tasks' => 'すべてのタスクを表示',
      ],
      'status' => 
      [
        'online' => 'オンライン',
        'offline' => 'オフライン',
      ],
      'you_have' => 
      [
        'messages' => '{0}メッセージがありません| {1}メッセージが1つあります| [2、Inf]メッセージがあります：number',
        'notifications' => '{0}通知がありません| {1}通知が1つあります| [2、Inf]通知があります：number件',
        'tasks' => '{0}タスクがありません| {1}タスクが1つあります| [2、Inf]：number個のタスクがあります',
      ],
    ],
    'search' => [
      'empty' => '検索語を入力してください。',
      'incomplete' => 'このシステム用に独自の検索ロジックを作成する必要があります。',
      'title' => 'の検索結果',
      'results' => '：queryの検索結果',
    ],
    'welcome' => 'ようこそ',
  ],
  'emails' => [
    'auth' => [
      'error' => 'おっと！',
      'greeting' => 'こんにちは！',
      'regards' => 'よろしく、',
      'trouble_clicking_button' => '「：action_text」ボタンをクリックできない場合は、以下のURLをコピーしてWebブラウザーに貼り付けてください。',
      'thank_you_for_using_app' => '私たちのアプリケーションをご利用いただきありがとうございます！',
      'password_reset_subject' => 'パスワードを再設定する',
      'password_cause_of_email' => 'アカウントのパスワードリセットリクエストを受け取ったため、このメールを受信して​​います。',
      'password_if_not_requested' => 'パスワードのリセットを要求しなかった場合、それ以上のアクションは不要です。',
      'reset_password' => 'パスワードをリセットするにはここをクリックしてください',
      'click_to_confirm' => 'アカウントを確認するにはここをクリックしてください：',
    ],
  ],
  'frontend' => [
    'test' => 'テスト',
    'tests' => [
      'based_on' => 
      [
        'permission' => '許可ベース-',
        'role' => 'ロールベース-',
      ],
      'js_injected_from_controller' => 'コントローラーから注入されたJavaScript',
      'using_blade_extensions' => 'ブレードエクステンションの使用',
      'using_access_helper' => 
      [
        'array_permissions' => 'ユーザーがすべてを所有する必要のあるアクセス許可名またはIDの配列でAccess Helperを使用する。',
        'array_permissions_not' => 'ユーザーがすべてを所有する必要のないアクセス許可名またはIDの配列でAccess Helperを使用する。',
        'array_roles' => 'ユーザーがすべてを所有する必要があるロール名またはIDの配列でAccess Helperを使用する。',
        'array_roles_not' => 'ユーザーがすべてを所有する必要がないロール名またはIDの配列でAccess Helperを使用する。',
        'permission_id' => 'アクセスヘルパーとアクセス許可IDの使用',
        'permission_name' => 'アクセスヘルパーと権限名を使用する',
        'role_id' => 'ロールIDでアクセスヘルパーを使用する',
        'role_name' => 'ロール名でのアクセスヘルパーの使用',
      ],
      'view_console_it_works' => 'コンソールを表示すると、「動作する！」と表示されるはずです。 FrontendController @ indexから来ています',
      'you_can_see_because' => '「：role」の役割があるため、これを見ることができます！',
      'you_can_see_because_permission' => '「：permission」の許可があるため、これを見ることができます！',
    ],
    'user' => [
      'change_email_notice' => '電子メールを変更すると、新しい電子メールアドレスを確認するまでログアウトされます。',
      'email_changed_notice' => '再度ログインする前に、新しい電子メールアドレスを確認する必要があります。',
      'profile_updated' => 'プロファイルが正常に更新されました。',
      'password_updated' => 'パスワードが正常に更新されました。',
    ],
    'welcome_to' => '：placeへようこそ',
  ],
];