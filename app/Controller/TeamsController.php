<?php
/**
 * 
 * TeamsController
 * 
 */

App::uses('AppController', 'Controller');

class TeamsController extends AppController {

	/**
	 * Chama os models definidos
	 */
	public $uses = array(
		'Team',
		'Task',
		'TeamTask'
	);

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
				'title_for_layout' 	=> 'Equipes',
				'action'			=> 'add',
				'button'			=> 'Adicionar Equipe',
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
			$this->Team->create();

			// Salva a prova
			if ($this->Team->save($this->request->data)):
				$this->Session->setFlash('Adicionado com sucesso.', SUCCESS);
				$this->redirect(array('action' => 'index', 'painel' => true));
			else:
				$this->Session->setFlash('Verifique os erros encontrado no formulário de preenchimento.', WARNING);
			endif;
		endif;

		// Set
		$this->set(
			array(
				'title_for_layout' 	=> 'Adicionar Equipe',
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

		// Equipe
		$this->Team->id = $id;

		// Se o registro não for encontrado
		if (!$this->Team->exists()):
			throw new NotFoundException('Equipe não encontrada.');
		endif;

		// Efetua ação de edição
		if ($this->request->is('post') || $this->request->is('put')):

			if ($this->Team->save($this->request->data)):
				$this->Session->setFlash('Alterado com sucesso.', SUCCESS);
				$this->redirect(array('action' => 'index', 'painel' => true));
			else:
				$this->Session->setFlash('Verifique os erros encontrado no formulário de preenchimento.', WARNING);
			endif;

		else:

			$this->request->data = $this->Team->read(null, $id);

		endif;

		// Set
		$this->set(
			array(
				'title_for_layout' 	=> 'Editar Equipe',
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

		// Equipe
		$this->Team->id = $id;

		// Se o registro não for encontrado
		if (!$this->Team->exists()):
			throw new NotFoundException('Equipe não encontrada.');
		endif;

		// Altera o status para o oposto do atual
		if ($this->Team->field('is_active') == true):
			$this->Team->saveField('is_active', false);
		else:
			$this->Team->saveField('is_active', true);
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

		// Equipe
		$this->Team->id = $id;

		// Se o registro não for encontrado
		if (!$this->Team->exists()):
			throw new NotFoundException('Equipe não encontrada.');
		endif;

		// Se existir efetua a ação de exclusão
		if ($this->Team->delete()):
			
			// Exclui a pontuação da equipe
			$this->TeamTask->deleteAll(array('TeamTask.team_id' => $id), false);

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

	/**
	 * Painel Index
	 */
	public function painel_points($id = null)
	{

		// Equipe
		$team = $this->Team->read(null, $id);

		// Se o registro não for encontrado
		if (!$this->Team->exists()):
			throw new NotFoundException('Equipe não encontrada.');
		endif;

		// Retorna todos os resultados
		$results = $this->paginate('TeamTask', array('TeamTask.team_id' => $id));

		// Set
		$this->set(
			array(
				'title_for_layout' 	=> 'Tectech´s ' . $team['Team']['acronym'],
				'controller'		=> 'points', $team['Team']['id'],
				'action'			=> 'add/' .  $team['Team']['id'],
				'button'			=> 'Adicionar Tectech´s',
				'class'				=> 'success',
				'results'			=> $results,
				'team'				=> $team
			)
		);

	}

}
