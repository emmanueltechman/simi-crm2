<?php 
return [
  'backend' => [
    'access' => [
      'users' => 
      [
        'delete_user_confirm' => '이 사용자를 완전히 삭제 하시겠습니까? 이 사용자의 ID를 참조하는 응용 프로그램의 어느 곳에서나 오류가 발생했을 가능성이 높습니다. 사용자가 위험을 감수해야합니다.',
        'if_confirmed_off' => '(확인 된 경우)',
        'restore_user_confirm' => '이 사용자를 원래 상태로 복원 하시겠습니까?',
      ],
    ],
    'dashboard' => [
      'title' => 'SuperAdmin 관리 대시 보드',
      'welcome' => '어서 오십시오',
    ],
    'general' => [
      'all_rights_reserved' => '판권 소유.',
      'are_you_sure' => '이 작업을 수행 하시겠습니까?',
      'boilerplate_link' => '로즈 빌링',
      'continue' => '계속하다',
      'member_since' => '회원 가입일',
      'minutes' => '의사록',
      'search_placeholder' => '검색...',
      'timeout' => '활동이 없기 때문에 보안상의 이유로 자동 로그 아웃되었습니다.',
      'see_all' => 
      [
        'messages' => '모든 메시지보기',
        'notifications' => '모두보기',
        'tasks' => '모든 작업보기',
      ],
      'status' => 
      [
        'online' => '온라인',
        'offline' => '오프라인',
      ],
      'you_have' => 
      [
        'messages' => '{0} 메시지가 없습니다 | {1} 메시지가 하나 있습니다 | [2, Inf] : 번호 메시지',
        'notifications' => '{0} 알림이 없습니다 | {1} 알림이 하나 있습니다 | [2, Inf] 있습니다 : 번호 알림',
        'tasks' => '{0} 당신은 할 일이 없습니다 | {1} 당신은 할 일이 하나 있습니다 | [2, Inf] 당신은 있습니다 :',
      ],
    ],
    'search' => [
      'empty' => '검색어를 입력하십시오.',
      'incomplete' => '이 시스템에 대한 고유 한 검색 논리를 작성해야합니다.',
      'title' => '검색 결과',
      'results' => '에 대한 검색 결과 : query',
    ],
    'welcome' => '어서 오십시오',
  ],
  'emails' => [
    'auth' => [
      'error' => '으악!',
      'greeting' => '여보세요!',
      'regards' => '문안 인사,',
      'trouble_clicking_button' => '": action_text"버튼을 클릭하는 데 문제가있는 경우 아래 URL을 복사하여 웹 브라우저에 붙여 넣으십시오.',
      'thank_you_for_using_app' => '우리의 응용 프로그램을 이용해 주셔서 감사합니다!',
      'password_reset_subject' => '암호를 재설정',
      'password_cause_of_email' => '귀하의 계정에 대한 비밀번호 재설정 요청이 접수되어이 이메일을 수신하고 있습니다.',
      'password_if_not_requested' => '비밀번호 재설정을 요청하지 않은 경우 추가 조치가 필요하지 않습니다.',
      'reset_password' => '비밀번호를 재설정하려면 여기를 클릭하십시오',
      'click_to_confirm' => '계정을 확인하려면 여기를 클릭하십시오.',
    ],
  ],
  'frontend' => [
    'test' => '테스트',
    'tests' => [
      'based_on' => 
      [
        'permission' => '권한 기반-',
        'role' => '역할 기반-',
      ],
      'js_injected_from_controller' => '컨트롤러에서 자바 스크립트 삽입',
      'using_blade_extensions' => '블레이드 확장 사용',
      'using_access_helper' => 
      [
        'array_permissions' => '사용자가 모든 것을 소유해야하는 권한 이름 또는 ID 배열로 Access Helper 사용',
        'array_permissions_not' => '사용자가 모든 것을 소유 할 필요가없는 일련의 권한 이름 또는 ID "와 함께 액세스 헬퍼 사용',
        'array_roles' => '사용자가 모든 것을 소유해야하는 역할 이름 또는 ID 배열로 Access Helper 사용',
        'array_roles_not' => '사용자가 모든 것을 소유 할 필요가없는 역할 이름 또는 ID 배열로 Access Helper 사용',
        'permission_id' => '권한 ID로 액세스 헬퍼 사용',
        'permission_name' => '권한 이름으로 액세스 헬퍼 사용',
        'role_id' => '역할 ID와 함께 액세스 도우미 사용',
        'role_name' => '역할 이름과 함께 액세스 도우미 사용',
      ],
      'view_console_it_works' => '콘솔보기, "작동합니다!" FrontendController @ index에서 온 것입니다.',
      'you_can_see_because' => '": role"역할이 있기 때문에 이것을 볼 수 있습니다!',
      'you_can_see_because_permission' => '": permission"권한이 있기 때문에 이것을 볼 수 있습니다!',
    ],
    'user' => [
      'change_email_notice' => '이메일을 변경하면 새 이메일 주소를 확인할 때까지 로그 아웃됩니다.',
      'email_changed_notice' => '다시 로그인하기 전에 새 이메일 주소를 확인해야합니다.',
      'profile_updated' => '프로필이 성공적으로 업데이트되었습니다.',
      'password_updated' => '비밀번호가 성공적으로 업데이트되었습니다.',
    ],
    'welcome_to' => ': place에 오신 것을 환영합니다',
  ],
];