<?php
/**
 * AclPhp
 *
 * Como utilizar?
 *
 * 1. Crie o model User em sua aplicação, com os seguintes atributos:
 *    username, group_id, password, email, firstname, lastname e  assim por diante.
 *
 * 2. Configure o AuthComponent autorizar ações via:
 *    $this->Auth->authorize = array('Actions' => array('actionPath' => 'controllers/'),...)
 *
 * 3. Acesse o core.php e faça as seguintes alterações:	
 *    Configure::write('Acl.classname', 'DbAcl'); -----> Configure::write('Acl.classname', 'PhpAcl');
 *	  Configure::write('Acl.database', 'default'); ----> Comente ou exclua esta linha.
 *
 */

/**
 * Define a forma de acessar usuário e grupo
 */
$config['map'] = array(
	'User' 				=> 'User/username',
	'Role' 				=> 'User/group_id',
);

/**
 * Define atalhos para mapear os tipos de grupos
 */
$config['alias'] = array(
	'Role/1' 			=> 'Role/master',
	'Role/2' 			=> 'Role/admin',
	'Role/3' 			=> 'Role/editor',
);

/**
 * Configurações dos Grupos, possibilidade de um grupo ter
 * a permissão da junção de vários grupos.
 * ex: 'Role/editor' 	=> 'Role/Admin, Role/Editor',
 */
$config['roles'] = array(
	'Role/master' 		=> null,
	'Role/admin' 		=> null,
	'Role/editor' 		=> null,
);

/**
 * Permissões
 */
$config['rules'] = array(
	'allow' => array(
		'*' 										=> 'Role/master, Role/admin',
		//'controllers/users/(dashboard|profile)' 	=> 'Role/admin',
		//'controllers/users/*'  					=> 'Role/editor',
	),
	'deny' => array(
		'/controllers/produtos/*'					=> 'Role/master',
		'/controllers/users/(edit|delete)/1'		=> 'Role/admin',
		'/controllers/users/*'						=> 'Role/editor',
		'/controllers/roles/*'						=> 'Role/editor',
		//'controllers/invoices/delete' 			=> 'Role/admin',
		//'controllers/articles/(delete|publish)' 	=> 'Role/editor',
	)
);
