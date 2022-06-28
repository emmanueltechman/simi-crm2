<?php 
return [
  'backend' => [
    'access' => [
      'users' => 
      [
        'delete_user_confirm' => 'Bạn có chắc chắn muốn xóa người dùng này vĩnh viễn? Bất cứ nơi nào trong ứng dụng tham chiếu id của người dùng này rất có thể sẽ xảy ra lỗi. Tiến hành có nguy cơ của riêng bạn. Điều này không thể được thực hiện.',
        'if_confirmed_off' => '(Nếu xác nhận là tắt)',
        'restore_user_confirm' => 'Khôi phục người dùng này về trạng thái ban đầu?',
      ],
    ],
    'dashboard' => [
      'title' => 'Bảng điều khiển quản trị SuperAdmin',
      'welcome' => 'Chào mừng bạn',
    ],
    'general' => [
      'all_rights_reserved' => 'Đã đăng ký Bản quyền.',
      'are_you_sure' => 'Bạn có chắc chắn muốn làm điều này?',
      'boilerplate_link' => 'Hóa đơn hoa hồng',
      'continue' => 'Tiếp tục',
      'member_since' => 'Thành viên từ',
      'minutes' => 'phút',
      'search_placeholder' => 'Tìm kiếm...',
      'timeout' => 'Bạn đã tự động đăng xuất vì lý do bảo mật vì bạn không có hoạt động nào trong',
      'see_all' => 
      [
        'messages' => 'Xem tất cả tin nhắn',
        'notifications' => 'Xem tất cả',
        'tasks' => 'Xem tất cả các nhiệm vụ',
      ],
      'status' => 
      [
        'online' => 'Trực tuyến',
        'offline' => 'Ngoại tuyến',
      ],
      'you_have' => 
      [
        'messages' => '{0} Bạn không có tin nhắn | {1} Bạn có 1 tin nhắn | [2, Inf] Bạn có: tin nhắn số',
        'notifications' => '{0} Bạn không có thông báo | {1} Bạn có 1 thông báo | [2, Inf] Bạn có: thông báo số',
        'tasks' => '{0} Bạn không có nhiệm vụ | {1} Bạn có 1 nhiệm vụ | [2, Inf] Bạn có: nhiệm vụ số',
      ],
    ],
    'search' => [
      'empty' => 'Vui lòng nhập một thuật ngữ tìm kiếm.',
      'incomplete' => 'Bạn phải viết logic tìm kiếm của riêng bạn cho hệ thống này.',
      'title' => 'kết quả tìm kiếm',
      'results' => 'Kết quả tìm kiếm cho: truy vấn',
    ],
    'welcome' => 'Chào mừng bạn',
  ],
  'emails' => [
    'auth' => [
      'error' => 'Rất tiếc!',
      'greeting' => 'Xin chào!',
      'regards' => 'Trân trọng,',
      'trouble_clicking_button' => 'Nếu bạn gặp sự cố khi nhấp vào nút ": hành động", hãy sao chép và dán URL bên dưới vào trình duyệt web của bạn:',
      'thank_you_for_using_app' => 'Cảm ơn bạn đã sử dụng ứng dụng của chúng tôi!',
      'password_reset_subject' => 'Đặt lại mật khẩu',
      'password_cause_of_email' => 'Bạn đang nhận được email này vì chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.',
      'password_if_not_requested' => 'Nếu bạn không yêu cầu đặt lại mật khẩu, không cần thực hiện thêm hành động nào.',
      'reset_password' => 'Nhấn vào đây để đặt lại mật khẩu của bạn',
      'click_to_confirm' => 'Nhấn vào đây để xác nhận tài khoản của bạn:',
    ],
  ],
  'frontend' => [
    'test' => 'Kiểm tra',
    'tests' => [
      'based_on' => 
      [
        'permission' => 'Dựa trên sự cho phép -',
        'role' => 'Dựa trên vai trò -',
      ],
      'js_injected_from_controller' => 'Javascript được tiêm từ bộ điều khiển',
      'using_blade_extensions' => 'Sử dụng tiện ích mở rộng Blade',
      'using_access_helper' => 
      [
        'array_permissions' => 'Sử dụng Trình trợ giúp truy cập với Mảng tên quyền hoặc ID mà người dùng phải sở hữu tất cả.',
        'array_permissions_not' => 'Sử dụng Trình trợ giúp truy cập với Mảng tên quyền hoặc ID mà người dùng không phải sở hữu tất cả.',
        'array_roles' => 'Sử dụng Trình trợ giúp truy cập với Mảng tên vai trò hoặc ID "nơi người dùng phải sở hữu tất cả.',
        'array_roles_not' => 'Sử dụng Trình trợ giúp truy cập với Mảng tên vai trò hoặc ID "mà người dùng không phải sở hữu tất cả.',
        'permission_id' => 'Sử dụng Trình trợ giúp truy cập với ID quyền',
        'permission_name' => 'Sử dụng Trình trợ giúp truy cập với Tên quyền',
        'role_id' => 'Sử dụng Trình trợ giúp truy cập với ID vai trò',
        'role_name' => 'Sử dụng Trình trợ giúp truy cập với Tên vai trò',
      ],
      'view_console_it_works' => 'Xem bảng điều khiển, bạn sẽ thấy "nó hoạt động!" vốn đến từ FrontendControll @ index',
      'you_can_see_because' => 'Bạn có thể thấy điều này bởi vì bạn có vai trò ": vai trò"!',
      'you_can_see_because_permission' => 'Bạn có thể thấy điều này bởi vì bạn có sự cho phép của ": quyền"!',
    ],
    'user' => [
      'change_email_notice' => 'Nếu bạn thay đổi e-mail, bạn sẽ đăng xuất cho đến khi bạn xác nhận địa chỉ e-mail mới của mình.',
      'email_changed_notice' => 'Bạn phải xác nhận địa chỉ e-mail mới trước khi bạn có thể đăng nhập lại.',
      'profile_updated' => 'Hồ sơ được cập nhật thành công.',
      'password_updated' => 'Mật khẩu được cập nhật thành công.',
    ],
    'welcome_to' => 'Chào mừng đến với: nơi',
  ],
];