<?php
/**
 * Routes
 */

// Home
Router::connect(
	'/', array(
		'controller' 		=> 'home',
		'action'			=> 'index'
	)
);

Router::connect(
	'/provas', array(
		'controller' 		=> 'tasks',
		'action'			=> 'index'
	)
);

Router::connect(
    '/provas/:id-:slug',
    array(
    	'controller' => 'tasks',
    	'action' => 'view'
    ),
    array(
        'pass' => array('id', 'slug'),
        'id' => '[0-9]+'
    )
);

// Painel Administrativo
Router::connect(
	'/painel', array(
		'controller' 		=> 'home',
		'action'			=> 'index',
		'painel'			=> true
	)
);

Router::connect(
	'/painel/profile', array(
		'controller' 		=> 'users',
		'action'			=> 'profile',
		'painel'			=> true
	)
);

Router::connect(
	'/painel/login', array(
		'controller' 		=> 'users',
		'action'			=> 'login',
		'painel'			=> true
	)
);

Router::connect(
	'/painel/logout', array(
		'controller' 		=> 'users',
		'action'			=> 'logout',
		'painel'			=> true
	)
);

// Load all plugin routes.
CakePlugin::routes();

// Carrega as rotas padrão do CakePHP.
require CAKE . 'Config' . DS . 'routes.php';
