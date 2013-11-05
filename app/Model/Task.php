<?php
/**
 * 
 * TaskModel
 * 
 */

define('UPLOAD_DIR', WWW_ROOT . 'img/tasks/');

App::uses('AppModel', 'Model');
App::uses('AttachmentBehavior', 'Uploader.Model/Behavior');

class Task extends AppModel {

	/**
	 * Nome
	 */
	public $name = 'Task';

	/**
	 * Plugins
	 */
	public $actsAs = array(
		'Uploader.Attachment' => array(
			'image' => array(
				'uploadDir' => UPLOAD_DIR,
				'nameCallback' => 'getSlug',
				'overwrite' => true,
				'transforms' => array(
					array(
						'method' => 'exif',
						'self' => true
					),
					'image_small' => array(
						'method' => AttachmentBehavior::CROP,
						'nameCallback' => 'getSlug',
						'append' => '-thumb',
						'overwrite' => true,
						'width' => 200,
						'height' => 200
					)
				)
			)
		),
		'Uploader.FileValidation' => array(
			'image' => array(
				'extension' => array('gif', 'jpg', 'png', 'jpeg'),
				'required' => array(
					'value' => false,
					'allowEmpty' => true
				)
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
	 * Validações
	 */
	public $validate = array(
	    'name' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Campo obrigatório.'
			)
	    ),
	    'deadline' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Campo obrigatório.'
			)
	    ),
	    'details' => array(
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
	 * Retorna o slug gerado
	 */
	public function getSlug()
	{
		return $this->generateSlug($this->data[$this->alias]['name']);
	}

	/**
	 * Métodos carregados antes de salvar
	 */
	public function beforeSave($options = array())
	{

		// Seta a data
		if (isset($this->data[$this->alias]['deadline'])):
			$this->data[$this->alias]['deadline'] = $this->dateFormat($this->data[$this->alias]['deadline']);
		endif;

		// Seta o slug
		$this->data[$this->alias]['slug'] = $this->getSlug();

		parent::beforeSave($options);

	}
	
}
