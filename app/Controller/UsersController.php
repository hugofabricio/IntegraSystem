<?php
/**
 * UsersController
 */

App::uses('AppController', 'Controller');

class UsersController extends AppController {

	/**
	 * Métodos carregados antes da action ser chamada 
	 */
	public function beforeFilter()
	{

		// Chamadas de callbacks
		return parent::beforeFilter();

		// Libera as seguintes páginas
		$this->Auth->allow(
			'painel_logout'
		);

	}

	/**
	 * Função para acessar o painel
	 */
	public function painel_login()
	{

		// Ação de Login
		if ($this->request->is('post')):
			if ($this->Auth->login()):
				if(!empty($this->request->data['User']['remember_me']) && $this->request->data['User']['remember_me'] == 's'):
					$cookie = array();
					$cookie['username'] = $this->request->data['User']['username'];

					// Escreve os dados no cookie (30 Dias)
					$this->Cookie->write('Auth.Painel', $cookie, true);
				endif;

				return $this->redirect($this->Auth->redirectUrl());
			else:
				$this->Session->setFlash('Usuário ou senha inválidos, tente novamente.', DANGER);
			endif;
		endif;

		// Set
		$this->set(
			'title_for_layout', 'Acessar'
		);

	}

	/**
	 * Função para sair do painel
	 */
	public function painel_logout()
	{

		// Destroi o Cookie
		$this->Cookie->delete('Auth.Painel');

		// Destroi a Sessão
		return $this->redirect($this->Auth->logout());

	}

	/**
	 * Função para listar os registros
	 */
	public function painel_index()
	{

		// Retorna todos os resultados
		$this->User->recursive = 0;
		$results = $this->paginate();

		// Set
		$this->set(
			array(
				'title_for_layout' 	=> 'Usuários',
				'action'			=> 'add',
				'button'			=> 'Adicionar Usuário',
				'class'				=> 'success',
				'is_save'			=> false,
				'results'			=> $results
			)
		);

	}

	/**
	 * Função para adicionar os registros
	 */
	public function painel_add()
	{

		if ($this->request->is('post')):
			$this->User->create();

			// Salva o usuário
			if ($this->User->save($this->request->data)):
				$this->Session->setFlash('Adicionado com sucesso.', SUCCESS);
				$this->redirect(array('action' => 'index', 'painel' => true));
			else:
				$this->Session->setFlash('Verifique os erros encontrado no formulário de preenchimento.', WARNING);
			endif;
		endif;

		// Set
		$this->set(
			array(
				'title_for_layout' 	=> 'Adicionar Usuário',
				'action'			=> 'index',
				'button'			=> 'Cancelar',
				'class'				=> 'danger',
				'is_save'			=> true
			)
		);

	}

	/**
	 * Função para editar os registros
	 */
	public function painel_edit($id = null)
	{

		// Usuário
		$this->User->id = $id;

		// Se o registro não for encontrado
		if (!$this->User->exists()):
			throw new NotFoundException('Usuário não encontrado.');
		endif;

		// Efetua ação de edição
		if ($this->request->is('post') || $this->request->is('put')):

			// Remove o usuário para não ser alterado de forma alguma
			unset($this->request->data['User']['username']);

			if ($this->User->save($this->request->data)):
				$this->Session->setFlash('Alterado com sucesso.', SUCCESS);
				$this->redirect(array('action' => 'index', 'painel' => true));
			else:
				$this->Session->setFlash('Verifique os erros encontrado no formulário de preenchimento.', WARNING);
			endif;

		else:

			$this->request->data = $this->User->read(null, $id);

		endif;

		// Set
		$this->set(
			array(
				'title_for_layout' 	=> 'Editar Usuário',
				'action'			=> 'index',
				'button'			=> 'Cancelar',
				'class'				=> 'danger',
				'is_save'			=> true
			)
		);

	}

	/**
	 * Função para editar os registros
	 */
	public function painel_profile()
	{

		// Usuário
		$this->User->id = AuthComponent::user('id');

		// Efetua ação de edição
		if ($this->request->is('post') || $this->request->is('put')):

			// Remove o usuário para não ser alterado de forma alguma
			unset($this->request->data['User']['username']);

			if ($this->User->save($this->request->data)):
				$this->Session->setFlash('Alterado com sucesso.', SUCCESS);
				$this->redirect(array('action' => 'index', 'painel' => true));
			else:
				$this->Session->setFlash('Verifique os erros encontrado no formulário de preenchimento.', WARNING);
			endif;

		else:

			$this->request->data = $this->User->read(null, AuthComponent::user('id'));

		endif;

		// Set
		$this->set(
			array(
				'title_for_layout' 	=> 'Editar Perfil',
				'controller'		=> 'home',
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

		// Usuário
		$this->User->id = $id;

		// Se o registro não for encontrado
		if (!$this->User->exists()):
			throw new NotFoundException('Usuário não encontrado.');
		endif;

		// Altera o status para o oposto do atual
		if ($this->User->field('is_active') == true):
			$this->User->saveField('is_active', false);
		else:
			$this->User->saveField('is_active', true);
		endif;

		// Mensagem de sucesso
		$this->Session->setFlash('Status alterado com sucesso.', SUCCESS);

		// Redireciona
		$this->redirect(array('action' => 'index', 'painel' => true));

	}

	/**
	 * Função para excluir os registros
	 */
	public function painel_delete($id = null)
	{

		// Usuário
		$this->User->id = $id;

		// Se o registro não for encontrado
		if (!$this->User->exists()):
			throw new NotFoundException('Usuário não encontrado.');
		endif;

		// Se existir efetua a ação de exclusão
		if ($this->User->delete()):
			$this->Session->setFlash('Excluído com sucesso.', SUCCESS);
			$this->redirect(array('action' => 'index', 'painel' => true));
		endif;

		// Mensagem de erro
		$this->Session->setFlash('Falha ao excluir.', WARNING);

		// Redireciona
		$this->redirect(array('action' => 'index', 'painel' => true));

	}

}
