<?php 
return [
  'backend' => [
    'access' => [
      'users' => 
      [
        'delete_user_confirm' => '¿Estás seguro de que deseas eliminar este usuario de forma permanente? En cualquier lugar de la aplicación que haga referencia a la identificación de este usuario, es muy probable que se produzca un error. Proceda bajo su propio riesgo. Esto no se puede deshacer.',
        'if_confirmed_off' => '(Si se confirma está desactivado)',
        'restore_user_confirm' => '¿Restaurar este usuario a su estado original?',
      ],
    ],
    'dashboard' => [
      'title' => 'Panel Administrativo SuperAdmin',
      'welcome' => 'Bienvenido',
    ],
    'general' => [
      'all_rights_reserved' => 'Todos los derechos reservados.',
      'are_you_sure' => '¿Seguro que quieres hacer esto?',
      'boilerplate_link' => 'Rose Billing',
      'continue' => 'Seguir',
      'member_since' => 'Miembro desde',
      'minutes' => 'minutos',
      'search_placeholder' => 'Buscar...',
      'timeout' => 'Se cerró la sesión automáticamente por razones de seguridad ya que no tuvo actividad en',
      'see_all' => 
      [
        'messages' => 'Ver todos los mensajes',
        'notifications' => 'Ver todo',
        'tasks' => 'Ver todas las tareas',
      ],
      'status' => 
      [
        'online' => 'En línea',
        'offline' => 'Desconectado',
      ],
      'you_have' => 
      [
        'messages' => '{0} No tienes mensajes | {1} Tienes 1 mensaje | [2, Inf] Tienes: número de mensajes',
        'notifications' => '{0} No tienes notificaciones | {1} Tienes 1 notificación | [2, Inf] Tienes: número de notificaciones',
        'tasks' => '{0} No tienes tareas | {1} Tienes 1 tarea | [2, Inf] Tienes: tareas de número',
      ],
    ],
    'search' => [
      'empty' => 'Por favor, introduzca un término de búsqueda.',
      'incomplete' => 'Debe escribir su propia lógica de búsqueda para este sistema.',
      'title' => 'Resultados de la búsqueda',
      'results' => 'Resultados de búsqueda para: query',
    ],
    'welcome' => 'Bienvenido',
  ],
  'emails' => [
    'auth' => [
      'error' => 'Whoops!',
      'greeting' => '¡Hola!',
      'regards' => 'Saludos,',
      'trouble_clicking_button' => 'Si tiene problemas para hacer clic en el botón ": texto de acción", copie y pegue la siguiente URL en su navegador web:',
      'thank_you_for_using_app' => 'Gracias por usar nuestra aplicación!',
      'password_reset_subject' => 'Restablecer la contraseña',
      'password_cause_of_email' => 'Recibió este correo electrónico porque recibimos una solicitud de restablecimiento de contraseña para su cuenta.',
      'password_if_not_requested' => 'Si no solicitó un restablecimiento de contraseña, no se requiere ninguna otra acción.',
      'reset_password' => 'Haga clic aquí para restablecer la contraseña',
      'click_to_confirm' => 'Haga clic aquí para confirmar su cuenta:',
    ],
  ],
  'frontend' => [
    'test' => 'Prueba',
    'tests' => [
      'based_on' => 
      [
        'permission' => 'Permiso Basado -',
        'role' => 'Basado en roles',
      ],
      'js_injected_from_controller' => 'Javascript inyectado desde un controlador',
      'using_blade_extensions' => 'Usar extensiones de cuchilla',
      'using_access_helper' => 
      [
        'array_permissions' => 'Uso de Access Helper con Array of Permission Names o ID "s donde el usuario tiene que poseer todo.',
        'array_permissions_not' => 'Uso de Access Helper con Array of Permission Names o ID "s donde el usuario no tiene que poseerlo todo.',
        'array_roles' => 'Uso de Access Helper con una matriz de nombres de roles o ID "s donde el usuario tiene que poseer todo.',
        'array_roles_not' => 'Uso de Access Helper con una matriz de nombres de roles o ID "s donde el usuario no tiene que poseerlo todo.',
        'permission_id' => 'Uso de Access Helper con ID de permiso',
        'permission_name' => 'Uso de Access Helper con nombre de permiso',
        'role_id' => 'Uso de Access Helper con ID de rol',
        'role_name' => 'Uso de Access Helper con nombre de rol',
      ],
      'view_console_it_works' => 'Ver consola, deberías ver "¡funciona!" que viene de FrontendController @ index',
      'you_can_see_because' => '¡Puedes ver esto porque tienes el rol de ": rol"!',
      'you_can_see_because_permission' => '¡Puede ver esto porque tiene el permiso de ": permiso"!',
    ],
    'user' => [
      'change_email_notice' => 'Si cambia su correo electrónico, se cerrará la sesión hasta que confirme su nueva dirección de correo electrónico.',
      'email_changed_notice' => 'Debe confirmar su nueva dirección de correo electrónico antes de poder iniciar sesión nuevamente.',
      'profile_updated' => 'Perfil actualizado con éxito.',
      'password_updated' => 'Contraseña actualizada con éxito.',
    ],
    'welcome_to' => 'Bienvenido a: lugar',
  ],
];