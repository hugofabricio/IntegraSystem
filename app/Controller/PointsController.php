<?php
/**
 * 
 * PointsController
 * 
 */

App::uses('AppController', 'Controller');

class PointsController extends AppController {

	/**
	 * Chama os models definidos
	 */
	public $uses = array(
		'TeamTask',
		'Team',
		'Task'
	);

	/**
	 * Painel Index
	 */
	public function painel_index()
	{

		// Retorna todos os resultados com paginação
		$results = $this->paginate();

		// Set
		$this->set(
			array(
				'title_for_layout' 	=> 'Tectech´s',
				'action'			=> 'add',
				'button'			=> 'Adicionar Tectech´s',
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

		// Busca todas as provas ativas
		$tasks = $this->TeamTask->Task->find('list', array('conditions' => array('Task.is_active' => true)));

		// Se não existir provas cadastradas
		if (count($tasks) == 0):

			// Mensagem de atenção
			$this->Session->setFlash('Você não tem provas cadastradas, adicione uma agora.', WARNING);

			// Redireciona
			$this->redirect(array('controller' => 'tasks', 'action' => 'add', 'painel' => true));

		endif;

		// Busca todas as equipes ativas
		$teams = $this->TeamTask->Team->find('list', array('conditions' => array('Team.is_active' => true)));

		// Se não existir equipes cadastradas
		if (count($teams) == 0):

			// Mensagem de atenção
			$this->Session->setFlash('Você não tem equipes cadastradas, adicione uma agora.', WARNING);

			// Redireciona
			$this->redirect(array('controller' => 'teams', 'action' => 'add', 'painel' => true));

		endif;

		if ($this->request->is('post')):

			// Verifica se já existe pontuação para prova e equipe definida no form
			if(!$this->TeamTask->find('first', array('conditions' => array('team_id' => $this->request->data['TeamTask']['team_id'], 'task_id' => $this->request->data['TeamTask']['task_id'])))):

				$this->TeamTask->create();

				// Salva a prova
				if ($this->TeamTask->save($this->request->data)):

					// Busca a equipe
					$team = $this->Team->read(null, $this->request->data['TeamTask']['team_id']);

					// Adiciona a pontuação da prova ao total da equipe
					$this->Team->set('points', $team['Team']['points'] + $this->request->data['TeamTask']['points']);

					// Salva a nova pontuação
					$this->Team->save();

					// Mensagem de sucesso
					$this->Session->setFlash('Adicionado com sucesso.', SUCCESS);

					// Redireciona
					$this->redirect(array('action' => 'index', 'painel' => true));

				else:

					// Mensagem de atenção
					$this->Session->setFlash('Verifique os erros encontrado no formulário de preenchimento.', WARNING);

				endif;

			else:

				// Mensagem de erro
				$this->Session->setFlash('Esta equipe já recebeu tectech´s para esta prova.', DANGER);

			endif;

		endif;

		// Set
		$this->set(
			array(
				'title_for_layout' 	=> 'Adicionar Tectech´s',
				'action'			=> 'index',
				'button'			=> 'Cancelar',
				'class'				=> 'danger',
				'is_save'			=> true,
				'tasks'				=> $tasks,
				'teams'				=> $teams
			)
		);

	}

	/**
	 * Painel Edit
	 */
	public function painel_edit($id = null)
	{

		// Pontuação
		$task = $this->TeamTask->read(null, $id);

		// Se o registro não for encontrado
		if (!$this->TeamTask->exists()):
			throw new NotFoundException('Tectech´s não encontrada.');
		endif;

		// Busca a equipe relacionada a prova
		$team = $this->Team->read(null, $task['TeamTask']['team_id']);

		// Efetua ação de edição
		if ($this->request->is('post') || $this->request->is('put')):

			if ($this->TeamTask->save($this->request->data)):

				// Busca a equipe
				$team = $this->Team->read(null, $task['TeamTask']['team_id']);

				// Subtrai a pontuação da prova ao total da equipe
				$this->Team->set('points', $team['Team']['points'] - $task['TeamTask']['points'] + $this->request->data['TeamTask']['points']);

				// Salva a nova pontuação
				$this->Team->save();

				// Mensagem de sucesso
				$this->Session->setFlash('Alterado com sucesso.', SUCCESS);

				// Redireciona
				$this->redirect(array('action' => 'index', 'painel' => true));
			else:

				// Mensagem de atenção
				$this->Session->setFlash('Verifique os erros encontrado no formulário de preenchimento.', WARNING);

			endif;

		else:

			// Popula os campos iniciais com os dados relacionado a pontuação selecionada
			$this->request->data = $task;

		endif;

		// Set
		$this->set(
			array(
				'title_for_layout' 	=> 'Editar Tectech´s',
				'action'			=> 'index',
				'button'			=> 'Cancelar',
				'class'				=> 'danger',
				'is_save'			=> true
			)
		);

	}

	/**
	 * Painel Delete
	 */
	public function painel_delete($id = null)
	{

		// Pontuação
		$task = $this->TeamTask->read(null, $id);

		// Se o registro não for encontrado
		if (!$this->TeamTask->exists()):
			throw new NotFoundException('Tectech´s não encontrada.');
		endif;

		// Se existir efetua a ação de exclusão
		if ($this->TeamTask->delete()):

			// Busca a equipe
			$team = $this->Team->read(null, $task['TeamTask']['team_id']);

			// Subtrai a pontuação da prova ao total da equipe
			$this->Team->set('points', $team['Team']['points'] - $task['TeamTask']['points']);

			// Salva a nova pontuação
			$this->Team->save();

			// Mensagem de sucesso
			$this->Session->setFlash('Excluído com sucesso.', SUCCESS);

			// Redireciona
			$this->redirect(array('action' => 'index', 'painel' => true));

		endif;

		// Mensagem de erro
		$this->Session->setFlash('Falha ao excluir.', WARNING);

		// Redireciona
		$this->redirect(array('action' => 'index', 'painel' => true));

	}

}
