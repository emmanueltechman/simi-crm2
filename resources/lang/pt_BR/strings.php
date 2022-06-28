<?php 
return [
  'backend' => [
    'access' => [
      'users' => 
      [
        'delete_user_confirm' => 'Tem certeza de que deseja excluir este usuário permanentemente? Em qualquer lugar do aplicativo que referenciar o ID desse usuário, provavelmente ocorrerá um erro. Prossiga por sua conta e risco. Isso não pode ser feito.',
        'if_confirmed_off' => '(Se confirmado estiver desativado)',
        'restore_user_confirm' => 'Restaurar este usuário ao seu estado original?',
      ],
    ],
    'dashboard' => [
      'title' => 'Painel administrativo do SuperAdmin',
      'welcome' => 'Bem-vinda',
    ],
    'general' => [
      'all_rights_reserved' => 'Todos os direitos reservados.',
      'are_you_sure' => 'Você tem certeza de que quer fazer isso?',
      'boilerplate_link' => 'Faturamento de rosas',
      'continue' => 'Continuar',
      'member_since' => 'Membro desde',
      'minutes' => 'minutos',
      'search_placeholder' => 'Procurar...',
      'timeout' => 'Você foi desconectado automaticamente por motivos de segurança, uma vez que não tinha atividade em',
      'see_all' => 
      [
        'messages' => 'Ver todas as mensagens',
        'notifications' => 'Ver tudo',
        'tasks' => 'Ver todas as tarefas',
      ],
      'status' => 
      [
        'online' => 'Conectados',
        'offline' => 'desligada',
      ],
      'you_have' => 
      [
        'messages' => '{0} Você não tem mensagens | {1} Você tem 1 mensagem | [2, Inf] Você tem: número de mensagens',
        'notifications' => '{0} Você não tem notificações | {1} Você tem 1 notificação | [2, Inf] Você tem: número de notificações',
        'tasks' => '{0} Você não tem tarefas | {1} Você tem 1 tarefa | [2, Inf] Você tem: número de tarefas',
      ],
    ],
    'search' => [
      'empty' => 'Por favor insira um termo de pesquisa.',
      'incomplete' => 'Você deve escrever sua própria lógica de pesquisa para este sistema.',
      'title' => 'Procurar Resultados',
      'results' => 'Resultados da pesquisa para: consulta',
    ],
    'welcome' => 'Bem-vinda',
  ],
  'emails' => [
    'auth' => [
      'error' => 'Ops!',
      'greeting' => 'Olá!',
      'regards' => 'Saudações,',
      'trouble_clicking_button' => 'Se estiver com problemas para clicar no botão ": action_text", copie e cole o URL abaixo no seu navegador da web:',
      'thank_you_for_using_app' => 'Obrigado por usar nosso aplicativo!',
      'password_reset_subject' => 'Redefinir senha',
      'password_cause_of_email' => 'Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para sua conta.',
      'password_if_not_requested' => 'Se você não solicitou uma redefinição de senha, nenhuma ação adicional será necessária.',
      'reset_password' => 'Clique aqui para redefinir sua senha',
      'click_to_confirm' => 'Clique aqui para confirmar sua conta:',
    ],
  ],
  'frontend' => [
    'test' => 'Teste',
    'tests' => [
      'based_on' => 
      [
        'permission' => 'Baseado em permissão -',
        'role' => 'Baseado em função -',
      ],
      'js_injected_from_controller' => 'Javascript injetado de um controlador',
      'using_blade_extensions' => 'Usando extensões de lâmina',
      'using_access_helper' => 
      [
        'array_permissions' => 'Usando o Access Helper com nomes ou IDs de matriz de permissão nos quais o usuário precisa possuir todos.',
        'array_permissions_not' => 'Usando o Access Helper com nomes ou IDs de matriz de permissão nos quais o usuário não precisa possuir todos.',
        'array_roles' => 'Usando o Access Helper com nomes ou IDs de matriz de funções em que o usuário precisa possuir tudo.',
        'array_roles_not' => 'Usando o Access Helper com nomes ou IDs de matriz de funções em que o usuário não precisa possuir tudo.',
        'permission_id' => 'Usando o Access Helper com ID de permissão',
        'permission_name' => 'Usando o Access Helper com nome de permissão',
        'role_id' => 'Usando o Access Helper com ID da Função',
        'role_name' => 'Usando o Access Helper com nome da função',
      ],
      'view_console_it_works' => 'No console de visualização, você verá "funciona!" que é proveniente de FrontendController @ index',
      'you_can_see_because' => 'Você pode ver isso porque você tem o papel de ": role"!',
      'you_can_see_because_permission' => 'Você pode ver isso porque possui a permissão ": permission"!',
    ],
    'user' => [
      'change_email_notice' => 'Se você alterar seu email, você será desconectado até confirmar seu novo endereço de email.',
      'email_changed_notice' => 'Você deve confirmar seu novo endereço de e-mail antes de poder fazer login novamente.',
      'profile_updated' => 'Perfil atualizado com sucesso.',
      'password_updated' => 'Senha atualizada com sucesso.',
    ],
    'welcome_to' => 'Bem-vindo a: place',
  ],
];