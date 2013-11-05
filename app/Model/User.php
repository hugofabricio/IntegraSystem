<?php
/**
 * 
 * UserModel
 * 
 */

App::uses('AppModel', 'Model');

class User extends AppModel {

	/**
	 * Nome
	 */
	public $name = 'User';

	/**
	 * Validações
	 */
	public $validate = array(
	    'name' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Campo obrigatório.'
			)
	    ),
	    'lastname' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Campo obrigatório.'
			)
	    ),
	    'email' => array(
			'required' => array(
		    	'rule' => array('notEmpty'),
		    	'message' => 'Campo obrigatório.'
			),
			'type' => array(
		    	'rule' => array('email'),
		    	'message' => 'E-mail inválido.'
			),
			'unique' => array(
		    	'rule' => array('isUnique'),
		    	'message' => 'Este e-mail já está em uso.',
		    	'on'=>'create',
			)
	    ),
	    'username' => array(
			'characters' => array(
				'rule'     => 'alphaNumeric',
				'message'  => 'Apenas caracteres alfanuméricos.'
            ),
			'required' => array(
		    	'rule' => array('notEmpty'),
		    	'message' => 'Campo obrigatório.'
			),
			'unique' => array(
		    	'rule' => array('isUnique'),
		    	'message' => 'Este usuário já está em uso.'
			)
	    ),
	    'password' => array(
			'required' => array(
		    	'rule' => array('notEmpty'),
		    	'message' => 'Campo obrigatório.',
		    	'on' => 'create'
			),
			'min' => array(
				'rule'    => array('minLength', '8'),
				'message' => 'A senha deve ter no mínimo 8 caracteres.',
		    	'on' => 'create'
			)
	    ),
	    'is_active' => array(
			'boolean' => array(
		    	'rule' => array('boolean'),
		    	'message' => 'Campo obrigatório.'
			)
	    )
	);

	/**
	 * Métodos carregados antes de salvar
	 */
	public function beforeSave($options = array())
	{

		// Está salvando um usuário com senha
		if (isset($this->data[$this->alias]['password'])) {
			$password = &$this->data[$this->alias]['password'];

			// Se a senha não estiver vazia
			if (!empty($password)) {
				// Gera o hash da senha
				$password = Security::hash($password, 'blowfish');
			} else {
				unset($this->data[$this->alias]['password']);
			}
		}

		parent::beforeSave($options);

	}
	
}
