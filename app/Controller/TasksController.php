<?php
/**
 * 
 * TasksController
 * 
 */

App::uses('AppController', 'Controller');

class TasksController extends AppController {

	/**
	 * Chama os models definidos
	 */
	public $uses = array(
		'Task',
		'Team',
		'TeamTask'
	);

	/**
	 * Index
	 */
	public function index()
	{

		// Retorna todos os resultados
		$results = $this->paginate();

		// Set
		$this->set(
			array(
				'title_for_layout' 	=> 'Provas',
				'results'			=> $results
			)
		);

	}

	/**
	 * View
	 */
	public function view($id = null, $slug = null)
	{

		$this->Task->id = $id;

		// Busca a prova de acordo com id e slug passado
		$result = $this->Task->find('first', array('conditions' => array('Task.id' => $id, 'Task.slug' => $slug)));

		// Se o registro não for encontrado
		if (!$this->Task->exists()):
			throw new NotFoundException('Prova não encontrada.');
		endif;

		// Set
		$this->set(
			array(
				'title_for_layout' 	=> $result['Task']['name'] . ' | Provas',
				'result' => $result
			)
		);

	}

	/**
	 * Painel Index
	 */
	public function painel_index()
	{

		// Retorna todos os resultados
		$results = $this->paginate();

		// Set
		$this->set(
			array(
				'title_for_layout' 	=> 'Provas',
				'action'			=> 'add',
				'button'			=> 'Adicionar Prova',
				'class'				=> 'success',
				'is_save'			=> false,
				'results'			=> $results
			)
		);

	}

	/**
	 * Painel Add
	 */
	public function painel_add()
	{

		if ($this->request->is('post')):
			$this->Task->create();

			// Salva a prova
			if ($this->Task->save($this->request->data)):
				$this->Session->setFlash('Adicionado com sucesso.', SUCCESS);
				$this->redirect(array('action' => 'index', 'painel' => true));
			else:
				$this->Session->setFlash('Verifique os erros encontrado no formulário de preenchimento.', WARNING);
			endif;
		endif;

		// Set
		$this->set(
			array(
				'title_for_layout' 	=> 'Adicionar Prova',
				'action'			=> 'index',
				'button'			=> 'Cancelar',
				'class'				=> 'danger',
				'is_save'			=> true
			)
		);

	}

	/**
	 * Painel Edit
	 */
	public function painel_edit($id = null)
	{

		// Prova
		$this->Task->id = $id;

		// Se o registro não for encontrado
		if (!$this->Task->exists()):
			throw new NotFoundException('Prova não encontrada.');
		endif;

		// Efetua ação de edição
		if ($this->request->is('post') || $this->request->is('put')):

			if ($this->Task->save($this->request->data)):
				$this->Session->setFlash('Alterado com sucesso.', SUCCESS);
				$this->redirect(array('action' => 'index', 'painel' => true));
			else:
				$this->Session->setFlash('Verifique os erros encontrado no formulário de preenchimento.', WARNING);
			endif;

		else:

			$this->request->data = $this->Task->read(null, $id);

		endif;

		// Set
		$this->set(
			array(
				'title_for_layout' 	=> 'Editar Prova',
				'action'			=> 'index',
				'button'			=> 'Cancelar',
				'class'				=> 'danger',
				'is_save'			=> true
			)
		);

	}

	/**
	 * Função para alterar o status
	 */
	public function painel_status($id = null)
	{

		// Prova
		$this->Task->id = $id;

		// Se o registro não for encontrado
		if (!$this->Task->exists()):
			throw new NotFoundException('Prova não encontrada.');
		endif;

		// Busca todas as pontuações relacionadas a esta prova
		$team_tasks = $this->TeamTask->find('all', array('conditions' => array('TeamTask.task_id' => $id), 'recursive' => -1));

		// Altera o status para o oposto do atual
		if ($this->Task->field('is_active') == true):

			// Percorre as pontuações
			foreach ($team_tasks as $task):

				// Busca a equipe
				$team = $this->Team->read(null, $task['TeamTask']['team_id']);

				// Subtrai a pontuação da prova ao total da equipe
				$this->Team->set('points', $team['Team']['points'] - $task['TeamTask']['points']);

				// Salva a nova pontuação
				$this->Team->save();

			endforeach;

			// Altera o campo para falso
			$this->Task->saveField('is_active', false);

		else:

			// Percorre as pontuações
			foreach ($team_tasks as $task):

				// Busca a equipe
				$team = $this->Team->read(null, $task['TeamTask']['team_id']);

				// Subtrai a pontuação da prova ao total da equipe
				$this->Team->set('points', $team['Team']['points'] + $task['TeamTask']['points']);

				// Salva a nova pontuação
				$this->Team->save();

			endforeach;

			// Altera o campo para verdadeiro
			$this->Task->saveField('is_active', true);

		endif;

		// Mensagem de sucesso
		$this->Session->setFlash('Status alterado com sucesso.', SUCCESS);

		// Redireciona
		$this->redirect(array('action' => 'index', 'painel' => true));

	}

	/**
	 * Painel Delete
	 */
	public function painel_delete($id = null)
	{

		// Prova
		$this->Task->id = $id;

		// Se o registro não for encontrado
		if (!$this->Task->exists()):
			throw new NotFoundException('Prova não encontrada.');
		endif;

		$team_tasks = $this->TeamTask->find('all', array('conditions' => array('TeamTask.task_id' => $id), 'recursive' => -1));

		foreach ($team_tasks as $task):

			// Busca a equipe
			$team = $this->Team->read(null, $task['TeamTask']['team_id']);

			// Subtrai a pontuação da prova ao total da equipe
			$this->Team->set('points', $team['Team']['points'] - $task['TeamTask']['points']);

			// Salva a nova pontuação
			$this->Team->save();

			$this->TeamTask->delete($task['TeamTask']['id']);

		endforeach;

		// Se existir efetua a ação de exclusão
		if ($this->Task->delete()):
			$this->Session->setFlash('Excluído com sucesso.', SUCCESS);
			$this->redirect(array('action' => 'index', 'painel' => true));
		endif;

		// Mensagem de erro
		$this->Session->setFlash('Falha ao excluir.', WARNING);

		// Redireciona
		$this->redirect(array('action' => 'index', 'painel' => true));

	}

}
