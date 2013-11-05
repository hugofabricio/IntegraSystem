<?php
/**
 * 
 * TaskTeamModel
 * 
 */

App::uses('AppModel', 'Model');

class TeamTask extends AppModel {

	/**
	 * Nome
	 */
	public $name = 'TeamTask';

	/**
	 * Validações
	 */
	public $validate = array(
	    'points' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Campo obrigatório.'
			)
	    ),
	    'team_id' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Campo obrigatório.'
			)
	    ),
	    'task_id' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Campo obrigatório.'
			)
	    )
	);

	/**
	 * Relacionamentos
	 */
    public $belongsTo = array(
        'Team' => array(
            'foreignKey' => 'team_id'
        ),
        'Task' => array(
            'foreignKey' => 'task_id'
        )
    );

}
