<?php 
return [
  'backend' => [
    'access' => [
      'users' => 
      [
        'delete_user_confirm' => '您确定要永久删除该用户吗？在应用程序中引用该用户ID的任何位置都很可能会出错。请您自担风险。无法撤消。',
        'if_confirmed_off' => '（如果确认关闭）',
        'restore_user_confirm' => '将此用户还原到原始状态？',
      ],
    ],
    'dashboard' => [
      'title' => 'SuperAdmin管理仪表板',
      'welcome' => '欢迎',
    ],
    'general' => [
      'all_rights_reserved' => '版权所有。',
      'are_you_sure' => '你确定要这么做吗？',
      'boilerplate_link' => '玫瑰帐单',
      'continue' => '继续',
      'member_since' => '会员自',
      'minutes' => '分钟',
      'search_placeholder' => '搜索...',
      'timeout' => '由于您没有进行任何活动，因此出于安全原因您已自动退出',
      'see_all' => 
      [
        'messages' => '查看所有讯息',
        'notifications' => '查看全部',
        'tasks' => '查看所有任务',
      ],
      'status' => 
      [
        'online' => '线上',
        'offline' => '离线',
      ],
      'you_have' => 
      [
        'messages' => '{0}您没有消息| {1}您有1条消息| [2，Inf]您有：number条消息',
        'notifications' => '{0}您没有通知| {1}您有1条通知| [2，Inf]您有：number条通知',
        'tasks' => '{0}您没有任务| {1}您有1个任务| [2，Inf]您有：number个任务',
      ],
    ],
    'search' => [
      'empty' => '请输入一个搜索词。',
      'incomplete' => '您必须为此系统编写自己的搜索逻辑。',
      'title' => '搜索结果',
      'results' => '：query的搜索结果',
    ],
    'welcome' => '欢迎',
  ],
  'emails' => [
    'auth' => [
      'error' => '哎呀！',
      'greeting' => '你好！',
      'regards' => '问候，',
      'trouble_clicking_button' => '如果您在单击“：action_text”按钮时遇到问题，请复制以下网址并将其粘贴到网络浏览器中：',
      'thank_you_for_using_app' => '感谢您使用我们的应用程序！',
      'password_reset_subject' => '重设密码',
      'password_cause_of_email' => '您收到此电子邮件是因为我们收到了您帐户的密码重置请求。',
      'password_if_not_requested' => '如果您不要求重设密码，则无需采取进一步措施。',
      'reset_password' => '点击这里重设密码',
      'click_to_confirm' => '点击此处确认您的帐户：',
    ],
  ],
  'frontend' => [
    'test' => '测试',
    'tests' => [
      'based_on' => 
      [
        'permission' => '基于权限-',
        'role' => '基于角色-',
      ],
      'js_injected_from_controller' => '从控制器注入的Javascript',
      'using_blade_extensions' => '使用刀片扩展',
      'using_access_helper' => 
      [
        'array_permissions' => '在用户确实拥有全部权限的情况下，使用带有权限名称或ID数组的Access Helper。',
        'array_permissions_not' => '在用户不必全部拥有权限名称或ID的情况下使用Access Helper。',
        'array_roles' => '在用户确实拥有全部权限的情况下，将Access Helper与角色名称或ID数组配合使用。',
        'array_roles_not' => '在用户不必全部拥有的情况下，将Access Helper与角色名称或ID数组配合使用。',
        'permission_id' => '使用具有权限ID的Access Helper',
        'permission_name' => '使用具有权限名称的Access Helper',
        'role_id' => '使用具有角色ID的Access Helper',
        'role_name' => '将Access Helper与角色名称一起使用',
      ],
      'view_console_it_works' => '在查看控制台中，您应该看到“它有效！” 这来自FrontendController @ index',
      'you_can_see_because' => '您可以看到这是因为您具有“：role”角色！',
      'you_can_see_because_permission' => '您可以看到这是因为您具有“：permission”的许可！',
    ],
    'user' => [
      'change_email_notice' => '如果更改电子邮件，您将注销，直到确认新的电子邮件地址。',
      'email_changed_notice' => '您必须先确认新的电子邮件地址，然后才能再次登录。',
      'profile_updated' => '个人资料已成功更新。',
      'password_updated' => '密码已成功更新。',
    ],
    'welcome_to' => '欢迎来到：place',
  ],
];