<?php
/**
 * 
 * TeamModel
 * 
 */

App::uses('AppModel', 'Model');

class Team extends AppModel {

	/**
	 * Nome
	 */
	public $name = 'Team';

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
	    'acronym' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Campo obrigatório.'
			)
	    ),
	    'color' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Campo obrigatório.'
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
	 * Relacionamentos
	 */
    public $hasMany = array(
        'TeamTask'
    );

    public $belongsTo = array(
        'Creator' => array(
        	'className' => 'User',
            'foreignKey' => 'creator_id'
        ),
        'Editor' => array(
        	'className' => 'User',
            'foreignKey' => 'editor_id'
        )
    );

	/**
	 * Retorna o slug gerado
	 */
	public function getSlug()
	{
		$name = $this->data[$this->alias]['name'];
		if ($name):
			return $this->generateSlug($this->data[$this->alias]['name']);
		else:
			return false;
		endif;
	}

	/**
	 * Métodos carregados antes de salvar
	 */
	public function beforeSave($options = array())
	{
		
		// Seta o slug
		$this->data[$this->alias]['slug'] = $this->getSlug();

		parent::beforeSave($options);

	}

}
