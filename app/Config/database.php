<?php
/**
 * Database
 */

class DATABASE_CONFIG {

	public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'usuario', // <-- Alterar
		'password' => 'senha', // <-- Alterar
		'database' => 'banco', // <-- Alterar
		'prefix' => 'app_',
		'encoding' => 'utf8',
	);

	public $test = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'usuario', // <-- Alterar
		'password' => 'senha', // <-- Alterar
		'database' => 'banco', // <-- Alterar
		'prefix' => 'app_',
		'encoding' => 'utf8',
	);
}
